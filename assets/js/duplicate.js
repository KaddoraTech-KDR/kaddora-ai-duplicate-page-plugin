jQuery(document).ready(function ($) {
  /**
   * SINGLE DUPLICATE
   */
  $(document).on("click", ".kadp-duplicate-btn", function (e) {
    e.preventDefault();

    let postId = $("#kadp-post-id").val();

    if (!postId) {
      alert("Please select a post");
      return;
    }

    let $btn = $(this);
    let $result = $("#kadp-single-result");

    // UI state
    $btn.prop("disabled", true).text("Processing...");
    $result.html("Processing...");

    $.ajax({
      url: kadp_ajax.ajax_url,
      type: "POST",
      dataType: "json", // 🔥 IMPORTANT FIX
      data: {
        action: "kadp_duplicate",
        post_id: postId,
        nonce: kadp_ajax.nonce,
      },
    })
      .done(function (response) {
        console.log("SUCCESS", response);

        if (response.success) {
          $result.html(
            '<span style="color:green;">Post duplicated successfully</span>',
          );

          setTimeout(() => {
            window.location.href = response.data.edit_link;
          }, 1500);
        } else {
          $result.html(
            '<span style="color:red;">' + response.data.message + "</span>",
          );
        }
      })
      .fail(function (xhr) {
        console.log("FAIL", xhr.responseText);

        $result.html('<span style="color:red;">Server error</span>');
      })
      .always(function () {
        $btn.prop("disabled", false).text("Duplicate Now");
      });
  });

  /**
   * BULK DUPLICATE
   */
  $(document).on("click", ".kadp-bulk-duplicate-btn", function (e) {
    e.preventDefault();

    let postIds = [];

    $(".kadp-post-checkbox:checked").each(function () {
      postIds.push($(this).val());
    });

    if (postIds.length === 0) {
      alert("Please select at least one post");
      return;
    }

    let $btn = $(this);
    let $result = $("#kadp-bulk-result");

    // UI state
    $btn.prop("disabled", true).text("Processing...");
    $result.html("Processing...");

    $.post(kadp_ajax.ajax_url, {
      action: "kadp_bulk_duplicate",
      post_ids: postIds,
      nonce: kadp_ajax.nonce,
    })
      .done(function (response) {
        if (response.success) {
          $result.html(
            '<span style="color:green;">' + response.data.message + "</span>",
          );

          setTimeout(() => location.reload(), 1500);
        } else {
          $result.html(
            '<span style="color:red;">' + response.data.message + "</span>",
          );
        }
      })
      .fail(function () {
        $result.html('<span style="color:red;">Server error</span>');
      })
      .always(function () {
        $btn.prop("disabled", false).text("Duplicate Selected");
      });
  });

  /**
   * =========================
   * SELECT ALL CHECKBOX
   * =========================
   */
  $(document).on("change", "#kadp-select-all", function () {
    $(".kadp-post-checkbox").prop("checked", $(this).prop("checked"));
  });
});
