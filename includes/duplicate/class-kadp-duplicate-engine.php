<?php

if (!defined('ABSPATH')) {
  exit;
}

class KADP_Duplicate_Engine
{
  /**
   * DUPLICATE POST
   */
  public function duplicate($post_id, $args = [])
  {
    $post = get_post($post_id);

    if (!$post) {
      return new WP_Error('invalid_post', 'Post not found');
    }

    /**
     * DEFAULT SETTINGS
     */
    $defaults = [
      'status'       => get_option('kadp_default_status', 'draft'),
      'title_prefix' => get_option('kadp_title_prefix', 'Copy of '),
      'title_suffix' => '',
    ];

    $args = wp_parse_args($args, $defaults);

    /**
     * CREATE NEW POST
     */
    $new_post = [
      'post_title'   => $args['title_prefix'] . $post->post_title . $args['title_suffix'],
      'post_content' => $post->post_content,
      'post_excerpt' => $post->post_excerpt,
      'post_status'  => $args['status'],
      'post_type'    => $post->post_type,
      'post_author'  => get_current_user_id(),
    ];

    $new_post_id = wp_insert_post($new_post);

    /**
     * ERROR HANDLING (POST CREATION FAILED)
     */
    if (is_wp_error($new_post_id)) {

      $history = new KADP_History_Model();
      $history->insert([
        'original_post_id'   => $post_id,
        'duplicated_post_id' => 0,
        'action_type'        => 'duplicate',
        'status'             => 'failed'
      ]);

      return $new_post_id;
    }

    /**
     * DUPLICATE META
     */
    $meta = new KADP_Duplicate_Meta();
    $meta->copy($post_id, $new_post_id);

    /**
     * DUPLICATE TAXONOMY
     */
    $tax = new KADP_Duplicate_Taxonomy();
    $tax->copy($post_id, $new_post_id);

    /**
     * DUPLICATE MEDIA
     */
    $media = new KADP_Duplicate_Media();
    $media->copy_featured_image($post_id, $new_post_id);

    /**
     * TRIGGER INTEGRATIONS (Elementor, Woo, SEO)
     */
    do_action('kadp_after_duplicate', $post_id, $new_post_id);

    /**
     * FINAL SUCCESS LOG
     */
    $history = new KADP_History_Model();
    $history->insert([
      'original_post_id'   => $post_id,
      'duplicated_post_id' => $new_post_id,
      'action_type'        => 'duplicate',
      'status'             => 'success'
    ]);

    return $new_post_id;
  }
}
