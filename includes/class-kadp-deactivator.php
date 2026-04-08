<?php

if (!defined('ABSPATH')) {
  exit;
}

class KADP_Deactivator
{
  /**
   * RUN ON DEACTIVATION
   */
  public static function deactivate()
  {
    self::clear_scheduled_events();
  }

  /**
   * CLEAR CRON JOBS
   */
  private static function clear_scheduled_events()
  {
    $timestamp = wp_next_scheduled('kadp_run_automation');

    if ($timestamp) {
      wp_unschedule_event($timestamp, 'kadp_run_automation');
    }
  }
}
