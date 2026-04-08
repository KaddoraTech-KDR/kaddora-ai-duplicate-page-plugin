<?php

$model = new KADP_Automation_Model();

// Save
if ($_POST && isset($_POST['kadp_save_auto'])) {
  $model->insert($_POST);
  echo '<div class="notice notice-success"><p>Automation saved</p></div>';
}

$jobs = $model->get_all();

?>

<div class="wrap kadp-automation">

  <div class="kadp-header">
    <h1>Automation</h1>
    <p class="kadp-subtitle">Automate post duplication tasks with scheduled jobs</p>
  </div>

  <?php
  if ($_POST && isset($_POST['kadp_save_auto'])) {
    echo '<div class="kadp-notice success"><p>Automation saved</p></div>';
  }
  ?>

  <!-- CREATE -->
  <form method="post" class="kadp-card kadp-form-card">

    <div class="kadp-card-header">
      <h3>Create Automation</h3>
    </div>

    <div class="kadp-form-grid">

      <div class="kadp-field">
        <label>Automation Name</label>
        <input type="text" name="name" placeholder="Enter name" required>
      </div>

      <div class="kadp-field">
        <label>Post ID</label>
        <input type="number" name="post_id" placeholder="Enter post ID" required>
      </div>

      <div class="kadp-field">
        <label>Frequency</label>
        <select name="frequency">
          <option value="daily">Daily</option>
          <option value="hourly">Hourly</option>
        </select>
      </div>

    </div>

    <div class="kadp-actions">
      <button name="kadp_save_auto" class="button button-primary kadp-btn">
        💾 Save Automation
      </button>
    </div>

  </form>

  <!-- LIST -->
  <div class="kadp-card">

    <div class="kadp-card-header">
      <h3>Automation Jobs</h3>
    </div>

    <div class="kadp-table-wrap">
      <table class="widefat striped kadp-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Post</th>
            <th>Next Run</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>
          <?php if (!empty($jobs)) : ?>
            <?php foreach ($jobs as $job): ?>
              <tr id="kadp-job-<?php echo esc_attr($job->id); ?>">

                <td><?php echo esc_html($job->id); ?></td>
                <td><?php echo esc_html($job->name); ?></td>
                <td><?php echo esc_html($job->source_post_id); ?></td>
                <td><?php echo esc_html($job->next_run); ?></td>

                <td>
                  <span class="kadp-status <?php echo esc_attr($job->status); ?>">
                    <?php echo esc_html($job->status); ?>
                  </span>
                </td>

                <td class="kadp-actions-inline">

                  <button
                    class="button kadp-delete-job kadp-btn-danger"
                    data-id="<?php echo esc_attr($job->id); ?>">
                    Delete
                  </button>

                  <button
                    class="button kadp-toggle-job kadp-btn-secondary"
                    data-id="<?php echo esc_attr($job->id); ?>"
                    data-status="<?php echo esc_attr($job->status); ?>">
                    <?php echo ($job->status === 'active') ? 'Pause' : 'Resume'; ?>
                  </button>

                </td>

              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="6" class="kadp-empty">No automation jobs found</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </div>

</div>