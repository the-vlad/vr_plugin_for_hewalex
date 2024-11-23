/* INSTALATOR MAP SEARCH */

/* @GLOBALS - define functions for global usage */

function makeLoader() {
  $("#loader").removeClass("hidden");
  $(".marker-bar").addClass("disableState");
  $("#append-clients").addClass("loadopacity");
}
function endLoader() {
  setTimeout(function () {
    $("#loader").addClass("hidden");
    $(".marker-bar").removeClass("disableState");
    $(".leftdata").removeClass("loadopacity");
    $("#append-clients").removeClass("loadopacity");
  }, 450);
}

function capitalizeFirstLetter(string) {
  string = string.toLowerCase();
  return string.charAt(0).toUpperCase() + string.slice(1);
}

function initRange() {
  let count = 20;
  let countEl = document.getElementById("range");
  let plus = document.getElementsByClassName("plus");
  let minus = document.getElementsByClassName("minus");
  for (let a = 0; a < plus.length; a++) {
    var elem = plus[a];
    elem.onclick = function () {
      if (count < 50) {
        count = count + 5;
        countEl.value = count;
      }
    };
  }
  for (let b = 0; b < minus.length; b++) {
    var elem2 = minus[b];
    elem2.onclick = function () {
      if (count > 5) {
        count = count - 5;
        countEl.value = count;
      }
    };
  }
}

function generateAccordion(
  accname,
  filtername,
  jsonItemID,
  jsonItemAddressesCity,
  jsonItemAddressesStreet,
  jsonItemEmail,
  jsonItemPhone,
  jsonItemAddressesCode,
  jsonItemName,
  getProvince,
  jsonItemWebsite
) {
  let accordionData = $(
    '<h3 id="theacc" class="subcat-item" data-filter="' +
      filtername +
      '"' +
      'data-marker="' +
      jsonItemID +
      '">' +
      '<div class="item" data-targetid="' +
      jsonItemID +
      '"' +
      'data-filter="' +
      filtername +
      '"' +
      'data-postcode="' +
      jsonItemAddressesCode +
      '"' +
      'data-province="' +
      getProvince +
      '"' +
      'data-city="' +
      capitalizeFirstLetter(jsonItemAddressesCity) +
      '"><div class="anchor-data" id="scroll' +
      jsonItemID +
      '"></div>' +
      '<p class="firstdata">' +
      jsonItemName +
      " " +
      '<span class="city">' +
      capitalizeFirstLetter(jsonItemAddressesCity) +
      "</span></p>" +
      "</div>" +
      "</h3>" +
      '<div class="subcat-content" data-marker="' +
      jsonItemID +
      '">' +
      '<div class="item" data-marker="' +
      jsonItemID +
      '"' +
      'data-city="' +
      capitalizeFirstLetter(jsonItemAddressesCity) +
      '">' +
      '<p class="street_city"> ' +
      jsonItemAddressesStreet +
      " " +
      jsonItemAddressesCity +
      "  " +
      jsonItemAddressesCode +
      "</p>" +
      '<p class="phone">tel: ' +
      jsonItemPhone +
      "</p>" +
      '<p class="mail">e-mail: ' +
      jsonItemEmail +
      "</p>" +
      '<p class="www">' +
      jsonItemWebsite +
      "</p>" +
      "</div>" +
      "</div>"
  );

  accname.append(accordionData);
}

/* @capitalize province jsonitem */
function clearNullStrings() {
  $(".street_city:contains('null')").html(" ");
  $(".postcode:contains('null')").html(" ");
  $(".city:contains('null')").html(" ");
  $(".mail:contains('null')").html(" ");
  $(".www:contains('null')").html(" ");
  $(".phone:contains('null')").html(" ");
}

function restoreAccordion() {
  $("#theacc .item").removeClass("hidden");
  $("#theacc .item").addClass("go-visible");
  $("#theacc").removeClass("hidden");
  $("#theacc").addClass("go-visible");
}

function refreshAccordion(accname) {
  accname.accordion();
  accname.accordion({
    active: false,
    collapsible: true,
  });
  accname.accordion("refresh");
}

