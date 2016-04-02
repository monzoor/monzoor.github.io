( function($){
	var document = window.document;
	function _setting_upload() {
		var upload_wrap = $('.wip-upload-form');

		if( upload_wrap.length ) {

			upload_wrap.each( function() {
				var _t = $(this),
					_p = _t.parent(),
					inp = _t.data('input'),
					upload_handler = _t.find('.wip-upload-handle'),
					uploadFrame;

					upload_handler.on('click', function(e) {
						e.preventDefault();

						if ( typeof uploadFrame !== 'undefined' ) {
							uploadFrame.open();
							return;
						}

						uploadFrame = wp.media.frames.file_frame = wp.media({
							title: 'Select Image',
							multiple: false
						});

					    uploadFrame.on( 'select', function() {
							var selection = uploadFrame.state().get('selection'),
								attachment, pr;

							attachment = selection.toJSON();
							pr = typeof attachment[0].sizes.thumbnail === "undefined" ? attachment[0].sizes.full.url : attachment[0].sizes.thumbnail.url;
							//console.log( attachment );
							_t.find( '#'+inp ).val( attachment[0].id );

							var viewer = _t.find('.wip_form_preview');
							viewer.html('<img src="'+pr+'" alt="" /><a class="file-remove" href="#" title="Remove">&times;</a>');
						});

						uploadFrame.open();

					});

					_t.delegate('.file-remove', 'click', function(){
						_t.find('.wip_form_preview').html('');
						_t.find( '#'+inp ).val('');
						return false;
					});
			});
		}
	};


	function beforeFormSubmit() {
		var f=$('form#addtag');

		if( f.length ) {
			//f.attr('id', 'addtagnew').removeClass('validate');
			f.find('#submit').mousedown(function(e) {
				if ( typeof tinymce !== 'undefined' ){
					tinymce.triggerSave();
				}
			});
		}
	}
	

	$(document).ready(function(){
		_setting_upload();
		beforeFormSubmit();
	});
})( window.jQuery );