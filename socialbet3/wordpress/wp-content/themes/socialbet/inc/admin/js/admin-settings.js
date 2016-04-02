( function($) {
	"use strict";

	var document = window.document;
	// file options, open wordpress media frame
	function _settings_upload(){
		var upload_wrap = $('.wip-upload-form');

		if( upload_wrap.length ) {

			upload_wrap.each( function() {
				var _t = $(this),
					_p = _t.parent(),
					upload_handler = _t.find('.wip-upload-handle'),
					uploadFrame;

					upload_handler.on('click', function(e) {
						e.preventDefault();

						if ( uploadFrame ) {
							uploadFrame.open();
							return;
						}

						uploadFrame = wp.media.frames.file_frame = wp.media({
							title: 'Select Image',
							multiple: false
						});

					    uploadFrame.on( 'select', function() {
							var selection = uploadFrame.state().get('selection'),
								attachment;

							attachment = selection.toJSON();
							//console.log( attachment );
							$( e.target.hash+'_value' ).val( attachment[0].id );
							$( e.target.hash ).val( attachment[0].url );

							if( _p.find('.wip_form_preview').length === 0 ) {
								$('<span class="wip_form_preview" />').insertAfter( _t );
							}

							var viewer = _p.find('.wip_form_preview');
							viewer.html('<img src="'+attachment[0].url+'" alt="" /><a class="file-remove" href="#" title="Remove"><i class="fa fa-times"></i></a>');
						});

						uploadFrame.open();

					});

					_p.delegate('.file-remove', 'click', function(){
						_p.find('.wip_form_preview').fadeOut('fast', function(){ $(this).detach(); });
						$( upload_handler.attr('href')+'_value' ).val('');
						$( upload_handler.attr('href') ).val('');
						return false;
					});
			});
		}

	}


	//convert checkbox	
	function wCB(){
		
		var _form = $('#wip_settings')
		, checkBox = _form.find("input[type='checkbox']")
		, newInput = [];
		
		checkBox.each(function(){

			var jthis = $(this)
			, jthisID = jthis.attr('name')
			, value = "no", ni, __embed;
			
			if( jthis.attr('checked') ){
				
				value = "yes";
			
			}
			
			ni = '<input type="hidden" name="'+jthisID+'" value="'+value+'"/>';
			__embed = '<div class="WIP-jq-check"><a href="#"><span class="on">ON</span><span class="off">OFF</span><span class="animated-checkbox">|||</span></a>'+ni+'</div>';
			
			$(__embed).insertBefore( jthis );
			
			jthis.detach();
		
		});

		
		$('.WIP-jq-check').each(function(i){
				
			var liveA = $(this).find('a');

			newInput[i] = $(this).find("input[type='hidden']")
					
			if ( newInput[i].val() == "yes" ){		
				liveA.removeClass('checked-off').addClass('checked-on');			
			} else {		
				liveA.removeClass('checked-on').addClass('checked-off');			
			}
			
			liveA.on('click', function ( e ) {
				e.preventDefault();
					
				if( $(this).hasClass('checked-on') ){

					$(this).find('.animated-checkbox').stop(true,true).animate({ left : '0'}, 150, function () {
						
						liveA.removeClass('checked-on').addClass('checked-off');
						newInput[i].val('no');
					
					});
				
				} else {

					$(this).find('.animated-checkbox').stop(true,true).animate({ left : '50%'}, 150, function () {
						
						liveA.removeClass('checked-off').addClass('checked-on');
						newInput[i].val('yes');
					
					});

				}
					
			});
			
		});

	};


	function runColorPicker() {
		var inputPick = $('.settings-color-picker');

		if( inputPick.length > 0 ) {
			inputPick.each( function() {
				var d = this, visualPreview = $('#'+$(this).data('color-preview')),
						irisTarget = $('#'+$(this).data('color-target'));
					$(this).iris({
						hide : true,
						target : irisTarget,
						change : function( event, ui ) {
							visualPreview.css({backgroundColor : ui.color.toString()});
						}
					});

					$('body').on( 'click', function(event){
						if ( $(event.target).hasClass("wipform_color_placement") || $(event.target).parent().hasClass("wipform_color_placement") || $(event.target).hasClass("wipform_color_preview") || $(event.target).parent().hasClass("wipform_color_preview") ) {
							return;
						}
						$(d).iris('hide');
					});

					$(d).on('focus', function(){
						$('.settings-color-picker').not( $(this) ).iris('hide');
						$(this).iris('show');
					});
			});
		}
	}


	function sidebarHelper() {
		var press = $('#enter-sidebar'), spinner = press.parent().find('.fa-spinner'), lists = $('#wip-sidebar-data');

		if( press.length ) {
			spinner.css({opacity : 0});
			press.on('click', function(e) {
				e.preventDefault();

				var sb_name = $('#wipform_sidebar_manager').val(),
					_nonce = $('input[name="sidebar_manager_nonce"]').val(),
					data;

				//show the loading
				spinner.stop(true,true).animate({opacity : 1}, 300);

				if( sb_name === "" ){
					spinner.stop(true,true).animate({opacity : 0}, 300, function(){
						alert('Please Enter the Sidebar Name');
					});
				} else {

					data = {
						action: 'wip_theme_settings_ajax_action',
						_ajax_nonce : _nonce,
						type : 'add-sidebar',
						sbname : sb_name
					};

					$.post(ajaxurl, data, function(response) {

						var ulAppend = $('<ul id="wip-custom-sidebar-lists" />')
						, json = $.parseJSON(response);
						
						//reset the form
						$('#wipform_sidebar_manager').val("");

						if( json.Error ){
							spinner.stop(true,true).animate({opacity : 0}, 300, function(){
								alert( json.errorText );
							});
						} else {

							if( lists.find('#wip-custom-sidebar-lists').length < 1 ) {
								lists.html('').append( ulAppend );
							}

							spinner.stop(true,true).animate({opacity : 0}, 300, function(){
								lists.find('#wip-custom-sidebar-lists').append( json.htmlCallback );

								lists.find('.sidebar-remove').on('click', function(e){
									e.preventDefault();
									var t = $(this), sidebarId = t.data('sidebarid');

										data = {
											action: 'wip_theme_settings_ajax_action',
											_ajax_nonce : _nonce,
											type : 'remove-sidebar',
											sbname : sidebarId
										};

									$.post(ajaxurl, data, function() {
										t.parent().slideDown(300, function(){
											$(this).detach();
										})
									});

								});
							});


						}

					});

				}

			});


			lists.find('.sidebar-remove').on('click', function(e){
				e.preventDefault();
				var t = $(this), sidebarId = t.data('sidebarid'), _nonce = $('input[name="sidebar_manager_nonce"]').val(), data;

					data = {
						action: 'wip_theme_settings_ajax_action',
						_ajax_nonce : _nonce,
						type : 'remove-sidebar',
						sbname : sidebarId
					};

				$.post(ajaxurl, data, function() {
					t.parent().slideDown(300, function(){
						$(this).detach();
					})
				});

			})
		}
	}

	$( document ).ready( function() {

		_settings_upload();
		wCB();
		sidebarHelper();
		runColorPicker();

	} );

})(window.jQuery);


