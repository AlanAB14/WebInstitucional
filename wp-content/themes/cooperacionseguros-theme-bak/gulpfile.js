// Startup
// sudo npm install --save-dev
const gulp = require("gulp");
const plugins = require("gulp-load-plugins")();

// Compilar main.less
function less() {
  return gulp
    .src(["./assets/less/main.less"])
    .pipe(plugins.plumber())
    .pipe(plugins.less())
    .pipe(plugins.cssmin())
    .pipe(gulp.dest("./assets/css"))
    .on("error", function (err) {
      gutil.log(err);
      this.emit("end");
    });
}

// Combinar javascript
function scripts() {
  return gulp
    .src([
      "./assets/js/vendor/jquery-3.6.0.min.js",
      "./assets/js/vendor/jsrender.min.js",
      "./assets/js/vendor/jquery.validate.js",
      "./assets/js/vendor/additional-methods.js",
      "./assets/js/vendor/js.cookie.js",
      "./assets/js/vendor/jquery.redirect.js",
      "./assets/js/vendor/select2/js/select2.min.js",
      "./assets/js/vendor/select2/js/i18n/es.js",
      "./assets/js/vendor/tooltipster/js/tooltipster.bundle.min.js",
      "./assets/js/vendor/leaflet/leaflet.js",
      "./assets/js/vendor/slick/slick.min.js",
      "./assets/js/vendor/responsiveTabs/jquery.responsiveTabs.js",
      "./assets/js/vendor/inputmask/jquery.inputmask.js",
      "./assets/js/vendor/datepicker/datepicker.js",
      "./assets/js/vendor/datepicker/datepicker.es-ES.js",
      "./assets/js/own/functions.js",
      "./assets/js/own/main.js",
      "./assets/js/own/productos.js",
      "./assets/js/own/planes.js",
      "./assets/js/own/productores.js",
      "./assets/js/own/oficinas.js",
      "./assets/js/own/checkout.js",
      "./assets/js/own/validate.js",
      "./assets/js/own/quiero-que-me-llamen.js",
      "./assets/js/own/reclamos-de-terceros.js",
    ])
    .pipe(plugins.plumber())
    .pipe(plugins.concat("main.js"))
    .pipe(gulp.dest("./assets/js"))
    .pipe(
      plugins.terser({
        output: { comments: false },
      })
    )
    .pipe(plugins.rename({ extname: ".min.js" }))
    .pipe(gulp.dest("./assets/js"))
    .on("error", function (err) {
      gutil.log(err);
      this.emit("end");
    });
}

// Observar cambios en estos archivos...
function watchFiles() {
  gulp.watch("./assets/less/*.less", less);
  gulp.watch(["./assets/js/lib/*.js", "./assets/js/own/*.js"], scripts);
}

const serve = gulp.series(less, scripts);
serve.description = "Procesar CSS y Javascript";

const watch = gulp.parallel(watchFiles);
watch.description = "Observar cambios";

const defaultTasks = gulp.parallel(serve, watch);

exports.less = less;
exports.watchFiles = watchFiles;
exports.default = defaultTasks;
