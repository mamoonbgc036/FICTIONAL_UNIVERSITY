<?php 

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
	}

	add_action( 'after_setup_theme', 'university_support' );

?>