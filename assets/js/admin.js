jQuery(document).ready(function ($) {
  $(document).on("click", ".kadp-delete-history", function () {
    let id = $(this).data("id");

    if (!confirm("Are you sure you want to delete this record?")) {
      return;
    }

    $.post(
      kadp_ajax.ajax_url,
      {
        action: "kadp_delete_history",
        id: id,
        nonce: kadp_ajax.nonce,
      },
      function (res) {
        if (res.success) {
          $("#kadp-row-" + id).fadeOut();
        } else {
          alert(res.data.message || "Delete failed");
        }
      },
    );
  });
});
