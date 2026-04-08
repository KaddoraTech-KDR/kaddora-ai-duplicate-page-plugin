<?php
if (!defined("ABSPATH")) exit;

class KADP_WooCommerce
{
  public function init()
  {
    add_action('kadp_after_duplicate', [$this, 'duplicate_product_data'], 10, 2);
  }

  public function duplicate_product_data($old_id, $new_id)
  {
    if (get_post_type($old_id) !== 'product') return;

    $price = get_post_meta($old_id, '_price', true);
    update_post_meta($new_id, '_price', $price);
  }
}
