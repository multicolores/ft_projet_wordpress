jQuery(document).ready(function () {
  jQuery("#ft-form-inscription").submit(function (e) {
    e.stopPropagation();
    e.preventDefault();

    let formData = new FormData();
    formData.append("action", "ftprojetcreateprospect");
    formData.append("security", ftprojetscript.security);

    jQuery("#ft-form-inscription")
      .find("input, select")
      .each(function (i) {
        let id = jQuery(this).attr("id");
        if (typeof id !== "undefined") formData.append(id, jQuery(this).val());
      });

    jQuery("#ft-loading-container").show();

    jQuery.ajax({
      url: ftprojetscript.ajax_url,
      xhrFields: {
        withCredentials: true,
      },
      cache: false,
      contentType: false,
      processData: false,
      data: formData,
      type: "post",
      success: function (rs, textStatus, jqXHR) {
        jQuery("#ft-loading-container").hide();
        return false;
      },
    });
  });
});
