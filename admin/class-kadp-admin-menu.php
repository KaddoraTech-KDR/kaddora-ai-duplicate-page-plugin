<?php

if (!defined('ABSPATH')) {
  exit;
}

class KADP_Admin_Menu
{
  /**
   * register_menu
   */
  public function register_menu()
  {
    add_menu_page(
      __('Kaddora AI', 'kadp'),
      __('Kaddora AI', 'kadp'),
      'manage_options',
      'kadp-dashboard',
      [$this, 'dashboard'],
      'dashicons-superhero',
      25
    );

    add_submenu_page(
      'kadp-dashboard',
      __('Dashboard', 'kadp'),
      __('Dashboard', 'kadp'),
      'manage_options',
      'kadp-dashboard',
      [$this, 'dashboard']
    );

    add_submenu_page(
      'kadp-dashboard',
      __('Duplicate', 'kadp'),
      __('Duplicate', 'kadp'),
      'manage_options',
      'kadp-duplicate',
      [$this, 'duplicate']
    );

    add_submenu_page(
      'kadp-dashboard',
      __('Bulk Duplicate', 'kadp'),
      __('Bulk Duplicate', 'kadp'),
      'manage_options',
      'kadp-bulk',
      [$this, 'bulk']
    );

    add_submenu_page(
      'kadp-dashboard',
      __('AI Tools', 'kadp'),
      __('AI Tools', 'kadp'),
      'manage_options',
      'kadp-ai-tools',
      [$this, 'ai_tools']
    );

    add_submenu_page(
      'kadp-dashboard',
      __('Automation', 'kadp'),
      __('Automation', 'kadp'),
      'manage_options',
      'kadp-automation',
      [$this, 'automation']
    );

    add_submenu_page(
      'kadp-dashboard',
      __('History', 'kadp'),
      __('History', 'kadp'),
      'manage_options',
      'kadp-history',
      [$this, 'history']
    );

    add_submenu_page(
      'kadp-dashboard',
      __('Settings', 'kadp'),
      __('Settings', 'kadp'),
      'manage_options',
      'kadp-settings',
      [$this, 'settings']
    );
  }

  // dashboard
  public function dashboard()
  {
    KADP_Admin::render('dashboard');
  }

  // duplicate
  public function duplicate()
  {
    KADP_Admin::render('duplicate-posts');
  }

  // bulk
  public function bulk()
  {
    KADP_Admin::render('bulk-duplicate');
  }

  // ai_tools
  public function ai_tools()
  {
    KADP_Admin::render('ai-tools');
  }

  // automation
  public function automation()
  {
    KADP_Admin::render('automation');
  }

  // history
  public function history()
  {
    KADP_Admin::render('history');
  }

  // settings
  public function settings()
  {
    KADP_Admin::render('settings');
  }
}
