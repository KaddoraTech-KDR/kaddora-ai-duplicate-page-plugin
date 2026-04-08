<?php

if (!defined('ABSPATH')) exit;

class KADP_Automation_Model
{
  private $table;

  public function __construct()
  {
    global $wpdb;
    $this->table = $wpdb->prefix . 'kadp_automation';
  }

  public function insert($data)
  {
    global $wpdb;

    return $wpdb->insert($this->table, [
      'name' => sanitize_text_field($data['name']),
      'source_post_id' => intval($data['post_id']),
      'frequency' => sanitize_text_field($data['frequency']),
      'next_run' => date('Y-m-d H:i:s', strtotime('+1 hour')),
      'status' => 'active'
    ]);
  }

  public function get_all()
  {
    global $wpdb;
    return $wpdb->get_results("SELECT * FROM {$this->table} ORDER BY id DESC");
  }
}
