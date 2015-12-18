/*jshint node:true */
module.exports = function ( grunt ) {
	grunt.loadNpmTasks( 'grunt-contrib-less' );
	grunt.loadNpmTasks( 'grunt-contrib-csslint' );
	grunt.loadNpmTasks( 'grunt-cssjanus' );

	grunt.initConfig( {
		pkg: grunt.file.readJSON( 'package.json' ),
		less: {
			site: {
				files: {
					'css/rtl.wtf.style.css': 'less/rtl.wtf.style.less'
				}
			}
		},
		csslint: {
			options: {
				csslintrc: '.csslintrc'
			},
			site: [
				'css/rtl.wtf.style.css'
			],
		},
		cssjanus: {
			options: {
				generateExactDuplicates: true
			},
			site: {
				files: {
					'css/ltr.wtf.style.css': 'css/rtl.wtf.style.css'
				}
			}
		}
	} );

	grunt.registerTask( 'default', [ 'less', 'csslint', 'cssjanus' ] );
};
