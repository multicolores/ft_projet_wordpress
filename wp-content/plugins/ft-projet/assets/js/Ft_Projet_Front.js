jQuery(document).ready(function () {
  !sessionStorage.getItem("userAuthorisation") &&
    sessionStorage.setItem("userAuthorisation", "step1");

  //redirection si on est pas authorisé à aller sur la pages
  if (window.location.pathname.includes("choix-voyage-step-select")) {
    if (!sessionStorage.getItem("userAuthorisation").includes("step2")) {
      window.history.back();
    }
  } else if (window.location.pathname.includes("choix-voyage-step-final")) {
    console.log("je passe par ici");
    if (!sessionStorage.getItem("userAuthorisation").includes("step3")) {
      window.history.back();
    }
  }

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
        //update authorisation sessionStorage value
        sessionStorage.setItem("userAuthorisation", "step1,step2");

        window.location.href =
          window.location.origin +
          window.location.pathname.replace(
            "choix-voyage",
            "choix-voyage-step-select"
          );

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
      //enable button lorsque le premier pays est selectionné
      if (i == 1)
        jQuery("#ft-form-submit-pays-list-select").removeClass(
          "disable-select-pays"
        );
    });
  }

  jQuery("#ft-form-pays-list-select").submit(function (e) {
    e.stopPropagation();
    e.preventDefault();

    let formData = new FormData();
    formData.append("action", "ftprojetcreateuserpayslist");
    formData.append("security", ftprojetscript.security);

    jQuery("#ft-form-pays-list-select")
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
        //update authorisation sessionStorage value
        sessionStorage.setItem("userAuthorisation", "step1,step2,step3");

        window.location.href =
          window.location.origin +
          window.location.pathname.replace(
            "choix-voyage-step-select",
            "choix-voyage-step-final"
          );
        return false;
      },
    });
  });

  //---STEP 3 CONFIRMATION PAYS
  jQuery("#ft-form-pays-recap").click(function (e) {
    e.stopPropagation();
    e.preventDefault();

    const datas = {
      action: "ftprojetgetpropspectinfo",
      security: ftprojetscript.security,
    };
    let prospectInfo;

    jQuery.post(ftprojetscript.ajax_url, datas, function (rs) {
      console.log(rs);
      prospectInfo = rs.split(";");

      // TODO load le handlebars d'un autre fichier
      const choix_voyage_url =
        window.location.origin +
        window.location.pathname.replace(
          "choix-voyage-step-final",
          "choix-voyage"
        );

      const template = Handlebars.compile(
        "<div class='modalboxContent'><p>Merci {{sexe}} {{nom}} {{prenom}} pour votre choix !</p><a href='" +
          choix_voyage_url +
          "'>Retour</a></div>"
      );

      const context = {
        nom: prospectInfo[0],
        prenom: prospectInfo[1],
        sexe: prospectInfo[2] == "Homme" ? "Mr" : "Mme",
      };

      const html = template(context);
      document.getElementById("handlebarsModalBox").innerHTML = html;
      jQuery("#handlebarsModalBox").addClass("show-modal-box");

      //reset authorisation sessionStorage value
      sessionStorage.setItem("userAuthorisation", "step1");
      return false;
    });
  });
});
