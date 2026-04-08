<?php

if (!defined('ABSPATH')) {
  exit;
}

class KADP_Duplicate_Taxonomy
{
  public function copy($old_id, $new_id)
  {
    $taxonomies = get_object_taxonomies(get_post_type($old_id));

    foreach ($taxonomies as $taxonomy) {

      $terms = wp_get_object_terms($old_id, $taxonomy, ['fields' => 'ids']);

      if (!empty($terms)) {
        wp_set_object_terms($new_id, $terms, $taxonomy);
      }
    }
  }
}
