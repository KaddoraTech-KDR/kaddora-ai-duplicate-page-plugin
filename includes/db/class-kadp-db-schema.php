<?php

if (!defined('ABSPATH')) {
  exit;
}

class KADP_DB_Schema
{
  private $charset_collate;

  public function __construct()
  {
    global $wpdb;
    $this->charset_collate = $wpdb->get_charset_collate();
  }

  /**
   * CREATE ALL TABLES
   */
  public function create_tables()
  {
    $this->create_history_table();
    $this->create_ai_logs_table();
    $this->create_automation_table();
  }

  /**
   * HISTORY TABLE
   */
  private function create_history_table()
  {
    global $wpdb;

    $table = $wpdb->prefix . 'kadp_history';

    $sql = "CREATE TABLE $table (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            original_post_id BIGINT UNSIGNED NOT NULL,
            duplicated_post_id BIGINT UNSIGNED NOT NULL,
            user_id BIGINT UNSIGNED NOT NULL,
            action_type VARCHAR(50) DEFAULT 'duplicate',
            status VARCHAR(20) DEFAULT 'success',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY original_post_id (original_post_id),
            KEY user_id (user_id)
        ) {$this->charset_collate};";

    $this->run_dbdelta($sql);
  }

  /**
   * AI LOGS TABLE
   */
  private function create_ai_logs_table()
  {
    global $wpdb;

    $table = $wpdb->prefix . 'kadp_ai_logs';

    $sql = "CREATE TABLE $table (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            post_id BIGINT UNSIGNED,
            prompt_type VARCHAR(100),
            tokens_used INT DEFAULT 0,
            status VARCHAR(20) DEFAULT 'success',
            response TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY post_id (post_id)
        ) {$this->charset_collate};";

    $this->run_dbdelta($sql);
  }

  /**
   * AUTOMATION TABLE
   */
  private function create_automation_table()
  {
    global $wpdb;

    $table = $wpdb->prefix . 'kadp_automation';

    $sql = "CREATE TABLE $table (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            source_post_id BIGINT UNSIGNED,
            target_post_type VARCHAR(50),
            frequency VARCHAR(50),
            last_run DATETIME NULL,
            next_run DATETIME NULL,
            status VARCHAR(20) DEFAULT 'active',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) {$this->charset_collate};";

    $this->run_dbdelta($sql);
  }

  /**
   * RUN DBDELTA SAFELY
   */
  private function run_dbdelta($sql)
  {
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
  }
}
