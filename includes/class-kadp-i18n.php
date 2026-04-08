<?php
if (!defined("ABSPATH")) exit;

class KADP_i18n
{
  public function load_textdomain()
  {
    load_plugin_textdomain('kadp', false, dirname(plugin_basename(KADP_PLUGIN_FILE)) . '/languages/');
  }
}
