<?php

if (!defined('ABSPATH')) {
  exit;
}

class KADP_REST_API
{
  public function register_routes()
  {
    register_rest_route('kadp/v1', '/duplicate', [
      'methods'  => 'POST',
      'callback' => [$this, 'duplicate_post'],
      'permission_callback' => [$this, 'permission']
    ]);

    register_rest_route('kadp/v1', '/ai-rewrite', [
      'methods'  => 'POST',
      'callback' => [$this, 'ai_rewrite'],
      'permission_callback' => [$this, 'permission']
    ]);
  }

  /**
   * PERMISSION
   */
  public function permission()
  {
    return current_user_can('edit_posts');
  }

  /**
   * DUPLICATE VIA API
   */
  public function duplicate_post($request)
  {
    $post_id = intval($request['post_id']);

    $engine = new KADP_Duplicate_Engine();
    $new_id = $engine->duplicate($post_id);

    if (is_wp_error($new_id)) {
      return ['error' => $new_id->get_error_message()];
    }

    return [
      'success' => true,
      'new_post_id' => $new_id
    ];
  }

  /**
   * AI REWRITE VIA API
   */
  public function ai_rewrite($request)
  {
    $content = sanitize_text_field($request['content']);

    $ai = new KADP_AI_Manager();
    $result = $ai->rewrite_content($content);

    return [
      'success' => true,
      'content' => $result
    ];
  }
}
