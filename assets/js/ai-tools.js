jQuery(document).ready(function ($) {
  $(".kadp-ai-rewrite-btn").on("click", function () {
    let content = $("#kadp-ai-content").val();

    if (!content) {
      alert("Enter content first");
      return;
    }

    $("#kadp-ai-output").html("⏳ Generating...");

    $.post(
      kadp_ajax.ajax_url,
      {
        action: "kadp_ai_rewrite",
        content: content,
        nonce: kadp_ajax.nonce,
      },
      function (res) {
        if (res.success) {
          $("#kadp-ai-output").html(res.data.content);
        } else {
          $("#kadp-ai-output").html("Error: " + res.data.message);
        }
      },
    );
  });

  // delete
  $(document).on("click", ".kadp-delete-ai-log", function () {
    let id = $(this).data("id");

    if (!confirm("Delete this log?")) return;

    $.post(
      kadp_ajax.ajax_url,
      {
        action: "kadp_delete_ai_log",
        id: id,
        nonce: kadp_ajax.nonce,
      },
      function (res) {
        if (res.success) {
          $("button[data-id='" + id + "']")
            .closest("tr")
            .fadeOut();
        } else {
          alert(res.data.message || "Delete failed");
        }
      },
    );
  });
});
