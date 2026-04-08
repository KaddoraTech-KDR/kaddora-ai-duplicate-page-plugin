<?php
if (!defined('ABSPATH')) {
  exit;
}

class KADP_Admin_Settings
{
  public function init()
  {
    add_action('admin_init', [$this, 'register_settings']);
  }

  /**
   * REGISTER SETTINGS
   */
  public function register_settings()
  {
    // API Key
    register_setting('kadp_settings_group', 'kadp_api_key', [
      'sanitize_callback' => 'sanitize_text_field'
    ]);

    // Enable AI
    register_setting('kadp_settings_group', 'kadp_enable_ai', [
      'sanitize_callback' => [$this, 'sanitize_checkbox']
    ]);

    // Default Status
    register_setting('kadp_settings_group', 'kadp_default_status', [
      'sanitize_callback' => 'sanitize_text_field'
    ]);

    // Title Prefix
    register_setting('kadp_settings_group', 'kadp_title_prefix', [
      'sanitize_callback' => 'sanitize_text_field'
    ]);

    // Webhook URL
    register_setting('kadp_settings_group', 'kadp_webhook_url', [
      'sanitize_callback' => 'esc_url_raw'
    ]);
  }

  /**
   * SANITIZE CHECKBOX
   */
  public function sanitize_checkbox($value)
  {
    return $value == '1' ? 1 : 0;
  }
}
