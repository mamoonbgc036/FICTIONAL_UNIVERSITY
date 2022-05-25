import 'jquery';


class MyNotes{
	constructor(){
		this.events();
	}

	events(){
		$( '#my-notes' ).on( 'click','.delete-note', this.deleteNote );
		$( '#my-notes' ).on( 'click','.edit-note', this.editNote.bind(this) );
		$( '#my-notes' ).on( 'click','.update-note', this.updateNote.bind(this) );
		$( '.submit-note' ).on( 'click', this.createNote );
	}

	createNote(){
		alert('ok');
		let createData = {
			'title': $('.new-note-title').val(),
			'content': $('.new-note-body').val(),
			'status' : 'publish'
		}
		$.ajax({
			beforeSend:function(xhr){
				xhr.setRequestHeader( 'X-WP-Nonce', universityData.nonce );
			},
			url : universityData.root_url+'/wp-json/wp/v2/note/',
			type : 'POST',
			data: createData,
			success: (response)=>{
				$(`
					<li data-id="${response.id}">
    					<input readonly class="note-title-field" type="" name="" value="${response.title.raw}">

    					<span class="edit-note"><i class="fa fa-pencil"></i>Edit</span>
    					<span class="delete-note"><i class="fa fa-trash-o"></i>delete</span>
    					<textarea readonly class="note-body-field">${response.content.raw}</textarea>
    					<span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right"></i>Save</span>
    				</li>
				`).prependTo('#my-notes').hide().slideDown();
			},
			error: (response)=>{
				console.log('sorry');
				console.log(response);
			}
		})
	}

	updateNote(e){
		let deleteNoteId = $(e.target).parents('li');

		let updateData = {
			'title': deleteNoteId.find('.note-title-field').val(),
			'content': deleteNoteId.find('.note-body-field').val(),
		}
		$.ajax({
			beforeSend:function(xhr){
				xhr.setRequestHeader( 'X-WP-Nonce', universityData.nonce );
			},
			url : universityData.root_url+'/wp-json/wp/v2/note/'+ deleteNoteId.data( 'id' ),
			type : 'POST',
			data: updateData,
			success: (response)=>{
				this.makeNoteReadonly(deleteNoteId);
				console.log('congrates');
				console.log(response);
			},
			error: (response)=>{
				console.log('sorry');
				console.log(response);
			}
		})
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