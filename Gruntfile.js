/* globals module */
module.exports = function(grunt) {
	'use strict';

	grunt.initConfig( {
		wp_deploy: {
			deploy: {
				options: {
					plugin_slug: 'wp-noteup',
					svn_user:    'aubreypwd',
					assets_dir:  'wp-org-assets'
				}
			}
		}
	} );

	// Load tasks
	grunt.loadNpmTasks( 'grunt-wp-deploy' );

	// Register tasks
	grunt.registerTask( 'default', [ 'wordpressdeploy' ] );
};
