<?php

if (!defined('ABSPATH')) {
  exit;
}

class KADP_Bulk_Duplicate
{
  /**
   * INIT
   */
  public function init()
  {
    // Add bulk action
    add_filter('bulk_actions-edit-post', [$this, 'register_bulk_action']);
    add_filter('bulk_actions-edit-page', [$this, 'register_bulk_action']);

    // Handle bulk action
    add_filter('handle_bulk_actions-edit-post', [$this, 'handle_bulk'], 10, 3);
    add_filter('handle_bulk_actions-edit-page', [$this, 'handle_bulk'], 10, 3);

    // Admin notice
    add_action('admin_notices', [$this, 'admin_notice']);
  }

  /**
   * REGISTER BULK ACTION
   */
  public function register_bulk_action($actions)
  {
    $actions['kadp_bulk_duplicate'] = 'Duplicate';

    return $actions;
  }

  /**
   * HANDLE BULK DUPLICATION
   */
  public function handle_bulk($redirect_to, $doaction, $post_ids)
  {
    if ($doaction !== 'kadp_bulk_duplicate') {
      return $redirect_to;
    }

    if (empty($post_ids)) {
      return $redirect_to;
    }

    if (!current_user_can('edit_posts')) {
      return $redirect_to;
    }

    $engine = new KADP_Duplicate_Engine();

    $count = 0;

    foreach ($post_ids as $post_id) {

      // Safety: permission check per post
      if (!current_user_can('edit_post', $post_id)) {
        continue;
      }

      $result = $engine->duplicate($post_id);

      if (!is_wp_error($result)) {
        $count++;
      }
    }

    /**
     * REDIRECT WITH RESULT
     */
    $redirect_to = add_query_arg(
      'kadp_bulk_done',
      $count,
      $redirect_to
    );

    return $redirect_to;
  }

  /**
   * ADMIN NOTICE
   */
  public function admin_notice()
  {
    if (!isset($_GET['kadp_bulk_done'])) {
      return;
    }

    $count = intval($_GET['kadp_bulk_done']);

    echo '<div class="notice notice-success is-dismissible">';
    echo '<p>' . $count . ' posts duplicated successfully.</p>';
    echo '</div>';
  }
}
