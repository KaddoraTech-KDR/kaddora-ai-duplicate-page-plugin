<?php

if (!defined('ABSPATH')) {
  exit;
}

class KADP_Duplicate_Media
{
  public function copy_featured_image($old_id, $new_id)
  {
    $thumbnail_id = get_post_thumbnail_id($old_id);

    if ($thumbnail_id) {
      set_post_thumbnail($new_id, $thumbnail_id);
    }
  }
}
