<?php

if (!defined('ABSPATH')) {
  exit;
}

class KADP_Admin_Assets
{
  public function enqueue($hook)
  {
    /**
     * SAFE PAGE CHECK
     */
    $page = isset($_GET['page']) ? sanitize_text_field($_GET['page']) : '';

    if (!$page || strpos($page, 'kadp-') === false) {
      return;
    }

    /**
     * =========================
     * GLOBAL CSS
     * =========================
     */
    wp_enqueue_style(
      'kadp-admin',
      KADP_PLUGIN_URL . 'assets/css/admin.css',
      [],
      KADP_VERSION
    );

    wp_enqueue_style(
      'kadp-dashboard',
      KADP_PLUGIN_URL . 'assets/css/dashboard.css',
      [],
      KADP_VERSION
    );

    wp_enqueue_style(
      'kadp-settings',
      KADP_PLUGIN_URL . 'assets/css/settings.css',
      [],
      KADP_VERSION
    );

    /**
     * =========================
     * GLOBAL JS
     * =========================
     */
    wp_enqueue_script(
      'kadp-admin',
      KADP_PLUGIN_URL . 'assets/js/admin.js',
      ['jquery'],
      KADP_VERSION,
      true
    );

    /**
     * LOCALIZE (IMPORTANT)
     */
    wp_localize_script('kadp-admin', 'kadp_ajax', [
      'ajax_url' => admin_url('admin-ajax.php'),
      'nonce'    => wp_create_nonce('kadp_nonce')
    ]);

    /**
     * =========================
     * PAGE BASED LOADING (SMART)
     * =========================
     */

    /**
     * DASHBOARD
     */
    if ($page === 'kadp-dashboard') {

      wp_enqueue_script(
        'chart-js',
        KADP_PLUGIN_URL . 'assets/vendor/chart.min.js',
        [],
        KADP_VERSION,
        true
      );

      wp_enqueue_script(
        'kadp-dashboard',
        KADP_PLUGIN_URL . 'assets/js/dashboard.js',
        ['jquery', 'chart-js'],
        KADP_VERSION,
        true
      );
    }

    /**
     * DUPLICATE 
     */
    if (in_array($page, ['kadp-duplicate', 'kadp-bulk'])) {

      wp_enqueue_script(
        'kadp-duplicate',
        KADP_PLUGIN_URL . 'assets/js/duplicate.js',
        ['jquery'],
        KADP_VERSION,
        true
      );
    }

    /**
     * AI TOOLS
     */
    if ($page === 'kadp-ai-tools') {

      wp_enqueue_style(
        'kadp-ai',
        KADP_PLUGIN_URL . 'assets/css/ai-tools.css',
        [],
        KADP_VERSION
      );

      wp_enqueue_script(
        'kadp-ai',
        KADP_PLUGIN_URL . 'assets/js/ai-tools.js',
        ['jquery'],
        KADP_VERSION,
        true
      );
    }

    /**
     * AUTOMATION
     */
    if ($page === 'kadp-automation') {

      wp_enqueue_style(
        'kadp-automation',
        KADP_PLUGIN_URL . 'assets/css/automation.css',
        [],
        KADP_VERSION
      );

      wp_enqueue_script(
        'kadp-automation',
        KADP_PLUGIN_URL . 'assets/js/automation.js',
        ['jquery'],
        KADP_VERSION,
        true
      );
    }

    /**
     * SETTINGS
     */
    if ($page === 'kadp-settings') {

      wp_enqueue_style(
        'kadp-settings-extra',
        KADP_PLUGIN_URL . 'assets/css/settings.css',
        [],
        KADP_VERSION
      );
    }
  }
}
