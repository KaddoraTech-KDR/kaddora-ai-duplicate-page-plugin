<?php

$model = new KADP_History_Model();

// Filters
$filters = [
  'user' => isset($_GET['user']) ? intval($_GET['user']) : '',
  'date' => isset($_GET['date']) ? sanitize_text_field($_GET['date']) : ''
];

$rows = (!empty($filters['user']) || !empty($filters['date']))
  ? $model->filter($filters)
  : $model->get_all();

?>

<div class="wrap kadp-history">

  <div class="kadp-header">
    <h1>Kaddora AI History</h1>
    <p class="kadp-subtitle">Track duplication activity and user actions</p>
  </div>

  <!-- FILTER -->
  <form method="get" class="kadp-card kadp-filter-bar">
    <input type="hidden" name="page" value="kadp-history">

    <div class="kadp-filter-group">
      <div class="kadp-field">
        <label>Date</label>
        <input type="date" name="date" value="<?php echo esc_attr($filters['date']); ?>">
      </div>

      <div class="kadp-field">
        <label>User ID</label>
        <input type="number" name="user" placeholder="Enter User ID"
          value="<?php echo esc_attr($filters['user']); ?>">
      </div>

      <div class="kadp-filter-actions">
        <button class="button button-primary kadp-btn-filter">Apply Filter</button>
      </div>
    </div>
  </form>

  <!-- TABLE -->
  <div class="kadp-card">
    <div class="kadp-card-header">
      <h3>History Records</h3>
    </div>

    <div class="kadp-table-wrap">
      <table class="widefat striped kadp-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Original</th>
            <th>Duplicate</th>
            <th>User</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>
          <?php if (!empty($rows)) : ?>
            <?php foreach ($rows as $row) : ?>
              <tr id="kadp-row-<?php echo esc_attr($row->id); ?>">
                <td><?php echo esc_html($row->id); ?></td>
                <td><?php echo esc_html($row->original_post_id); ?></td>
                <td><?php echo esc_html($row->duplicated_post_id); ?></td>
                <td><?php echo esc_html($row->user_id); ?></td>
                <td><?php echo esc_html($row->created_at); ?></td>

                <td>
                  <button
                    class="button kadp-delete-history kadp-btn-danger"
                    data-id="<?php echo esc_attr($row->id); ?>">
                    Delete
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="6" class="kadp-empty">No history found</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </div>

</div>