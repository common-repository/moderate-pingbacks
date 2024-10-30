<?php
/*
Plugin Name: Moderate Pingbacks
Plugin URI: http://wordpress.org/extend/plugins/moderate-pingbacks/
Description: Puts pingbacks not marked as 'spam' into moderation.
Author: Nick Momrik
Version: 1.22
Author URI: http://nickmomrik.com/
*/ 

function mdv_check_is_pingback ($commentdata) {
	global $mdv_is_pingback;

	extract($commentdata);
	
	if ('pingback' == $comment_type)
		$mdv_is_pingback = true;
	else
		$mdv_is_pingback = false;
	
	compact('comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'user_ID');
	
	return $commentdata;
}

function mdv_moderate_pingback ($approved) {
	global $mdv_is_pingback;

	if (1 == $approved && $mdv_is_pingback)
		$approved = 0;

	return $approved;
}

add_filter('preprocess_comment', 'mdv_check_is_pingback');
add_filter('pre_comment_approved', 'mdv_moderate_pingback', 21);
?>
