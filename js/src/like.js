class Like{
	constructor(){
		this.events();
	}

	events(){
		$('.like-box').on('click', this.keyDispatcher.bind(this));
	}

	keyDispatcher(e){
		let currentCliked = $(e.target).closest('.like-box');
		if(currentCliked.attr('data-exists')=='yes'){
			this.delete(currentCliked);
		} else{
			this.createLike(currentCliked);
		}
	}

	delete(currentCliked){
		let id = currentCliked.attr('data-liked');
		$.ajax({
			url: universityData.root_url + '/wp-json/university/v1/managelikes',
			type: 'DELETE',
			data:{'id_for_delete':id},
			success: (response)=>{
				currentCliked.attr('data-exists', 'no');
				let likeCount = parseInt(currentCliked.find('.like-count').html());
				likeCount--;
				currentCliked.find('.like-count').html(likeCount);
			},
			error: (response)=>{
				alert('ok');
			}
		})
	}

	createLike(currentCliked){
		$.ajax({
			beforeSend:function(xhr){
				xhr.setRequestHeader( 'X-WP-Nonce', universityData.nonce );
			},
			url: universityData.root_url + '/wp-json/university/v1/managelikes',
			type: 'POST',
			data: {'professorId': currentCliked.data('professor')},
			success: (response)=>{
				currentCliked.attr('data-exists', 'yes');
				let likeCount = parseInt(currentCliked.find('.like-count').html());
				likeCount++;
				currentCliked.find('.like-count').html(likeCount);
				currentCliked.attr('data-liked', response);
			},
			error: (response)=>{
				console.log(response);
			}
		})
	}
}

export default Like;