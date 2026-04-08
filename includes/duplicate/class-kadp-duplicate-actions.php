<?php

if (!defined('ABSPATH')) {
  exit;
}

class KADP_Duplicate_Actions
{
  /**
   * INIT HOOKS
   */
  public function init()
  {
    // Add row action (post list)
    add_filter('post_row_actions', [$this, 'add_duplicate_link'], 10, 2);
    add_filter('page_row_actions', [$this, 'add_duplicate_link'], 10, 2);

    // Handle duplicate action
    add_action('admin_action_kadp_duplicate', [$this, 'handle_duplicate']);

    // Admin notice
    add_action('admin_notices', [$this, 'admin_notice']);
  }

  /**
   * ADD DUPLICATE LINK
   */
  public function add_duplicate_link($actions, $post)
  {
    if (!current_user_can('edit_posts')) {
      return $actions;
    }

    $url = wp_nonce_url(
      admin_url('admin.php?action=kadp_duplicate&post_id=' . $post->ID),
      'kadp_duplicate_nonce'
    );

    $actions['kadp_duplicate'] = '<a href="' . esc_url($url) . '">Duplicate</a>';

    return $actions;
  }

  /**
   * HANDLE DUPLICATION
   */
  public function handle_duplicate()
  {
    // Security check
    if (!isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'kadp_duplicate_nonce')) {
      wp_die('Security check failed');
    }

    if (!isset($_GET['post_id'])) {
      wp_die('No post ID');
    }

    $post_id = intval($_GET['post_id']);

    if (!current_user_can('edit_post', $post_id)) {
      wp_die('Permission denied');
    }

    /**
     * CALL ENGINE
     */
    $engine = new KADP_Duplicate_Engine();
    $new_post_id = $engine->duplicate($post_id);

    if (is_wp_error($new_post_id)) {
      wp_die($new_post_id->get_error_message());
    }

    /**
     * REDIRECT WITH SUCCESS
     */
    wp_redirect(
      add_query_arg([
        'kadp_duplicated' => 1,
        'new_post_id'     => $new_post_id
      ], admin_url('edit.php'))
    );
    exit;
  }

  /**
   * ADMIN NOTICE
   */
  public function admin_notice()
  {
    if (!isset($_GET['kadp_duplicated'])) {
      return;
    }

    $new_post_id = isset($_GET['new_post_id']) ? intval($_GET['new_post_id']) : 0;

    $edit_link = $new_post_id ? get_edit_post_link($new_post_id) : '#';

    echo '<div class="notice notice-success is-dismissible">';
    echo '<p>Post duplicated successfully. <a href="' . esc_url($edit_link) . '">Edit new post</a></p>';
    echo '</div>';
  }
}
