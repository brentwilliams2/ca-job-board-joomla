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
 *
 * BrowserSync doesn't work with Joomla!, need URL rewriting
 */

// Generic dependencies
const freader = require("fs");

// delete utility compatible with Gulp
const del = require('del');

// Gulp task runner
const { src, dest, parallel, series } = require('gulp');

// Filesystem watcher
const watch = require('gulp-watch');

// Map each file in a stream into multiple files that are piped out
const flatmap = require('gulp-flatmap');

// Wrapper to system rsync
const rsync = require('gulp-rsync');

// Rename globs in the source stream
const rename = require('gulp-rename');

// Concat multiple files into one file
const concat = require('gulp-concat');

// Prevent pipe breaking caused by errors from gulp plugins
const plumber = require('gulp-plumber');

// Async logger for use with plumber
const notify = require("gulp-notify");

// Console log entries, prefixed with a timestamp
const log = require('fancy-log');

// Console beeps to know when the watcher died
const beep = require('beepbeep')

// Available colors are red, green, yellow, blue, magenta, cyan, white, and gray
const colors = require('ansi-colors');

// SASS compiler
const sass = require('gulp-sass');

// SASS linter using native Node module
const sassLint = require('gulp-sass-lint');

// SASS linter rules, merged with default rules
const sassLintOptions = {
  rules: {
    'no-css-comments': 0 // Severity 0 (disabled)
  }
}

// CSS minifier using
const cleanCSS = require('gulp-clean-css');

// Javascript linter
const eslint = require('gulp-eslint');

// SASS linter rules, merged with default rules
const esLintOptions = {
  rules: {
    'indent': [ 'warn', 2 ] // Two-space rule instead of Crockford's default 4
  }
}

// Minify JavaScript with UglifyJS3
const uglify = require('gulp-uglify');

// Load config
const config = JSON.parse( freader.readFileSync('./gulp-config.json') );

// Environmental variables that should be set for the shell
const joomlaDir = process.env.CA_DIRECTORY_TO_JOOMLA;
const repoDir   = process.env.CA_DIRECTORY_TO_REPO;

// For setting USER:GROUP in Rsync
config.chown    = process.env.CA_JOOMLA_USER_GROUP;

/*
 * Terminate on unhandled promise rejection
 */
process.on('unhandledRejection', function(err, promise) {
  beep(3, 20);
  console.error('Unhandled rejection (promise: ', promise, ', reason: ', err, ').');
  process.exit();
});

/*
 * Error handler for Plumber, to prevent breaking pipes when watcher on
 */
function onError(err) {
  beep(3, 20);
  notify.onError({
    title: "Gulp error in " + err.plugin,
    message:  err.toString()
  })(err);
}

/*
 * Make sure we have necessary environmental variables
 */
function init(done) {
  if(!joomlaDir || !repoDir || !config.chown) noDirEnvVar();
  done();
}

/*
 * Options to the gulp-watch plugin
 */
const watcherOptions = {
  events: ['add', 'change']
}

/*
 * Watch repository PHP directories
 */
function watchRepoPhp () {
  return watch( getGlobArray('php'), watcherOptions, function (Vinyl) {
    const phpJoomlaRelDir = getDestDir(Vinyl);

    src(Vinyl.path)
      .pipe( plumber({ errorHandler: onError }) )
      .pipe(rename(function (path) {
        path.dirname = phpJoomlaRelDir;
      }))
      .pipe( dest(joomlaDir))
      // Log it to console
      .on('end', function() { log( colors.green('Copied: ' + joomlaDir + phpJoomlaRelDir + '/' + Vinyl.basename)) });
  });
}

/*
 * Watch repository SCSS directories
 */
function watchRepoScss () {
  return watch( getGlobArray('scss'), watcherOptions, function (Vinyl) {
    // remove leading slash from the directories, since dest() requires a path
    const repoCssDir = getCssRepoDir(Vinyl).slice(1);
    // transform Joomla! live site directory from scss to css and strip leading slash
    const joomlaCssDir = joomlaDir.slice(1) + getDestDir(Vinyl).replace(/\/scss/, '/css');

    src(Vinyl.path, { sourcemaps: true })
      .pipe( plumber({ errorHandler: onError }) )
      .pipe(sassLint(sassLintOptions))
      // outputs the lint results to the console
      .pipe( sassLint.format() )
      // compile SCSS
      .pipe( sass() )
      // rename the path and file extension for the compiled file and save
      .pipe(rename(function (path) {
        path.dirname = repoCssDir;
        path.extname = ".css";
      }))
      .pipe( dest('/', { sourcemaps: '.' }) )
      // save the file in the Joomla! live site CSS directory
      .pipe(rename(function (path) {
        path.dirname = joomlaCssDir;
      }))
      .pipe( dest('/'))
      // Log it to console
      .on('end', function() {
        log( colors.green('Compiled: /' + repoCssDir + Vinyl.stem + '.css'));
        log( colors.green('Copied:   /' + joomlaCssDir + '/' + Vinyl.stem + '.css'));
      });
  });
}

