<div class="wrap kadp-settings-page">

  <div class="kadp-header">
    <h1>Kaddora AI Settings</h1>
    <p class="kadp-subtitle">Configure AI, duplication, and integrations</p>
  </div>

  <?php
  if (isset($_GET['settings-updated'])) {
    echo '<div class="kadp-notice success"><p>Settings saved successfully.</p></div>';
  }
  ?>

  <form method="post" action="options.php" class="kadp-form">
    <?php settings_fields('kadp_settings_group'); ?>

    <!-- API SETTINGS -->
    <div class="kadp-card">
      <div class="kadp-card-header">
        <h2>🔑 API Configuration</h2>
      </div>

      <div class="kadp-field">
        <label>OpenAI API Key</label>
        <input type="password"
          name="kadp_api_key"
          value="<?php echo esc_attr(get_option('kadp_api_key')); ?>"
          placeholder="Enter your API key..." />

        <p class="description">Required for AI features like rewrite & SEO.</p>
      </div>

      <div class="kadp-field-inline">
        <label class="kadp-toggle">
          <input type="checkbox" name="kadp_enable_ai" value="1"
            <?php checked(1, get_option('kadp_enable_ai')); ?> />
          <span></span>
          Enable AI Features
        </label>
      </div>
    </div>

    <!-- DUPLICATE SETTINGS -->
    <div class="kadp-card">
      <div class="kadp-card-header">
        <h2>📄 Duplicate Settings</h2>
      </div>

      <div class="kadp-field">
        <label>Default Status</label>
        <select name="kadp_default_status">
          <option value="draft" <?php selected(get_option('kadp_default_status'), 'draft'); ?>>Draft</option>
          <option value="publish" <?php selected(get_option('kadp_default_status'), 'publish'); ?>>Publish</option>
          <option value="private" <?php selected(get_option('kadp_default_status'), 'private'); ?>>Private</option>
        </select>
      </div>

      <div class="kadp-field">
        <label>Title Prefix</label>
        <input type="text" name="kadp_title_prefix"
          value="<?php echo esc_attr(get_option('kadp_title_prefix', 'Copy of ')); ?>" />
      </div>
    </div>

    <!-- WEBHOOK -->
    <div class="kadp-card">
      <div class="kadp-card-header">
        <h2>🔗 Webhooks</h2>
      </div>

      <div class="kadp-field">
        <label>Webhook URL</label>
        <input type="url" name="kadp_webhook_url"
          value="<?php echo esc_attr(get_option('kadp_webhook_url')); ?>"
          placeholder="https://your-app.com/webhook" />
      </div>
    </div>

    <!-- SAVE -->
    <div class="kadp-save">
      <?php submit_button('💾 Save Settings', 'primary kadp-btn'); ?>
    </div>

  </form>
</div>