import 'jquery';


class MyNotes{
	constructor(){
		this.events();
	}

	events(){
		$( '.delete-note' ).on( 'click', this.deleteNote );
		$( '.edit-note' ).on( 'click', this.editNote.bind(this) );
	}

	editNote(e){
		let edit = $(e.target).parents('li');
		if( edit.data('state')=='editable' ){
			this.makeNoteReadonly(edit);
		} else{
			this.makeNoteEditable(edit);
		}
	}

	makeNoteEditable(edit){
		edit.find('.note-title-field, .note-body-field').removeAttr('readonly').addClass('note-active-field');
		edit.find('.edit-note').html('<i class="fa fa-times"></i>cancel')
		edit.find( '.update-note' ).addClass('update-note--visible');
		edit.data('state', 'editable');
	}

	makeNoteReadonly(edit){
		edit.find('.note-title-field, .note-body-field').attr('readonly', 'readonly').removeClass('note-active-field');
		edit.find('.edit-note').html('<i class="fa fa-pencil"></i>edit')
		edit.find( '.update-note' ).removeClass('update-note--visible');
		edit.data('state', 'cancel');
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