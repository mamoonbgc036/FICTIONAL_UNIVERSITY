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
		if(is_user_logged_in()){
			$professor = sanitize_text_field($data['professorId']);
			$is_liked = new WP_Query(array(
         					'author'=>get_current_user_id(),
         					'post_type'=>'like',
         					'meta_query'=>array(array(
         						'key'=>'liked_professor_id',
         						'compare'=>'=',
         						'value'=>$professor,
		         			))
         				));

			if($is_liked->found_posts==0){
				return wp_insert_post(array(
					'post_type'=>'like',
					'post_status'=>'publish',
					'meta_input'=>array(
						'liked_professor_id'=>$professor,
					),
				));
			} else{
				return 'You liked the professor';
			}
			
		} else{
			die('Loggedin to create a like');
		}
	}

	function deleteLikes($data){
		$id = sanitize_text_field($data['id_for_delete']);
		if( get_current_user_id() == get_post_field( $id ) AND get_post_type( $id ) == 'like' ){
			wp_delete_post($id, true);
			return 'deleted';
		}
	}