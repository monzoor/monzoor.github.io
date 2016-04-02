/*!
 * imagesLoaded PACKAGED v3.1.8
 * JavaScript is all like "You images are done yet or what?"
 * MIT License
 */
(function(){function e(){}function t(e,t){for(var n=e.length;n--;)if(e[n].listener===t)return n;return-1}function n(e){return function(){return this[e].apply(this,arguments)}}var i=e.prototype,r=this,o=r.EventEmitter;i.getListeners=function(e){var t,n,i=this._getEvents();if("object"==typeof e){t={};for(n in i)i.hasOwnProperty(n)&&e.test(n)&&(t[n]=i[n])}else t=i[e]||(i[e]=[]);return t},i.flattenListeners=function(e){var t,n=[];for(t=0;e.length>t;t+=1)n.push(e[t].listener);return n},i.getListenersAsObject=function(e){var t,n=this.getListeners(e);return n instanceof Array&&(t={},t[e]=n),t||n},i.addListener=function(e,n){var i,r=this.getListenersAsObject(e),o="object"==typeof n;for(i in r)r.hasOwnProperty(i)&&-1===t(r[i],n)&&r[i].push(o?n:{listener:n,once:!1});return this},i.on=n("addListener"),i.addOnceListener=function(e,t){return this.addListener(e,{listener:t,once:!0})},i.once=n("addOnceListener"),i.defineEvent=function(e){return this.getListeners(e),this},i.defineEvents=function(e){for(var t=0;e.length>t;t+=1)this.defineEvent(e[t]);return this},i.removeListener=function(e,n){var i,r,o=this.getListenersAsObject(e);for(r in o)o.hasOwnProperty(r)&&(i=t(o[r],n),-1!==i&&o[r].splice(i,1));return this},i.off=n("removeListener"),i.addListeners=function(e,t){return this.manipulateListeners(!1,e,t)},i.removeListeners=function(e,t){return this.manipulateListeners(!0,e,t)},i.manipulateListeners=function(e,t,n){var i,r,o=e?this.removeListener:this.addListener,s=e?this.removeListeners:this.addListeners;if("object"!=typeof t||t instanceof RegExp)for(i=n.length;i--;)o.call(this,t,n[i]);else for(i in t)t.hasOwnProperty(i)&&(r=t[i])&&("function"==typeof r?o.call(this,i,r):s.call(this,i,r));return this},i.removeEvent=function(e){var t,n=typeof e,i=this._getEvents();if("string"===n)delete i[e];else if("object"===n)for(t in i)i.hasOwnProperty(t)&&e.test(t)&&delete i[t];else delete this._events;return this},i.removeAllListeners=n("removeEvent"),i.emitEvent=function(e,t){var n,i,r,o,s=this.getListenersAsObject(e);for(r in s)if(s.hasOwnProperty(r))for(i=s[r].length;i--;)n=s[r][i],n.once===!0&&this.removeListener(e,n.listener),o=n.listener.apply(this,t||[]),o===this._getOnceReturnValue()&&this.removeListener(e,n.listener);return this},i.trigger=n("emitEvent"),i.emit=function(e){var t=Array.prototype.slice.call(arguments,1);return this.emitEvent(e,t)},i.setOnceReturnValue=function(e){return this._onceReturnValue=e,this},i._getOnceReturnValue=function(){return this.hasOwnProperty("_onceReturnValue")?this._onceReturnValue:!0},i._getEvents=function(){return this._events||(this._events={})},e.noConflict=function(){return r.EventEmitter=o,e},"function"==typeof define&&define.amd?define("eventEmitter/EventEmitter",[],function(){return e}):"object"==typeof module&&module.exports?module.exports=e:this.EventEmitter=e}).call(this),function(e){function t(t){var n=e.event;return n.target=n.target||n.srcElement||t,n}var n=document.documentElement,i=function(){};n.addEventListener?i=function(e,t,n){e.addEventListener(t,n,!1)}:n.attachEvent&&(i=function(e,n,i){e[n+i]=i.handleEvent?function(){var n=t(e);i.handleEvent.call(i,n)}:function(){var n=t(e);i.call(e,n)},e.attachEvent("on"+n,e[n+i])});var r=function(){};n.removeEventListener?r=function(e,t,n){e.removeEventListener(t,n,!1)}:n.detachEvent&&(r=function(e,t,n){e.detachEvent("on"+t,e[t+n]);try{delete e[t+n]}catch(i){e[t+n]=void 0}});var o={bind:i,unbind:r};"function"==typeof define&&define.amd?define("eventie/eventie",o):e.eventie=o}(this),function(e,t){"function"==typeof define&&define.amd?define(["eventEmitter/EventEmitter","eventie/eventie"],function(n,i){return t(e,n,i)}):"object"==typeof exports?module.exports=t(e,require("wolfy87-eventemitter"),require("eventie")):e.imagesLoaded=t(e,e.EventEmitter,e.eventie)}(window,function(e,t,n){function i(e,t){for(var n in t)e[n]=t[n];return e}function r(e){return"[object Array]"===d.call(e)}function o(e){var t=[];if(r(e))t=e;else if("number"==typeof e.length)for(var n=0,i=e.length;i>n;n++)t.push(e[n]);else t.push(e);return t}function s(e,t,n){if(!(this instanceof s))return new s(e,t);"string"==typeof e&&(e=document.querySelectorAll(e)),this.elements=o(e),this.options=i({},this.options),"function"==typeof t?n=t:i(this.options,t),n&&this.on("always",n),this.getImages(),a&&(this.jqDeferred=new a.Deferred);var r=this;setTimeout(function(){r.check()})}function f(e){this.img=e}function c(e){this.src=e,v[e]=this}var a=e.jQuery,u=e.console,h=u!==void 0,d=Object.prototype.toString;s.prototype=new t,s.prototype.options={},s.prototype.getImages=function(){this.images=[];for(var e=0,t=this.elements.length;t>e;e++){var n=this.elements[e];"IMG"===n.nodeName&&this.addImage(n);var i=n.nodeType;if(i&&(1===i||9===i||11===i))for(var r=n.querySelectorAll("img"),o=0,s=r.length;s>o;o++){var f=r[o];this.addImage(f)}}},s.prototype.addImage=function(e){var t=new f(e);this.images.push(t)},s.prototype.check=function(){function e(e,r){return t.options.debug&&h&&u.log("confirm",e,r),t.progress(e),n++,n===i&&t.complete(),!0}var t=this,n=0,i=this.images.length;if(this.hasAnyBroken=!1,!i)return this.complete(),void 0;for(var r=0;i>r;r++){var o=this.images[r];o.on("confirm",e),o.check()}},s.prototype.progress=function(e){this.hasAnyBroken=this.hasAnyBroken||!e.isLoaded;var t=this;setTimeout(function(){t.emit("progress",t,e),t.jqDeferred&&t.jqDeferred.notify&&t.jqDeferred.notify(t,e)})},s.prototype.complete=function(){var e=this.hasAnyBroken?"fail":"done";this.isComplete=!0;var t=this;setTimeout(function(){if(t.emit(e,t),t.emit("always",t),t.jqDeferred){var n=t.hasAnyBroken?"reject":"resolve";t.jqDeferred[n](t)}})},a&&(a.fn.imagesLoaded=function(e,t){var n=new s(this,e,t);return n.jqDeferred.promise(a(this))}),f.prototype=new t,f.prototype.check=function(){var e=v[this.img.src]||new c(this.img.src);if(e.isConfirmed)return this.confirm(e.isLoaded,"cached was confirmed"),void 0;if(this.img.complete&&void 0!==this.img.naturalWidth)return this.confirm(0!==this.img.naturalWidth,"naturalWidth"),void 0;var t=this;e.on("confirm",function(e,n){return t.confirm(e.isLoaded,n),!0}),e.check()},f.prototype.confirm=function(e,t){this.isLoaded=e,this.emit("confirm",this,t)};var v={};return c.prototype=new t,c.prototype.check=function(){if(!this.isChecked){var e=new Image;n.bind(e,"load",this),n.bind(e,"error",this),e.src=this.src,this.isChecked=!0}},c.prototype.handleEvent=function(e){var t="on"+e.type;this[t]&&this[t](e)},c.prototype.onload=function(e){this.confirm(!0,"onload"),this.unbindProxyEvents(e)},c.prototype.onerror=function(e){this.confirm(!1,"onerror"),this.unbindProxyEvents(e)},c.prototype.confirm=function(e,t){this.isConfirmed=!0,this.isLoaded=e,this.emit("confirm",this,t)},c.prototype.unbindProxyEvents=function(e){n.unbind(e.target,"load",this),n.unbind(e.target,"error",this)},s});

