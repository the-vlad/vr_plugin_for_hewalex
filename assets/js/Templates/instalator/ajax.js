import AWN from "awesome-notifications";

let options = {
  position: "bottom-right",
  icons: {
    enabled: false,
  },
};
options.labels = {
  success: "SUKCES",
  warning: "UWAGA",
  alert: "BŁĄD",
};

document.addEventListener("DOMContentLoaded", function () {
  [].forEach.call(document.querySelectorAll(".delete-post"), function (el) {
    el.addEventListener("click", function () {
      let obj = this.parentNode.parentNode;
      let onCancel = () => {
        new AWN().info("Oferta nie została usunięta");
      };
      new AWN().confirm(
        "Czy na pewno chcesz usunąć ofertę?",
        (state = false) => {
          state = true;
          if (state) {
            let httpRequest = new XMLHttpRequest();
            httpRequest.open("POST", instalator_template_rest.ajaxUrl, true);
            httpRequest.setRequestHeader(
              "Content-Type",
              "application/x-www-form-urlencoded"
            );
            httpRequest.onload = function () {
              if (this.status >= 200 && this.status < 400) {
                obj.style.display = "none";
                new AWN().success("Oferta została usunięta", options);
              } else {
                // If fail
                console.log(this.response);
              }
            };
            httpRequest.send(
              "action=deleteOffer&nonce=" +
                this.dataset.nonce +
                "&id=" +
                this.dataset.id
            );
          }
        },
        onCancel,
        {
          labels: {
            confirm: "Potwierdzenie",
          },
        }
      );
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  [].forEach.call(document.querySelectorAll(".delete-cart"), function (el) {
    el.addEventListener("click", function () {
      let obj = this.parentNode.parentNode;
      let onCancel = () => {
        new AWN().info("Oferta nie została usunięta");
      };
      new AWN().confirm(
        "Czy na pewno chcesz usunąć ofertę?",
        (state = false) => {
          state = true;
          if (state) {
            let httpRequest = new XMLHttpRequest();
            httpRequest.open("POST", instalator_template_rest.ajaxUrl, true);
            httpRequest.setRequestHeader(
              "Content-Type",
              "application/x-www-form-urlencoded"
            );
            httpRequest.onload = function () {
              if (this.status >= 200 && this.status < 400) {
                obj.style.display = "none";
                new AWN().success("Oferta została usunięta", options);
              } else {
                // If fail
                console.log(this.response);
              }
            };
            httpRequest.send(
              "action=deleteCart&nonce=" +
                this.dataset.nonce +
                "&id=" +
                this.dataset.id
            );
          }
        },
        onCancel,
        {
          labels: {
            confirm: "Potwierdzenie",
          },
        }
      );
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  [].forEach.call(
    document.querySelectorAll(".delete-history-cart"),
    function (el) {
      el.addEventListener("click", function () {
        let obj = this.parentNode.parentNode;
        let onCancel = () => {
          new AWN().info("Koszyk nie został usunięta");
        };
        new AWN().confirm(
          "Czy na pewno chcesz usunąć ofertę?",
          (state = false) => {
            state = true;
            if (state) {
              let httpRequest = new XMLHttpRequest();
              httpRequest.open("POST", instalator_template_rest.ajaxUrl, true);
              httpRequest.setRequestHeader(
                "Content-Type",
                "application/x-www-form-urlencoded"
              );
              httpRequest.onload = function () {
                if (this.status >= 200 && this.status < 400) {
                  obj.style.display = "none";
                  new AWN().success("Koszyk został usunięty", options);
                } else {
                  // If fail
                  console.log(this.response);
                }
              };
              httpRequest.send(
                "action=deleteHistoryCart&nonce=" +
                  this.dataset.nonce +
                  "&id=" +
                  this.dataset.id
              );
            }
          },
          onCancel,
          {
            labels: {
              confirm: "Potwierdzenie",
            },
          }
        );
      });
    }
  );
});

/**
 * Check Solar Set
 * Instalator
 */
jQuery(document).ready(function () {
  $("#number_set_form").on("submit", function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();

    let form = $(this);
    let ajaxurl = form.data("url");
    let detail_info = {
      post_title: form.find("#number_set").val(),
    };

    if (detail_info.post_title === "") {
      new AWN().warning("Pole jest puste", options);
      return;
    }

    $.ajax({
      url: ajaxurl,
      type: "POST",
      data: {
        post_details: detail_info,
        action: "SaveFormByInstallator", // this is going to be used inside wordpress functions.php
      },
      error: function (error) {
        new AWN().alert("Bląd: nieprawidłowy numer.", options);
      },
      success: function (response) {
        // console.log('wwwwww');
        console.log("showresponse", response);
        let findStatus = response;
        let registeredState = findStatus.includes("warning");
        let freshState = findStatus.includes("success");
        let truePoints = findStatus.includes("truePoints");
        let falsePoints = findStatus.includes("falsePoints");

        if (registeredState && falsePoints) {
          new AWN().alert(
            "Przepraszamy , instalacja już zarejestrowana",
            options
          );
        }
        if (registeredState && truePoints) {
          new AWN().success("Instalacja istnieje, punkty naliczone", options);
        }
        if (freshState) {
          new AWN().success(
            "Rejestracja zestawu przebiegła pomyślnie!",
            options
          );
        }
      },
    });
  });
});
