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

	function createLikes($data){
		$professor = sanitize_text_field($data['professorId']);
		wp_insert_post(array(
			'post_type'=>'like',
			'post_status'=>'publish',
			'post_title'=>'this is title',
			'meta_input'=>array(
				'liked_professor_id'=>$professor,
			),
		));
	}

	function deleteLikes(){
		return 'deleted';
	}