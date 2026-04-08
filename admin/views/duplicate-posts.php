<div class="wrap kadp-duplicate-page">

  <div class="kadp-header">
    <h1>Duplicate Post</h1>
    <p class="kadp-subtitle">Quickly duplicate any existing post with one click</p>
  </div>

  <div class="kadp-card kadp-duplicate-card">

    <div class="kadp-card-header">
      <h3>Select Post</h3>
    </div>

    <div class="kadp-field">
      <label>Choose a Post</label>
      <select id="kadp-post-id" class="kadp-input">
        <?php
        $posts = get_posts(['numberposts' => 20]);
        foreach ($posts as $post) {
          echo '<option value="' . $post->ID . '">' . esc_html($post->post_title) . '</option>';
        }
        ?>
      </select>
    </div>

    <div class="kadp-actions">
      <button class="button button-primary kadp-duplicate-btn">
        ⚡ Duplicate Now
      </button>
    </div>

    <div id="kadp-single-result" class="kadp-result-box"></div>

  </div>

</div>