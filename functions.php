<?php 


	function page_banner( $arg = NULL ) {

		if ( ! $arg['title'] ) {
			$arg['title'] = get_the_title();
		}

		if ( ! $arg['subtitle'] ){
			$arg['subtitle'] = get_field( 'page_banner_subtitle' );
		}

		if ( ! $arg['photo'] ) {
			if ( get_field( 'page_banner_background_image' ) ) {
				$arg['photo'] = get_field( 'page_banner_background_image' )['sizes']['page_banner_image_size'];
			} else {
				$arg['photo'] = get_theme_file_uri( '/images/ocean.jpg' );
			}
		}
		?>
		<div class="page-banner">
	      <div class="page-banner__bg-image" style="background-image: url(<?php echo $arg['photo']; ?>)"></div>
	      <div class="page-banner__content container container--narrow">
	        <h1 class="page-banner__title"><?php echo $arg['title']; ?></h1>
	        <div class="page-banner__intro">
	          <p><?php echo $arg['subtitle']; ?></p>
	        </div>
	      </div>
	  </div>
		<?php
	}
	function university_files() {
		wp_enqueue_script( 'university_slide_scripts', get_theme_file_uri( '/build/index.js' ), array(), wp_get_theme()->get('Version'), true );

		wp_enqueue_style( 'university-google-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');

		wp_enqueue_style( 'university_fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', [], [] );

		wp_enqueue_style( 'university_index_style', get_template_directory_uri().'/build/index.css', [], '' );

		wp_enqueue_style( 'university_main_style', get_stylesheet_uri(), [], filemtime( get_template_directory().'/style.css' ) );
	}

	add_action( 'wp_enqueue_scripts', 'university_files' );


	function university_support() {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'professor_landscape', 400, 260, true );
		add_image_size( 'professor_portrait', 480, 650, true );
		add_image_size( 'page_banner_image_size', 1500, 350, true );
	}

	add_action( 'after_setup_theme', 'university_support' );


	function university_adjust_query( $query ) {
		if ( ! is_admin() && is_post_type_archive( 'event' ) ) {
			$today = date('Ymd');
			$query->set( 'meta_key', 'event_date' );
			$query->set( 'orderby', 'meta_value_num' );
			$query->set( 'order', 'ASC' );
			$query->set( 'meta_query', array(
				array(
					'key' => 'event_date',
					'compare' => '>=',
					'value' => $today,
					'type' => 'numeric',
				)
			) );
		}
	}

	add_action( 'pre_get_posts', 'university_adjust_query' )

?>