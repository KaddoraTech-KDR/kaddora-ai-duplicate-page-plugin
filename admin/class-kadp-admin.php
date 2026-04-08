<?php

if (!defined('ABSPATH')) {
  exit;
}

class KADP_Admin
{
  /**
   * Load admin dependencies
   */
  public function __construct()
  {
    // Future: init hooks if needed
  }

  /**
   * Render view helper
   */
  public static function render($view, $data = [])
  {
    $file = KADP_PLUGIN_DIR . 'admin/views/' . $view . '.php';

    if (file_exists($file)) {
      extract($data);
      include $file;
    } else {
      echo '<div class="wrap"><h2>View not found</h2></div>';
    }
  }
}