/**
 * Multiple image upload helper function
 * @since version 1.0
 * @author Webinpixels
 */
!function ($) {
	"use strict";

	function wipThemeSettingsMultipleImage( el ) {
		this.el = el;
		this.$formGraber = $( '#'+$(this.el).data('formid') );
		this.$clicker = $(this.el).find('.multiple-wip-upload-handle');

		if( $(this.el).find('.wip_setting_image_lists').length < 1 ) {
			var ulAppend = $('<ul />').addClass('wip_setting_image_lists');

			$(this.el).find('.wip_multi_image_preview').append( ulAppend );
		}

		this.lists = $(this.el).find('.wip_setting_image_lists');
console.log( this.$formGraber.val() )
		this.init();
	};

	wipThemeSettingsMultipleImage.prototype = {
		constructor: wipThemeSettingsMultipleImage

		, init : function(){
			var that = this;

			this.onButtonClick();
			this.onDeleteClicked();
			this.lists.sortable({
				handle: '.wip_setting_mi_thumbnail',
				placeholder: 'sortable-placeholder',
				items : 'li',
				revert: 200,
				opacity: 0.5,
				update : function ( event, ui){
					return that.updateSortable();
				}
			});
		}

		, onDeleteClicked : function() {
			var that = this;

			$(this.el).find('.delete_wip_setting_image_lists').unbind().on('click', function(e) {
				e.preventDefault();

				var target = $(this).attr('rel');

				if( $('#'+target).length ) {
					$('#'+target).fadeOut(200, function(){
						$('#'+target).detach();
						return that.updateSortable();
					});
				}

			});
		}

		, onButtonClick : function() {
			var that = this;

			this.$clicker.on('click', function(e) {

				e.preventDefault();

				// open the wp media
				if ( file_frame ) {
					file_frame.open();
					return;
				}

				var file_frame = wp.media.frames.file_frame = wp.media({
					title: that.$clicker.text() + ' ( [Ctrl]+click or [command]+click for multiple selection )',
					multiple: true
				});

			    file_frame.on( 'select', function() {
					var selection = file_frame.state().get('selection'),
						newVal = ( that.$formGraber.val() !== "" ) ? (that.$formGraber.val()).split(",") : [];

					selection.map( function( attachment ) {
						attachment = attachment.toJSON();				
						
						if( attachment.type == 'image' && !that.checkExistance(attachment.id) ){
							var pr = typeof attachment.sizes.thumbnail === "undefined" ? attachment.sizes.full.url : attachment.sizes.thumbnail.url;
							var htmlMain = '<img class="wip_setting_mi_thumbnail" src="'+pr+'" alt="" /><a class="delete_wip_setting_image_lists" href="#" rel="'+that.el.id+'_wip_setting_list_'+ attachment.id +'" title="Remove"><i class="fa fa-times"></i></a>';
							
							that.lists.append('<li id="'+that.el.id+'_wip_setting_list_'+attachment.id+'" data-objectid="'+attachment.id+'">'+htmlMain+'</li>');

							newVal.push( String(attachment.id) );

						}

						// refresh the sortable, shall we!?
						that.lists.sortable({
							handle: '.wip_setting_mi_thumbnail',
							placeholder: 'sortable-placeholder',
							items : 'li',
							revert: 200,
							opacity: 0.5,
							update : function ( event, ui){
								return that.updateSortable();
							}
						});

					});
					
					// join the array into a string
					newVal = newVal.join(",");
					
					// modify the form value
					that.$formGraber.val( newVal );
					that.onDeleteClicked();
			    });

				file_frame.open();
			});

		}

		, updateSortable : function() {
			var that = this,
				valNow = that.lists.find('li').map( function(){
					return $(this).data('objectid');
				}).get().join();


			that.$formGraber.val( valNow );

		}

		, checkExistance : function( theID ){

			if( this.$formGraber.length ){
				var listedIDval = ( this.$formGraber.val() ).split(",");

				if( -1 != $.inArray( String(theID), listedIDval ) ) return true;
			}

			return false;
		}
	};

	$.fn.wipThemeSettingsMultipleImage = function () {
		return this.each(function () {
			if (!$.data(this, 'wipthemesettingsmultipleimage')) {
				$.data(this, 'wipthemesettingsmultipleimage', 
					new wipThemeSettingsMultipleImage( this ));
			}
		});
	};

	$.fn.wipThemeSettingsMultipleImage.Constructor = wipThemeSettingsMultipleImage;

}( window.jQuery );

