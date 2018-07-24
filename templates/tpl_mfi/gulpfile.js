// Generic dependencies
var gulp = require('gulp');
var sourcemaps = require('gulp-sourcemaps');
var plumber    = require('gulp-plumber'); // reasonable error handling for Gulp
var rename     = require('gulp-rename');
var concat     = require('gulp-concat');

// Error handling dependencies
var beep       = require('beepbeep');
var gutil      = require('gulp-util');

// CSS handling dependencies
var cleanCSS   = require('gulp-clean-css');
var sass       = require('gulp-sass');

// Javascript handling dependencies
var uglify     = require('gulp-uglify');

// Error handling
var onError = function (err) {
    beep([0, 0, 0]);
    gutil.log(gutil.colors.green(err));
};

// Compile Sass
function compileSassFile(src, dest)
{
	return gulp.src(src)
    .pipe(plumber({ errorHandler: onError }))
    .pipe(sourcemaps.init())
		.pipe(sass({precision: 8}))
		.pipe(gulp.dest(dest))
    .pipe(cleanCSS({ compatibility: 'ie8' }))
    .pipe(sourcemaps.write('./'))
		.pipe(rename(function (path) {
			path.basename += '.min';
    }))
		.pipe(gulp.dest(dest));
}

gulp.task('sass', function () {
  return (
    compileSassFile('./scss/template.scss', './css'),
    compileSassFile('./scss/bootstrap.scss', './css'),
    compileSassFile('./scss/icons.scss', './css'),
    compileSassFile('./scss/chosen.scss', './css/jui')
  );
});

/*
 * Minify Javascripts
 */
function compileJavascript(src) {
	return gulp.src(src)
    .pipe(plumber({ errorHandler: onError }))
    .pipe(sourcemaps.init())
		.pipe(concat('template.js'))
		.pipe(gulp.dest('./js'))
		.pipe(uglify())
		.pipe(rename(function (path) {
			path.basename += '.min';
     }))
    .pipe(sourcemaps.write('./'))
		.pipe(gulp.dest('./js'));
}

gulp.task('js', function () {
	return compileJavascript(
		[
			'./js/src/template.js'
		]
	);
});

/*
 * Watch
 */
gulp.task('watch',
	[
		'watch:sass',
		'watch:js'
	],
	function() {
});

/*
 * Watch: sass
 */
gulp.task('watch:sass',	function() {
		gulp.watch('./scss/**', ['sass']);
});

/*
 * Watch: Javascript
 */
gulp.task('watch:js',
	function() {
		gulp.watch('./js/src/**',	['js']);
});

/*
 * Default task
 */
gulp.task('default', ['sass', 'js', 'watch'], function() {
});

