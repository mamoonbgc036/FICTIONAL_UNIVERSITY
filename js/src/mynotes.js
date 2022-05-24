import 'jquery';


class MyNotes{
	constructor(){
		this.events();
	}

	events(){
		$( '.delete-note' ).on( 'click', this.deleteNote );
		$( '.edit-note' ).on( 'click', this.editNote );
	}

	editNote(e){
		let edit = $(e.target).parents('li');
		edit.find('.note-title-field, .note-body-field').removeAttr('readonly').addClass('note-active-field');
		edit.find( '.update-note' ).addClass('update-note--visible');
	}

	deleteNote(e){
		let deleteNoteId = $(e.target).parents('li');
		$.ajax({
			beforeSend:function(xhr){
				xhr.setRequestHeader( 'X-WP-Nonce', universityData.nonce );
			},
			url : universityData.root_url+'/wp-json/wp/v2/note/'+ deleteNoteId.data( 'id' ),
			type : 'DELETE',
			success: function(response){
				deleteNoteId.slideUp();
				console.log('congrates');
				console.log(response);
			},
			error: function(response){
				console.log('sorry');
				console.log(response);
			}
		})
	}
}

export default MyNotes; 