class Like{
	constructor(){
		this.events();
	}

	events(){
		$('.like-box').on('click', this.keyDispatcher.bind(this));
	}

	keyDispatcher(e){
		let currentCliked = $(e.target).closest('.like-box');
		alert(currentCliked.data('exists'));
		if(currentCliked.data('exists')=='yes'){
			this.delete();
		} else{
			this.createLike(currentCliked);
		}
	}

	delete(){
		$.ajax({
			url: universityData.root_url + '/wp-json/university/v1/managelikes',
			type: 'DELETE',
			success: (response)=>{
				alert(response);
			},
			error: (response)=>{
				alert(response);
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
				alert(response);
			},
			error: (response)=>{
				alert(response);
			}
		})
	}
}

export default Like;