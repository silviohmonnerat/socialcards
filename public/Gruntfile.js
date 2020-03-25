'use strict';
module.exports = function(grunt) {

	grunt.initConfig({

		dirs: {
			js: 'js',
			css: 'css',
		},

		watch: {
			options: {
				livereload: 12345,
			},
			js: {
				files: [
					'assets/js/source/*.js',
					'assets/js/source/**/*.js'
				],
				tasks: ['uglify' ]
			},
			css: {
				files: [ 'assets/sass/scss/**/*.{scss,sass}' ],
				tasks: [ 'sass', 'cssmin' ]
			}
		},

		// uglify to concat, minify, and make source maps
		uglify: {
			dist: {
				options: {
					sourceMap: true
				},
				files: {
					'assets/js/app.min.js': [
                        'assets/js/source/**/*.js'
                    ]
				}
			}
		},

		sass: {
			dist: {
				options: { 
                    style: "expanded", 
                    trace: true 
                },
				files: {
					'assets/sass/build.css': 'assets/sass/app.scss'
				}
			}
		},

		cssmin: {
			dist: {
				files: {
					'assets/css/app.min.css': [ 'assets/sass/build.css' ],
				}
			}
		},

		exec: {
			txpull: {
				cmd: 'tx pull -a --minimum-perc=75'
			},
			txpush_s: {
				cmd: 'tx push -s'
			},
		}

	});

	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-contrib-sass' );
	grunt.loadNpmTasks( 'grunt-exec' );

	// register task
	grunt.registerTask('default', ['watch']);

	grunt.registerTask( 'tx', ['exec:txpull']);
	grunt.registerTask( 'makeandpush', [ 'exec:txpush_s']);

	grunt.registerTask('build', ['uglify', 'sass', 'cssmin', 'tx', 'makeandpush' ]);
};

/*
https://foliotek.github.io/Croppie/
*/
