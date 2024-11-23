const mix = require("laravel-mix");
require("laravel-mix-clean");

mix
  .setPublicPath("dist")
  .js("assets/js/main.js", "scripts")
  .sass("assets/scss/index.scss", "css")
  .sass("assets/scss/Templates/instalator/_calculator-pv.scss", "css")
  .sass("assets/scss/Templates/instalator/_calculator-pcco.scss", "css")
  .sass("assets/scss/Templates/instalator/_calculator-pcwb.scss", "css")
  .sass("assets/scss/Templates/instalator/_calculator-mount.scss", "css")
  .copyDirectory("assets/img", "dist/img")
  .options({ processCssUrls: false });

// mix.copyDirectory("assets/images", "dist/images");
mix.js("react-form/src/index.js", "react_dist/js").react();

mix.js(
  "assets/js/Templates/globals/angular.js",
  "dist/scripts/calculators/angular-pack"
);

mix.js(
  "assets/js/Templates/globals/sliders.js",
  "dist/scripts/calculators/angular-pack/sliders.js"
);

mix.js(
  "assets/js/Templates/instalator/map/map.js",
  "dist/scripts/map/installer"
);
mix.js(
  "assets/js/Templates/distributor/map/map.js",
  "dist/scripts/map/distributor"
);

//custom admin - edit action
mix.js("assets/admin/js/index.js", "dist/admin/js");
mix.sass("assets/admin/scss/index.scss", "dist/admin/css");

if (mix.inProduction()) {
  mix.clean();
}

mix.sourceMaps().version();
