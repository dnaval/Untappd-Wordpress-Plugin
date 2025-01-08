/**
 * Custom JavaScript for the theme.
 *
 * This file contains custom JavaScript code used in the theme, such as event listeners
 * and DOM manipulations.
 *
 * @package tbkinterview
 * @since 1.0.0
 */

(function () {
	'use strict';

	document.querySelectorAll( '.stars' ).forEach(
		function (starContainer) {
			var rating     = parseFloat( starContainer.getAttribute( 'data-rating' ) );
			var percentage = (rating / 5) * 100;

			starContainer.style.background = 'linear-gradient(to right, gold ' + percentage + '%, #ccc ' + percentage + '%)';
		}
	);
})();