<?php
/**
 * Main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package tbkinterview
 * @since 1.0.0
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php wp_title(); ?></title>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<header>
	<div class="centered-div"><h1><?php bloginfo( 'name' ); ?></h1></div>
		<p><?php bloginfo( 'description' ); ?></p>
		<nav>
			<?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
		</nav>
	</header>

	<main>
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				the_title( '<h2>', '</h2>' );
				the_content();
			endwhile;
		else :
			echo '<p>No content found</p>';
		endif;
		?>
	</main>

	<footer>
		<div class="centered-div"><p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php esc_html( bloginfo( 'name' ) ); ?></p></div>
	</footer>
	<?php wp_footer(); ?>
</body>
</html>
