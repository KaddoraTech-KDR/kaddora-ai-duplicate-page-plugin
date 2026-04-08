<?php

if (!defined('ABSPATH')) exit;

class KADP_Rule_Engine
{
  public function should_run($job)
  {
    if (!get_post($job->source_post_id)) {
      return false;
    }

    if ($job->status !== 'active') {
      return false;
    }

    if (strtotime($job->next_run) > current_time('timestamp')) {
      return false;
    }

    return true;
  }
}
