/* globals module */

module.exports = function(grunt) {
	'use strict';

	grunt.initConfig( {

		/**
		 * Deploy to WordPress.org
		 *
		 *     grunt wp_deploy
		 *
		 * @type {Object} Settings for deploy npm module.
		 */
		wp_deploy: {
			deploy: {
				options: {

					// https://wordpress.org/plugins/wp-noteup/
					plugin_slug: 'wp-noteup',
					svn_user:    'aubreypwd',

					// Files with banners, icons, etc.
					assets_dir:  'wp-org-assets'
				}
			}
		}
	} );

	// Load tasks.
	grunt.loadNpmTasks( 'grunt-wp-deploy' );

	// Register tasks.
	grunt.registerTask( 'default', [] );
};
