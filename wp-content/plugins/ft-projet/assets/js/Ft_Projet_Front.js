jQuery(document).ready(function () {
  //---STEP 1 USER INSCRIPTION

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

  //---STEP 2 SELECT PAYS

  // enable next pays select on select of last pays
  for (let i = 1; i < 5; i++) {
    jQuery("#ft_select_pays" + i).change(() => {
      jQuery("#ft_select_pays" + (i + 1) + "_container").removeClass(
        "disable-select-pays"
      );
    });
  }
});
