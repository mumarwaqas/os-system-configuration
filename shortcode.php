<?php
add_filter( 'wp_nav_menu', 'do_shortcode' );
add_filter( 'nav_menu_link_attributes', 'sc_login', 10, 4 ); 
add_filter( 'nav_menu_link_attributes', 'sc_signup', 10, 4 ); 
// Add shortcode function on "init"
add_shortcode( 'LOGIN', 'sc_login' );
add_shortcode( 'SIGNUP', 'sc_signup' );

function sc_login($atts, $content = "") 
{
	if ( false !== strpos( $atts[ 'href' ], '[LOGIN]' ) ) 
	{
		// Simply overwrite the url with a set value
		$atts[ 'href' ] = get_option('login');
	}
	return $atts;
}
function sc_signup($atts, $content = "") 
{
	if ( false !== strpos( $atts[ 'href' ], '[SIGNUP]' ) ) 
	{
		// Simply overwrite the url with a set value
		$atts[ 'href' ] = get_option('signup');
	}
	return $atts;
}