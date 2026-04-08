<?php

$log_model = new KADP_AI_Log_Model();
$logs = $log_model->get_all(10);

?>

<div class="wrap kadp-ai-tools">

  <div class="kadp-header">
    <h1>AI Content Rewrite</h1>
    <p class="kadp-subtitle">Rewrite and optimize content using AI</p>
  </div>

  <!-- INPUT -->
  <div class="kadp-card kadp-input-card">

    <div class="kadp-card-header">
      <h3>Enter Content</h3>
    </div>

    <textarea id="kadp-ai-content" class="kadp-textarea"
      placeholder="Write or paste your content here..."></textarea>

    <div class="kadp-actions">
      <button class="button button-primary kadp-ai-rewrite-btn">
        ✨ Rewrite with AI
      </button>
    </div>

  </div>

  <!-- OUTPUT -->
  <div class="kadp-card kadp-output-box">
    <div class="kadp-card-header">
      <h3>Output</h3>
    </div>

    <div id="kadp-ai-output" class="kadp-output-content">
      No output yet...
    </div>
  </div>

  <!-- AI LOGS TABLE -->
  <div class="kadp-card">
    <div class="kadp-card-header">
      <h3>Recent AI Logs</h3>
    </div>

    <div class="kadp-table-wrap">
      <table class="widefat striped kadp-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Status</th>
            <th>Tokens</th>
            <th>Response</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>
          <?php if (!empty($logs)) : ?>
            <?php foreach ($logs as $log): ?>
              <tr>
                <td><?php echo esc_html($log->id); ?></td>
                <td><?php echo esc_html($log->prompt_type); ?></td>
                <td>
                  <span class="kadp-status <?php echo esc_attr($log->status); ?>">
                    <?php echo esc_html($log->status); ?>
                  </span>
                </td>
                <td><?php echo esc_html($log->tokens_used); ?></td>
                <td class="kadp-response-cell">
                  <?php echo esc_html(wp_trim_words($log->response, 15)); ?>
                </td>
                <td><?php echo esc_html($log->created_at); ?></td>
                <td>
                  <button
                    class="button kadp-delete-ai-log kadp-btn-danger"
                    data-id="<?php echo esc_attr($log->id); ?>">
                    Delete
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="7" class="kadp-empty">No logs found</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </div>

</div>