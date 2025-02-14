// Load plugins
const { src, dest, watch, series, parallel} = require("gulp");

// Dependency for CSS Files
const cssnano = require("cssnano");
const postcss = require("gulp-postcss");
const sass = require("gulp-sass");
const cleanCSS = require('gulp-clean-css');
const sourcemaps = require("gulp-sourcemaps");

// Dependency for JS Files
const uglify = require("gulp-uglify");
const jslint = require('gulp-jslint');

//Dependeny for HTML Files
const htmltidy = require('gulp-htmltidy');
const htmlhint = require("gulp-htmlhint");

// Dependency for image optimizations
const changed = require('gulp-changed');
const imagemin = require("gulp-imagemin");
const optipng = require('imagemin-optipng');
const mozjpeg = require('imagemin-mozjpeg');
const Gifsicle = require('imagemin-gifsicle');
const svgo = require('imagemin-svgo');

// Common Dependency
const autoprefixer = require("autoprefixer");
const concat = require("gulp-concat");
const replace = require("gulp-replace");
const notify = require("gulp-notify");
const browserSync = require("browser-sync").create();
const rename = require("gulp-rename");

// Font Minifications
const fontmin = require('gulp-fontmin');

//Path 
// const files = {}
var  htnlpath = "./somaiya/views/somaiya_general/*.html";
var  fontsPath ='components/fonts/*.{ttf,TTF, svg, SVG, eot, EOT, woff, WOFF, woff2, WOFF2}';
var  scssPath ='./assets/somaiya_com/openFiles/css/*.scss';
var  jspath = './assets/somaiya_com/openFiles/js/**/*.js';
var  imagesPath =  './assets/somaiya_com/openFiles/img/**/*.+(png|jpg|jpeg|svg|gif)';

var  plugin_css = [
    "./node_modules/animate.css/animate.min.css",
    "./node_modules/bootstrap/dist/css/bootstrap.css",
    "./node_modules/font-awesome/css/font-awesome.min.css",
    "./node_modules/aos/dist/aos.css",
    "./assets/somaiya_com/openFiles/css/custom.scss"
    // "./node_modules/fullpage.js/dist/fullpage.min.css"
];

var  plugin_js = [
    "./assets/somaiya_com/openFiles/js/modernizr-custom.js",
    "./node_modules/jquery/dist/jquery.min.js",
    "./node_modules/bootstrap/dist/js/bootstrap.min.js",
    // "./node_modules/fullpage.js/dist/fullpage.min.js",
    // "./node_modules/fullpage.js/dist/fullpage.extensions.min.js",
    // "./node_modules/gsap/dist/gsap.min.js",
    // "./node_modules/scrollmagic/scrollmagic/minified/ScrollMagic.min.js",
    "./node_modules/aos/dist/aos.js",
    "./assets/somaiya_com/openFiles/js/custom.js"
    // "./assets/somaiya_com/openFiles/js/jquery.scroll-spy.min.js",
];

 //Scss Task 
 //UnCSS - to remove the unused CSS...
 function scssTask(){
   sequentialCSS = plugin_css.concat(scssPath);
   return src(sequentialCSS) 
   .pipe(sourcemaps.init())
   .pipe(sass().on("error", sass.logError))
   .pipe(concat('style.css'))
   .pipe(dest('./assets/somaiya_com/css'))
   .pipe(postcss([
     autoprefixer({
          browsersbrowserslist: ["> 1%", "iOS 7", "ie >= 10"],
          cascade: false
      }), 
      cssnano()
    ]))
   .pipe(cleanCSS({compatibility: 'ie8'}))
   .pipe(sourcemaps.write('.'))
   .pipe(rename("style.min.css"))
   .pipe(dest('./assets/somaiya_com/css'))
   .pipe(browserSync.reload({stream: true}))
   .pipe(notify({ message: "style.min.css is ready!"}))
 };

 //JS Task 
 function jsTask(){
  sequentialJS = plugin_js.concat(jspath);
  return src(sequentialJS) 
  .pipe(concat('custom.js'))
  .pipe(jslint({ node:true, bitwise:true }))
  .pipe(dest('./assets/somaiya_com/js'))
  // .pipe(jslint.reporter( 'stylish' ))
  .pipe(uglify({
    mangle: true
  }))
  // .pipe(terser()) for es6
  .pipe(rename("custom.min.js"))
  .pipe(dest('./assets/somaiya_com/js'))
  .pipe(browserSync.stream())
  .pipe(notify({ message: "script.min.js is ready!" }))
};

//Image Min Task 
// gifsicle — Compress GIF images - NW
// mozjpeg — Compress JPEG images
// optipng — Compress PNG images
// svgo — Compress SVG images - NW

function imageMinifier(){
  return src(imagesPath)
  .pipe(changed(imagesPath))
  .pipe(imagemin([
    optipng({optimizationLevel: 7}),
    mozjpeg({quality: 90, progressive: true}),
    Gifsicle({optimize:5, interlaced: true}),
    svgo({
      plugins: [
          {removeViewBox: true},
          {cleanupIDs: false}
      ]
    })
  ]))
  .pipe(dest('./assets/somaiya_com/img'))
  .pipe(browserSync.stream())
  .pipe(notify({ message: "Image Minified!" }))
}

//HTML Watcher Task
function htmlWatcher(){
  return src(htnlpath)
  .pipe(htmltidy
    ({
        doctype: 'html5',
        indent: true
    })
  )
  .pipe(htmlhint())
  .pipe(htmlhint.reporter())
  .pipe(browserSync.stream())
  .pipe(notify({ message: "HTML Templates are ready!" }))
}

//Font Minifier Task
function fontMinifier(text){
  return src(fontsPath)
  .pipe(fontmin({
      text: text
  }))
  .pipe(dest('assets/fonts'))
  .pipe(browserSync.stream())
  .pipe(notify({ message: "All Fonts Minified!" }))
}

//Watch Task
function watchTask(){
  watch([scssPath, jspath, imagesPath, htnlpath, fontsPath],
        parallel(scssTask, jsTask, htmlWatcher,  fontMinifier),
        // parallel(scssTask, jsTask, htmlWatcher, imageMinifier, fontMinifier),
        browserSync.init({
          server: { 
            baseDir :'./somaiya/views/somaiya_general/'
          }
        })
    );
}

//default function
exports.default = series(
  parallel(scssTask, jsTask, htmlWatcher,  fontMinifier),
  // parallel(scssTask, jsTask, htmlWatcher, imageMinifier, fontMinifier),
  watchTask
)

// .on("change", browserSync.reload())