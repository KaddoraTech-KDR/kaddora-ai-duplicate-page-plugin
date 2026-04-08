<?php

if (!defined('ABSPATH')) {
  exit;
}

class KADP_Webhooks
{
  public function init()
  {
    add_action('kadp_after_duplicate', [$this, 'send_webhook'], 10, 2);
  }

  public function send_webhook($old_id, $new_id)
  {
    $url = get_option('kadp_webhook_url');

    if (!$url) return;

    wp_remote_post($url, [
      'body' => json_encode([
        'event' => 'post_duplicated',
        'original_id' => $old_id,
        'new_id' => $new_id
      ]),
      'headers' => [
        'Content-Type' => 'application/json'
      ]
    ]);
  }
}
