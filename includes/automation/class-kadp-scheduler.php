<?php

if (!defined('ABSPATH')) {
  exit;
}

class KADP_Scheduler
{
  public function init()
  {
    add_action('init', [$this, 'schedule_event']);
  }

  public function schedule_event()
  {
    if (!wp_next_scheduled('kadp_run_automation')) {
      wp_schedule_event(time(), 'hourly', 'kadp_run_automation');
    }
  }
}
