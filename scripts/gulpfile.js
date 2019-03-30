/**
 * Job Board build script to compile SASS, clean CSS, and minify JS and CSS
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Usage:
 *
 * Ensure you have 'gulp-cli' installed globally. Then,
 * run 'gulp' in the project scripts directory.
 */

// Generic dependencies
const freader = require("fs");


const del = require('del');

// Gulp task runner
const { src, dest, parallel, series } = require('gulp');

// Hot browser reload
const browserSync = require('browser-sync').create();

// Filesystem watcher
const watch = require('gulp-watch');

// Merge multiple Vinyl streams
const gulpMerge = require('gulp-merge');

// Conditional control structures in a stream
const gulpif = require('gulp-if');

// Rename globs in the source stream
const rename = require('gulp-rename');

// Concat multiple files into one file
const concat = require('gulp-concat');

// Prevent pipe breaking caused by errors from gulp plugins
const plumber = require('gulp-plumber');

// Libraries for error handling
const colors = require('ansi-colors');
const log = require('fancy-log');

// SASS compiler
const sass = require('gulp-sass');

// CSS minifier using
const cleanCSS = require('gulp-clean-css');

// Minify JavaScript with UglifyJS3
const uglify = require('gulp-uglify');

// Compression handling dependencies
const zip = require('gulp-zip');

// Load config
const config = JSON.parse( freader.readFileSync('./gulp-config.json') );

/*
 * Watch repository directories
 */
function watchRepo (done) {
  // Watch the PHP source files for change
  watch(getGlobArray('php'), function (Vinyl) {
    syncFiles('php', Vinyl);
  });

  done();
}

/*
 * Sync files from repo to live Joomla! site
 *
 * @param   string    group   The group to return source globs for, e.g. 'js', 'css', etc.
 *
 * @return  Stream
 */
function syncFiles(group, Vinyl) {
  return gulp.src('./app/js/minimizableControllBar/modules/**/*.css')
    .pipe(console.log)
    .pipe(gulp.dest('./app/js/minimizableControllBar/'))

  // this is in order to make the functions usable with and without done
  if(done) done();
}

/*
 * Extract an array of source globs from config for a given group
 *
 * @param   string    group   The group to return source globs for, e.g. 'js', 'css', etc.
 *
 * @return  Array   Returns an array of glob patterns
 */
function getGlobArray(group) {
  var globArray = new Array();

  config[group].forEach (function(glob) {
    globArray.push(glob.src);
  });

  return globArray;
}



function minimizableControllBar_css(done) {

}

function minimizableControllBar_jsonPreset(done) {
  gulp.src('./app/js/minimizableControllBar/modules/**/*.json')
    .pipe(gutil.buffer(function (err, files) {
      let presetAllJsonStr = '{\n'
      let i = 0
      for (i = 0; i < files.length - 1; i++) {
        //.....
      }
    }))

  // this is in order to make the functions usable with and without done
  if(done) done();
}

exports.watch = watchRepo;
