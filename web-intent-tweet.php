<?php
/**
Plugin Name:	Web Intent Tweet Button
Plugin URI:		http://wordpress.org/extend/plugins/web-intent-tweet-button/
Description:	Adds "Web Intent Tweet Button" below every post of WordPress Powered site. 
Version:		0.1
Author:			Ashish Thakur
Author URI:		http://farandaway.in
Licenses:		GPLV2
*/



//Setting and Configuration
define('WEBINTENT','<a id="web-intent" href="http://twitter.com/intent/tweet?url=%s&hashtags=%s"><img src="https://si0.twimg.com/images/dev/cms/intents/bird/bird_blue/bird_16_blue.png" style=none/></a>');

//Tie into WordPress Hooks and any function that should run on load
add_filter('the_content','web_intent_tweet_button');
add_action('init','web_intent_tweet_get_js');
add_action('admin_menu','add_menu_item');
add_action('wp_head','web_intent_add_jQuery');
/*
 * 
 * Adds local js file to the <head> of the WordPres Pages
 * @return none
 * 
 */
function web_intent_tweet_get_js(){
	 $src = plugins_url('tweet.js',__FILE__);
	 wp_register_script('tweet',$src);
	 wp_enqueue_script('tweet');
}

/**
 * 
 * function to include the jQuery source file
 * 
 */
function web_intent_add_jQuery()
{
	include('includes/dynamic_js.php');
}

/*
* 
* Get the URL of the current post
* 
* @return string the URL of the post
*/
function web_intent_tweet_get_post_url(){
		global $post;
		return get_permalink($post->ID);
}
	
/**
* Function to retrive twitter username from the database
* 
* @return Twitter UserName
*  
*/
function get_twitter_username(){
		$twitter_username =get_option('twitter_username_block');
		
		if(empty($twitter_username))
		{
				return '';
		}
		else {
			return $twitter_username;
		}
}
	
/**
* Adds Web Intent Tweet This Button to the post link
* 
* 
*/
function web_intent_tweet_button($content){
		 $url = urlencode(web_intent_tweet_get_post_url());
		 $screen_name = get_twitter_username();   //Twitter UserName retrieved from the database
		 $hashtags = '';
		 return $content .sprintf(WEBINTENT,$url,$hashtags);
}
	 
/**
* Function to generate the admin page
* 
* 
*/
function generate_admin_page(){
		$msg ='';	//used to display the message on updates
		if(!empty($_POST) && 
			check_admin_referer('web_intent_tweet_admin_options','web_intent_tweet_admin_nonce'))
			{
				update_option('twitter_username_block',stripcslashes($_POST['twitter_username']));
				$msg = '<div class="updated"><p>Your settings have been <strong>updated</strong></p></div>';
			}
			include('includes/admin-page.php');
}
	 
/**
* Adds a menu item inside the WordPress admin
* 
* 
*/
function add_menu_item()
{
			add_submenu_page(
					'plugins.php',// Menu page to attach to
					'Web Intent Tweet Button Configuration',// page title
					'Web Intent Tweet',// menu title
					'manage_options',// permissions
					'web-intent-tweet',// page-name (used in the URL)
					'generate_admin_page' // clicking callback function
					);
}
	  	 
/*EOF*/	 
	 
