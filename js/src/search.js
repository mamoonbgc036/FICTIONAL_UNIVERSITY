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
			if(this.searchField.val()){
				if(!this.isSpinnerRun){
					this.resultDiv.html('<div class="spinner-loader"></div>');
					this.isSpinnerRun = true;
				}
				this.typingTimer = setTimeout( this.getResult.bind(this), 500 );
			} else{
				this.resultDiv.html('');
				this.isSpinnerRun = false;
			}
		}

		this.previousVal = this.searchField.val();
	}

	getResult(){
		$.when(
		$.getJSON('http://127.0.0.1/WordPress/wp-json/wp/v2/posts?search='+ this.searchField.val()),
		$.getJSON('http://127.0.0.1/WordPress/wp-json/wp/v2/pages?search='+ this.searchField.val())
		).then((posts, pages)=>{
			let combinedData = posts[0].concat(pages[0]);
			this.resultDiv.html(`
				<h2 class="search-overlay__section-title">General Information</h2>
				${ combinedData.length ? '<ul class="link-list min-list">' : '<h3>No Content</h3>' }
					${ combinedData.map( item => `<li><a href="${item.link}">${item.title.rendered}</a> ${ item.type == 'post' ? `by ${ item.authorName }` : '' } </li>` ).join('') }
				${ combinedData.length ? '</ul>' : '' }
			`);
			this.isSpinnerRun = false;
		}, ()=>{
			this.resultDiv.html('<h3>Unexpected Error...</h3>')
		})
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
		$('body').addClass( 'body-no-scroll' );
		this.searchField.val('');
		setTimeout(()=>this.searchField.focus(), 301);
		this.isOverlayOpen = true;
	}

	closeOverlay(){
		this.searchOverlay.removeClass('search-overlay--active');
		$( 'body' ).removeClass( 'body-no-scroll' );
		this.isOverlayOpen = false;
	}
}

export default Search;