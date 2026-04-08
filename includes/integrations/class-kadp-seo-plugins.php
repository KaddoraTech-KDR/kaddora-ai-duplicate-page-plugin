<?php
if (!defined("ABSPATH")) exit;

class KADP_SEO_Plugins
{
  public function init()
  {
    add_action('kadp_after_duplicate', [$this, 'copy_seo_meta'], 10, 2);
  }

  public function copy_seo_meta($old_id, $new_id)
  {
    // Yoast
    $meta = get_post_meta($old_id, '_yoast_wpseo_title', true);
    update_post_meta($new_id, '_yoast_wpseo_title', $meta);
  }
}
