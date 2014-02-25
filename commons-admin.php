<?php
/**
* Plugin Name: Commons Admin Bar
* Plugin URI: http://commons.hwdsb.on.ca
* Description: A customized version of the WP Admin bar
* Author: mrjarbenne
* Version: 1.0
* Author URI: https://mrjarbenne.ca
* License:
*/

 
add_action('admin_bar_menu', 'customize_admin_bar', 11 );
function customize_admin_bar( $wp_admin_bar ) {
 
/*
Removing the "W" menu
*/
$wp_admin_bar->remove_menu( 'wp-logo' );
 
/*
Create a "Home" menu
First, just create the parent menu item
*/

if ( current_user_can( 'read' ) )
$wp_admin_bar->add_menu( array(
'id' => 'commonlinks',
'parent' => '0', //puts it on the left-hand side
'title' => 'Home',
'href' => ('http://commons.hwdsb.on.ca/')
) );

/*
Then add links to it
This link goes to the support page,
so only show it to users who are logged in
*/
if ( current_user_can( 'read' ) )
$wp_admin_bar->add_menu( array(
'id' => 'support',
'parent' => 'commonlinks',
'title' => 'Support',
'href' => ('http://support.commons.hwdsb.on.ca/')
) );
 
/*
This one goes to the Blog Request Form
*/
if ( current_user_can( 'read' ) )
$wp_admin_bar->add_menu( array(
'id' => 'blogrequest',
'parent' => 'commonlinks',
'title' => 'Blog Request Form',
'href' => ('http://support.commons.hwdsb.on.ca/blog-request-form/' )
) );

/*
This one goes to the Developers Blog
*/
if ( current_user_can( 'read' ) )
$wp_admin_bar->add_menu( array(
'id' => 'developments',
'parent' => 'commonlinks',
'title' => 'Developments',
'href' => ('http://dev.commons.hwdsb.on.ca/' )
) );
}