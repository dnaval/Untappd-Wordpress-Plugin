<?php
/**
 * Template Name: API Data Page
 * Description: A custom template to display API data.
 *
 * @package tbkinterview
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main-content" class="site-main">
	<div class="container">
		<?php
		if ( function_exists( 'display_api_data_html' ) ) {
			echo display_api_data_html();
		} else {
			echo '<p>API data is not available at the moment.</p>';
		}
		?>
	</div>
</main>

<?php
get_footer();
?>
