<?php
/**
 * Plugin Name: tbk interview test
 * Plugin URI:  https://dnavaldev.com/tbk-interview-test
 * Description: A brief description of what the plugin does.
 * Version:     1.0.0
 * Author:      Daniel Naval
 * Author URI:  https://dnavaldev.com
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: tbk_interview_test
 * Domain Path: /languages
 *
 * @package tbk interview test
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue scripts and styles for the theme.
 *
 * This function adds custom scripts and stylesheets to the theme.
 *
 * @return void
 */
function my_plugin_enqueue_assets() {
	if ( is_page_template( 'page-api-data.php' ) ) {
		wp_enqueue_style( 'my-plugin-styles', plugin_dir_url( __FILE__ ) . 'assets/style.css' );
		wp_enqueue_script( 'my-plugin-scripts', plugin_dir_url( __FILE__ ) . 'assets/script.js', array( 'jquery' ), '1.0', true );
	}
}
add_action( 'wp_enqueue_scripts', 'my_plugin_enqueue_assets' );

/**
 * Fetch data from the given API URL.
 *
 * This function sends a request to the provided API URL and returns the response.
 *
 * @param string $api_url The URL of the API to fetch data from.
 * @return mixed The response from the API, usually a JSON object or array.
 */
function fetch_data_from_api( $api_url ) {
	$response = wp_remote_get( $api_url );

	if ( is_wp_error( $response ) ) {
		return '<p>Error fetching data from Untappd API.</p>';
	}

	return json_decode( wp_remote_retrieve_body( $response ), true );
}

/**
 * Display data in HTML format
 *
 * This function get data related to Spruce Beer and return HTML output.
 *
 * @return json_data
 */
function display_api_data_html() {

	// Your Untappd Client ID and Client Secret!
	$api__base_url = 'https://api.untappd.com/v4';
	$client_id     = API_CLIENT_ID;
	$client_secret = API_CLIENT_SECRET;

	// Hardcoded search term for "Spruce Beer"!
	$query = 'Garrison Brewing Company + Spruce Beer';

	// API URL to search for "Spruce Beer"!
	$search_url = $api__base_url . '/search/beer?client_id=' . $client_id . '&client_secret=' . $client_secret . '&q=' . urlencode( $query );

	// Fetch the beer data!
	$data = fetch_data_from_api( $search_url );

	// Check if beers were found!
	if ( ! isset( $data['response']['beers']['items'][0] ) ) {
		return '<p>No Spruce Beer found.</p>';
	}

	// Get the first matching beer's ID and other details!
	$beer_id = $data['response']['beers']['items'][0]['beer']['bid'];

	// API URL to get "Spruce Beer" Info!
	$info_url = $api__base_url . '/beer/info/' . $beer_id . '?client_id=' . $client_id . '&client_secret=' . $client_secret;

	// Fetch the beer data!
	$data = fetch_data_from_api( $info_url );

	// Check if beers were found!
	if ( ! isset( $data['response']['beer'] ) ) {
		return '<p>No Spruce Beer Info found.</p>';
	}

	// Beer and Brewery info!
	$brewery_name    = $data['response']['beer']['brewery']['brewery_name'];
	$beer_name       = $data['response']['beer']['beer_name'];
	$beer_style      = $data['response']['beer']['beer_style'];
	$alcohol_content = $data['response']['beer']['beer_abv'];
	$ibu             = $data['response']['beer']['beer_ibu'];
	$avg_rating      = round( $data['response']['beer']['rating_score'], 2 );
	$beer_label      = $data['response']['beer']['beer_label'];
	$brewery_label   = $data['response']['beer']['brewery']['brewery_label'];

	// Generate the brewery and beer output!
	$output  = '<header>';
	$output .= '<img src="' . esc_html( $brewery_label ) . '" alt="Brewery Logo" class="logo" />';
	$output .= '<div class="title">' . esc_html( $brewery_name ) . '</div>';
	$output .= '</header>';
	$output .= '<div class="subheader">';
	$output .= '<img src="' . esc_html( $beer_label ) . '" alt="Beer Logo" />';
	$output .= '<ul class="subheader-list">';
	$output .= '<li><h2>' . esc_html( $beer_name ) . '</h2></li>';
	$output .= '<li><strong>Beer Style: </strong>' . esc_html( $beer_style ) . '</li>';
	$output .= '<li><strong>Alcohol Content: </strong>' . esc_html( $alcohol_content ) . '</li>';
	$output .= '<li><strong>IBU: </strong>' . esc_html( $ibu ) . '</li>';
	$output .= '<li><strong>Average Rating: </strong>' . esc_html( $avg_rating ) . '<br/><div class="stars" data-rating="' . esc_html( $avg_rating ) . '"></div></li>';
	$output .= '</ul>';
	$output .= '</div>';

	// API URL to fetch beer reviews!
	$reviews_url = $api__base_url . '/beer/checkins/' . $beer_id . '?client_id=' . $client_id . '&client_secret=' . $client_secret . '&limit=10';

	// Fetch the reviews data!
	$reviews_data = fetch_data_from_api( $reviews_url );

	// Check if reviews exist!
	if ( ! isset( $reviews_data['response']['checkins']['items'] ) ) {
		return '<p>No reviews found for Spruce Beer.</p>';
	}

	// Generate the review output!
	$output .= '<div class="centered-div"><h4>Recent Reviews for Spruce Beer</h4></div>';
	$output .= '<div class="content-grid">';

	foreach ( $reviews_data['response']['checkins']['items'] as $checkin ) {
		$user        = $checkin['user']['first_name'] . ' ' . $checkin['user']['last_name'];
		$user_avatar = $checkin['user']['user_avatar'];
		if ( $checkin['rating_score'] ) {
			$rating = $checkin['rating_score'];
		} else {
			$rating = 'No rating';
		}
		if ( $checkin['checkin_comment'] ) {
			$comment = $checkin['checkin_comment'];
		} else {
			$comment = 'No comment';
		}
		$time = gmdate( 'F j, Y', strtotime( $checkin['created_at'] ) );

		$output .= '<div><ul><li>';
		$output .= '<img src="' . esc_html( $user_avatar ) . '" alt="User Avatar" class="avatar"><br/>';
		$output .= '<strong>User:</strong> ' . esc_html( $user ) . '<br/>';
		$output .= '<strong>Comment:</strong> ' . esc_html( $comment ) . '<br/>';
		$output .= '<strong>Rating:</strong> ' . esc_html( $rating ) . '/5 <br/><div class="stars" data-rating="' . esc_html( $rating ) . '"></div><br/>';
		$output .= '<small><em>Reviewed on ' . esc_html( $time ) . '</em></small>';
		$output .= '</li></ul></div>';
	}
	$output .= '</div>';

	return $output;
}
add_shortcode( 'api_data', 'display_api_data_html' );
