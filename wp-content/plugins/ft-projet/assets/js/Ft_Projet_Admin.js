jQuery(document).ready(function () {
  jQuery(".majeur_checkBox").change(function (e) {
    console.log("checked");
    console.log(e);
    console.log(jQuery(this).data("id"));
    let datas;

    if (this.checked)
      datas = {
        action: "ftprojetmajeur",
        security: ftadminscript.security,
        id: jQuery(this).data("id"),
        majeurValue: 1,
      };
    else
      datas = {
        action: "ftprojetmajeur",
        security: ftadminscript.security,
        id: jQuery(this).data("id"),
        majeurValue: 0,
      };

    jQuery.post(ajaxurl, datas, function (rs) {
      console.log(rs);
      jQuery(".is-dismissible").show("slow");

      setTimeout(() => {
        jQuery(".is-dismissible").hide("slow");
      }, "1000");
      return false;
    });
  });
});
