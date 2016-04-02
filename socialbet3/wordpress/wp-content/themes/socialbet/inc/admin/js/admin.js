var document = window.document;

( function( $ ) {

	var dateTimerDo = function() {
		var dt = $('.date-time-picker');

		if( dt.length > 0 ) {
			dt.each( function() {
				$(this).datetimepicker({
					dateFormat : 'yy-mm-dd'
				});
			});
		}
	};

	$(document).ready( function() {
		dateTimerDo();
	});

})( window.jQuery );


var socbetadmin = socbetadmin || {};
socbetadmin.global = function(b) {
	var g = {
		init : function () 
		{
			var d=this;

			b(document).ready( function () 
			{

				d.triggerActions();

			});
		},

		triggerActions : function () {
			var d=this;

			d.EventMarketEntries();

		},

		EventMarketEntries : function () {
			var d=this, checked=b('#market-entries-wrap');

			d.triggerLinks();

			if( checked.length > 0 ) 
			{
				var btSubmit=b('#add-new-market-entry'), inputs = [];

				b('#market-entries-form').find('input').each( function() {
					inputs.push( this );
				});

				btSubmit.unbind().on( 'click', function(e) 
				{
					e.preventDefault();

					var pusherror = false;

					b.each( inputs, function( i, item ) {

						if( i < 3 && b(this).val() == "" )
							pusherror = true; 
					
					});

					if( pusherror ) {
						alert( sbL10n.errorMarketEntry );
						return;
					}

					var tHtml = '<tr>\
					<td class="column-entry-name">'+ b(inputs[0]).val() +'</td>\
					<td class="column-entry-odds">'+ b(inputs[1]).val() +'</td>\
					<td class="column-entry-decimal-odds">'+ b(inputs[2]).val() +'</td>\
					<td class="column-entry-price">'+ b(inputs[3]).val() +'</td>\
					<td class="column-entry-action">\
					<a href="#" class="entry-inline-edit">'+ sbL10n.edit +'</a>\
					| <a href="#" class="entry-inline-remove">'+ sbL10n.delete +'</a></td></tr>\
					<tr class="edit_event_entry"><td colspan="5">\
					<div class="col-wrap">\
					<div class="col-md-3"><input type="text" name="mentry_name[]" value="'+ b(inputs[0]).val() +'" /></div>\
					<div class="col-md-3"><input type="text" name="mentry_odds[]" value="'+ b(inputs[1]).val() +'" /></div>\
					<div class="col-md-3"><input type="text" name="mentry_decimal_odds[]" value="'+ b(inputs[2]).val() +'" /></div>\
					<div class="col-md-3"><input type="number" name="mentry_price[]" value="'+ b(inputs[3]).val() +'" /></div>\
					</div><p class="text-right"><a href="#" class="button button-primary update-entry-data">'+ sbL10n.saveChanges +'</a></p></td></tr>';

					b('#socbet-noentry').not(':hidden') && b('#socbet-noentry').fadeOut(200);

					b(tHtml).insertBefore(b('#socbet-noentry'));
					b(inputs[0]).val('');
					b(inputs[1]).val('');
					b(inputs[2]).val('');
					b(inputs[3]).val('');

					d.EventMarketEntries();
				});

			}
		},

		triggerLinks : function () 
		{
			var d=this;

			if( b('.entry-inline-edit').length ) {
				b('.entry-inline-edit').each( function() {
					b(this).unbind().on('click', function(e) {
						e.preventDefault();

						var target= b(this).parent().parent().next('.edit_event_entry');

						b(target).is(':hidden') ? b(target).fadeIn() : b(target).fadeOut();
					});
				});			
			}


			if( b('.entry-inline-remove').length ) {
				b('.entry-inline-remove').each( function() {
					b(this).unbind().on('click', function(e) {
						e.preventDefault();

						var target= b(this).parent().parent().next('.edit_event_entry'), selfTarget = b(this).parent().parent();

						b(target).not(':hidden') && b(target).hide();

						b(selfTarget).fadeOut(200,function(){
							b(target).remove();
							b(selfTarget).remove();

							if( b('#the-list-markets').find('tr').length < 2 ) {
								b('#socbet-noentry').is(':hidden') && b('#socbet-noentry').fadeIn(200);
							}
						});
					});
				});	
			}

			if( b('.update-entry-data').length ) {
				b('.update-entry-data').each( function() {
					var k=this, target= b(this).parent().parent().parent().prev('tr'), selfPar=b(this).parent().parent().parent(),inputs= [];
						
						b(k).parent().parent().find('input').each( function() {
							inputs.push( this );
						});

					b(k).unbind().on('click', function(e) {
						e.preventDefault();

						var pusherror = false;

						b.each( inputs, function( i, item ) {

							if( i < 3 && b(this).val() == "" )
								pusherror = true; 
						
						});

						if( pusherror ) {
							alert( sbL10n.errorMarketEntry );

							b(inputs[0]).val( b(target).find('td.column-entry-name').text() );
							b(inputs[1]).val( b(target).find('td.column-entry-odds').text() );
							b(inputs[2]).val( b(target).find('td.column-entry-decimal-odds').text() );
							b(inputs[3]).val( b(target).find('td.column-entry-price').text() );

							return;
						}

						b(target).find('td.column-entry-name').text( b(inputs[0]).val() );
						b(target).find('td.column-entry-odds').text( b(inputs[1]).val() );
						b(target).find('td.column-entry-decimal-odds').text( b(inputs[2]).val() );
						b(target).find('td.column-entry-price').text( b(inputs[3]).val() );

						b(selfPar).fadeOut();

					});
				});
			}

		}
	};
	g.init();
	return g;
}( window.jQuery );