<?php

if (!defined('ABSPATH')) exit;

$posts = get_posts([
  'numberposts' => 20,
  'post_status' => 'publish'
]);

?>

<div class="wrap kadp-bulk-duplicate">

  <div class="kadp-header">
    <h1>Bulk Duplicate Posts</h1>
    <p class="kadp-subtitle">Select multiple posts and duplicate them instantly</p>
  </div>

  <div class="kadp-card kadp-bulk-card">

    <div class="kadp-card-header">
      <h3>Select Posts</h3>
    </div>

    <!-- SELECT ALL -->
    <div class="kadp-select-all">
      <label class="kadp-checkbox kadp-checkbox-main">
        <input type="checkbox" id="kadp-select-all">
        <span></span>
        <strong>Select All</strong>
      </label>
    </div>

    <!-- LIST -->
    <div class="kadp-post-list">

      <?php if (!empty($posts)) : ?>
        <?php foreach ($posts as $post): ?>
          <label class="kadp-checkbox">
            <input type="checkbox" class="kadp-post-checkbox" value="<?php echo esc_attr($post->ID); ?>">
            <span></span>
            <?php echo esc_html($post->post_title); ?>
          </label>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="kadp-empty">No posts found</p>
      <?php endif; ?>

    </div>

    <!-- ACTION -->
    <div class="kadp-actions">
      <button class="button button-primary kadp-bulk-duplicate-btn">
        ⚡ Duplicate Selected
      </button>
    </div>

    <!-- RESULT -->
    <div id="kadp-bulk-result" class="kadp-result-box"></div>

  </div>

</div>