<?php

if (!defined('ABSPATH')) {
  exit;
}

class KADP_Activator
{
  public static function activate()
  {
    self::create_tables();
    self::set_version();
  }

  /**
   * CREATE TABLES
   */
  private static function create_tables()
  {
    if (!class_exists('KADP_DB_Schema')) {
      require_once KADP_PLUGIN_DIR . 'includes/db/class-kadp-db-schema.php';
    }

    $schema = new KADP_DB_Schema();
    $schema->create_tables();
  }

  /**
   * SAVE VERSION
   */
  private static function set_version()
  {
    update_option('kadp_version', KADP_VERSION);
  }
}