( function($){

	var rtime = new Date(1, 1, 2000, 12,00,00);
		var timeout = false;
		var delta = 200;

	function bindModuleEventHandlers() {
		//console.log("test")
		var windowheight = $('body').hasClass('tax-group_name') ? $(window).height() - 270 : $(window).height();
		$('.view-style > a').on('click',function(e) {
			e.preventDefault();
		    if ($(this).hasClass('grid-v')) {
		    	$(".list-v,.grid-v").removeClass("selected"),
		   		$(this).addClass("selected"),
		        $('.followers').removeClass('list').addClass('grid');
		    }
		    else if($(this).hasClass('list-v')) {
		    	$(".list-v,.grid-v").removeClass("selected"),
		   		$(this).addClass("selected"),
		        $('.followers').removeClass('grid').addClass('list');
		    }
		});
	
		$("#user_country").select2();

		$( ".actual-events" ).accordion({
	      heightStyle: "content"
	    });
	    // $(".actual-events").multiAccordion();

		$( "#tabs" ).tabs();
		$( "#tabs2" ).tabs();
		$( "#tabs3" ).tabs({ active: 1 });

		$(".left-container-wrapper").css({ minHeight : windowheight-54+'px' });
		$('.middle-container-wrapper').css({ minHeight : windowheight-(54+40)+'px' });
		$('.middle-container-wrapper-1col').css({ minHeight : windowheight-54+'px' });
		$('.middle-container-wrapper-2col-wide, .middle-container-wrapper-2col').css({ minHeight : windowheight-(54+20)+'px' });
		$('.right-container-wrapper').css({ minHeight : windowheight-(54+20)+'px' });

		var window_width=$(window).width();
		var doc_height= $('body').hasClass('tax-group_name') ? $(".main-container").height() - 270 : $(".main-container").height();
		var doc_height_sidebar = $(".main-container").height();

		$(".left-sidebar").css("height",doc_height_sidebar+54+"px");
		$(".left-gutter").css("height",doc_height+54+"px");
		$(".left-container-wrapper").css("height",doc_height+"px");
		$(".middle-container-wrapper").css("height",doc_height-40+"px");
		$(".right-container-wrapper").css("height",doc_height-20+"px");

		if(window_width>=969){
			$(".left-sidebar").removeClass("tab-por-nav");
			$(".top-navigation-wrapper .mob-nav").removeClass("mob-nav-triggred");
			$(".right-top-container, .main-container, .content-sub-wrapper").animate({"margin-left":"0"},200);

			$(".overlay").css("display","none");

		}
		if(window_width>=768 && window_width<=968){
			$(".left-navbar-wrapper .treeview li").click(function(){
				$(".left-sidebar").addClass("tab-por-nav");
				$(".content-wrapper").addClass("stop-overflow");
				if($(".tab-por-nav").length>0){
					//$(".content-sub-wrapper").animate({"margin-left":"11%"},200);
					$(".overlay").css("height",$(".main-container").height()+"px");
		   			$(".overlay").css("display","block");
				}
			});
			$(".overlay").click(function(){
				if($(".tab-por-nav").length>0){
					$(".left-sidebar").removeClass("tab-por-nav");
					//$(".content-sub-wrapper").animate({"margin-left":"0px"},200);
					$(".lvl-2,.lvl-3").css("display","none");
					$(".overlay").css("display","none");
				}
			});
		}
		if(window_width<=414){
			$(".top-navigation-wrapper .mob-nav").click(function(){
				$(this).addClass("mob-nav-triggred");
				$(".content-wrapper").addClass("stop-overflow");
				$(".left-sidebar").animate({"margin-left":"0"},200);
				$(".right-top-container, .main-container").animate({"margin-left":"45%"},200);

	   			if($(".mob-nav-triggred").length>0){
	   				$(".overlay").css("height",doc_height+"px");
		   			$(".overlay").css("display","block");
				}
			});
			$(".overlay").click(function(){
				if($(".mob-nav-triggred").length>0){
					$(".top-navigation-wrapper .mob-nav").removeClass("mob-nav-triggred");
					$(".content-wrapper").removeClass("stop-overflow");
					$(".left-sidebar").animate({"margin-left":"-45%"},200);
					$(".right-top-container, .main-container").animate({"margin-left":"0"},200);
					$(".overlay").css("display","none");
				}
			});
		}

		//compitition text box
		$(".compitition-wrapper .text-box-wrapper .right-box").css("min-height",$(".compitition-wrapper .text-box-wrapper .left-box").height()+"px")
		var maxHeight;
		$('.competition-box-wrapper li').each(function() { 
			maxHeight = Math.max(maxHeight, $(this).height()); 
		}).height(maxHeight);
	    $.fn.equalizeHeights = function(){
		  return this.height( Math.max.apply(this, $(this).map(function(i,e){ return $(e).height() }).get() ) )
		}
		$('.competition-box-wrapper li').equalizeHeights();
		
	}

	function resizeend() {
	    if (new Date() - rtime < delta) {
	        setTimeout(resizeend, delta);
	    } else {
	        timeout = false;
	        $("#red").treeview({
				collapsed: true
		});
	    }               
	}


	function userPostNewStatus() {
		var btn = $('#post-status-trigger');

		if ( btn.length && $('form#user-status-write').length ) {
			var form = $('form#user-status-write'), upbt = $('.timeline-upload-trigger'), polbt = $('.timeline-poll-trigger');

			btn.unbind().on('click', function(e) {
				e.preventDefault();
				$('<img class="ajx-preloader-fb" src="'+socbet.preloader+'" alt="" />').appendTo( $(this) );
				form.trigger('submit');
			});

			form.unbind().on( 'submit', function(e) {
				e.preventDefault();

				if ( $(this).hasClass('processing') )
					return false;

				if ( $(this).find('#poll-creation').length ) {
					if ( $('#poll-creation').find('input[name="poll-name"]').val() === "" ) {
						$('#poll-creation').find('input[name="poll-name"]').addClass('inputError').focus();
						form.find('.ajx-preloader-fb').remove();
						return false;
					}
					var opcheck = "";
					$('#poll-creation').find('input[name^="poll-options"]').each(function(){
						opcheck += $(this).val();
					});

					if ( opcheck === "" ) {
						if ( $('#poll-creation').find('input[name^="poll-options"]').length < 1 ) {
							$('#poll-add-op').focus();
						}

						$('#poll-creation').find('input[name^="poll-options"]').addClass('inputError');
						form.find('.ajx-preloader-fb').remove();
						return false;
					}
				}

				$(this).addClass('processing');
				
				$(this).ajaxSubmit({
					url : socbet.ajax_url,
					dataType: 'json',
					resetForm: true,
					type: 'POST',
					success: function( resp ) {
						form.removeClass('processing');
						$('#timeline-upload-holder').html('');
						if ( form.find('#poll-creation').length ) {
							form.find('#poll-creation').remove();
						}
						form.find('.ajx-preloader-fb').remove();
						if ( resp.err === 'yes' ) {
							return false;
						} else {
							var pid = parseInt( resp.post_id ),
								baseUrl = document.location.href;

							$.get( baseUrl, '', function(data){
								var newItem = $("#user-status-"+pid, data),
									headerTag = $("#user-profile-header", data), header;

								header = headerTag.length ? headerTag[0].innerHTML : '';

								$(newItem).imagesLoaded( function(){
									$(newItem).css({display:'none'});
									$('#user-status-wrapper').prepend($(newItem));
									$(newItem).fadeIn(300);
									if ( header )
										$("#user-profile-header").html(header);

									timelinesImages();
									timelineComments();
									userVotedPoll();
									triggerLikesDislikes();
									$(window).trigger('resize');
								});
							});

							return false;
						}
					}
				});

			});

			upbt.each( function() {
				var upbtcall = $(this);
				upbtcall.unbind().on( 'click', function(e) {
					e.preventDefault();
					$('#form-ajx-tlf').find('input[name="socbet_timelinefiles_upload"]').trigger('click');
				});
			});

			polbt.unbind().on( 'click', function(e) {
				e.preventDefault();
				if ( $('#timeline-poll-holder').find('#poll-creation').length ) 
					return false;

				$(socbet.add_poll).appendTo($('#timeline-poll-holder'));
				$(window).trigger('resize');

				$('input[name^="poll-options"]:first').focus();

				$('#remove-poll-creation').unbind().on( 'click', function() {
					$('#poll-creation').remove();
					return false;
				});

				triggerAddPolOptions();
				triggerDelPolOptions();
			});

			$('#form-ajx-tlf').find('input[name="socbet_timelinefiles_upload"]').unbind().on( 'change', function() {
				$('#form-ajx-tlf').trigger('submit');
			});

			$('#form-ajx-tlf').unbind().on( 'submit', function(e) {
				e.preventDefault();
				var dis = $('<div class="img-box"/>');
				$(this).ajaxSubmit({
					url : socbet.ajax_url,
					dataType: 'json',
					beforeSubmit: function() {
						form.addClass('processing');
						$('#timeline-upload-holder').append( dis );
					},
					resetForm: false,
					type: 'POST',
					uploadProgress: function(event, position, total, percentComplete) {
						var percentVal = percentComplete + '%';
						if ( parseInt(percentComplete) > 98 ) {
							dis.html( 'Please wait..' );
						} else {
							dis.html( percentVal );
						}
					},
					success: function( resp ) {
						form.removeClass('processing');				
						
						if ( resp.err === 'yes' ) {
							dis.remove();
							alert( socbet.messages.upload_error );
							return false;	
						} else {

							dis.html('<input type="hidden" name="timeline_attachment_ids[]" value="'+resp.attachment_id+'" /><img src="'+resp.thumbnail+'" alt="" /><div class="close-abs dark-gray remove-attachment" data-attachmentid="'+resp.attachment_id+'"><span class="icon-close"></span></div>');
							triggerDelAttachments();
							
						}
					}
				});
			});
		}
	}


	function triggerDelPolOptions() {
		var b=$('.remove-poll-option');

		b.each( function() {
			$(this).unbind().on( 'click', function(){
				$(this).parent().parent().fadeOut('fast', function() {
					$(this).remove();
					$(window).trigger('resize');
				})
			});
		});
	}

	function triggerAddPolOptions() {
		var b=$('#poll-add-op');

		b.unbind().on('focus', function() {
			$(socbet.add_poll_field).insertBefore( b );
			$('input[name^="poll-options"]:last').focus();
			$(window).trigger('resize');
			triggerDelPolOptions();
		});
	}


	function triggerDelAttachments() {

		if ( $('#post-status-trigger').length ) {
			if ( $('.close-abs').length ) {
				$('.close-abs').each( function() {
					var d=this;
					$(d).unbind().on( 'click', function(e) {
						e.preventDefault();
						$(d).parent().fadeOut(300, function(){
							$(d).parent().remove();
						});
					});
				});
			}
		}
	}


	function triggerDelAttchmentMsg() {
			if ( $('.close-abs').length ) {
				$('.close-abs').each( function() {
					var d=this;
					$(d).unbind().on( 'click', function(e) {
						e.preventDefault();
						$(d).parent().fadeOut(300, function(){
							$(d).parent().remove();
						});
					});
				});
			}
	}


	function checkAtMsgBeforeUpload() {
		if ( window.File && window.FileReader && window.FileList && window.Blob ) {
        	var ftype = $('input[name="socbet_timelinefiles_upload"]')[0].files[0].type;

        	switch(ftype) {
        		case 'image/png':
        		case 'image/gif':
        		case 'image/jpeg':
        		case 'image/pjpeg':
        			break;
        		default:
					alert( socbet.messages.unsupported_file_type );
					return false;
        			break;
        	}

        	return true;
		} else {
			alert( socbet.messages.unsupported_browser );
			return false;
		}
	}

	function triggerReplyMsg() {

		if ( $('#msg-upload-holder').length ) {
			var form = $('form#form-ajx-msg-reply'), upbt = $('.timeline-upload-trigger'), btn = $('#trigger-msg-reply');
			upbt.each( function() {
				var upbtcall = $(this);
				upbtcall.unbind().on( 'click', function(e) {
					e.preventDefault();
					$('#form-ajx-tlf').find('input[name="socbet_timelinefiles_upload"]').trigger('click');
				});
			});

			btn.unbind().on('click', function(e) {
				e.preventDefault();
				if ( $('textarea[name="message-content"]').val() === "" ) {
					return false;
				}
				$('<img class="ajx-preloader-fb" src="'+socbet.preloader+'" alt="" />').appendTo( $(this) );
				form.trigger('submit');
			});

			form.unbind().on('submit', function(e) {
				e.preventDefault();

				if ( $(this).hasClass('processing') )
					return false;

				$(this).addClass('processing');
				$(this).ajaxSubmit({
					url : socbet.ajax_url,
					dataType: 'json',
					resetForm: true,
					type: 'POST',
					success: function( resp ) {
						$('#msg-upload-holder').html('');
						form.removeClass('processing');
						form.find('.ajx-preloader-fb').remove();
						if ( resp.err === 'yes' ) {
							if ( typeof resp.redirect !== 'undefined' ) {
								window.location.replace( resp.url );
								return false;
							}

							return false;
						} else {
							var pid = parseInt( resp.reply_id ),
								baseUrl = document.location.href;

							if ( $('#modal-sent-message').length ) {
								$('#modal-sent-message').find('.md-close').trigger('click');
							} else {
								$.get( baseUrl, '', function(data){
									var newItem = $("#reply-"+pid, data);

									$(newItem).imagesLoaded( function(){
										$(newItem).css({display:'none'});
										$('#profile-dialogue-wrapper').append($(newItem));
										$(newItem).fadeIn(250, function(){
											$(window).trigger('resize');
										});
									});
								});
							}

							return false;
						}
					}
				});

			});

			$('#form-ajx-tlf').find('input[name="socbet_timelinefiles_upload"]').unbind().on( 'change', function() {
				$('#form-ajx-tlf').trigger('submit');
			});

			$('#form-ajx-tlf').unbind().on( 'submit', function(e) {
				e.preventDefault();
				var dis = $('<div class="img-box"/>');

				if ( form.hasClass('processing') )
					return false;

				$(this).ajaxSubmit({
					url : socbet.ajax_url,
					dataType: 'json',
					beforeSubmit: function() {
						var cc = checkAtMsgBeforeUpload();
						if ( cc ) {
							form.addClass('processing');
							$('#msg-upload-holder').append( dis );
						}
					},
					resetForm: false,
					type: 'POST',
					uploadProgress: function(event, position, total, percentComplete) {
						var percentVal = percentComplete + '%';
						if ( parseInt(percentComplete) > 98 ) {
							dis.html( 'Please wait..' );
						} else {
							dis.html( percentVal );
						}
					},
					success: function( resp ) {
						form.removeClass('processing');
						if ( resp.err === 'yes' ) {
							dis.remove();
							alert( socbet.messages.upload_error );
							return false;	
						} else {

							dis.html('<input type="hidden" name="timeline_attachment_ids[]" value="'+resp.attachment_id+'" /><img src="'+resp.thumbnail+'" alt="" /><div class="close-abs dark-gray remove-attachment" data-attachmentid="'+resp.attachment_id+'"><span class="icon-close"></span></div>');
							triggerDelAttchmentMsg();
							
						}
					}
				});
			});
		}
	}


	function triggerLikesDislikes() {
		var bt = $('.ajx-timeline-misc');

		if ( bt.length ) {
			bt.each( function() {
				var d=$(this);

				d.unbind().on( 'click', function(e) {
					e.preventDefault();

					if ( d.hasClass('onprocess') )
						return false;

					var url=d.data('uri'), postid=d.data('postid'), likes=d.data('load-likes'), dislikes=d.data('load-dislikes'), urlq;
					d.addClass('onprocess');
					urlq = { 'taction' : d.data('qry'),pid : postid };

					$.get( url, urlq, function(data){
						var likesdom = $("#"+likes, data)[0].innerHTML,
							dislikesdom = $("#"+dislikes, data)[0].innerHTML;

						$("#"+likes).html(likesdom);
						$("#"+dislikes).html(dislikesdom);
						d.removeClass('onprocess');
						triggerLikesDislikes();
					});
				});
			});
		}
	}


	function userVotedPoll() {
		var ipt = $('input[name="pool_me"]');

		if ( ipt.length ) {

			ipt.each( function() {
				var d=$(this), fr=d.closest('form');

				d.unbind().on('change', function() {
					$(this).parent().find('label').append( $('<img class="ajx-preloader-fb" src="'+socbet.preloader+'" alt="" />') );
					fr.trigger('submit');
				});

				fr.unbind().on('submit', function(e) {
					e.preventDefault();
					var pid = fr.find('input[name="post_id"]').val();
					$(this).ajaxSubmit({
						url : socbet.ajax_url,
						dataType: 'json',
						resetForm: true,
						type: 'POST',
						success: function( resp ) {
							fr.find('.ajx-preloader-fb').remove();				
							
							if ( resp.err === 'yes' ) {
								if ( typeof resp.redirect !== 'undefined' ) {
									window.location.replace( resp.url );
									return false;
								}

								alert( socbet.messages.upload_error );
								return false;	
							} else {

								$.get( resp.url, '', function(data){
									var newItem = $("#poll-single-wrap-"+pid, data)[0].innerHTML;

									$("#poll-single-wrap-"+pid).html( newItem );
									$(window).trigger('resize');
								});

								return false;
								
							}
						}
					});
				});
			});
		}
	}

	function timelinesImages() {
		var l = $('.attachment-thumb-lists');

		if ( l.length ) {
			l.each(function() {
				var t=this;
				$(t).find('a').unbind().on('click', function(e) {
					e.preventDefault();
					if ( $(this).hasClass('active') )
						return false;

					var at = $(this), pl = $(this).data('placeholder'), h = $(this).attr('href'), img;

					if ( ! $(pl).length )
						return false;

					$(pl).addClass('loads-new-image');

					img = new Image();
					$(img).css({opacity: 0}).load( function() {
						$(t).parent().find('.active').removeClass('active');
						at.addClass('active');
						$(pl).css({height : $(pl).height()+'px'}).find('img').fadeOut( 200, function() {
							$(pl).find('img').remove();
							$(pl).append( $(img) );
							$(img).animate({opacity: 1}, 200 );
							$(pl).removeClass('loads-new-image').animate({height : $(img).height()+'px'}, 200, function(){
								$(pl).css({height: ''});
								$(window).trigger('resize');
							});
						});
						
					}).attr('src', h );
				});
			});
		}
	}


	function timelineComments() {
		var fr = $('.timeline-commentform-form');

		if( fr.length ) {
			
			trashComment();

			fr.each( function() {
				var f=this, act=$(this).attr('action'), backurl=$(this).data('backuri'), post_id=$(this).data('parentid');

				$(f).unbind().on('submit', function(e) {
					e.preventDefault();
					
					$(f).find('input[type="submit"]').prop("disabled", true);

					$(this).ajaxSubmit({
						type: 'POST',
						dataType: 'json',
						url: act,
						error: function ( XMLHttpRequest, textStatus, errorThrown ) {
							$(f).find('input[type="submit"]').prop("disabled", false);
							return false;
						},
						success: function ( resp ) {
							$(f).find('input[type="submit"]').prop("disabled", false);
							if ( resp.err == 'yes' ) {
								alert( socbet.messages.upload_error );
								return false;
							} else {
								$.get( backurl, '', function(data){
									var newItem = $("#timeline-comment-"+resp.comment_id, data),
										newCount = $("input#timelines-comments-number-count-"+post_id, data);
									
									$(f).find('textarea').val('');
									$(newItem).css({display:'none'});
									
									if ( $('#timeline-comment-lists-'+post_id).find('>.col-wp').length ) {	
										$(newItem).appendTo( $('#timeline-comment-lists-'+post_id).find('>.col-wp') );
									} else {
										$('#timeline-comment-lists-'+post_id).html('<div class="col-wp brd-top" />');
										$(newItem).appendTo( $('#timeline-comment-lists-'+post_id).find('>.col-wp') );
									}

									$('.timelines-comments-number-count-'+post_id).each(function(){
										$(this).html( $(newCount).val() );
									})

									$(newItem).fadeIn(300, function() {
										$(window).trigger('resize');
										trashComment();
									});
									
								});				
							}
						}
					});
				});

				$(f).find('textarea[name="comment"]').unbind().on('focus', function() {
					if ( $(f).find('.form-submit').is(':hidden') ) {
						$(f).find('.form-submit').show();
						$(window).trigger('resize');
					}
				}).on('blur', function() {
					if ( $(this).val() === "" ) {
						$(f).find('.form-submit').hide();
						$(window).trigger('resize');
					}
				});
			});
		}

		if ( $('.tm-get-all-comments').length ) {
			$('.tm-get-all-comments').each( function() {
				$(this).unbind().on('click', function(e) {
					e.preventDefault();
					if ( $(this).hasClass('processing') )
						return false;

					var d=this, uri=$(this).attr('href'), postID=$(this).data('postid');

					$(this).addClass('processing');
					$('<img class="ajx-preloader-fb" src="'+socbet.preloader+'" alt="" />').appendTo( $(this) );

					if ( $(this).hasClass('all') ) {
						$.get( uri, { showcomments : '1' }, function(data){
							var comm = $("#timeline-comment-lists-"+postID, data)[0].innerHTML,
								aHtml = $("#tm-get-all-comments-"+postID, data)[0].innerHTML;

							$("#timeline-comment-lists-"+postID).html(comm);
							$(d).removeClass('all').removeClass('processing').html(aHtml);
							$(window).trigger('resize');
							trashComment();
						});
					} else {
						$.get( uri, '', function(data){
							var comm = $("#timeline-comment-lists-"+postID, data)[0].innerHTML,
								aHtml = $("#tm-get-all-comments-"+postID, data)[0].innerHTML;

							$("#timeline-comment-lists-"+postID).html(comm);
							$(d).addClass('all').removeClass('processing').html(aHtml);
							$(window).trigger('resize');
							trashComment();
						});
					}
				});
			});
		}
	}



	function ajaxifyForm() {

		if ( $('form.ajaxify').length ) {
			$('form.ajaxify').each( function() {
				var d=this, ref = $(this).data('reload');

				$(d).unbind().on('submit', function(e){
					e.preventDefault();

					if ( $(this).hasClass('processing') )
						return false;

					$(this).addClass('processing');

					$(d).ajaxSubmit({
						type: 'POST',
						dataType: 'json',
						url: socbet.ajax_url,
						error: function ( XMLHttpRequest, textStatus, errorThrown ) {
							$(d).removeClass('processing');
							return false;
						},
						success: function ( resp ) {
							$(d).removeClass('processing');
							if ( resp.err === 'yes' ) {
								if ( typeof resp.redirect !== 'undefined' ) {
									window.location.replace( resp.url );
									return false;
								}
								
								return false;
							} else {
								
								if( $(d).parent().find('.md-close').length ) {
									$(d).parent().find('.md-close').click();
								}

								if ( ref ) {
									setTimeout( function(){
										window.location.reload();
									}, 500);
								}
							}
						}			
					});
				});
			});
		}
	}


	function trashComment() {
		if ( $('.timeline-remove-comment').length ) {
			$('.timeline-remove-comment').each( function() {
				var trc=$(this), cid = $(this).data('cid');

				trc.unbind().on( 'click', function(e) {
					e.preventDefault();

					if ( $(this).hasClass('onprocess') )
						return false;

					$(this).addClass('onprocess');

					if ( $('#delete-comment-trash-'+cid).length ) {
						$('#delete-comment-trash-'+cid).trigger('submit');
					}
				});

				$('#delete-comment-trash-'+cid).unbind().on('submit', function(e){
					e.preventDefault();
					var pid = $(this).data('timelineid');

					$(this).ajaxSubmit({
						type: 'POST',
						dataType: 'json',
						url: socbet.ajax_url,
						error: function ( XMLHttpRequest, textStatus, errorThrown ) {
							trc.removeClass('onprocess');
							return false;
						},
						success: function ( resp ) {
							trc.removeClass('onprocess');
							if ( resp.err === 'yes' ) {
								if ( typeof resp.redirect !== 'undefined' ) {
									window.location.replace( resp.url );
									return false;
								}
								
								return false;
							} else {
								$('#timeline-comment-'+cid).fadeOut(250);

								if( parseInt( resp.number ) > 1 ) {
									if( $('#tm-get-all-comments-'+pid).hasClass('all') ) {
										$('#tm-get-all-comments-'+pid).removeClass('all');
									} else {
										$('#tm-get-all-comments-'+pid).addClass('all');
									}
									$('#tm-get-all-comments-'+pid).trigger('click');
								} else {
									$.get( resp.url , '', function(data){
										var comm = $("#timeline-comment-lists-"+pid, data)[0].innerHTML;

										$("#timeline-comment-lists-"+pid).html(comm);
										$('#timeline-comments-'+pid).find('.more-comment').remove();
										$(window).trigger('resize');
										trashComment();
									});		
								}

								$('.timelines-comments-number-count-'+pid).each(function(){
									$(this).html( resp.number );
								})
							}
						}			
					});
				});
			});
		}
	}


	function userEnterCompetition() {
		var btn = $('.ajax-trigger-enter-competition'), form = btn.next('.ajax-enter-competition-form');

		if ( btn.length ) {
			btn.unbind().on( 'click', function() {
				if ( ! $(this).hasClass('onProcess') ) {
					$(this).addClass('onProcess');
					form.trigger('submit');
				}
			});

			form.unbind().on( 'submit', function(e) {
				e.preventDefault();
				$(this).ajaxSubmit({
					url : socbet.ajax_url,
					dataType: 'json',
					type: 'POST',
					success: function( resp ) {
						btn.removeClass('onProcess');

						$( '.md-overlay' ).trigger('click');
						if ( resp.err === 'yes' ) {
							$('.trigger-compettion-error').trigger('click');
							return false;
						} else {
							$('.hidden-after-ajax').hide();
							$('.show-after-ajax').show();
							$('.trigger-compettion-success').trigger('click');
							return false;
						}
					}
				});
			});
		}
	}


	function userQuitCompetition() {
		var btn = $('.ajax-trigger-quit-competition'), form = btn.parent().next('.ajax-quit-competition-form');

		if ( btn.length ) {
			btn.unbind().on( 'click', function(e) {
				e.preventDefault();
				if ( ! $(this).hasClass('onProcess') ) {
					$(this).addClass('onProcess');
					form.trigger('submit');
				}
			});

			form.unbind().on( 'submit', function(e) {
				e.preventDefault();
				$(this).ajaxSubmit({
					url : socbet.ajax_url,
					dataType: 'json',
					type: 'POST',
					success: function( resp ) {
						var pp = $('#competition-'+form.find('input[name="competition_id"]').val() );
						btn.removeClass('onProcess');

						if ( resp.err === 'yes' ) {
							if ( typeof resp.redirect !== 'undefined' ) {
								window.location.replace( resp.url );
								return false;
							}
							
							alert( socbet.messages.upload_error );
							return false;	
						} else {


							pp.stop(true,true).fadeOut( 300, function(){
								window.location.reload();
							});
						}

					}
				});
			});
		}
	}



	function userFollowprocess() {
		var btn = $('#triger-follow-user'), ff = $('#form-ajx-follow');

		if ( btn.length && ff.length ) {

			btn.unbind().on( 'click', function(e){
				e.preventDefault();

				if ( btn.hasClass('processing') )
					return false;

				btn.addClass('processing');
				ff.trigger('submit');
			});

			ff.unbind().on('submit', function(e){
				e.preventDefault();

				$(this).ajaxSubmit({
					url : socbet.ajax_url,
					dataType: 'json',
					type: 'POST',
					success: function( resp ) {
						btn.removeClass('processing');				
						
						if ( resp.err === 'yes' ) {
							if ( typeof resp.redirect !== 'undefined' ) {
								window.location.replace( resp.url );
								return false;
							}

							alert( socbet.messages.upload_error );
							return false;	
						} else {
							var baseUrl = document.location.href,
								curButton = $("#press-to-follow");
							
							$.get( baseUrl, '', function(data){
								var newItem = $("#press-to-follow", data);

								$(newItem).insertAfter( curButton );
								curButton.remove();
								$('#modal-user-follow').find('.md-close').trigger('click');

							});

							return false;	
						}
					}
				});
			});
		}
	}


	function userBlockedprocess() {
		var btn = $('#triger-block-user'), ff = $('#form-ajx-block');

		if ( btn.length && ff.length ) {

			btn.unbind().on( 'click', function(e){
				e.preventDefault();

				if ( btn.hasClass('processing') )
					return false;

				btn.addClass('processing');
				ff.trigger('submit');
			});

			ff.unbind().on('submit', function(e){
				e.preventDefault();

				$(this).ajaxSubmit({
					url : socbet.ajax_url,
					dataType: 'json',
					type: 'POST',
					success: function( resp ) {
						btn.removeClass('processing');				
						
						if ( resp.err === 'yes' ) {
							if ( typeof resp.redirect !== 'undefined' ) {
								window.location.replace( resp.url );
								return false;
							}

							alert( socbet.messages.upload_error );
							return false;	
						} else {
							var baseUrl = document.location.href,
								curButton = $("#press-to-block");
							
							$.get( baseUrl, '', function(data){
								var newItem = $("#press-to-block", data);

								$(newItem).insertAfter( curButton );
								curButton.remove();
								$('#modal-block-user').find('.md-close').trigger('click');

							});

							return false;	
						}
					}
				});
			});
		}
	}

	function userPhotoUploader() {
		var btn=$('#user-photo-trigger');

		if ( btn.length ) {
			btn.unbind().on( 'click', function() {
				
				if ( ! $(this).hasClass('onProcess') )
					$('input[name="user-photo"]').length && $('input[name="user-photo"]').trigger('click');
				else
					alert( socbet.messages.onprocess );
			
			});

			if ( $('input[name="user-photo"]').length ) {
				var form = $('.user-change-photo'), field = $('input[name="user-photo"]'), curText = $('#user-photo-text').html();
				field.unbind().on( 'change', function() {
					form.trigger('submit');
				});

				form.unbind().on( 'submit', function(e) {
					e.preventDefault();
					$(this).ajaxSubmit({
						url : socbet.ajax_url,
						dataType: 'json',
						beforeSubmit: checkBeforeUpload,
						resetForm: true,
						type: 'POST',
						uploadProgress: function(event, position, total, percentComplete) {
							var percentVal = percentComplete + '%';
							$('#user-photo-text').show();
							if ( parseInt(percentComplete) > 98 ) {
								$('#user-photo-text').html( 'Please wait..' );
							} else {
								$('#user-photo-text').html( percentVal );
							}
						},
						success: function( resp ) {
							$('#user-photo-text').html( curText ).removeAttr('style');
							$('#user-photo-trigger').removeClass('onProcess');				
							
							if ( resp.err === 'yes' ) {
								alert( socbet.messages.upload_error );
								return false;	
							} else {

								$('#usr-img-box').css({ backgroundImage : 'url("'+resp.imgUrl+'")' });
								window.setTimeout( function(){
									window.location.reload();
								}, 250);

							}
						}
					});
				});
			}
		}

		if ( $('#form-ajx-group-thumbnail').length ) {
			var g_form = $('#form-ajx-group-thumbnail');

			g_form.find('input[type="file"]').unbind().on( 'change', function() {
				if ( $(this).val() !== "" ) {
					g_form.trigger('submit');
				}
			});

			g_form.unbind().on('submit', function(e){
				e.preventDefault();
				var btText = $('#group-thumbnail-trigger-upload').find('.up-text').html(),
					group_id = g_form.find('input[name="group_id"]').val();

				$(this).ajaxSubmit({
					url : socbet.ajax_url,
					dataType: 'json',
					beforeSubmit: function(){
						if ( window.File && window.FileReader && window.FileList && window.Blob ) {
							var fsize = g_form.find('input[type="file"]')[0].files[0].size; //get file size
				        	var ftype = g_form.find('input[type="file"]')[0].files[0].type;

				        	switch(ftype) {
				        		case 'image/png':
				        		case 'image/gif':
				        		case 'image/jpeg':
				        		case 'image/pjpeg':
				        			break;
				        		default:
				        			$('#group-thumbnail-trigger-upload').removeClass('onProcess');
									alert( socbet.messages.unsupported_file_type );
									return false;
				        			break;
				        	}

				        	$('#group-thumbnail-trigger-upload').addClass('onProcess');
						} else {
							$('#group-thumbnail-trigger-upload').removeClass('onProcess');
							alert( socbet.messages.unsupported_browser );
							return false;
						}
					},
					resetForm: true,
					type: 'POST',
					uploadProgress: function(event, position, total, percentComplete) {
						var percentVal = percentComplete + '%';
						
						if ( parseInt(percentComplete) > 98 ) {
							$('#group-thumbnail-trigger-upload').find('.up-text').html( 'Please wait..' );
						} else {
							$('#group-thumbnail-trigger-upload').find('.up-text').html( percentVal );
						}
					},
					success: function( resp ) {
						$('#group-thumbnail-trigger-upload').find('.up-text').html( btText );
						$('#group-thumbnail-trigger-upload').removeClass('onProcess');				
						
						if ( resp.err === 'yes' ) {
							alert( socbet.messages.upload_error );
							return false;	
						} else {
							$('.group-thumbnail-'+group_id).each( function(){
								$(this).attr( 'src', resp.imgUrl );
							});
						}
					}
				});
			});
		}

		if ( $('#form-ajx-group-image').length ) {
			var gi_form = $('#form-ajx-group-image');

			gi_form.find('input[type="file"]').unbind().on( 'change', function() {
				if ( $(this).val() !== "" ) {
					gi_form.trigger('submit');
				}
			});

			gi_form.unbind().on('submit', function(e){
				e.preventDefault();
				var btText = $('#group-image-trigger-upload').find('.up-text').html(),
					group_id = gi_form.find('input[name="group_id"]').val();

				$(this).ajaxSubmit({
					url : socbet.ajax_url,
					dataType: 'json',
					beforeSubmit: function(){
						if ( window.File && window.FileReader && window.FileList && window.Blob ) {
							var fsize = gi_form.find('input[type="file"]')[0].files[0].size; //get file size
				        	var ftype = gi_form.find('input[type="file"]')[0].files[0].type;

				        	switch(ftype) {
				        		case 'image/png':
				        		case 'image/gif':
				        		case 'image/jpeg':
				        		case 'image/pjpeg':
				        			break;
				        		default:
				        			$('#group-image-trigger-upload').removeClass('onProcess');
									alert( socbet.messages.unsupported_file_type );
									return false;
				        			break;
				        	}

				        	$('#group-image-trigger-upload').addClass('onProcess');
						} else {
							$('#group-image-trigger-upload').removeClass('onProcess');
							alert( socbet.messages.unsupported_browser );
							return false;
						}
					},
					resetForm: true,
					type: 'POST',
					uploadProgress: function(event, position, total, percentComplete) {
						var percentVal = percentComplete + '%';
						
						if ( parseInt(percentComplete) > 98 ) {
							$('#group-image-trigger-upload').find('.up-text').html( 'Please wait..' );
						} else {
							$('#group-image-trigger-upload').find('.up-text').html( percentVal );
						}
					},
					success: function( resp ) {
						$('#group-image-trigger-upload').find('.up-text').html( btText );
						$('#group-image-trigger-upload').removeClass('onProcess');				
						
						if ( resp.err === 'yes' ) {
							alert( socbet.messages.upload_error );
							return false;	
						} else {
							$('#group-top-img').css({backgroundImage: 'url('+resp.imgUrl+')'});
						}
					}
				});
			});
		}
	}


	function checkBeforeUpload() {
		if ( window.File && window.FileReader && window.FileList && window.Blob ) {
			var fsize = $('input[name="user-photo"]')[0].files[0].size; //get file size
        	var ftype = $('input[name="user-photo"]')[0].files[0].type;

        	switch(ftype) {
        		case 'image/png':
        		case 'image/gif':
        		case 'image/jpeg':
        		case 'image/pjpeg':
        			break;
        		default:
					alert( socbet.messages.unsupported_file_type );
					return false;
        			break;
        	}

        	// check the image size, maximum for user photo is 500kb
        	if ( fsize>500000 ) {
				alert( socbet.messages.file_too_big );
				return false;
        	}

        	$('#user-photo-trigger').addClass('onProcess');
		} else {
			alert( socbet.messages.unsupported_browser );
			return false;
		}
	}


	function paginateOnScroll() {
		if ( $('.loads-more-page').length ) {
			var pagenow = parseInt( $('.loads-more-page').data('page') ), maxpages = parseInt( $('.loads-more-page').data('maxpages') ), loadsprocess=false;
			$(window).on( 'scroll', function() {
				if ( $(window).scrollTop() + $(window).height() == $(document).height() ) {
					if ( !loadsprocess && pagenow < maxpages ) {
						loadsprocess = true;
						$('.loads-more-page').fadeIn(250, function() {
							var baseUrl = document.location.href;
							$(window).trigger('resize');
							$.get( baseUrl, { paged : pagenow+1 }, function(data){
								var newItem = $("#user-status-wrapper", data)[0].innerHTML;

								$(newItem).imagesLoaded( function(){
									$(newItem).css({display:'none'});
									pagenow = pagenow+1;
									$('.loads-more-page').data('page', pagenow).hide();
									$('#user-status-wrapper').append($(newItem));
									$(newItem).fadeIn(300, function() {
										timelinesImages();
										timelineComments();
										userVotedPoll();
										triggerLikesDislikes();

										loadsprocess = false;
										$(window).trigger('resize');
									});
								});
							});
						});
					}
				}
			});

		}
	}


	function bindGlobalAjax() {
		var btn = $('.ajx-form-call');

		btn.each( function(){
			var b=this, form = $(this).data('form'), type = $(this).data('form-type');
			$(b).unbind().on('click', function(e){
				e.preventDefault();
				if ( $(this).hasClass('onProcess') )
					return false;

				if ( $('#'+form).length ) {
					if ( type === 'upload' ) {
						$('#'+form).find('input[type="file"]').trigger('click');
					}
				}
			});
		});
	}

	$( document ).ready(function(){
		$("#red").treeview({
			animated: "fast",
			collapsed: true,
			control: "#treecontrol",
			unique: true
		});
		$('.bets input, .form-box input').iCheck({
		    checkboxClass: 'icheckbox_minimal',
		    radioClass: 'iradio_minimal',
		    increaseArea: '20%' // optional
		  });
		$(".mob-head").click(function(){
			event.preventDefault();
		})
		
		bindModuleEventHandlers();

		$('[data-endtimes]').each(function() {
			var $this = $(this), finalDate = $this.data('endtimes');
			//console.log( finalDate );
			if ( finalDate !== null ) {
				$this.countdown(finalDate, function(event) {
					$this.find('.days').find('em').html( event.strftime('%D') );
					$this.find('.hours').find('em').html( event.strftime('%H') );
					$this.find('.min').find('em').html( event.strftime('%M') );
					$this.find('.sec').find('em').html( event.strftime('%S') );
				});
			}
		});

		userPhotoUploader();
		userEnterCompetition();
		userQuitCompetition();
		userPostNewStatus();
		timelinesImages();
		timelineComments();
		userVotedPoll();
		triggerLikesDislikes();
		triggerReplyMsg();
		userFollowprocess();
		userBlockedprocess();
		ajaxifyForm();
		bindGlobalAjax();
		
	});

	$( window ).on( 'load', function() {
		$(".left-container-wrapper").css({ minHeight : '' });
		$('.middle-container-wrapper').css({ minHeight : '' });
		$('.middle-container-wrapper-1col').css({ minHeight : '' });
		$('.middle-container-wrapper-2col-wide, .middle-container-wrapper-2col').css({ minHeight : '' });
		$('.right-container-wrapper').css({ minHeight : ''});

		$(".left-sidebar").css("height","auto");
		$(".left-gutter").css("height","auto");
		$(".left-container-wrapper").css("height","auto");
		$(".middle-container-wrapper-1col").css("height","auto");
		$(".middle-container-wrapper-2col-wide, .middle-container-wrapper-2col").css("height","auto");
		$(".right-container-wrapper").css("height","auto");

		bindModuleEventHandlers();
		paginateOnScroll();
		tamingselect();
	});

	$( window ).on('resize', function() {

		$(".left-container-wrapper").css({ minHeight : '' });
		$('.middle-container-wrapper').css({ minHeight : '' });
		$('.middle-container-wrapper-1col').css({ minHeight : '' });
		$('.middle-container-wrapper-2col-wide, .middle-container-wrapper-2col').css({ minHeight : '' });
		$('.right-container-wrapper').css({ minHeight : ''});
		$(".left-sidebar").css("height","auto");
		$(".middle-container-wrapper").css("height","auto");
		$(".left-gutter").css("height","auto");
		$(".left-container-wrapper").css("height","auto");
		$(".middle-container-wrapper-1col").css("height","auto");
		$(".middle-container-wrapper-2col-wide, .middle-container-wrapper-2col").css("height","auto");
		$(".right-container-wrapper").css("height","auto");

		rtime = new Date();
	    if (timeout === false) {
	        timeout = true;
	        setTimeout(resizeend, delta);
	    }

		var window_width=$(window).width();
		//add classes
		if(window_width<=414){
			$("body").removeClass("mobile").removeClass("big-mobile").removeClass("tab-portrait").removeClass("tab-landscape");
			$("body").addClass("mobile");
		}
		else if(window_width>=415 && window_width<=767){
			$("body").removeClass("mobile").removeClass("big-mobile").removeClass("tab-portrait").removeClass("tab-landscape");
			$("body").addClass("big-mobile");
		}
		else if(window_width>=768 && window_width<=968){
			$("body").removeClass("mobile").removeClass("big-mobile").removeClass("tab-portrait").removeClass("tab-landscape");
			$("body").addClass("tab-portrait");
		}
		else if(window_width>=969 && window_width<=1189){
			$("body").removeClass("mobile").removeClass("big-mobile").removeClass("tab-portrait").removeClass("tab-landscape");
			$("body").addClass("tab-landscape");
		}
		else $("body").removeClass("mobile").removeClass("big-mobile").removeClass("tab-portrait").removeClass("tab-landscape");


		// if($("body").hasClass("mobile")){
		// 	$(".left-sidebar").css("margin-left","");
		// }
		if ($("body").hasClass("big-mobile")) {
			$(".overlay").css("display","none");
			$(".left-sidebar").css("margin-left","");
			$(".right-top-container, .main-container").animate({"margin-left":"0"},0);
		}


		bindModuleEventHandlers();


	});

})( window.jQuery );