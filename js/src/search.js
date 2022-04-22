import 'jquery';

class Search{
	constructor(){
		this.resultDiv = $('#search-overlay__results');
		this.openButton = $('.js-search-trigger');
		this.closeButton = $('.search-overlay__close');
		this.searchOverlay = $('.search-overlay');
		this.searchField = $( '#search-term' );
		this.isSpinnerRun = false;
		this.previousVal;
		this.events();
		this.isOverlayOpen = false;
		this.typingTimer;
	}

	events(){
		this.openButton.on('click', this.openOverlay.bind(this));
		this.closeButton.on('click', this.closeOverlay.bind(this));
		$(document).on('keydown', this.keyDispatcher.bind(this));
		this.searchField.on( 'keyup', this.inputFieldEvent.bind(this) );
	}

	inputFieldEvent(){

		if(this.previousVal!=this.searchField.val()){
			clearTimeout( this.typingTimer );
			if(!this.isSpinnerRun){
				this.resultDiv.html('<div class="spinner-loader"></div>');
				this.isSpinnerRun = true;
			}
			this.typingTimer = setTimeout( this.getResult.bind(this), 500 );
		}

		this.previousVal = this.searchField.val();
	}

	getResult(){
		$.getJSON('http://127.0.0.1/WordPress/index.php/wp-json/wp/v2/posts?search='+ this.searchField.val(), posts => {
			this.resultDiv.html(`
				<h2 class="search-overlay__section-title">General Information</h2>
				${ posts.length ? '<ul class="link-list min-list">' : '<h3>No Content</h3>' }
					${ posts.map( item => `<li><a href="${item.link}">${item.title.rendered}</a></li>` ).join('') }
				${ posts.length ? '</ul>' : '' }
			`);
			this.isSpinnerRun = false;
		});
	}

	keyDispatcher(e){
		if (e.keyCode == 83 && !this.isOverlayOpen){
			this.openOverlay();
		}

		if ( e.keyCode == 27 && this.isOverlayOpen ){
			this.closeOverlay();
		}
	}

	openOverlay(){
		this.searchOverlay.addClass('search-overlay--active')
		$('body').addClass( 'body-no-scroll' )
		this.isOverlayOpen = true;
	}

	closeOverlay(){
		this.searchOverlay.removeClass('search-overlay--active');
		$( 'body' ).removeClass( 'body-no-scroll' );
		this.isOverlayOpen = false;
	}
}

export default Search;