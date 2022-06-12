<?php 
	
	require get_theme_file_path('/inc/likes-route.php');

	require get_theme_file_path('/inc/search-route.php');

	function university_rest_api(){
		register_rest_field('post', 'authorName', array(
			'get_callback' => function(){ return get_the_author(); }
		));
	}
	add_action('rest_api_init', 'university_rest_api');

	function page_banner( $arg = NULL ) {

		if(! isset($arg['title']) ){
			$arg['title'] = get_the_title();
		}

		if ( ! isset( $arg['subtitle'] ) ){
			$arg['subtitle'] = get_field( 'page_banner_subtitle' );
		}

		if ( ! isset( $arg['photo'] ) ) {
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
		wp_enqueue_script( 'university_live_search', get_theme_file_uri( '/js/dist/bundle.js' ), array(), wp_get_theme()->get('Version'), true );


		wp_enqueue_style( 'university-google-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');

		wp_enqueue_style( 'university_fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', [], [] );

		wp_enqueue_style( 'university_index_style', get_template_directory_uri().'/build/index.css', [], '' );

		wp_enqueue_style( 'university_main_style', get_stylesheet_uri(), [], filemtime( get_template_directory().'/style.css' ) );
		wp_localize_script( 'university_live_search', 'universityData', [
			'root_url' => get_site_url(),
			'nonce' => wp_create_nonce( 'wp_rest' ),
		] );
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

	add_action( 'pre_get_posts', 'university_adjust_query' );

	function university_map_api($api){
		// $api['key'] = 'AIzaSyAE2zrvgue9j-Zsk7e0zIACgeaLmIbuzhU';
		$api['key'] = 'AIzaSyBh9b1rNCp6k0i5JeMHiRP4klDymBeoEWk';
		return $api;
	}

	add_filter( 'acf/fields/google_map/api', 'university_map_api' );

	//REDIRECT SUBSCRIBER TO FRONTEND
	add_action( 'admin_init', 'redirectSubscriber' );

	function redirectSubscriber(){
		$ourSubscriber = wp_get_current_user();

		if( count($ourSubscriber->roles)==1 AND $ourSubscriber->roles[0] == 'subscriber' ){
			wp_redirect( site_url('/') );
			exit;
		}
	}

	//REMOVE ADMIN BAR FOR SUBSCRIBER TO FRONTEND
	add_action( 'wp_loaded', 'noAdminBarForSubscriber' );

	function noAdminBarForSubscriber(){
		$ourSubscriber = wp_get_current_user();

		if( count($ourSubscriber->roles)==1 AND $ourSubscriber->roles[0] == 'subscriber' ){
			show_admin_bar( false );
		}
	}

	//WORDPRESS LOGIN LOGO URL CHANGE TO OUR HOMEPAGE FROM WORDPRESS.ORG

	add_filter( 'login_headerurl', 'ourHeaderUrl' );

	function ourHeaderUrl(){
		return esc_url( site_url( '/' ) );
	}

	//ADD MY OWN CSS TO MODIFY LOGIN SCREEN

	add_action( 'login_enqueue_scripts', 'changeLoginStyle' );

	function changeLoginStyle(){
		wp_enqueue_style( 'university_main_style', get_stylesheet_uri(), [], filemtime( get_template_directory().'/style.css' ) );
	}

	//CHANGE HOVER NAME OF LOGIN LOGO

	add_filter( 'login_headertitle', 'ourOwnHoverName' );

	function ourOwnHoverName(){
		return get_bloginfo( 'name' );
	}

?>