var wipadmin = wipadmin || {};
wipadmin.glob = function (b) {
  "use strict"; /*jshint validthis:true, laxcomma:true, expr:true*/
  var document = window.document;
  var g = {
  	init: function () {
  		var d = this;
		b(document).ready(function () {
			d.documentReady();
		});
  	},
  	documentReady: function(){
      if (b('.wip_admin_tab_options').length > 0) {
        b('.wip_admin_tab_options').each(function () {
          new wipadmin.glob.tabbed(this);
        });
      }

      if (b('.wip_opacity_render').length > 0) {
        b('.wip_opacity_render').each(function () {
          new wipadmin.glob.slider(this);
        });
      }
  	},
    tabbed: function (m) {
      var n = {
        init: function (m) {
          this.tab = m;
          this.tabber = b(this.tab).find('.wip_admin_tab_lists').find('a').map(function () {
            return this;
          });
          b(this.tabber[0]).addClass('tab-active');
          b(this.tab).find('.wip_admin_tab_pane').hide();
          b(this.tab).find('.wip_admin_tab_pane').eq(0).show();
          this.tabberClick();
          this.detectOpenTab();
        },
        tabberClick: function () {
          var d = this;
          b(d.tabber).each(function (i) {
            b(d.tabber[i]).on('click', function (e) {
            	var t = b(this);
              e.preventDefault();
              if (!b(this).hasClass('tab-active')) {
                b(d.tab).find('.tab-active').removeClass('tab-active');
                b(this).addClass('tab-active');
                b(d.tab).find('.wip_admin_tab_pane').filter(':visible').hide();
                b(d.tab).find('.wip_admin_tab_pane').eq(i).fadeIn('normal');
                window.setTimeout( function(){
                	var st = b(window).scrollTop();
                	window.location = t.attr('href');
                	b('body,html').scrollTop(st);
                }, 100);
              }
            });
          });
        },
        detectOpenTab: function() {
          var d = this,
              ur = location.href.replace( '#', '?v='),
			  par = wipadmin.glob.grab_param('v', ur);

			if( par !== "" ){
				b(d.tabber).each(function (i) {
					var hr = b(this).attr('href').replace('#', '');

					if( hr === par ) {
						b(this).trigger('click');
					}
				});
			}
        }
      };
      n.init(m);
      return n;
    },
    slider: function(m) {
      var n = {
        init: function (m) {
          
          this.sliderId = m.id;
          this.ex = b('#'+this.sliderId).data('extension') === "" ? '%' : b('#'+this.sliderId).data('extension');
          this.min = b('#'+this.sliderId).data('min') === "" ? 0 : b('#'+this.sliderId).data('min');
          this.max = b('#'+this.sliderId).data('max') === "" ? 100 : b('#'+this.sliderId).data('max');

          var cwraper = b('<div id="slider-for'+this.sliderId+'" class="wip_admin_slider_parent"><div class="wip_admin_slider" /></div>');

          if( b('#'+this.sliderId).parent().find('.wip_admin_slider_parent').length < 1 ) {
          	b('#'+this.sliderId).after(cwraper).attr('type', 'hidden');
          	this.slider = b('#'+this.sliderId).next('.wip_admin_slider_parent').find('.wip_admin_slider');
          }
          this.fireSlider();
        },
        fireSlider: function () {
          var d = this;
          b(d.slider).slider({
          	range: 'min',
          	min: d.min,
          	max: d.max,
          	value: parseInt( b('#'+d.sliderId).val() ),
          	slide: function( event, ui ) {
          		b('#'+d.sliderId).val( ui.value );
          		b('#opacity_val_'+d.sliderId).html( ui.value+d.ex );
          	}
          });
          b('#'+d.sliderId).val( b(d.slider).slider('value') );
          b('#opacity_val_'+d.sliderId).html( b(d.slider).slider('value')+d.ex );
        }
      };
      n.init(m);
      return n;
    },
	grab_param: function(name,url){
		name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
		var regexS = "[\\?&]"+name+"=([^&#]*)";
		var regex = new RegExp( regexS );
		var results = regex.exec( url );
		if( results == null )
			return "";
			else
		return results[1];
	}
  };
  g.init();
  return g;
}(window.jQuery);