/*
 * Build and return the repo CSS directory for the file, without the directory
 * root, from the Vinyl object's base property and the path map
 *
 * @return  string
 */
function getCssRepoDir(Vinyl) {
  for (let srcPath of Object.keys(config.pathMap)) {
    // this handles subdirectories, by matching on the base path
    if (Vinyl.path.includes(srcPath)) {
      return Vinyl.dirname.replace(/\/scss/, '/css');
    }
  }
  throw "Can't find a matching path from config.pathMap for file: " + Vinyl.path;
}

/*
 * Watch repository Js directories
 */
function watchRepoJs () {
  return watch( getGlobArray('js'), watcherOptions, function (Vinyl) {
    const jsJoomlaRelDir = getDestDir(Vinyl);

    src(Vinyl.path)
      .pipe( plumber({ errorHandler: onError }) )
      .pipe( eslint(esLintOptions) )
      // outputs the lint results to the console
      .pipe( eslint.format() )
      .pipe(rename(function (path) {
        path.dirname = jsJoomlaRelDir;
      }))
      .pipe( dest(joomlaDir))
      // Log it to console
      .on('end', function() { log( colors.green('Copied: ' + joomlaDir + jsJoomlaRelDir + '/' + Vinyl.basename)) });
  });
}

/*
 * Watch other repository directories
 */
function watchRepoOther () {
  return watch( getGlobArray('other'), watcherOptions, function (Vinyl) {
    const otherJoomlaRelDir = getDestDir(Vinyl);

    src(Vinyl.path)
      .pipe( plumber({ errorHandler: onError }) )
      .pipe(rename(function (path) {
        path.dirname = otherJoomlaRelDir;
      }))
      .pipe( dest(joomlaDir))
      // Log it to console
      .on('end', function() { log( colors.green('Copied: ' + joomlaDir + otherJoomlaRelDir + '/' + Vinyl.basename)) });
  });
}

/*
 * Build and return the destination directory for the file, without the directory
 * root, from the Vinyl object's base property and the path map
 *
 * @return  string
 */
function getDestDir(Vinyl) {
  for (let srcPath of Object.keys(config.pathMap)) {
    if (Vinyl.path.includes(srcPath)) {
      // extract the base path being watched and the env var-set repo path from the directory
      relDir = Vinyl.dirname.replace(repoDir, '');

      // @TODO: This doesn't work for wildcard file globs, like '*.php' used in the root of plugins

      // If we do have a fragment because of watching the base path recursively, extract it
      // and prepend a directory separator. The path mapping to a Joomla! live site path
      // retrieved from config can't know what the fragment will be
      if (relDir + '/' !== srcPath) {
        return config.pathMap[srcPath] + '/' + relDir.replace(srcPath, '');
      } else {
        return config.pathMap[srcPath];
      }
    }
  }
  throw "Can't find a matching path from config.pathMap for file: " + Vinyl.path;
}

/*
 * Extract an array of source globs from config for a given group
 *
 * @param   string    group   The group to return source globs for, e.g. 'js', 'css', etc.
 *
 * @return  Array   Returns an array of glob patterns
 */
function getGlobArray(group) {
  // only called once per group by the watcher
  var globArray = new Array();

  config[group].forEach (function (globRecord) {
    // Make sure glob doesn't have any double-asterisk glob patterns, e.g. /my/path/**/*.css
    if (/.*\*{2}/.test(globRecord)) throw "Globstar patterns (e.g. /**/*.css) aren't allowed in globs: " + globRecord;

    // absolute path string to repo + glob pattern string from config file
    const glob = repoDir + globRecord;
    globArray.push(glob);
  });

  return globArray;
}

/*
 * Sync files from repo to live Joomla! site for all globs, ensuring nothing stale
 *
 * @return  Stream
 */
function rsyncRepoToLiveSite() {
  const globArray = new Array();

  Object.keys(config.pathMap).forEach(function (rsyncKey) {
    globArray.push(repoDir + rsyncKey);
  });

  return src(globArray)
    .pipe(flatmap(function(stream, Vinyl) {
      return src(Vinyl.base)
        // rsync -arz
        .pipe(rsync({
          root: Vinyl.base + '/',
          destination: getDestDirFromBase(Vinyl.base),
          recursive: true,
          archive: true,
          silent: true,
          compress: true,
          delete: true,
          emptyDirectories: true,
          chown: config.chown
        }))
        .on('error', function() { log(colors.red('Error in rsyncing. Source:\n' + Vinyl.path + '\nDestination:\n' + getDestDirFromBase(Vinyl.base) )); })
        .on('end', function() { log(colors.green('Rsyncing: ' + Vinyl.base)); });
    }))
}

