<?php

if (!defined('ABSPATH')) {
  exit;
}

class KADP_AI_Log_Model
{
  private $table;

  public function __construct()
  {
    global $wpdb;
    $this->table = $wpdb->prefix . 'kadp_ai_logs';
  }

  /**
   * INSERT AI LOG
   */
  public function insert($data)
  {
    global $wpdb;

    $wpdb->insert($this->table, [
      'post_id'     => $data['post_id'] ?? 0,
      'prompt_type' => $data['prompt_type'] ?? '',
      'tokens_used' => $data['tokens_used'] ?? 0,
      'status'      => $data['status'] ?? 'success',
      'response'    => $data['response'] ?? '',
      'created_at'  => current_time('mysql')
    ]);
  }

  /**
   * GET LOGS
   */
  public function get_all($limit = 20)
  {
    global $wpdb;

    return $wpdb->get_results(
      $wpdb->prepare(
        "SELECT * FROM {$this->table} ORDER BY id DESC LIMIT %d",
        $limit
      )
    );
  }
}
