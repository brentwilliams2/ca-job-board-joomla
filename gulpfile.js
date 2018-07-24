var gulp = require('gulp');

var config = require('./gulp-config.json');

// Dependencies
var beep        = require('beepbeep');
var browserSync = require('browser-sync');
var cleanCSS    = require('gulp-clean-css');
var concat      = require('gulp-concat');
var del         = require('del');
var gutil       = require('gulp-util');
var plumber     = require('gulp-plumber');
var rename      = require('gulp-rename');
var sass        = require('gulp-sass');
var uglify      = require('gulp-uglify');
var zip         = require('gulp-zip');
var xml2js      = require('xml2js');
var parser      = new xml2js.Parser();

var extPath      = '.';
var assetsPath = '.';
var templateName = 'tpl_mfi';

var joomlaTemplatePath = config.joomlaDir + '/templates/' + templateName;

var templateFiles = [
	extPath + '/css/**',
	extPath + '/fonts/**',
	extPath + '/html/**',
	extPath + '/images/**',
	extPath + '/includes/**',
	extPath + '/js/**',
	extPath + '/scss/**',
	extPath + '/vendor/**',
	extPath + '/*.md',
	extPath + '/*.png',
	extPath + '/*.php',
	extPath + '/*.ico',
	extPath + '/*.xml'
];

var onError = function (err) {
    beep([0, 0, 0]);
    gutil.log(gutil.colors.green(err));
};

/*
 * Browsersync task
 */
gulp.task('browser-sync', function() {
  return browserSync({ proxy : "localhost" });
});

/*
 * Clean template directory in working Joomla installation
 */
gulp.task('clean', function() {
	return del(joomlaTemplatePath, {force : true});
});

/*
 * Copy repository template files to working Joomla installation template directory
 */
gulp.task('copy', ['clean'], function() {
	return gulp.src( templateFiles, { base: extPath } )
		.pipe(gulp.dest(joomlaTemplatePath));
});

// Sass
function compileSassFile(src, destinationFolder, options)
{
	return gulp.src(src)
		.pipe(plumber({ errorHandler: onError }))
		.pipe(sass())
		.pipe(gulp.dest(assetsPath + '/' + destinationFolder))
		.pipe(gulp.dest(joomlaTemplatePath + '/' + destinationFolder))
		.pipe(browserSync.reload({ stream:true }))
		.pipe(cleanCSS({ compatibility: 'ie8' }))
		.pipe(rename(function (path) {
			path.basename += '.min';
		}))
		.pipe(gulp.dest(assetsPath + '/' + destinationFolder))
		.pipe(gulp.dest(joomlaTemplatePath + '/' + destinationFolder))
		.pipe(browserSync.reload({ stream:true }));
}

gulp.task('sass', function () {
	return compileSassFile(
		assetsPath + '/scss/template.scss',
		'css'
	);
});

/*
 * Minify scripts
 */
function compileScripts(src, ouputFileName, destinationFolder) {
	return gulp.src(src)
		.pipe(plumber({ errorHandler: onError }))
		.pipe(concat(ouputFileName))
		.pipe(gulp.dest(extPath + '/' + destinationFolder))
		.pipe(gulp.dest(joomlaTemplatePath + '/' + destinationFolder))
		.pipe(browserSync.reload({ stream:true }))
		.pipe(uglify())
		.pipe(rename(function (path) {
			path.basename += '.min';
		}))
		.pipe(gulp.dest(extPath + '/' + destinationFolder))
		.pipe(gulp.dest(joomlaTemplatePath + '/' + destinationFolder))
		.pipe(browserSync.reload({ stream:true }));
}

gulp.task('scripts', function () {
	return compileScripts(
		[
			assetsPath + '/js/template.js'
		],
		'template.js',
		'js'
	);
});

/*
 * Watch
 */
gulp.task('watch',
	[
		'watch:sass',
		'watch:scripts',
		'watch:template'
	],
	function() {
});

/*
 * Watch: template
 */
gulp.task('watch:template',
	function() {
		var exclude = [
			'!' + extPath + '/css/**',
			'!' + extPath + '/scss/**',
			'!' + extPath + '/js/**',
		];

		gulp.watch(templateFiles.concat(exclude),['copy']);
});

/*
 * Watch: sass
 */
gulp.task('watch:sass',
	function() {
		gulp.watch(
			extPath + '/scss/**',
			['sass']
		);
});

/*
 * Watch: scripts
 */
gulp.task('watch:scripts',
	function() {
		gulp.watch([
			extPath + '/js/template.js'
			],
			['scripts']
		);
});

/*
 * Default task
 */
gulp.task('default', ['copy', 'watch', 'browser-sync'], function() {
});