function filterMarkerBySearch(n, map, markers) {
  let radioval = "Tak";
  let toggleMarker;
  let checkedSunHeat = $("#sunHeat:checked").val();
  let checkedCollectorSun = $("#collectorSun:checked").val();
  let checkedPompHeat = $("#pompHeat:checked").val();
  let checkedPompHeatWater = $("#pompHeatWater:checked").val();
  let checkedOptiEner = $("#optiEner:checked").val();
  let checkedPompheatPool = $("#pompHeatPool:checked").val();
  const filteredMarkers = markers.filter((marker) => {
    switch (radioval) {
      case checkedSunHeat:
        toggleMarker = marker.sunHeat;
        break;
      case checkedCollectorSun:
        toggleMarker = marker.collectorSun;
        break;
      case checkedPompHeat:
        toggleMarker = marker.pompHeat;
        break;
      case checkedPompHeatWater:
        toggleMarker = marker.pompHeatWater;
        break;
      case checkedOptiEner:
        toggleMarker = marker.optiEner;
        break;
      case checkedPompheatPool:
        toggleMarker = marker.pompHeatPool;
        break;
      default:
        "";
        break;
    }
    if (n === undefined) {
      marker.setMap(null);
      return toggleMarker === radioval;
    }
    if (n.includes(marker.province)) {
      return n.includes(marker.province) && toggleMarker === radioval;
    }
    if (n.includes(marker.city)) {
      return n.includes(marker.city) && toggleMarker === radioval;
    } else {
      for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
      }
    }
  });
  for (let i = 0; i < filteredMarkers.length; i++) {
    filteredMarkers[i].setMap(map);
  }
  // console.log("MARKER params:::");
}

