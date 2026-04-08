<?php

if (!defined('ABSPATH')) {
  exit;
}

class KADP_Ajax
{
  // delete_ai_log
  public function delete_ai_log()
  {
    $this->verify_request();

    if (!current_user_can('manage_options')) {
      wp_send_json_error(['message' => 'Permission denied']);
    }

    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if (!$id) {
      wp_send_json_error(['message' => 'Invalid ID']);
    }

    global $wpdb;

    $table = $wpdb->prefix . 'kadp_ai_logs';

    $deleted = $wpdb->delete($table, ['id' => $id], ['%d']);

    if ($deleted) {
      wp_send_json_success(['message' => 'Deleted']);
    } else {
      wp_send_json_error(['message' => 'Delete failed']);
    }
  }

  // toggle_job
  public function toggle_job()
  {
    $this->verify_request();

    if (!current_user_can('manage_options')) {
      wp_send_json_error(['message' => 'Permission denied']);
    }

    $id = intval($_POST['id']);
    $status = sanitize_text_field($_POST['status']);

    $new_status = ($status === 'active') ? 'paused' : 'active';

    global $wpdb;

    $table = $wpdb->prefix . 'kadp_automation';

    $updated = $wpdb->update(
      $table,
      ['status' => $new_status],
      ['id' => $id],
      ['%s'],
      ['%d']
    );

    if ($updated !== false) {
      wp_send_json_success(['message' => 'Updated']);
    } else {
      wp_send_json_error(['message' => 'Update failed']);
    }
  }

  //  delete_job
  public function delete_job()
  {
    $this->verify_request();

    if (!current_user_can('manage_options')) {
      wp_send_json_error(['message' => 'Permission denied']);
    }

    $id = intval($_POST['id']);

    global $wpdb;

    $table = $wpdb->prefix . 'kadp_automation';

    $deleted = $wpdb->delete($table, ['id' => $id], ['%d']);

    if ($deleted) {
      wp_send_json_success(['message' => 'Deleted']);
    } else {
      wp_send_json_error(['message' => 'Delete failed']);
    }
  }

  // delete_history
  public function delete_history()
  {
    $this->verify_request();

    if (!current_user_can('manage_options')) {
      wp_send_json_error(['message' => 'Permission denied']);
    }

    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if (!$id) {
      wp_send_json_error(['message' => 'Invalid ID']);
    }

    global $wpdb;

    $table = $wpdb->prefix . 'kadp_history';

    $deleted = $wpdb->delete($table, ['id' => $id], ['%d']);

    if ($deleted) {
      wp_send_json_success(['message' => 'Deleted']);
    } else {
      wp_send_json_error(['message' => 'Delete failed']);
    }
  }

  // bulk_duplicate
  public function bulk_duplicate()
  {
    while (ob_get_level()) {
      ob_end_clean();
    }
    $this->verify_request();

    $post_ids = isset($_POST['post_ids']) ? (array) $_POST['post_ids'] : [];

    if (empty($post_ids)) {
      wp_send_json_error(['message' => 'No posts selected']);
    }

    $engine = new KADP_Duplicate_Engine();

    $count = 0;

    foreach ($post_ids as $post_id) {

      $result = $engine->duplicate(intval($post_id));

      if (!is_wp_error($result)) {
        $count++;
      }
    }

    wp_send_json_success([
      'message' => "{$count} posts duplicated successfully"
    ]);
  }

  // bulk_ai_rewrite
  public function bulk_ai_rewrite()
  {
    $this->verify_request();

    $post_ids = isset($_POST['post_ids']) ? (array) $_POST['post_ids'] : [];

    if (empty($post_ids)) {
      wp_send_json_error(['message' => 'No posts selected']);
    }

    $ai = new KADP_AI_Manager();

    $results = [];

    foreach ($post_ids as $post_id) {

      $post = get_post($post_id);

      if (!$post) continue;

      $new_content = $ai->rewrite_content($post->post_content);

      wp_update_post([
        'ID' => $post_id,
        'post_content' => $new_content
      ]);

      $results[] = $post_id;
    }

    wp_send_json_success([
      'message' => count($results) . ' posts rewritten',
      'ids' => $results
    ]);
  }

  /**
   * DUPLICATE VIA AJAX
   */
  public function duplicate()
  {
    while (ob_get_level()) {
      ob_end_clean();
    }

    $this->verify_request();

    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;

    if (!$post_id) {
      wp_send_json_error(['message' => 'Invalid post ID']);
    }

    if (!current_user_can('edit_post', $post_id)) {
      wp_send_json_error(['message' => 'Permission denied']);
    }

    $engine = new KADP_Duplicate_Engine();
    $new_post_id = $engine->duplicate($post_id);

    if (is_wp_error($new_post_id)) {
      wp_send_json_error(['message' => $new_post_id->get_error_message()]);
    }

    wp_send_json_success([
      'message' => 'Post duplicated successfully',
      'new_post_id' => $new_post_id,
      'edit_link' => get_edit_post_link($new_post_id)
    ]);
  }

  /**
   * AI REWRITE
   */
  public function ai_rewrite()
  {
    $this->verify_request();

    $content = isset($_POST['content']) ? wp_kses_post($_POST['content']) : '';

    if (empty($content)) {
      wp_send_json_error(['message' => 'Content is empty']);
    }

    /**
     * AI CALL
     */
    $ai = new KADP_AI_Manager();

    $response = $ai->rewrite_content($content);

    if (!$response) {
      wp_send_json_error(['message' => 'AI failed']);
    }

    wp_send_json_success([
      'message' => 'AI rewrite complete',
      'content' => $response
    ]);
  }

  /**
   * SECURITY CHECK
   */
  private function verify_request()
  {
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'kadp_nonce')) {
      wp_send_json_error(['message' => 'Invalid nonce']);
    }
  }
}
