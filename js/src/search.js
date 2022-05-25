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
		// $(document).on('keydown', this.keyDispatcher.bind(this));
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
		$.getJSON( universityData.root_url+ '/wp-json/university/v1/search?term='+ this.searchField.val(), (results) =>{
			this.resultDiv.html(`
				<div class="row">
					<div class="one-third">
						<h2 class="search-overlay__section-title">General Information</h2>
						${ results.general_info.length ? '<ul class="link-list min-list">' : '<h3>No Content</h3>' }
		 				${ results.general_info.map( item => `<li><a href="${item.permalink}">${item.title}</a> ${ item.postType == 'post' ? `by ${ item.authorName }` : '' } </li>` ).join('') }
		 				${ results.general_info.length ? '</ul>' : '' }
					</div>
					<div class="one-third">
						<h2 class="search-overlay__section-title">Programs</h2>
						${ results.programs.length ? '<ul class="link-list min-list">' : `<h3>No programs match <a href="${universityData.root_url}/programs">view available programs</a></h3>` }
		 				${ results.programs.map( item => `<li><a href="${item.permalink}">${item.title}</a></li>` ).join('') }
		 				${ results.programs.length ? '</ul>' : '' }
						<h2 class="search-overlay__section-title">Professors</h2>
						${ results.professors.length ? '<ul class="link-list min-list">' : '<h3>No Content</h3>' }
		 				${ results.professors.map( item => `
		 					<li class="professor-card__list-item"><a class="professor-card" href="${ item.permalink }">
				              <img class="professor-card__image" src="${ item.image }" >
				              <span class="professor-card__name">${ item.title }</span>
				             </a></li>
		 				` ).join('') }
		 				${ results.professors.length ? '</ul>' : '' }
					</div>
					<div class="one-third">
						<h2 class="search-overlay__section-title">Events</h2>
						${ results.events.length ? '' : `<h3>No events match <a href="${universityData.root_url}/events">view all events</a></h3>` }
		 				${ results.events.map( item => `
		 					<div class="event-summary">
						      <a class="event-summary__date event-summary__date--beige t-center" href="${ item.permalink }">
						          <span class="event-summary__month">${ item.month }</span>
						          <span class="event-summary__day">${ item.day }</span>
						      </a>
						      <div class="event-summary__content">
						          <h5 class="event-summary__title headline headline--tiny"><a href="${ item.permalink }">${ item.title }</a></h5>
						          <p>${ item.description }<a href="${ item.permalink }" class="nu gray">Read more</a></p>
						      </div>
						  </div>
		 				` ).join('') }
		 				${ results.events.length ? '' : '' }
					</div>
				</div>
			`);
			this.isSpinnerRun = false;
		})
	}

	// keyDispatcher(e){
	// 	if (e.keyCode == 83 && !this.isOverlayOpen){
	// 		this.openOverlay();
	// 	}

	// 	if ( e.keyCode == 27 && this.isOverlayOpen ){
	// 		this.closeOverlay();
	// 	}
	// }

	openOverlay(){
		this.searchOverlay.addClass('search-overlay--active')
		$('body').addClass( 'body-no-scroll' );
		this.searchField.val('');
		setTimeout(()=>this.searchField.focus(), 301);
		this.isOverlayOpen = true;
		return false;
	}

	closeOverlay(){
		this.searchOverlay.removeClass('search-overlay--active');
		$( 'body' ).removeClass( 'body-no-scroll' );
		this.isOverlayOpen = false;
	}
}

export default Search;