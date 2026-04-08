<?php
$history_model = new KADP_History_Model();
$ai_model = new KADP_AI_Log_Model();

$history = $history_model->get_all(50);
$ai_logs = $ai_model->get_all(50);

$total_duplicates = count($history);
$total_ai = count($ai_logs);
?>

<div class="wrap kadp-dashboard">

  <div class="kadp-header">
    <h1>Kaddora AI Dashboard</h1>
    <p class="kadp-subtitle">Monitor duplication activity and AI usage</p>
  </div>

  <!-- STATS -->
  <div class="kadp-grid">

    <div class="kadp-card kadp-stat-card">
      <div class="kadp-stat-icon">📄</div>
      <div class="kadp-stat-content">
        <h3>Total Duplicates</h3>
        <p><?php echo esc_html($total_duplicates); ?></p>
      </div>
    </div>

    <div class="kadp-card kadp-stat-card">
      <div class="kadp-stat-icon">🤖</div>
      <div class="kadp-stat-content">
        <h3>AI Requests</h3>
        <p><?php echo esc_html($total_ai); ?></p>
      </div>
    </div>

    <div class="kadp-card kadp-stat-card">
      <div class="kadp-stat-icon">⚡</div>
      <div class="kadp-stat-content">
        <h3>Status</h3>
        <p class="kadp-status-active">Active</p>
      </div>
    </div>

  </div>

  <!-- RECENT HISTORY -->
  <div class="kadp-card">
    <div class="kadp-card-header">
      <h2>Recent Activity</h2>
    </div>

    <div class="kadp-table-wrap">
      <table class="widefat striped kadp-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Original</th>
            <th>Duplicate</th>
            <th>Date</th>
          </tr>
        </thead>

        <tbody>
          <?php if (!empty($history)) : ?>
            <?php foreach ($history as $row) : ?>
              <tr>
                <td><?php echo esc_html($row->id); ?></td>
                <td><?php echo esc_html($row->original_post_id); ?></td>
                <td><?php echo esc_html($row->duplicated_post_id); ?></td>
                <td><?php echo esc_html($row->created_at); ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="4" class="kadp-empty">No data found</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </div>

</div>