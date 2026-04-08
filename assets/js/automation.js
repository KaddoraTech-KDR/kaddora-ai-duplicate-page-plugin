jQuery(document).ready(function ($) {
  // delete
  $(document).on("click", ".kadp-delete-job", function () {
    let id = $(this).data("id");

    if (!confirm("Delete this automation?")) return;

    $.post(
      kadp_ajax.ajax_url,
      {
        action: "kadp_delete_job",
        id: id,
        nonce: kadp_ajax.nonce,
      },
      function (res) {
        if (res.success) {
          $("#kadp-job-" + id).fadeOut();
        } else {
          alert(res.data.message || "Delete failed");
        }
      },
    );
  });

  /**
   * TOGGLE STATUS
   */
  $(document).on("click", ".kadp-toggle-job", function () {
    let id = $(this).data("id");
    let status = $(this).data("status");

    $.post(
      kadp_ajax.ajax_url,
      {
        action: "kadp_toggle_job",
        id: id,
        status: status,
        nonce: kadp_ajax.nonce,
      },
      function (res) {
        if (res.success) {
          location.reload();
        } else {
          alert(res.data.message || "Update failed");
        }
      },
    );
  });
});
