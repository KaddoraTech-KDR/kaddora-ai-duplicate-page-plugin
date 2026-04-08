<?php
if (!defined("ABSPATH"))  exit;

class KADP_Public
{
  public function enqueue()
  {
    wp_enqueue_style(
      'kadp-public',
      KADP_PLUGIN_URL . 'assets/css/public.css'
    );
  }
}
