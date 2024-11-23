/**
 * 3rd parts
 */
// import "angular";
// import "angular-sanitize";
// import "angular-chart.js";
import "jquery";
import "jquery-ui";
import "lodash";
import "bootstrap-wizard";
import "jquery-validation";

/**
 * Custom
 */

import "./Templates/trainers/global.js";
import "./Templates/newsletter/global.js";
import "./Templates/information/global.js";

// Shop products
import "./Templates/Shop/increment";
import "./Templates/Shop/pagination";
import "./Templates/Shop/form-address";
import "./Templates/Shop/ajax";

// import "./Templates/instalator/app-2.js";
import "./Templates/instalator/ajax.js";
import "./common/notices/success.js";
import "./common/notices/error.js";

import Checkbox from "./Templates/user/acf_checkbox";

/**
 * Angular Calculators
 */
// import "./Templates/instalator/pvslctool.js";
// import "./Templates/instalator/calculator-pv-2.js";
// // import "./Templates/instalator/pumpsform.js";
// // import "./Templates/instalator/pcwbtool.js";
// import "./Templates/instalator/offerform.js";

/**
 * Offer instalator tabs
 */

import "./Templates/instalator/offer-instalator-tabs.js";

document.addEventListener("DOMContentLoaded", function (event) {
  const checkbox = new Checkbox();
});
