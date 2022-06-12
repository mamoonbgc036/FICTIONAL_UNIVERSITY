<?php 

	add_action( 'rest_api_init', 'custom_likes_route' );

	function custom_likes_route(){
		register_rest_route( 'university/v1', 'managelikes', array(
			'methods'=>'POST',
			'callback'=>'createLikes',
		));
		register_rest_route( 'university/v1', 'managelikes', array(
			'methods'=>'DELETE',
			'callback'=>'deleteLikes',
		));
	}

	function createLikes(){
		return 'created';
	}

	function deleteLikes(){
		return 'deleted';
	}