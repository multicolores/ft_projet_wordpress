jQuery(document).ready(function () {
  jQuery(".majeur_checkBox").change(function (e) {
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
      jQuery(".is-dismissible").show("slow");

      setTimeout(() => {
        jQuery(".is-dismissible").hide("slow");
      }, "1000");
      return false;
    });
  });
  jQuery(".select-note").change(function (e) {
    const datas = {
      action: "ftprojetnote",
      security: ftadminscript.security,
      id: jQuery(this).data("id"),
      noteValue: jQuery(this).val(),
    };

    jQuery.post(ajaxurl, datas, function (rs) {
      jQuery(".is-dismissible").show("slow");

      setTimeout(() => {
        jQuery(".is-dismissible").hide("slow");
      }, "1000");
      return false;
    });
  });

  jQuery("#ft-submitPaysConfigForm").click(function (e) {
    e.stopPropagation();
    e.preventDefault();

    const datas = {
      action: "ftprojetdisponible",
      security: ftadminscript.security,
      idsListToChange: jQuery("#ft-pays-multiselect").val(),
    };

    jQuery.post(ajaxurl, datas, function (rs) {
      jQuery(".is-dismissible").show("slow");

      setTimeout(() => {
        jQuery(".is-dismissible").hide("slow");
      }, "2000");
      return false;
    });
  });
});
