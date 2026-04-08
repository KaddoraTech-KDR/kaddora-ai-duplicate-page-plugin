<?php

if (!defined('ABSPATH')) {
  exit;
}

class KADP_Duplicate_Meta
{
  public function copy($old_id, $new_id)
  {
    $meta = get_post_meta($old_id);

    if (empty($meta)) {
      return;
    }

    foreach ($meta as $key => $values) {

      // Skip protected/meta keys if needed
      if ($this->skip_meta($key)) {
        continue;
      }

      foreach ($values as $value) {
        add_post_meta($new_id, $key, maybe_unserialize($value));
      }
    }
  }

  private function skip_meta($key)
  {
    $skip = [
      '_edit_lock',
      '_edit_last'
    ];

    return in_array($key, $skip);
  }
}