/*
 * Build and return the rsync destination directory for the file
 * from the Vinyl object's base property and the path map
 *
 * @return  string
 */
function getDestDirFromBase(fileBase) {
  const srcDir = fileBase.replace(repoDir, '') + '/';
  return joomlaDir + config.pathMap[srcDir];
}

/*
 * Compile SASS files to CSS
 */
function compileCss() {
  return src(getGlobArray('scss'), { sourcemaps: true })
    .pipe( plumber({ errorHandler: onError }) )
    .pipe(sassLint())
    // outputs the lint results to the console
    .pipe(sassLint.format())
    .pipe(sassLint.failOnError())
    .pipe( sass() )
    .pipe(rename(function (Vinyl) {
      Vinyl.dirname = 'css';
      Vinyl.extname = ".css";
    }))
    .pipe( dest(repoDir, { sourcemaps: '.' }))
    .on('end', function() { log(colors.green('Compiled SCSS...')); });
}

/*
 * Minify CSS files
 */
function minifyCss() {
  return src(getGlobArray('css'), { sourcemaps: true })
    .pipe( plumber({ errorHandler: onError }) )
    .pipe( cleanCSS() )
    .pipe(rename(function (Vinyl) {
      Vinyl.extname = ".min.css";
    }))
    .pipe( dest(repoDir, { sourcemaps: '.' }))
    .on('end', function() { log(colors.green('Minified SCSS...')); });
}

/*
 * Compress CSS files
 */
function compressCss() {
  return src(getGlobArray('css'))
    .pipe( plumber({ errorHandler: onError }) )
    // @TODO: need to filer and compress only already minified files, and then source maps
    //.pipe( zip('archive.zip'))
    .pipe(rename(function (Vinyl) {
      Vinyl.extname = ".min.css.zip";
    }))
    .pipe( dest(repoDir, { sourcemaps: '.' }))
    .on('end', function() { log(colors.green('@TODO: Implement CSS file compression')); });
}

/*
 * Minify Javascript files
 */
function minifyJs() {
  return src(getGlobArray('js'), { sourcemaps: true })
    .pipe( plumber({ errorHandler: onError }) )
    .pipe( uglify() )
    .pipe(rename(function (Vinyl) {
      Vinyl.extname = ".min.js";
    }))
    .pipe( dest(repoDir, { sourcemaps: '.' }))
    .on('end', function() { log(colors.green('Minified Javascript files...')); });
}

/*
 * Compress Js files
 */
function compressJs() {
  return src(getGlobArray('js'))
    .pipe( plumber({ errorHandler: onError }) )
    // @TODO: need to filer and compress only already minified files, and then source maps
    //.pipe( zip('archive.zip'))
    .pipe(rename(function (Vinyl) {
      Vinyl.extname = ".min.js.zip";
    }))
    .pipe( dest(repoDir, { sourcemaps: '.' }))
    .on('end', function() { log(colors.green('@TODO: Implement Javascript file compression')); });
}

/*
 * @TODO: Implement default task
 */
function defaultTask() {
  console.log("Implementation of default task is empty");
}

/*
 * Output error message and die if necessary environmental variables aren't set
 */
function noDirEnvVar() {
  console.log("\nYou need to set the following environmental variable in your shell");
  console.log("environment, for example in /etc/bash.bashrc on Debian systems:\n");
  if(!repoDir)   console.log("  CA_DIRECTORY_TO_REPO - the root of the project repository");
  if(!joomlaDir) console.log("  CA_DIRECTORY_TO_JOOMLA - the root of the live Joomla! site to hot reload");
  if(!config.chown) console.log("  CA_JOOMLA_USER_GROUP - Your user name and the web server group name");
  console.log("\nExample entries for Debian in bash.bashrc:\n");
  if(!repoDir)   console.log("  export CA_DIRECTORY_TO_REPO=\"/var/www/work/ca-job-board-joomla\"");
  if(!joomlaDir) console.log("  export CA_DIRECTORY_TO_JOOMLA=\"/var/www/joomla\"");
  if(!config.chown) console.log("  export CA_JOOMLA_USER_GROUP=\"yourusername:www-data\"");
  console.log("\n");
  process.exit();
}

exports.default = defaultTask;

exports.watch = series(
  init,
  rsyncRepoToLiveSite,
  parallel(
    watchRepoPhp,
    watchRepoScss,
    watchRepoJs,
    watchRepoOther
  )
);

exports.build = series(
  init,
  compileCss,
  minifyCss,
  compressCss,
  minifyJs,
  compressJs
);
