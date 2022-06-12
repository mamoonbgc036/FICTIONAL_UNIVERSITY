class Like{
	constructor(){
		this.events();
	}

	events(){
		$('.like-box').on('click', this.keyDispatcher.bind(this));
	}

	keyDispatcher(e){
		let currentCliked = $('.like-box').attr('data-exists');
		if(currentCliked=='yes'){
			this.delete();
		} else{
			this.createLike();
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

	createLike(){
		$.ajax({
			url: universityData.root_url + '/wp-json/university/v1/managelikes',
			type: 'POST',
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