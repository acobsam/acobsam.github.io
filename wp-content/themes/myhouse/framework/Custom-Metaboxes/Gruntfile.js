module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		phpunit: {
			classes: {}
		},
		githooks: {
			all: {
				'pre-commit': 'default'
			}
		},
 
		cssmin: {
			options: {
				 
			},
			minify: {
				expand: true,
				src: ['style.css'],
				// dest: '',
				ext: '.min.css'
			}
		},
		jshint: {
			all: [
				'Gruntfile.js',
				'js/cmb.js'
			],
			options: {
				curly   : true,
				eqeqeq  : true,
				immed   : true,
				latedef : true,
				newcap  : true,
				noarg   : true,
				sub     : true,
				unused  : true,
				undef   : true,
				boss    : true,
				eqnull  : true,
				globals : {
					exports : true,
					module  : false
				},
				predef  :['document','window','jQuery','cmb_l10','wp','tinyMCEPreInit','tinyMCE','console']
			}
		},
		uglify: {
			all: {
				files: {
					'js/cmb.min.js': ['js/cmb.js']
				},
				options: {
	 
					mangle: false
				}
			}
		},
		watch:  {

			css: {
				files: ['style.css'],
				tasks: ['cssmin']
			},

			scripts: {
				files: ['js/cmb.js'],
				tasks: ['jshint', 'uglify'],
				options: {
					debounceDelay: 500
				}
			}
		}


	});

	grunt.loadNpmTasks('grunt-phpunit');
	grunt.loadNpmTasks('grunt-githooks');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-watch');
	// grunt.loadNpmTasks('grunt-contrib-concat');

	grunt.registerTask('default', ['jshint', 'cssmin', 'uglify', 'phpunit']);
	grunt.registerTask('tests', ['jshint', 'phpunit']);
};
