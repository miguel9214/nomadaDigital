//Global Decalaration

var gulp         = require( 'gulp' ),
	concat       = require( 'gulp-concat' ),
	sass         = require( 'gulp-sass' )( require( 'sass' ) ),
	minifyCSS    = require( 'gulp-clean-css' ),
	minify       = require( 'gulp-minify' ),
	beautify     = require( 'gulp-beautify' ),
	postcss      = require( 'gulp-postcss' ),
	autoprefixer = require( 'autoprefixer' ),
	clean        = require( 'gulp-clean' ),
	browserSync  = require( 'browser-sync' ).create(),
	banner       = require( 'gulp-header-comment' ),
	sourcemaps   = require( 'gulp-sourcemaps' ),
	merge        = require( 'merge-stream' ),
	pkg          = require( './package.json' );

	// /*-- Minify and add Multi browser prefix in css --*/

	var comment = 'Theme Name: <%= pkg.title %>\n' +
	'Theme URI: <%= pkg.theme_uri %>\n' +
	'Author: <%= pkg.author %>\n' +
	'Author URI: <%= pkg.author_uri %>\n' +
	'Description: <%= pkg.description %>\n' +
	'Version: <%= pkg.version %>\n' +
	'Text Domain: <%= pkg.text_domain %>\n' +
	'Tested up to: <%= pkg.tested_up_to %>\n' +
	'Requires PHP: <%= pkg.requires_php %>\n' +
	'Tags: <%= pkg.tags %>\n' +
	'License: <%= pkg.license %>\n' +
	'License URI: <%= pkg.license_uri %>\n';

	// Compile css from scss
	gulp.task(
		'scss',
		function () {
			var style = gulp.src( 'assets/scss/style.scss' )
			.pipe( sass( {outputStyle: 'compressed'} ) )
			.pipe( postcss( [ autoprefixer() ] ) )
			// Beatify css
			.pipe( concat( 'style.css' ) )
			.pipe( banner( comment ) )
			.pipe( beautify.css( { indent_size: 4} ) )
			.pipe( sourcemaps.write() )
			.pipe( gulp.dest( '.' ) )
			.pipe( browserSync.reload( {stream: true} ) )
			// Minify css
			.pipe( minifyCSS() )
			// .pipe(sass({outputStyle: 'compressed'}))
			.pipe( banner( comment ) )
			.pipe( concat( 'style.min.css' ) )
			.pipe( sourcemaps.write() )
			.pipe( gulp.dest( '.' ) );
			// .pipe(browserSync.reload({stream: true}));

			var eddfes = gulp.src( 'assets/scss/compatibility/edd-fes.scss' )
			.pipe( sass().on( 'error', sass.logError ) )
			.pipe( postcss( [ autoprefixer() ] ) )
			// Beatify css
			.pipe( concat( 'assets/css/edd-fes.css' ) )
			// .pipe(banner(comment))
			.pipe( beautify.css( { indent_size: 4} ) )
			.pipe( sourcemaps.write() )
			.pipe( gulp.dest( '.' ) )
			.pipe( browserSync.reload( {stream: true} ) )
			// Minify css
			.pipe( minifyCSS() )
			.pipe( banner( comment ) )
			.pipe( concat( 'assets/css/edd-fes.min.css' ) )
			.pipe( sourcemaps.write() )
			.pipe( gulp.dest( '.' ) );

			var eddreviews = gulp.src( 'assets/scss/compatibility/edd-reviews.scss' )
			.pipe( sass().on( 'error', sass.logError ) )
			.pipe( postcss( [ autoprefixer() ] ) )
			// Beatify css
			.pipe( concat( 'assets/css/edd-reviews.css' ) )
			// .pipe(banner(comment))
			.pipe( beautify.css( { indent_size: 4} ) )
			.pipe( sourcemaps.write() )
			.pipe( gulp.dest( '.' ) )
			.pipe( browserSync.reload( {stream: true} ) )
			// Minify css
			.pipe( minifyCSS() )
			.pipe( banner( comment ) )
			.pipe( concat( 'assets/css/edd-reviews.min.css' ) )
			.pipe( sourcemaps.write() )
			.pipe( gulp.dest( '.' ) );

			var eddpointsrewards = gulp.src( 'assets/scss/compatibility/edd-points-and-rewards.scss' )
			.pipe( sass().on( 'error', sass.logError ) )
			.pipe( postcss( [ autoprefixer() ] ) )
			// Beatify css
			.pipe( concat( 'assets/css/edd-points-and-rewards.css' ) )
			// .pipe(banner(comment))
			.pipe( beautify.css( { indent_size: 4} ) )
			.pipe( sourcemaps.write() )
			.pipe( gulp.dest( '.' ) )
			.pipe( browserSync.reload( {stream: true} ) )
			// Minify css
			.pipe( minifyCSS() )
			.pipe( banner( comment ) )
			.pipe( concat( 'assets/css/edd-points-and-rewards.min.css' ) )
			.pipe( sourcemaps.write() )
			.pipe( gulp.dest( '.' ) );

			return merge( style, eddfes, eddreviews, eddpointsrewards );

		}
	);

	/*-- clean js file task --*/
	gulp.task(
		'clean',
		function() {
			return gulp.src( ['assets/js/digifly.js', 'assets/js/digifly.min.js'], { read: false } )
			.pipe( clean() );
		}
	);


	var jsFiles = [
		'assets/vendor/modernizr.js',
		'assets/js/src/navigation.js',
		'assets/vendor/svg4everybody.js',
		'assets/js/src/digifly.js'
	];

	gulp.task(
		'scripts',
		gulp.series(
			['clean'],
			function() {
				return gulp.src( jsFiles,{ allowEmpty: true } )
				.pipe( concat( 'digifly.js' ) )
				.pipe( gulp.dest( 'assets/js' ) );
			}
		)
	);

	var jsFilesmin = [
		'assets/vendor/modernizr.custom.min.js',
		'assets/js/src/navigation.js',
		'assets/vendor/svg4everybody.min.js',
		'assets/js/src/digifly.js'
	];

	gulp.task(
		'scriptsmin',
		gulp.series(
			['clean'],
			function() {
				return gulp.src( jsFilesmin,{ allowEmpty: true } )
				.pipe( minify( {noSource: true} ) )
				.pipe( concat( 'digifly.min.js' ) )
				.pipe( gulp.dest( 'assets/js' ) );
			}
		)
	);

	// Watch
	gulp.task(
		'watch',
		function () {
			gulp.watch( ['assets/scss/**/*.scss'], gulp.series( 'scss' ) );
			gulp.watch( jsFiles, gulp.series( 'scripts' ) );
			gulp.watch( jsFilesmin, gulp.series( 'scriptsmin' ) );
			// gulp.watch("assets/scss/*.scss", gulp.series('scss'));
		}
	);

	gulp.task( 'default', gulp.series( ['scss','watch','scripts','scriptsmin'] ) );
