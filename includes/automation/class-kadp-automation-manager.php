<?php

if (!defined('ABSPATH')) exit;

class KADP_Automation_Manager
{
  public function init()
  {
    add_action('kadp_run_automation', [$this, 'run']);
  }

  public function run()
  {
    global $wpdb;

    $table = $wpdb->prefix . 'kadp_automation';

    $jobs = $wpdb->get_results("SELECT * FROM {$table} WHERE status = 'active'");

    if (empty($jobs)) return;

    $rule   = new KADP_Rule_Engine();
    $engine = new KADP_Duplicate_Engine();

    foreach ($jobs as $job) {
      if (!$rule->should_run($job)) {
        continue;
      }

      $new_id = $engine->duplicate($job->source_post_id);

      if (is_wp_error($new_id)) {
        continue;
      }

      $next = ($job->frequency === 'hourly')
        ? strtotime('+1 hour')
        : strtotime('+1 day');

      $wpdb->update(
        $table,
        [
          'last_run' => current_time('mysql'),
          'next_run' => date('Y-m-d H:i:s', $next)
        ],
        ['id' => $job->id],
        ['%s', '%s'],
        ['%d']
      );
    }
  }
}
