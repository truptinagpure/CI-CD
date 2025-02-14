var gulp = require("gulp");
/*----plugins----*/
var sass = require("gulp-sass");
var concat = require("gulp-concat");
var uglify = require("gulp-uglify");
var cssnano = require("gulp-cssnano");
var rename = require("gulp-rename");
var autoprefixer = require("gulp-autoprefixer");
var merge2 = require("merge2");
var notify = require("gulp-notify");
var browserSync = require("browser-sync").create();
var eslint = require("gulp-eslint");
// var fontmin = require('gulp-fontmin');
// var imagemin = require("gulp-imagemin");
// var optipng = require('imagemin-optipng');
// var mozjpeg = require('imagemin-mozjpeg');
// var Gifsicle = require('imagemin-gifsicle');
// var svgo = require('imagemin-svgo');
/*----plugins----*/

/*----Destinations Folder----*/

// JS Destinations
var JS_DISTRIBUTION_FOLDER = "./assets/somaiya_com/js";

// CSS Destinations
var CSS_DISTRIBUTION_FOLDER = "./assets/somaiya_com/css";

// PLUGINS CSS
var THIRD_PARTY_CSS = [
    "./node_modules/animate.css/animate.min.css",
    "./node_modules/bootstrap/dist/css/bootstrap.css",
    "./node_modules/font-awesome/css/font-awesome.min.css",
    "./node_modules/aos/dist/aos.css",
    "./node_modules/fullpage.js/dist/fullpage.min.css",
];

// CUSTOME CSS
var CUSTOM_CSS = ["./assets/somaiya_com/openFiles/css/custom.scss"];

// PLUGINS JS
var THIRD_PARTY_JS = [
    "./assets/somaiya_com/openFiles/js/modernizr-custom.js",
    "./node_modules/jquery/dist/jquery.min.js",
    "./node_modules/bootstrap/dist/js/bootstrap.min.js",
    // "./node_modules/fullpage.js/dist/fullpage.min.js",
    // "./node_modules/fullpage.js/dist/fullpage.extensions.min.js",
    // "./node_modules/gsap/dist/gsap.min.js",
    // "./node_modules/scrollmagic/scrollmagic/minified/ScrollMagic.min.js",
    "./node_modules/aos/dist/aos.js",
    // "./assets/somaiya_com/openFiles/js/jquery.scroll-spy.min.js",
];

// CUSTOME JS
var CUSTOM_JS = ["./assets/somaiya_com/openFiles/js/custom.js"];

// FONTS PATH
// var fontsPath = 'openFiles/fonts/*.{ttf,TTF, svg, SVG, eot, EOT, woff, WOFF, woff2, WOFF2}';

// IMAEGS PATH
// var imagesPath = 'components/images/*.{png,jpg,jpeg,svg,gif}';

/*----Destinations Folder----*/

// Browser SYNC
gulp.task("browser-sync", ["styles"], function () {
    browserSync.init({
        server: {
            injectChanges: true,
            baseDir: "./"
        }
    });
});

// STyles Merge
gulp.task("styles", function () {
    var sequentialCSS = THIRD_PARTY_CSS.concat(CUSTOM_CSS);
    return gulp.src(sequentialCSS)
        .pipe(sass().on("error", sass.logError))
        .pipe(concat("style.css"))
        .pipe(autoprefixer({
            browsers: ["> 1%", "iOS 7", "ie >= 10"],
            cascade: false
        }))
        .pipe(gulp.dest(CSS_DISTRIBUTION_FOLDER))
        .pipe(rename("style.min.css"))
        .pipe(cssnano())
        .pipe(gulp.dest(CSS_DISTRIBUTION_FOLDER))
        .pipe(browserSync.reload({ stream: true }))
        .pipe(notify({
            message: "style.min.css is ready!"
        }));
});

// Scripts Merge
gulp.task("scripts", function () {
    var sequentialJS = THIRD_PARTY_JS.concat(CUSTOM_JS);
    return gulp.src(sequentialJS)
        .pipe(concat("custom.js"))
        .pipe(gulp.dest(JS_DISTRIBUTION_FOLDER))
        .pipe(rename("custom.min.js"))
        .pipe(uglify({
            mangle: true
        }))
        .pipe(gulp.dest(JS_DISTRIBUTION_FOLDER))
        .pipe(notify({
            message: "custom.min.js is ready!"
        }));
});

// Scripts Linting
gulp.task("lint", function () {
    return gulp.src(CUSTOM_JS).pipe(eslint({
        "rules": {
            "quotes": [1, "single"],
            "semi": [1, "always"]
        }
    }))
        .pipe(eslint.format())
        // Brick on failure to be super strict
        .pipe(eslint.failOnError());
});

//Font Minifier Task
// gulp.task("fonts", function(text) {
//     return src(fontsPath)
//         .pipe(fontmin({
//             text: text
//         }))
//         .pipe(dest('assets/fonts'))
//         .pipe(browserSync.stream())
//         .pipe(notify({ message: "All Fonts Minified!" }))
// });

// Image Minifier
// gulp.task("imageMinifier", function() {
//     return src(imagesPath)
//         .pipe(imagemin([
//             optipng({ optimizationLevel: 6 }),
//             mozjpeg({ quality: 80, progressive: true }),
//             Gifsicle({ optimize: 3, interlaced: true }),
//             svgo({
//                 plugins: [
//                     { removeViewBox: true },
//                     { cleanupIDs: false }
//                 ]
//             })
//         ]))
//         .pipe(dest('assets/images'))
// });

// GUlp Watcher
gulp.task("watch", ["browser-sync"], function () {
    gulp.watch("./assets/somaiya_com/openFiles/css/**/*.scss", ["styles"]).on("change", browserSync.reload);
    gulp.watch("./assets/somaiya_com/openFiles/js/**/*.js", ["scripts"]).on("change", browserSync.reload);
    gulp.watch("*.html").on("change", browserSync.reload);
});

// Final Executions
gulp.task("default", ["styles", "scripts", "watch"]);

// Service Workers Task
// gulp.task('generate-service-worker', function(callback) {
//   var path = require('path');
//   var swPrecache = require('sw-precache');
//   var rootDir = 'app';

//   swPrecache.write(path.join(rootDir, 'sw.js'), {
//     staticFileGlobs: [rootDir + '/**/*.{js,html,css,png,jpg,gif}'],
//     stripPrefix: rootDir
//   }, callback);
// });