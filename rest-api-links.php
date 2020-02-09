<?php
/*
Plugin Name: REST API Links
Plugin URI: https://github.com/dshanske/rest-api-links/
Description: Adds links to REST API resources
Version: 0.0.1
Author: David Shanske
Text Domain: extra-feeds
License: GPL2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/

defined( 'ABSPATH' ) || die( "WordPress plugin can't be loaded directly." );

function rest_add_link() {
	if ( is_home() ) {
		return;
	}
	if ( is_attachment() ) {
		rest_head_link( rest_url( 'wp/v2/media/' . get_the_ID() ) );
	} elseif ( is_singular() ) {
		rest_head_link( rest_url( 'wp/v2/posts/' . get_the_ID() ) );
	} elseif ( is_author() ) {
		rest_head_link( rest_url( 'wp/v2/users/' . get_the_author_meta( 'ID' ) ) );
	} elseif ( is_category() ) {
		$term = get_queried_object();
		rest_head_link( rest_url( 'wp/v2/categories/' . $term->term_id ) );
	} elseif ( is_tag() ) {
		$term = get_queried_object();
		rest_head_link( rest_url( 'wp/v2/tags/' . $term->term_id ) );
	}
}

function rest_head_link( $url ) {
	printf( '<link rel="alternate https:://api.w.org" type="%s" href="%s" />', esc_attr( 'application/json' ), esc_url( $url ) );
	echo PHP_EOL;
}

add_action( 'wp_head', 'rest_add_link' );

