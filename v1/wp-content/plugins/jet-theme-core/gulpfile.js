'use strict';

let gulp            = require( 'gulp' ),
	rename          = require( 'gulp-rename' ),
	notify          = require( 'gulp-notify' ),
	uglify          = require( 'gulp-uglify-es' ).default,
	checktextdomain = require( 'gulp-checktextdomain' );

gulp.task( 'js-editor-minify', function() {
	return gulp.src( './assets/js/editor.js' )
		.pipe( uglify() )
		.pipe( rename( { extname: '.min.js' } ) )
		.pipe( gulp.dest( './assets/js/' ) )
		.pipe( notify( 'Editor.js Minify Done!' ) );
} );

//watch
gulp.task( 'watch', function() {
	gulp.watch( './assets/js/editor.js', gulp.series( 'js-editor-minify' ) );
} );

gulp.task( 'checktextdomain', function() {
	return gulp.src( ['**/*.php', '!framework/**/*.php'] )
		.pipe( checktextdomain( {
			text_domain: 'jet-theme-core',
			keywords:    [
				'__:1,2d',
				'_e:1,2d',
				'_x:1,2c,3d',
				'esc_html__:1,2d',
				'esc_html_e:1,2d',
				'esc_html_x:1,2c,3d',
				'esc_attr__:1,2d',
				'esc_attr_e:1,2d',
				'esc_attr_x:1,2c,3d',
				'_ex:1,2c,3d',
				'_n:1,2,4d',
				'_nx:1,2,4c,5d',
				'_n_noop:1,2,3d',
				'_nx_noop:1,2,3c,4d',
				'translate_nooped_plural:1,2c,3d'
			]
		} ) );
} );

