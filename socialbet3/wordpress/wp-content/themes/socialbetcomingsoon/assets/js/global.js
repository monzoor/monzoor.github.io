var sb = sb || {};

sb.ui = function () {
  "use strict";
  var Modernizr = window.Modernizr;
  return {
    getSupportedCss: function () {
      return Modernizr.csstransforms3d ? 'transform3D' : (Modernizr.csstransforms ? 'transform' : '');
    },
    isMobile: function () {
      return jQuery.browser.mobile;
    },
    isTouch: function () {
      return Modernizr.touch;
    }
  };
}();


sb.glob = function (b, u) {
  "use strict"; /*jshint validthis:true, laxcomma:true, expr:true*/
  var document = window.document;
  var g = {
  	isMobile: u.isMobile(),
    ticker: false,
  	init: function() {
  		var d=this;

  		d.mainBg();
  		b(document).ready( function() {
  			d.ajaxProp();
        if ( b("#flip-count").length ) {
          d.flipNumber();
        }
  		});
      b(window).on('TickerStop', function() {
        d.getAjax();
      });
  	},
    flipNumber : function() {
      var d=this, k;

      d.ticker = b('.tick').ticker({
        separators: true,
        autostart : false,
        onStop: function() {
          //console.log('stoped');
          d.getAjax();
        }
      });
      d.getAjax();

    },
    getAjax: function() {
      var d=this;

      //console.log('doing interval');
      if( d.ticker[0].running )
        return;

      b.get( socbet.home_uri, '', function(res){
        var valSubs = b("#flip-count", res).data('counted');
        //console.log('getting result: '+valSubs);
        if ( b("#flip-count").data('counted') !== valSubs ) {
          b("#flip-count").data('counted', valSubs );
         // console.log( b("#flip-count").data('counted') );
          d.ticker[0].goTotick( valSubs );
        }

        setTimeout( function(){ d.getAjax() }, 50000);

      });
    },
  	ajaxProp: function() {
  		var d=this, sf=b('#subscribe-form');

  		if(sf.length) {
  			sf.unbind().on('submit', function(e) {
  				e.preventDefault();

  				if( b('input[name=subscribe_email]').val() == "" ) {
  					d.showNoticeEmailError('blank');
  					return false;
  				}

  				b('#form-loading').remove();
  				var loading = b('<div id="form-loading" />').appendTo(sf);


  				b.ajax({
  					url : socbet.ajax_url,
  					type : 'POST',
  					data: b(this).serialize(),
  					success: function( data, textStatus, jQxhr ) {
  						b('#form-loading').fadeOut();
  						if( data == '400' ) {
  							d.showNoticeEmailError('invalid');
  							b('input[name=subscribe_email]').val('');
  							return false;
  						} else if( data == '300' ) {
  							d.showNoticeEmailError('blank');
  							b('input[name=subscribe_email]').val('');
  							return false;
  						} else if( data == '150' ) {
  							d.showNoticeEmailError('duplicated');
  							b('input[name=subscribe_email]').val('');
  							return false;
  						} else if( data == '250' ) {
  							d.showNoticeEmailError('fatal');
  							b('input[name=subscribe_email]').val('');
  							return false;
  						} else if( data == '200' ) {
                ga( 'send', 'event', 'subscribe', 'submit' );
  							b('#second-content').css({display:'block', opacity: 0, scale:0});
  							b('#first-content').transition({opacity:0, scale: 0}, 300, 'easeOutSine', function() {
  								b('#first-content').remove();
  								b('#second-content').transition({opacity: 1, scale: 1}, 300, 'easeOutSine');
  								return false;
  							});
  						}
  					},
  					error: function( jqXhr, textStatus, errorThrown ){
  						b('#form-loading').fadeOut();
  						//console.log( errorThrown );
							d.showNoticeEmailError('fatal');
							b('input[name=subscribe_email]').val('');
							return false;
  					}
  				});

  			});
  		}

  	},
  	showNoticeEmailError: function( type ) {
  		var d=this, ht, errMsg;

  		switch( type ) {
  			case 'blank':
  				errMsg = socbet.email_required;
  				break;
  			case 'invalid':
  				errMsg = socbet.email_invalid;
  				break;
  			case 'duplicated':
  				errMsg = socbet.email_duplicated;
  				break;
  			case 'fatal':
  				errMsg = socbet.fatal;
  				break;
  		}

  		ht = '<div class="error-message" style="display:none">'+errMsg+'</div>';

  		if( b('.error-message').length ) {
  			b('.error-message').remove();
  		}

  		b(ht).insertBefore( b('input[name=subscribe_email]') );

  		b('.error-message').css({opacity: 0, display:'block', bottom: '150px'}).transition({opacity: 1, bottom: '60px'}, 300, 'easeOutSine', function() {
  			b('input[name=subscribe_email]').unbind().on('focus', function() {
  				b('.error-message').transition({opacity:0, bottom:'150px'}, 300, 'easeOutSine', function() {
  					b(this).css({display: 'none'});
  				});
  			});
  		});

  	},
  	mainBg : function() {
			var n = {
				img: socbet.main_bg,
				bgW: socbet.bg_width,
				bgH: socbet.bg_height,
				nimg : false,
				init: function() {
					var md=this, ws;

					this.nimg = new Image();
					b(this.nimg).attr('src', md.img ).appendTo(b('#site-main-bg'));

					b(document).ready( function() {
						md.objRes();
					});

					b(window).on( 'load', function() {
						md.objRes();
					});

					b(window).on( 'resize', function() {
						md.objRes();
					});
				},
				objRes:function() {
					var md=this, ws
					, tr=md.bgH/md.bgW
          , destinationH = md.bgH
          , destinationW = md.bgW
          , imageLeft = 0
          , imageTop = 0;

					ws=g.getWindowSize();

		      if( (ws.height/ws.width) > tr ){
		        destinationH = ws.height;
		        destinationW = ws.height / tr;
		      } else {
		        destinationW = ws.width;
		        destinationH = ws.width * tr;
		      }

		      imageLeft = (ws.width-destinationW)/2+'px';
		      imageTop = (ws.height-destinationH)/2+'px';

		      b(md.nimg).css({ 
		      	width : destinationW+'px', 
		      	height: destinationH+'px',
		      	x: imageLeft,
		      	y: 0
		      });

		      b('#parallax-overlay').find('img').each(function() {
			      b(this).css({ 
			      	width : destinationW+'px', 
			      	height: destinationH+'px',
			      	x: imageLeft,
			      	y: 0,
			      	marginLeft : 0,
			      	marginTop : 0
			      });
		      });

					if( ws.width > 768 ) {
						b('#parallax-overlay').addClass('need-for-parallax');
						md.doParallax();
					} else {
						b('#parallax-overlay').removeClass('need-for-parallax');
						b('body').unbind('mousemove');
					}

				},
				doParallax: function() {
					var md=this, par=b('#parallax-overlay');

					b('body').on('mousemove', function(e){
							/* Work out mouse position */
							var offset = par.offset();
							var xPos = e.pageX - offset.left;
							var yPos = e.pageY - offset.top;

							/* Get percentage positions */
							var mouseXPercent = Math.round(xPos / par.width() * 100);
							var mouseYPercent = Math.round(yPos / par.height() * 100);
							var Horsex = xPos-(par.width()/2);

							/* Position Each Layer */
							par.children('img').each(
								function(){
									var cssObj = {
										'margin-left': 1.5*mouseXPercent + 'px',
										'margin-top': 1.5*mouseYPercent + 'px'
									}

									if( b(this).hasClass('horse1') || b(this).hasClass('horse2') ) {
										cssObj = {
											'margin-left': Horsex/20 + 'px',
											'margin-top': '0px'
										}
										if( b(this).hasClass('horse2') ) {
											cssObj = {
												'margin-left': -1*(Horsex/20) + 'px',
												'margin-top': '0px'
											}
										}
									} else {
										if( b(this).hasClass('snow1') ) {
											cssObj = {
												'margin-left': -1.5*mouseXPercent + 'px',
												'margin-top': -1.5*mouseYPercent + 'px'
											}
										}
									}

									b(this).animate(cssObj, {duration: 400, queue: false, easing: 'linear'} );

								}
							);

						}
					);

				}
			};
      n.init();
      return n;
  	},
    getWindowSize: function () {
      var a = {
        width: !1,
        height: !1
      };
      "undefined" !== typeof window.innerWidth ? a.width = window.innerWidth : "undefined" !== typeof document.documentElement && "undefined" !== typeof document.documentElement.clientWidth ? a.width = document.documentElement.clientWidth : "undefined" !== typeof document.body && (a.width = document.body.clientWidth);
      "undefined" !== typeof window.innerHeight ? a.height = window.innerHeight : "undefined" !== typeof document.documentElement && "undefined" !== typeof document.documentElement.clientHeight ? a.height = document.documentElement.clientHeight : "undefined" !== typeof document.body && (a.height = document.body.clientHeight);
      return a;
    },
    getElemSize: function(m) {
      var d=this, el=b(m)[0], a = { width: !1, height: !1 };

      if( b(m).length < 1 ) return a;

      a.width = el.offsetWidth;
      a.height = el.offsetHeight;

      return a;
    },
  };
  g.init();
  return g;
}(window.jQuery, sb.ui);
