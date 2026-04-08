<?php

if (!defined('ABSPATH')) exit;

class KADP_History_Model
{
  private $table;

  public function __construct()
  {
    global $wpdb;
    $this->table = $wpdb->prefix . 'kadp_history';
  }

  /**
   * INSERT LOG
   */
  public function insert($data)
  {
    global $wpdb;

    $wpdb->insert($this->table, [
      'original_post_id'   => intval($data['original_post_id']),
      'duplicated_post_id' => intval($data['duplicated_post_id']),
      'user_id'            => get_current_user_id(),
      'action_type'        => sanitize_text_field($data['action_type'] ?? 'duplicate'),
      'status'             => sanitize_text_field($data['status'] ?? 'success'),
      'created_at'         => current_time('mysql')
    ]);
  }

  /**
   * GET ALL
   */
  public function get_all($limit = 20)
  {
    global $wpdb;

    return $wpdb->get_results(
      $wpdb->prepare(
        "SELECT * FROM {$this->table} ORDER BY id DESC LIMIT %d",
        intval($limit)
      )
    );
  }

  /**
   * FILTER DATA
   */
  public function filter($args = [])
  {
    global $wpdb;

    $where = "WHERE 1=1";

    if (!empty($args['user'])) {
      $where .= $wpdb->prepare(" AND user_id = %d", intval($args['user']));
    }

    if (!empty($args['date'])) {
      $where .= $wpdb->prepare(" AND DATE(created_at) = %s", sanitize_text_field($args['date']));
    }

    return $wpdb->get_results("SELECT * FROM {$this->table} {$where} ORDER BY id DESC");
  }
}
