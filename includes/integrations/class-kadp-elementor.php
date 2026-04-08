<?php

if (!defined('ABSPATH')) {
  exit;
}

class KADP_Elementor
{
  public function init()
  {
    add_action('kadp_after_duplicate', [$this, 'duplicate_elementor_data'], 10, 2);
  }

  public function duplicate_elementor_data($old_id, $new_id)
  {
    $data = get_post_meta($old_id, '_elementor_data', true);

    if ($data) {
      update_post_meta($new_id, '_elementor_data', $data);
    }
  }
}
