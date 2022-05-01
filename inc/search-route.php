<?php 

	add_action('rest_api_init', 'university_search_route');

	function university_search_route(){
		register_rest_route('university/v1', 'search', array(
			'methods' => WP_REST_SERVER::READABLE,
			'callback' => 'university_search_result'
		));
	}

	function university_search_result($data){
		$main_query = new WP_Query(array(
			'post_type' => ['post', 'page', 'program', 'professor', 'event'],
			's' => sanitize_text_field($data['term']),
		));

		$results = [
			'general_info' => [],
			'programs' => [],
			'professors' => [],
			'events' => [],
		];

		while($main_query->have_posts()){
			$main_query->the_post();
			if(get_post_type() == 'post' or get_post_type() == 'page'){
				array_push($results['general_info'], array(
					'title' => get_the_title(),
					'permalink' => get_the_permalink(),
					'postType' => get_post_type(),
					'authorName'=> get_the_author(),
				));
			}

			if(get_post_type() == 'professor'){
				array_push($results['professors'], array(
					'title' => get_the_title(),
					'permalink' => get_the_permalink(),
					'image' => get_the_post_thumbnail_url( 0, 'professor_landscape' )
				));
			}

			if(get_post_type() == 'program'){
				array_push($results['programs'], array(
					'title' => get_the_title(),
					'permalink' => get_the_permalink(),
					'ID' => get_the_ID(),
				));
			}

			if(get_post_type() == 'event'){
				$the_date = new DateTime( get_field( 'event_date' ) );
				$description = null;

				if ( has_excerpt() ) {
						$description = get_the_excerpt();
						} else {
						    $description = wp_trim_words( get_the_content(), 18 );
				};
				array_push($results['events'], array(
					'title' => get_the_title(),
					'permalink' => get_the_permalink(),
					'month' => $the_date->format( 'M' ),
					'day' => $the_date->format( 'd' ),
					'description' => $description,
				));
			}
		}

		$metaQueryforProfessor = array('relation' => 'OR');


		if( $results['programs'] ){
			foreach( $results['programs'] as $item ){
				array_push( $metaQueryforProfessor, array(
					'key' => 'related_programs',
					'compare' => 'LIKE',
					'value' => '"'.$item['ID'].'"'
				) );
			}

			$programRelationshipQuery = new WP_Query(array(
				'post_type' => array('professor', 'event'),
				'meta_query' => $metaQueryforProfessor,
			));

			while( $programRelationshipQuery->have_posts() ){
				$programRelationshipQuery->the_post();

				if(get_post_type() == 'event'){
					$the_date = new DateTime( get_field( 'event_date' ) );
					$description = null;

					if ( has_excerpt() ) {
							$description = get_the_excerpt();
							} else {
							    $description = wp_trim_words( get_the_content(), 18 );
					};
					array_push($results['events'], array(
						'title' => get_the_title(),
						'permalink' => get_the_permalink(),
						'month' => $the_date->format( 'M' ),
						'day' => $the_date->format( 'd' ),
						'description' => $description,
					));
				}

				if(get_post_type() == 'professor'){
					array_push($results['professors'], array(
						'title' => get_the_title(),
						'permalink' => get_the_permalink(),
						'image' => get_the_post_thumbnail_url( 0, 'professor_landscape' )
					));
				}
			}

			$results['professors'] = array_unique($results['professors'], SORT_REGULAR);
			$results['events'] = array_unique($results['events'], SORT_REGULAR);

		}


		return $results;
	}