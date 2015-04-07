module.exports = function(grunt) {

	// Project configuration.
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		

		// watch for changes and trigger csslint, autoprefixer, cssmin, jshint, uglify and livereload
		watch: {
			options: {
				livereload: true,
			},
			css: {
				files: ['css/source/*.css'],
				tasks: ['cssmin']
			},
			js: {
				files: ['js/source/*.js'],
				tasks: ['uglify']
			},
			// https://github.com/gruntjs/grunt-contrib-watch#live-reloading
			livereload: {
				options: {
					livereload: true
				},
				// reload page when css, js, images or php files changed
				files: ['css/*.css', 'js/*.js', 'img/**/*.{png,jpg,jpeg,gif,webp,svg}', '**/*.php']
			},
		},



		uglify: {
			options: {
				banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
			},
			my_target: {
				files: {
					'js/premise.min.js': ['js/source/*.js']
				}
			}
		},
		

		cssmin: {
			options: {
				shorthandCompacting: false,
				roundingPrecision: -1
			},
			target: {
				files: {
					'css/premise.min.css': ['css/source/*.css']
				}
			}
		}


	});

	// Load Tasks
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-cssmin');

	// Default task(s).
	grunt.registerTask('default', ['watch']);

};