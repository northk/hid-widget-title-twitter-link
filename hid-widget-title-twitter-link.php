<?php
/*
Plugin Name: hid-widget-title-twitter-link
Plugin URI: http://highintegritydesign.com
Description: Provide a link to a Twitter public timeline from inside a widget title, using a shortcode.
Version: 1.0
Author: North Krimsly
Author URI: http://highintegritydesign.com
License: GPL2

hid-widget-title-twitter-link is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

hid-widget-title-twitter-link is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with hid-widget-title-twitter-link. If not, see http://www.gnu.org/licenses/gpl-2.0.html

*/

class HID_widget_title_twitter_link {  

    public function __construct()  
    {  
		// Add a new 'hid-widget-title-twitter-link' shortcode and attach it to our class method
        add_shortcode('hid-widget-title-twitter-link', array(
            $this, 
            'do_widget_title_twitter_link_shortcode')
        );  

		// Add support for evaluating shortcodes, to all widget titles
		add_filter('widget_title', 'do_shortcode');
	}  

    public function do_widget_title_twitter_link_shortcode($atts = array())  
    {  
        // first parse the username shortcode attribute and value
        $args = shortcode_atts( array(
            'username' => ''
        ), $atts);

        // for some reason the 'username' attribute comes through with quotes included 
        // which are html encoded, so we have to un-encode those quotes first. 
        // Then we can strip out the quotes.
        $args['username'] = html_entity_decode($args['username'], ENT_QUOTES);
        $args['username'] = str_replace(array("\"", "'"), '', $args['username']);

        // finally check if it's a valid Twitter user name. If so return a link to the
        // Twitter profile.
        if ((preg_match('/^[A-Za-z0-9_]{1,15}$/', $args["username"]))) {        
            return "<a href='http://twitter.com/{$args["username"]}'>@{$args["username"]}</a>";
        }

        // if the username is invalid, log a debug error and don't return anything
        else {
            if ( true === WP_DEBUG ) {
                error_log('hid-widget-title-twitter-link plugin: missing or invalid user name.');
            }
        }
    }
}

// construct a new instance of the cta button
$hid_widget_title_twitter_link_instance = new HID_widget_title_twitter_link();  

?>