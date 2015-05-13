module.exports = function(grunt) {

	// Set up the CSS files object
	// destination > source
	var sassFilesObject = {};
	sassFilesObject['dist/admin/css/pilau-dcf-admin.css'] = 'dist/admin/css/pilau-dcf-admin.scss';
	sassFilesObject['dist/public/css/pilau-dcf-registration.css'] = 'dist/public/css/pilau-dcf-registration.scss';

	// Load NPM tasks
	require( 'matchdep' ).filterDev( 'grunt-*' ).forEach( grunt.loadNpmTasks );

	// Default tasks
	grunt.registerTask( 'default', ['copy','sass','autoprefixer'] );

	// Config tasks
	grunt.initConfig({

		// Read in the grunt modules
		pkg: grunt.file.readJSON( 'package.json' ),

		// Process SASS
		sass: {
			options: {
				outputStyle: 'compressed',
				sourceMap: true
			},
			default: {
				files: sassFilesObject
			}
		},

		// Autoprefixer
		autoprefixer: {
			options: {
				browsers: ['last 2 versions', 'ie >= 8'],
				cascade: false,
				map: true
			},
			admin: {
				expand: true,
				flatten: true,
				src: 'dist/admin/css/*.css',
				dest: 'dist/admin/css/'
			},
			public: {
				expand: true,
				flatten: true,
				src: 'dist/public/css/*.css',
				dest: 'dist/public/css/'
			}
		},

		// Copy to dist
		copy: {
			default: {
				cwd: 'src/',
				src: '**/*',
				dest: 'dist/',
				expand: true
			}
		}

	});

};
