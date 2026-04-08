<?php

if (!defined('ABSPATH')) {
  exit;
}

class KADP_Loader
{
  /**
   * Store all actions & filters
   */
  protected $actions = [];
  protected $filters = [];

  /**
   * Constructor
   */
  public function __construct()
  {
    $this->load_dependencies();
    $this->init_hooks();
  }

  /**
   * ---------------------------------------------------
   * LOAD ALL REQUIRED FILES
   * ---------------------------------------------------
   */
  private function load_dependencies()
  {
    /**
     * Helper function (local)
     */
    $load = function ($class, $path) {

      if (!class_exists($class)) {

        $file = KADP_PLUGIN_DIR . $path;

        if (file_exists($file)) {
          require_once $file;
        } else {
          error_log("KADP File Missing: " . $file);
          return;
        }
      }

      if (!class_exists($class)) {
        error_log("KADP Class Not Found After Load: " . $class);
      }
    };

    /**
     * CORE
     */
    $load('KADP_Helper', 'includes/class-kadp-helper.php');
    $load('KADP_Validator', 'includes/class-kadp-validator.php');
    $load('KADP_i18n', 'includes/class-kadp-i18n.php');

    /**
     * DB
     */
    $load('KADP_DB_Schema', 'includes/db/class-kadp-db-schema.php');
    $load('KADP_History_Model', 'includes/db/class-kadp-history-model.php');
    $load('KADP_AI_Log_Model', 'includes/db/class-kadp-ai-log-model.php');
    $load('KADP_Automation_Model', 'includes/db/class-kadp-automation-model.php');

    /**
     * DUPLICATE SYSTEM
     */
    $load('KADP_Duplicate_Engine', 'includes/duplicate/class-kadp-duplicate-engine.php');
    $load('KADP_Duplicate_Actions', 'includes/duplicate/class-kadp-duplicate-actions.php');
    $load('KADP_Bulk_Duplicate', 'includes/duplicate/class-kadp-bulk-duplicate.php');
    $load('KADP_Duplicate_Media', 'includes/duplicate/class-kadp-duplicate-media.php');
    $load('KADP_Duplicate_Taxonomy', 'includes/duplicate/class-kadp-duplicate-taxonomy.php');
    $load('KADP_Duplicate_Meta', 'includes/duplicate/class-kadp-duplicate-meta.php');

    /**
     * AI SYSTEM
     */
    $load('KADP_AI_Manager', 'includes/ai/class-kadp-ai-manager.php');
    $load('KADP_AI_Prompts', 'includes/ai/class-kadp-ai-prompts.php');
    $load('KADP_AI_Content_Variation', 'includes/ai/class-kadp-ai-content-variation.php');
    $load('KADP_AI_Title_Rewriter', 'includes/ai/class-kadp-ai-title-rewriter.php');
    $load('KADP_AI_SEO_Helper', 'includes/ai/class-kadp-ai-seo-helper.php');

    /**
     * AUTOMATION
     */
    $load('KADP_Automation_Manager', 'includes/automation/class-kadp-automation-manager.php');
    $load('KADP_Recurring_Jobs', 'includes/automation/class-kadp-recurring-jobs.php');
    $load('KADP_Rule_Engine', 'includes/automation/class-kadp-rule-engine.php');
    $load('KADP_Scheduler', 'includes/automation/class-kadp-scheduler.php');
    $load('KADP_Trigger_Hooks', 'includes/automation/class-kadp-trigger-hooks.php');

    /**
     * INTEGRATIONS
     */
    $load('KADP_Elementor', 'includes/integrations/class-kadp-elementor.php');
    $load('KADP_WooCommerce', 'includes/integrations/class-kadp-woocommerce.php');
    $load('KADP_SEO_Plugins', 'includes/integrations/class-kadp-seo-plugins.php');
    $load('KADP_Webhooks', 'includes/integrations/class-kadp-webhooks.php');

    /**
     * ADMIN
     */
    $load('KADP_Admin', 'admin/class-kadp-admin.php');
    $load('KADP_Admin_Menu', 'admin/class-kadp-admin-menu.php');
    $load('KADP_Admin_Assets', 'admin/class-kadp-admin-assets.php');
    $load('KADP_Admin_Settings', 'admin/class-kadp-admin-settings.php');

    /**
     * PUBLIC
     */
    $load('KADP_Public', 'public/class-kadp-public.php');

    /**
     * AJAX + CORE
     */
    $load('KADP_Ajax', 'includes/class-kadp-ajax.php');
    $load('KADP_Capabilities', 'includes/class-kadp-capabilities.php');
    $load('KADP_Post_Types', 'includes/class-kadp-post-types.php');
    $load('KADP_REST_API', 'includes/class-kadp-rest-api.php');
  }

