<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
  exit;
}

global $wpdb;

/**
 * DELETE OPTIONS
 */
$options = [
  'kadp_api_key',
  'kadp_enable_ai',
  'kadp_default_status',
  'kadp_title_prefix',
  'kadp_webhook_url',
  'kadp_version'
];

foreach ($options as $option) {
  delete_option($option);
}

/**
 * CLEAR SCHEDULED EVENTS
 */
$timestamp = wp_next_scheduled('kadp_run_automation');

if ($timestamp) {
  wp_unschedule_event($timestamp, 'kadp_run_automation');
}

/**
 * DELETE TABLES 
 */

$tables = [
  $wpdb->prefix . 'kadp_history',
  $wpdb->prefix . 'kadp_ai_logs',
  $wpdb->prefix . 'kadp_automation'
];

foreach ($tables as $table) {
  $wpdb->query("DROP TABLE IF EXISTS {$table}");
}