/* @MAP init map */
jQuery(window).ready(function ($) {
  initRange();
  if ($("#map") != null) {
    function initialize() {
      let markers = [];
      let activeMarker;
      let iconSelected = {
        url: window.zh_url + "/assets/img/activemark.svg",
        scaledSize: new google.maps.Size(24, 40),
      };
      let iconDefault = {
        url: window.zh_url + "/assets/img/map_marker_alt-1-1.svg",
        scaledSize: new google.maps.Size(24, 40),
      };
      let map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(50.270908, 19.039993),
        zoom: 9,
        disableDefaultUI: false,
        mapTypeControl: false,
        scaleControl: false,
        zoomControl: true,
        styles: [
          {
            elementType: "geometry",
            stylers: [
              {
                color: "#f5f5f5",
              },
            ],
          },
          {
            elementType: "labels.icon",
            stylers: [
              {
                visibility: "off",
              },
            ],
          },
          {
            elementType: "labels.text.fill",
            stylers: [
              {
                color: "#616161",
              },
            ],
          },
          {
            elementType: "labels.text.stroke",
            stylers: [
              {
                color: "#f5f5f5",
              },
            ],
          },
          {
            featureType: "administrative.land_parcel",
            elementType: "labels.text.fill",
            stylers: [
              {
                color: "#bdbdbd",
              },
            ],
          },
          {
            featureType: "poi",
            elementType: "geometry",
            stylers: [
              {
                color: "#eeeeee",
              },
            ],
          },
          {
            featureType: "poi",
            elementType: "labels.text.fill",
            stylers: [
              {
                color: "#757575",
              },
            ],
          },
          {
            featureType: "poi.park",
            elementType: "geometry",
            stylers: [
              {
                color: "#e5e5e5",
              },
            ],
          },
          {
            featureType: "poi.park",
            elementType: "labels.text.fill",
            stylers: [
              {
                color: "#9e9e9e",
              },
            ],
          },
          {
            featureType: "road",
            elementType: "geometry",
            stylers: [
              {
                color: "#ffffff",
              },
            ],
          },
          {
            featureType: "road.arterial",
            elementType: "labels.text.fill",
            stylers: [
              {
                color: "#757575",
              },
            ],
          },
          {
            featureType: "road.highway",
            elementType: "geometry",
            stylers: [
              {
                color: "#dadada",
              },
            ],
          },
          {
            featureType: "road.highway",
            elementType: "labels.text.fill",
            stylers: [
              {
                color: "#616161",
              },
            ],
          },
          {
            featureType: "road.local",
            elementType: "labels.text.fill",
            stylers: [
              {
                color: "#9e9e9e",
              },
            ],
          },
          {
            featureType: "transit.line",
            elementType: "geometry",
            stylers: [
              {
                color: "#e5e5e5",
              },
            ],
          },
          {
            featureType: "transit.station",
            elementType: "geometry",
            stylers: [
              {
                color: "#eeeeee",
              },
            ],
          },
          {
            featureType: "water",
            elementType: "geometry",
            stylers: [
              {
                color: "#c9c9c9",
              },
            ],
          },
          {
            featureType: "water",
            elementType: "labels.text.fill",
            stylers: [
              {
                color: "#9e9e9e",
              },
            ],
          },
        ],
      });

      let circle = [];
      let clickSunheat = 0;
      let clickCollectorsun = 0;
      let clickPompheat = 0;
      let clickPompheatWater = 0;
      let clickPompheatPool = 0;
      let clickOptiEner = 0;

      function setZoom() {
        map.setZoom(5);
        map.zoom = 5;
      }

      function toggleMarkerActive(marker, i, jsonItemID, markers) {
        // @marker onclick toggle data
        google.maps.event.addListener(
          marker,
          "click",
          (function (marker, i) {
            return function () {
              $("#append-clients")
                .find("[data-marker='" + jsonItemID + "']")
                .trigger("click");

              let dataset = $("#append-clients").find(
                "[data-marker='" + jsonItemID + "']"
              )[1].dataset.marker;

              let state = $("#append-clients").find(
                "[data-marker='" + jsonItemID + "']"
              )[0].ariaSelected;

              for (let i = 0; i < markers.length; i++) {
                markers[i].setIcon(iconDefault);
              }
              if (jsonItemID == dataset && state == "true") {
                marker.setIcon(iconSelected);
              } else {
                marker.setIcon(iconDefault);
              }

              document.getElementById("scroll" + jsonItemID).scrollIntoView({
                behavior: "smooth",
                block: "start",
                inline: "start",
              });
            };
          })(marker, i)
        );
      }

      function restoreMarkers() {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(map);
        }
        markers = [];
      }

      function clearMarkers() {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(null);
        }
        markers = [];
      }

      function resetAll() {
        if (circle.length !== 0 || undefined) {
          circle.setMap(null);
        }
        $(".default_string").show();
        $(".reset_all").hide();
        $("#search-input").val("");
        $("#adet").val(20);
        clickSunheat = 0;
        clickCollectorsun = 0;
        clickPompheat = 0;
        clickPompheatWater = 0;
        clickOptiEner = 0;
        clickPompheatPool = 0;

        clearMarkers();
        setZoom();
        $('input[name="customfilters"]').prop("checked", false);
        $("#collectorSun").attr("value", "Nie");
        $(".leftdata div").empty();
      }

      $(".reset_all").click(function () {
        resetAll();
      });

      Object.defineProperty(String.prototype, "capitalize", {
        value: function () {
          return this.charAt(0).toUpperCase() + this.slice(1);
        },
        enumerable: false,
      });

      $(".allradio").click(function () {
        $(".default_string").hide();
        $(".reset_all").show();
      });
      endLoader();

      /* *** FILTERS ****j */

      /* @collectorsun */

      $("#collectorSun").click(function () {
        $("#collectorSun").val("Tak");
        clickSunheat = 0;
        clickPompheat = 0;
        clickPompheatWater = 0;
        clickPompheatPool = 0;
        clickOptiEner = 0;
        clickCollectorsun++;
        let searchInput = $("#search-input").val();
        let n = searchInput;
        let collectorSun = "Tak";
        let accname = $("#append-clients");

        if (clickCollectorsun === 1) {
          $("#append-clients").empty();
          clearMarkers();
          makeLoader();
          setZoom();
          refreshAccordion(accname);

          (async () => {
            try {
              const res = await fetch(installer_collectorsun.path, {
                headers: { Accept: "application/json" },
              });
              const json = await res.json();

              for (let i = 0; i < json.length; i++) {
                let jsonItem = json[i];
                if (
                  jsonItem.Addresses.Lat !== null &&
                  jsonItem.Addresses.City !== null &&
                  jsonItem.Addresses.City !== undefined &&
                  jsonItem.Addresses.Lat !== undefined
                ) {
                  let getProvince;
                  if (
                    jsonItem.Addresses.Province !== null ||
                    jsonItem.Addresses.Province !== undefined
                  ) {
                    getProvince = jsonItem.Addresses.Province.capitalize();
                  } else {
                    getProvince = "";
                  }

                  let filtername = collectorSun;
                  generateAccordion(
                    accname,
                    filtername,
                    jsonItem.ID,
                    jsonItem.Addresses.City,
                    jsonItem.Addresses.Street,
                    jsonItem.Email,
                    jsonItem.Phone,
                    jsonItem.Addresses.Code,
                    jsonItem.Name,
                    getProvince,
                    jsonItem.Website
                  );

                  let latLng = new google.maps.LatLng(
                    jsonItem.Addresses.Lat,
                    jsonItem.Addresses.Long
                  );

                  let thecity = capitalizeFirstLetter(jsonItem.Addresses.City);
                  let getcity = thecity
                    .split("-")
                    .map((e) => e.charAt(0).toUpperCase() + e.slice(1))
                    .join("-");

                  let marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    city: getcity,
                    province: getProvince,
                    title: jsonItem.title,
                    targetid: jsonItem.ID,
                    icon: iconDefault,
                    collectorSun: collectorSun,
                  });
                  markers.push(marker);

                  toggleMarkerActive(marker, i, jsonItem.ID, markers);
                }
              }
            } catch (e) {
              console.error("json is empty or not created");
            }
            refreshAccordion(accname);
            let acclength = $("#append-clients #theacc").length;

            if (acclength === markers.length) {
              // endLoader();
              $("#theacc .item").click(function () {
                let data_acc_marker = $(this).attr("data-targetid");
                let parent = $(this).parent();
                let totable = Object.values(parent);
                let state = $(totable[0]).attr("aria-selected");

                for (let i = 0; i < markers.length; i++) {
                  if (
                    data_acc_marker === markers[i].targetid &&
                    state == "false"
                  ) {
                    markers[i].setIcon(iconSelected);
                  } else {
                    markers[i].setIcon(iconDefault);
                  }
                }
              });
            }
            if (n !== "") {
              // makeLoader();
              setTimeout(function () {
                $("#search_button")[0].click();
                // endLoader();
                filterMarkerBySearch(n, map, markers);
              }, 50);
            } else {
              // makeLoader();
              setTimeout(function () {
                endLoader();
              }, 50);
            }
            clearNullStrings();
          })();
        }
      });

      /* @pompheat */
      $("#pompHeat").click(function () {
        $("#pompHeat").val("Tak");
        clickSunheat = 0;
        clickCollectorsun = 0;
        clickPompheatWater = 0;
        clickPompheatPool = 0;
        clickOptiEner = 0;
        clickPompheat++;
        let searchInput = $("#search-input").val();
        let n = searchInput;
        let accname = $("#append-clients");
        let pompHeat = "Tak";

        if (clickPompheat === 1) {
          $("#append-clients").empty();
          clearMarkers();
          makeLoader();
          setZoom();
          refreshAccordion(accname);

          (async () => {
            try {
              const res = await fetch(installer_pompheat.path, {
                headers: { Accept: "application/json" },
              });
              const json = await res.json();
              // console.log("json", json);

              for (let i = 0; i < json.length; i++) {
                let jsonItem = json[i];
                if (
                  jsonItem.Addresses.Lat !== null &&
                  jsonItem.Addresses.City !== null &&
                  jsonItem.Addresses.City !== undefined &&
                  jsonItem.Addresses.Lat !== undefined
                ) {
                  let getProvince;
                  if (
                    jsonItem.Addresses.Province !== null ||
                    jsonItem.Addresses.Province !== undefined
                  ) {
                    getProvince = jsonItem.Addresses.Province.capitalize();
                  } else {
                    getProvince = "";
                  }

                  let filtername = pompHeat;
                  generateAccordion(
                    accname,
                    filtername,
                    jsonItem.ID,
                    jsonItem.Addresses.City,
                    jsonItem.Addresses.Street,
                    jsonItem.Email,
                    jsonItem.Phone,
                    jsonItem.Addresses.Code,
                    jsonItem.Name,
                    getProvince,
                    jsonItem.Website
                  );

                  let latLng = new google.maps.LatLng(
                    jsonItem.Addresses.Lat,
                    jsonItem.Addresses.Long
                  );

                  let marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    city: jsonItem.Addresses.City,
                    province: getProvince,
                    title: jsonItem.title,
                    targetid: jsonItem.ID,
                    icon: iconDefault,
                    pompHeat: pompHeat,
                  });
                  markers.push(marker);

                  toggleMarkerActive(marker, i, jsonItem.ID, markers);
                }
              }
            } catch (e) {
              console.error("json is empty or not created");
            }
            refreshAccordion(accname);
            let acclength = $("#append-clients #theacc").length;

            if (acclength === markers.length) {
              // endLoader();
              $("#theacc .item").click(function () {
                let data_acc_marker = $(this).attr("data-targetid");
                let parent = $(this).parent();
                let totable = Object.values(parent);
                let state = $(totable[0]).attr("aria-selected");

                for (let i = 0; i < markers.length; i++) {
                  if (
                    data_acc_marker === markers[i].targetid &&
                    state == "false"
                  ) {
                    markers[i].setIcon(iconSelected);
                  } else {
                    markers[i].setIcon(iconDefault);
                  }
                }
              });
            }
            if (n !== "") {
              makeLoader();
              setTimeout(function () {
                $("#search_button")[0].click();
                // endLoader();
                filterMarkerBySearch(n, map, markers);
              }, 50);
            } else {
              makeLoader();
              setTimeout(function () {
                endLoader();
              }, 50);
            }
            clearNullStrings();
          })();
        }
      });

      /* @pompheatwater */

      $("#pompHeatWater").click(function () {
        $("#pompHeatWater").val("Tak");
        clickSunheat = 0;
        clickCollectorsun = 0;
        clickPompheat = 0;
        clickOptiEner = 0;
        clickPompheatPool = 0;
        clickPompheatWater++;
        let searchInput = $("#search-input").val();
        let n = searchInput;
        let pompHeatWater = "Tak";
        let accname = $("#append-clients");

        if (clickPompheatWater === 1) {
          $("#append-clients").empty();
          clearMarkers();
          makeLoader();
          setZoom();
          refreshAccordion(accname);

          (async () => {
            try {
              const res = await fetch(installer_pompheatwater.path, {
                headers: { Accept: "application/json" },
              });
              const json = await res.json();

              for (let i = 0; i < json.length; i++) {
                let jsonItem = json[i];
                if (
                  jsonItem.Addresses.Lat !== null &&
                  jsonItem.Addresses.City !== null &&
                  jsonItem.Addresses.City !== undefined &&
                  jsonItem.Addresses.Lat !== undefined
                ) {
                  let getProvince;
                  if (
                    jsonItem.Addresses.Province !== null ||
                    jsonItem.Addresses.Province !== undefined
                  ) {
                    getProvince = jsonItem.Addresses.Province.capitalize();
                  } else {
                    getProvince = "";
                  }

                  let filtername = pompHeatWater;
                  generateAccordion(
                    accname,
                    filtername,
                    jsonItem.ID,
                    jsonItem.Addresses.City,
                    jsonItem.Addresses.Street,
                    jsonItem.Email,
                    jsonItem.Phone,
                    jsonItem.Addresses.Code,
                    jsonItem.Name,
                    getProvince,
                    jsonItem.Website
                  );

                  let latLng = new google.maps.LatLng(
                    jsonItem.Addresses.Lat,
                    jsonItem.Addresses.Long
                  );

                  let marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    city: jsonItem.Addresses.City,
                    province: getProvince,
                    title: jsonItem.title,
                    targetid: jsonItem.ID,
                    icon: iconDefault,
                    pompHeatWater: pompHeatWater,
                  });
                  markers.push(marker);

                  toggleMarkerActive(marker, i, jsonItem.ID, markers);
                }
              }
            } catch (e) {
              console.error("json is empty or not created");
            }
            refreshAccordion(accname);
            let acclength = $("#append-clients #theacc").length;

            if (acclength === markers.length) {
              endLoader();
              $("#theacc .item").click(function () {
                let data_acc_marker = $(this).attr("data-targetid");
                // console.log(data_acc_marker);
                //        let marker = new google.maps.Marker({});
                let parent = $(this).parent();
                let totable = Object.values(parent);
                let state = $(totable[0]).attr("aria-selected");

                for (let i = 0; i < markers.length; i++) {
                  if (
                    data_acc_marker === markers[i].targetid &&
                    state == "false"
                  ) {
                    markers[i].setIcon(iconSelected);
                  } else {
                    markers[i].setIcon(iconDefault);
                  }
                }
              });
            }
            if (n !== "") {
              makeLoader();
              setTimeout(function () {
                $("#search_button")[0].click();
                filterMarkerBySearch(n, map, markers);
              }, 50);
            } else {
              makeLoader();
              setTimeout(function () {
                endLoader();
              }, 50);
            }
            clearNullStrings();
          })();
        }
      });

      /* @pompheatpool */
      $("#pompHeatPool").click(function () {
        $("#pompHeatPool").val("Tak");
        clickSunheat = 0;
        clickPompheat = 0;
        clickPompheatWater = 0;
        clickOptiEner = 0;
        clickSunheat = 0;
        clickPompheatPool++;
        let searchInput = $("#search-input").val();
        let n = searchInput;
        let pompHeatPool = "Tak";
        let accname = $("#append-clients");

        if (clickPompheatPool === 1) {
          $("#append-clients").empty();
          clearMarkers();
          makeLoader();
          setZoom();
          refreshAccordion(accname);

          (async () => {
            try {
              const res = await fetch(installer_pompheatpool.path, {
                headers: { Accept: "application/json" },
              });
              const json = await res.json();
              // console.log("json", json);

              for (let i = 0; i < json.length; i++) {
                let jsonItem = json[i];
                if (
                  jsonItem.Addresses.Lat !== null &&
                  jsonItem.Addresses.City !== null &&
                  jsonItem.Addresses.City !== undefined &&
                  jsonItem.Addresses.Lat !== undefined
                ) {
                  let getProvince;
                  if (
                    jsonItem.Addresses.Province !== null ||
                    jsonItem.Addresses.Province !== undefined
                  ) {
                    getProvince = jsonItem.Addresses.Province.capitalize();
                  } else {
                    getProvince = "";
                  }

                  let filtername = pompHeatPool;
                  generateAccordion(
                    accname,
                    filtername,
                    jsonItem.ID,
                    jsonItem.Addresses.City,
                    jsonItem.Addresses.Street,
                    jsonItem.Email,
                    jsonItem.Phone,
                    jsonItem.Addresses.Code,
                    jsonItem.Name,
                    getProvince,
                    jsonItem.Website
                  );

                  let latLng = new google.maps.LatLng(
                    jsonItem.Addresses.Lat,
                    jsonItem.Addresses.Long
                  );

                  let marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    city: jsonItem.Addresses.City,
                    province: getProvince,
                    title: jsonItem.title,
                    targetid: jsonItem.ID,
                    icon: iconDefault,
                    pompHeatWater: pompHeatPool,
                  });
                  markers.push(marker);

                  toggleMarkerActive(marker, i, jsonItem.ID, markers);
                }
              }
            } catch (e) {
              console.error("json is empty or not created");
            }
            refreshAccordion(accname);
            let acclength = $("#append-clients #theacc").length;

            if (acclength === markers.length) {
              // endLoader();
              $("#theacc .item").click(function () {
                let data_acc_marker = $(this).attr("data-targetid");
                let parent = $(this).parent();
                let totable = Object.values(parent);
                let state = $(totable[0]).attr("aria-selected");

                for (let i = 0; i < markers.length; i++) {
                  if (
                    data_acc_marker === markers[i].targetid &&
                    state == "false"
                  ) {
                    markers[i].setIcon(iconSelected);
                  } else {
                    markers[i].setIcon(iconDefault);
                  }
                }
              });
            }
            if (n !== "") {
              makeLoader();
              setTimeout(function () {
                $("#search_button")[0].click();
                // endLoader();
                filterMarkerBySearch(n, map, markers);
              }, 50);
            } else {
              makeLoader();
              setTimeout(function () {
                endLoader();
              }, 50);
            }
            clearNullStrings();
          })();
        }
      });

      /* @sunheat */
      $("#sunHeat").click(function () {
        $("#sunHeat").val("Tak");
        clickSunheat = 0;
        clickPompheat = 0;
        clickPompheatWater = 0;
        clickPompheatPool = 0;
        clickOptiEner = 0;
        clickSunheat++;
        let searchInput = $("#search-input").val();
        let n = searchInput;
        let sunHeat = "Tak";
        let accname = $("#append-clients");

        if (clickSunheat === 1) {
          $("#append-clients").empty();
          clearMarkers();
          makeLoader();
          setZoom();
          refreshAccordion(accname);

          (async () => {
            try {
              const res = await fetch(installer_sunheat.path, {
                headers: { Accept: "application/json" },
              });

              const json = await res.json();

              for (let i = 0; i < json.length; i++) {
                let jsonItem = json[i];
                if (
                  jsonItem.Addresses.Lat !== null &&
                  jsonItem.Addresses.City !== null &&
                  jsonItem.Addresses.City !== undefined &&
                  jsonItem.Addresses.Lat !== undefined
                ) {
                  let getProvince;
                  if (
                    jsonItem.Addresses.Province !== null ||
                    jsonItem.Addresses.Province !== undefined
                  ) {
                    getProvince = jsonItem.Addresses.Province.capitalize();
                  } else {
                    getProvince = "";
                  }

                  let filtername = sunHeat;
                  generateAccordion(
                    accname,
                    filtername,
                    jsonItem.ID,
                    jsonItem.Addresses.City,
                    jsonItem.Addresses.Street,
                    jsonItem.Email,
                    jsonItem.Phone,
                    jsonItem.Addresses.Code,
                    jsonItem.Name,
                    getProvince,
                    jsonItem.Website
                  );

                  let latLng = new google.maps.LatLng(
                    jsonItem.Addresses.Lat,
                    jsonItem.Addresses.Long
                  );

                  let marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    city: jsonItem.Addresses.City,
                    province: getProvince,
                    title: jsonItem.title,
                    targetid: jsonItem.ID,
                    icon: iconDefault,
                    sunHeat: sunHeat,
                  });
                  markers.push(marker);

                  toggleMarkerActive(marker, i, jsonItem.ID, markers);
                }
              }
            } catch (e) {
              console.error("json is empty or not created");
            }
            refreshAccordion(accname);
            let acclength = $("#append-clients #theacc").length;

            if (acclength === markers.length) {
              endLoader();
              $("#theacc .item").click(function () {
                let data_acc_marker = $(this).attr("data-targetid");
                let parent = $(this).parent();
                let totable = Object.values(parent);
                let state = $(totable[0]).attr("aria-selected");

                for (let i = 0; i < markers.length; i++) {
                  if (
                    data_acc_marker === markers[i].targetid &&
                    state == "false"
                  ) {
                    markers[i].setIcon(iconSelected);
                  } else {
                    markers[i].setIcon(iconDefault);
                  }
                }
              });
            }
            if (n !== "") {
              makeLoader();
              setTimeout(function () {
                $("#search_button")[0].click();
                // endLoader();
                filterMarkerBySearch(n, map, markers);
              }, 50);
            } else {
              makeLoader();
              setTimeout(function () {
                endLoader();
              }, 50);
            }
            clearNullStrings();
          })();
        }
      });

      /* @optiener */

      $("#optiEner").click(function () {
        $("#optiEner").val("Tak");
        clickSunheat = 0;
        clickCollectorsun = 0;
        clickPompheatWater = 0;
        clickPompheat = 0;
        clickPompheatPool = 0;
        clickOptiEner++;
        let searchInput = $("#search-input").val();
        let n = searchInput;
        let optiEner = "Tak";
        let accname = $("#append-clients");

        if (clickOptiEner === 1) {
          $("#append-clients").empty();
          clearMarkers();
          makeLoader();
          setZoom();
          refreshAccordion(accname);

          (async () => {
            try {
              const res = await fetch(installer_optiener.path, {
                headers: { Accept: "application/json" },
              });
              const json = await res.json();
              // console.log("json", json);

              for (let i = 0; i < json.length; i++) {
                let jsonItem = json[i];
                if (
                  jsonItem.Addresses.Lat !== null &&
                  jsonItem.Addresses.City !== null &&
                  jsonItem.Addresses.City !== undefined &&
                  jsonItem.Addresses.Lat !== undefined
                ) {
                  let getProvince;
                  if (
                    jsonItem.Addresses.Province !== null ||
                    jsonItem.Addresses.Province !== undefined
                  ) {
                    getProvince = jsonItem.Addresses.Province.capitalize();
                  } else {
                    getProvince = "";
                  }

                  let filtername = optiEner;
                  generateAccordion(
                    accname,
                    filtername,
                    jsonItem.ID,
                    jsonItem.Addresses.City,
                    jsonItem.Addresses.Street,
                    jsonItem.Email,
                    jsonItem.Phone,
                    jsonItem.Addresses.Code,
                    jsonItem.Name,
                    getProvince,
                    jsonItem.Website
                  );

                  let latLng = new google.maps.LatLng(
                    jsonItem.Addresses.Lat,
                    jsonItem.Addresses.Long
                  );

                  let thecity = capitalizeFirstLetter(jsonItem.Addresses.City);
                  let getcity = thecity
                    .split("-")
                    .map((e) => e.charAt(0).toUpperCase() + e.slice(1))
                    .join("-");

                  let marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    city: getcity,
                    province: getProvince,
                    title: jsonItem.title,
                    targetid: jsonItem.ID,
                    icon: iconDefault,
                    optiEner: optiEner,
                    code: jsonItem.Addresses.Code || "",
                  });
                  markers.push(marker);
                  toggleMarkerActive(marker, i, jsonItem.ID, markers);
                }
              }
            } catch (e) {
              console.error("json is empty or not created");
            }
            refreshAccordion(accname);
            let acclength = $("#append-clients #theacc").length;

            if (acclength === markers.length) {
              endLoader();
              $("#theacc .item").click(function () {
                let data_acc_marker = $(this).attr("data-targetid");
                let parent = $(this).parent();
                let totable = Object.values(parent);
                let state = $(totable[0]).attr("aria-selected");

                for (let i = 0; i < markers.length; i++) {
                  if (
                    data_acc_marker === markers[i].targetid &&
                    state == "false"
                  ) {
                    markers[i].setIcon(iconSelected);
                  } else {
                    markers[i].setIcon(iconDefault);
                  }
                }
              });
            }
            if (n !== "") {
              makeLoader();
              setTimeout(function () {
                $("#search_button")[0].click();
                // endLoader();
                filterMarkerBySearch(n, map, markers);
              }, 50);
            } else {
              makeLoader();
              setTimeout(function () {
                endLoader();
              }, 50);
            }
            clearNullStrings();
          })();
        }
      });

      /* <<<<<<<< starting @SEARCH >>>>>>> */

      /* @initsearch  */
      let input = /** @type {HTMLInputElement} */ (
        document.getElementById("search-input")
      );

      let searchBox = new google.maps.places.SearchBox(
        /** @type {HTMLInputElement} */
        (input)
      );

      /* @search  */

      // google.maps.event.addListener("place_changed", function () {
      //   alert("WOW");

      //   var place = autocomplete1.getPlace();
      //   error(); // This is the runtime error, undefined function
      // });

      $("#search_button").click(function () {
        // console.log("searchbox", searchBox);
        // console.log("CLICKED");
        setTimeout(function () {
          let searchInput = $("#search-input").val();

          // console.log("searchbox::", searchBox.gm_accessors_.places);
          if (searchInput.length == 0) {
            return false;
          } else {
            // alert("empty");
            let extendedMarkers = [];

            if (circle.length !== 0 || undefined) {
              circle.setRadius(0);
              circle.setMap(null);
            }

            let getRange = document.getElementById("range").value;
            let radius = parseInt(getRange, 10) * 1000;

            circle = new google.maps.Circle({
              radius: radius,
              fillOpacity: 0.5,
              strokeColor: "#e3a14e",
              fillColor: "#e3a14e",
            });
            // google.maps.event.addListener(
            //   searchBox,
            //   "places_changed",
            //   function () {
            let places = searchBox.getPlaces();

            if (places.length == 0) {
              return;
            }

            /* @search - get map location */
            var bounds = new google.maps.LatLngBounds();
            for (let i = 0, place; (place = places[i]); i++) {
              bounds.extend(place.geometry.location);
            }
            map.fitBounds(bounds);

            markers.forEach((marker) => {
              marker.setMap(null); // Set map
            });

            /* @aftersearch - get currentcity */
            places.forEach((placeItem) => {
              window.currentCity = placeItem.formatted_address;
            });

            zoomLevel = map.getZoom();

            let n = window.currentCity || places[0].formatted_address;
            console.log("WINDOWCURRENTCITY:", n);

            map.setZoom(10);
            map.zoom = 10;

            /* @aftersearch - filter markers depends on search result */
            let radioval = "Tak";
            let toggleMarker;
            let checkedSunHeat = $("#sunHeat:checked").val();
            let checkedCollectorSun = $("#collectorSun:checked").val();
            let checkedPompHeat = $("#pompHeat:checked").val();
            let checkedPompHeatWater = $("#pompHeatWater:checked").val();
            let checkedOptiEner = $("#optiEner:checked").val();
            let checkedPompheatPool = $("#pompHeatPool:checked").val();

            const filteredMarkers = markers.filter((marker) => {
              switch (radioval) {
                case checkedSunHeat:
                  toggleMarker = marker.sunHeat;
                  break;
                case checkedCollectorSun:
                  toggleMarker = marker.collectorSun;
                  break;
                case checkedPompHeat:
                  toggleMarker = marker.pompHeat;
                  break;
                case checkedPompHeatWater:
                  toggleMarker = marker.pompHeatWater;
                  break;
                case checkedOptiEner:
                  toggleMarker = marker.optiEner;
                  break;
                case checkedPompheatPool:
                  toggleMarker = marker.pompHeatPool;
                  break;
                default:
                  "";
                  break;
              }

              if (window.currentCity === undefined) {
                marker.setMap(null);
                return toggleMarker === radioval;
              }

              console.log("WINDOWCITY", window.currentCity);

              if (window.currentCity.includes(marker.province)) {
                return (
                  window.currentCity.includes(marker.province) &&
                  toggleMarker === radioval
                );
              }
              // console.log("CHECKCITY:", marker.city);
              if (window.currentCity.includes(marker.city)) {
                return (
                  window.currentCity.includes(marker.city) &&
                  toggleMarker === radioval
                );
              } else {
                for (var i = 0; i < markers.length; i++) {
                  markers[i].setMap(null);
                }
              }
            });

            var marker = filteredMarkers[0];

            var bounds = new google.maps.LatLngBounds();

            setTimeout(function () {
              for (var j = 0; j < markers.length; j++) {
                if (
                  google.maps.geometry.spherical.computeDistanceBetween(
                    markers[j].getPosition(),
                    marker.getPosition()
                  ) < radius
                ) {
                  console.log("bounds", marker[j]);

                  bounds.extend(markers[j].getPosition());
                  extendedMarkers.push(markers[j]);
                  markers[j].setMap(map);
                } else {
                  markers[j].setMap(null);
                }
              }
            }, 270);

            // setTimeout(function () {
            console.log("allmarkers", extendedMarkers);
            circle.setOptions({ center: marker.getPosition() });
            circle.setMap(map);
            // }, 70);

            $(".allradio").click(function () {
              // setTimeout(function () {
              if (circle.getBounds() !== null) {
                circle.setMap(null);
              }
              makeLoader();
              // }, 140);
            });
            //   }
            // );

            // alert("CHANGED");
            setTimeout(function () {
              $(".subcat-item .item").each(function () {
                let $this = $(this);
                $this.parent().addClass("hidden");
                let value = $this.attr("data-city").toLowerCase();
                let valueProvince = $this.attr("data-province").toLowerCase();
                let valuePostcode = $this.attr("data-postcode");

                for (var j = 0; j < extendedMarkers.length; j++) {
                  let n = extendedMarkers[j].city.toLowerCase();
                  let province = extendedMarkers[j].province.toLowerCase();
                  makeLoader();

                  if (n.includes(value)) {
                    $this.parent().removeClass("hidden");
                  }

                  // if (province.includes(valueProvince)) {
                  //   $this.parent().removeClass("hidden");
                  // }

                  // if (valueProvince == n) {
                  //   $this.parent().removeClass("hidden");
                  // }

                  if (n.includes(valuePostcode)) {
                    $this.parent().removeClass("hidden");
                  }
                }
                endLoader();
              });
            }, 940);
          }
        }, 370);
      });

      google.maps.event.addListener(map, "bounds_changed", function () {
        let bounds = map.getBounds();
        searchBox.setBounds(bounds);
      });

      document.getElementById("search_button").onclick = function () {
        let input = document.getElementById("search-input");
        google.maps.event.trigger(input, "focus", {});
        google.maps.event.trigger(input, "keydown", {
          keyCode: 13,
        });
        google.maps.event.trigger(this, "focus", {});
      };
    }
    google.maps.event.addDomListener(window, "load", initialize);
  }
});