  /**
   * ---------------------------------------------------
   * INITIALIZE HOOKS
   * ---------------------------------------------------
   */
  private function init_hooks()
  {
    /**
     * i18n
     */
    $i18n = new KADP_i18n();
    $this->add_action('plugins_loaded', $i18n, 'load_textdomain');

    /**
     * Admin
     */
    if (is_admin()) {
      $admin = new KADP_Admin();
      $admin_menu = new KADP_Admin_Menu();
      $admin_assets = new KADP_Admin_Assets();
      $admin_settings = new KADP_Admin_Settings();

      $this->add_action('admin_init', $admin_settings, 'register_settings');
      $this->add_action('admin_menu', $admin_menu, 'register_menu');
      $this->add_action('admin_enqueue_scripts', $admin_assets, 'enqueue');
    }

    /**
     * Public
     */
    $public = new KADP_Public();
    $this->add_action('wp_enqueue_scripts', $public, 'enqueue');

    /**
     * AJAX
     */
    $ajax = new KADP_Ajax();
    $this->add_action('wp_ajax_kadp_duplicate', $ajax, 'duplicate');
    $this->add_action('wp_ajax_kadp_ai_rewrite', $ajax, 'ai_rewrite');
    $this->add_action('wp_ajax_kadp_bulk_ai', $ajax, 'bulk_ai_rewrite');
    $this->add_action('wp_ajax_kadp_bulk_duplicate', $ajax, 'bulk_duplicate');
    $this->add_action('wp_ajax_kadp_delete_history', $ajax, 'delete_history');
    $this->add_action('wp_ajax_kadp_delete_job', $ajax, 'delete_job');
    $this->add_action('wp_ajax_kadp_toggle_job', $ajax, 'toggle_job');
    $this->add_action('wp_ajax_kadp_delete_ai_log', $ajax, 'delete_ai_log');

    /**
     * Duplicate System
     */
    $duplicate = new KADP_Duplicate_Actions();
    $this->add_action('admin_init', $duplicate, 'init');

    $bulk = new KADP_Bulk_Duplicate();
    $this->add_action('admin_init', $bulk, 'init');

    /**
     * Automation
     */
    $automation = new KADP_Automation_Manager();
    $this->add_action('init', $automation, 'init');
    $scheduler = new KADP_Scheduler();
    $this->add_action('init', $scheduler, 'init');

    /**
     * Integrations
     */
    $elementor = new KADP_Elementor();
    $this->add_action('init', $elementor, 'init');
    $woo = new KADP_WooCommerce();
    $this->add_action('init', $woo, 'init');
    $seo = new KADP_SEO_Plugins();
    $this->add_action('init', $seo, 'init');
    $webhook = new KADP_Webhooks();
    $this->add_action('init', $webhook, 'init');

    /**
     * REST API
     */
    $rest = new KADP_REST_API();
    $this->add_action('rest_api_init', $rest, 'register_routes');

    /**
     * DB Version Check (IMPORTANT)
     */
    $this->add_action('init', $this, 'check_db_version');

    /**
     * loader
     */
    $this->add_action('init', new KADP_Capabilities(), 'init');
    $this->add_action('init', new KADP_Post_Types(), 'init');
  }

  /**
   * check_db_version
   */
  public function check_db_version()
  {
    $installed_version = get_option('kadp_version');

    if ($installed_version !== KADP_VERSION) {
      require_once KADP_PLUGIN_DIR . 'includes/db/class-kadp-db-schema.php';

      $schema = new KADP_DB_Schema();
      $schema->create_tables();

      update_option('kadp_version', KADP_VERSION);
    }
  }

  /**
   * ---------------------------------------------------
   * ADD ACTION
   * ---------------------------------------------------
   */
  public function add_action($hook, $component, $callback, $priority = 10, $accepted_args = 1)
  {
    $this->actions[] = [
      'hook' => $hook,
      'component' => $component,
      'callback' => $callback,
      'priority' => $priority,
      'accepted_args' => $accepted_args
    ];
  }

  /**
   * ---------------------------------------------------
   * ADD FILTER
   * ---------------------------------------------------
   */
  public function add_filter($hook, $component, $callback, $priority = 10, $accepted_args = 1)
  {
    $this->filters[] = [
      'hook' => $hook,
      'component' => $component,
      'callback' => $callback,
      'priority' => $priority,
      'accepted_args' => $accepted_args
    ];
  }

  /**
   * ---------------------------------------------------
   * RUN ALL HOOKS
   * ---------------------------------------------------
   */
  public function run()
  {
    foreach ($this->actions as $hook) {
      add_action(
        $hook['hook'],
        [$hook['component'], $hook['callback']],
        $hook['priority'],
        $hook['accepted_args']
      );
    }

    foreach ($this->filters as $hook) {
      add_filter(
        $hook['hook'],
        [$hook['component'], $hook['callback']],
        $hook['priority'],
        $hook['accepted_args']
      );
    }
  }
}
