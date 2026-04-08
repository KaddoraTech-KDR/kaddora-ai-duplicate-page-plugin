<?php

/**
 * Plugin Name: Kaddora AI Duplicate Page Plugin
 * Plugin URI: https://kaddora.com
 * Description: Duplicate WordPress pages with AI-powered enhancements and automation.
 * Version: 1.0.0
 * Author: Kaddora
 * Text Domain: kadp
 * Author URI: https://kaddora.com
 * License: GPL2+
 */

if (!defined('ABSPATH')) {
  exit;
}

/**
 * ---------------------------------------------------
 * DEFINE CONSTANTS
 * ---------------------------------------------------
 */
define('KADP_VERSION', '1.0.0');
define('KADP_PLUGIN_FILE', __FILE__);
define('KADP_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('KADP_PLUGIN_URL', plugin_dir_url(__FILE__));
define('KADP_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * ---------------------------------------------------
 * LOAD CORE LOADER
 * ---------------------------------------------------
 */
require_once KADP_PLUGIN_DIR . 'includes/class-kadp-loader.php';
require_once KADP_PLUGIN_DIR . 'includes/class-kadp-activator.php';
require_once KADP_PLUGIN_DIR . 'includes/class-kadp-deactivator.php';

register_activation_hook(__FILE__, ['KADP_Activator', 'activate']);
register_deactivation_hook(__FILE__, ['KADP_Deactivator', 'deactivate']);

/**
 * ---------------------------------------------------
 * INITIALIZE PLUGIN
 * ---------------------------------------------------
 */
function kadp_run_plugin()
{
  $plugin = new KADP_Loader();
  $plugin->run();
}

kadp_run_plugin();
