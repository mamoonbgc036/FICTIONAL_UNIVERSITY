<?php 

	add_action('rest_api_init', 'university_search_route');

	function university_search_route(){
		register_rest_route('university/v1', 'search', array(
			'methods' => WP_REST_SERVER::READABLE,
			'callback' => 'university_search_result'
		));
	}

	function university_search_result(){
		$professors = new WP_Query(array(
			'post_type' => 'professor',
		));

		$professorsResults = [];

		while($professors->have_posts()){
			$professors->the_post();
			array_push($professorsResults, array(
				'title' => get_the_title(),
				'permalink' => get_the_permalink(),
			));
		}

		return $professorsResults;
	}