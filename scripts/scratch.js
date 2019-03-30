
/*
exports.delete = function(cb) {
  // Use the `delete` module directly, instead of using gulp-rimraf
  del(['output/*.js'], cb);
}
*/

// config.template
// config.component

// Error handling
const onError = function (err) {
  log(colors.green(err));
};

/*
By default, gulp will create files with the same permissions as the running
process, but you can configure the modes through options in src(), dest(), etc.

Can you tag streams with Gulp src() so that they can be redirected to different directories by dest()?

src() options:
  allowEmpty    Suppress error when glob matches a single file (no wildcards) and there isn't a match (file is missing)
  sourcemaps
  dot           If set to true, compare globs against dot files, like .gitignore.
  nocase	      If set to true, performs a case-insensitive match.
  ignore	      Globs to exclude from matches.

External sourcemaps:
*/

function sync() {
  src('input/**/*.js', { sourcemaps: true })
    .pipe(dest('output/', { sourcemaps: '.' }));
}



function liveReload() {
  if(!process.env.CA_DIRECTORY_TO_JOOMLA) noJoomlaDirEnvVar();

  // Create a static server
  return browserSync({ proxy : "localhost" });
}

// BrowserSync (callback)
function browserSync(done) {
  browserSync.init({
    server: {
      baseDir: "./_site/"
    },
    port: 3000
  });
  done();
}

// BrowserSync Reload (callback)
function browserSyncReload(done) {
  browserSync.reload();
  done();
}

/*
dest() options:
  mode	(number|function)     stat.mode of the Vinyl object	The mode used when creating files. If not
                              set and stat.mode is missing, the process' mode will be used instead.
  dirMode	(number|function)		The mode used when creating directories. If not set, the process' mode will be used.
*/

function init(cb) {
  if(!process.env.CA_DIRECTORY_TO_REPO) noRepoDirEnvVar();

  cb();
}

function cssTranspile() {
	return src('./scss/template.scss')
		.pipe( plumber({ errorHandler: onError }) )
    .pipe( sass() )

    // save the CSS files
		.pipe( dest( './css' ) )
    .pipe( dest( '/var/www/joomla/templates/tpl_mfi/css' ) )

    // trigger the browser to reload
    .pipe( browserSync.reload({ stream:true }) )
    // .pipe( browserSync.stream() )

    // minify CSS
    .pipe( cleanCSS({ compatibility: 'ie8' }) )

		.pipe( rename(function (path) {
			path.basename += '.min';
    }))

    // save minified CSS with ".min" in the file name
		.pipe( dest( './css' ) )
    .pipe( dest( '/var/www/joomla/templates/tpl_mfi/css' ) )
}

function cssMinify() {
  // body omitted
}

function jsTranspile() {
  return src('*.js')
    .pipe(dest('output'));

}

// Lint scripts (returns a stream)
function scriptsLint() {
  return gulp
    .src(["./assets/js/**/*", "./gulpfile.js"])
    .pipe(plumber())
    .pipe(eslint())
    .pipe(eslint.format())
    .pipe(eslint.failAfterError());
}

function jsBundle() {
  // body omitted
}

function jsMinify() {
	return src([
    './js/template.js'
  ])
  .pipe(plumber({ errorHandler: onError }) )

  .pipe(sourcemaps.init())

  .pipe( concat( 'template.js' ) )

  .pipe( dest( './js' ) )
  .pipe( dest( '/var/www/joomla/templates/tpl_mfi/js' ) )

  .pipe( browserSync.reload({ stream:true }) )

  .pipe( uglify() )

  .pipe(rename(function (path) {
    path.basename += '.min';
  }))

  .pipe(sourcemaps.write('./'))

  .pipe( dest( './js' ) )
  .pipe( dest( '/var/www/joomla/templates/tpl_mfi/js' ) )

  .pipe( browserSync.reload({ stream:true }) );
}

function noRepoDirEnvVar() {
  console.log("\nYou need to set the following environmental variable in your shell");
  console.log("environment, for example in /etc/bash.bashrc on Debian systems:\n");
  console.log("  CA_DIRECTORY_TO_REPO - the root of the project repository");
  console.log("\nExample entries for Debian in bash.bashrc:\n");
  console.log("  export CA_DIRECTORY_TO_REPO=\"/var/www/work/ca-job-board-joomla\"\n");
}

function noJoomlaDirEnvVar() {
  console.log("\nYou need to set the following environmental variable in your shell");
  console.log("environment, for example in /etc/bash.bashrc on Debian systems:\n");
  console.log("  CA_DIRECTORY_TO_JOOMLA - the root of the live Joomla! site to hot reload");
  console.log("\nExample entries for Debian in bash.bashrc:\n");
  console.log("  export CA_DIRECTORY_TO_JOOMLA=\"/var/www/joomla\"\n");
}

exports.liveReload = liveReload;

exports.default = series(
  init,
  parallel(
    cssTranspile,
    series(jsTranspile, jsBundle)
  ),
  parallel(cssMinify, jsMinify)
);
