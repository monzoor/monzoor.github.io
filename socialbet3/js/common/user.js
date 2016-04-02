
var bindModuleEventHandlers = function () {
	var WindowWidth = $(window).width();
	

	var window_width=$(window).width();
	var window_height=$(window).height();
	var doc_height=$(".main-container").height();

	// Left gutter Height
	setTimeout(function(){
		var DocumentHeight = $(document).height();
		(DocumentHeight < 300) ? 
			$(".left-gutter").css("height",700+"px") :
			($(".left-gutter").css("height",DocumentHeight+"px"),
			$(".left-sidebar").css("height",DocumentHeight+"px"),
			$(".right-container-wrapper,.right-container-wrapper-2col, .middle-container-wrapper-2col-wide").css("height",(DocumentHeight-76)+"px"),
			$(".left-container-wrapper").css("height",(DocumentHeight-54)+"px")
			)
	},500)


	// top navigation fix for mobile
	var TopNavDOM = $(".top-navigation-wrapper .mob-view ul");
	
	(WindowWidth <= 767) ? 
		TopNavDOM.css('visibility','hidden') : 
		TopNavDOM.css('visibility','visible');

	// Grid and List View
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


	$(".write-post-wrapper .writing-post .attach ul.attach-menu li").click(function(){
		event.preventDefault();
		($(".write-post-wrapper .writing-post .attach ul.attach-menu li ul.options").css("visibility") === "hidden") ?
			(
				$(this).css("background-color", "#ffffff"),
				$(this).children("ul").css("top","-150px"),
				$(this).children("ul").css("width","143px"),
				$(".write-post-wrapper .writing-post .attach ul.attach-menu li ul.options").css("visibility","visible")
				) :
			(
				$(this).css("background-color", "transparent"),
				$(".write-post-wrapper .writing-post .attach ul.attach-menu li ul.options").css("visibility","hidden")
				)
	})

	// Select 1
	$("#e1").select2({
		placeholder: "Select a State"
	});

	// accordion
	$( ".actual-events" ).accordion({
      heightStyle: "content"
    });

	// Tabs
	$( "#tabs" ).tabs();
	$( "#tabs2" ).tabs();
	$( "#tabs3" ).tabs({ active: 1 });

// ######################################################


	// var maxHeight = 0;
	// $('.profile-groups-wrapper .groups-wrapper li')
	//   .each(function() { maxHeight = Math.max(maxHeight, $(this).height()); })
	//   .height(maxHeight);

	
	var middle_height=$(".middle-container-wrapper").height();
	var middle_height_2col_wide=$(".middle-container-wrapper-2col-wide").height();


		//console.log(doc_height);
		//console.log(middle_height);
		//console.log(middle_height_2col_wide);
	// if(middle_height<=doc_height){
	// 	$(".middle-container-wrapper").css("height",doc_height-40+"px");
	// }
	// if(middle_height_2col_wide<=doc_height){
	// 	$(".middle-container-wrapper-2col-wide").css("height",window_height-40+"px");
	// }
	// var doc_height=$(".main-container").height();
	//console.log(doc_height);

	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~



	//$(".left-sidebar").css("height",doc_height+54+"px");
	//$(".left-container-wrapper").css("height",doc_height+"px");
	//$(".right-container-wrapper").css("height",doc_height-20+"px");

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
				$(".overlay").css("height",doc_height+"px");
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
	if($(".profile-competition-wrapper").length()<0){
		$('.competition-box-wrapper li')
		    .each(function() { maxHeight = Math.max(maxHeight, $(this).height()); })
		    .height(maxHeight);
		

		    $.fn.equalizeHeights = function(){
			  return this.height( Math.max.apply(this, $(this).map(function(i,e){ return $(e).height() }).get() ) )
			}
			$('.competition-box-wrapper li').equalizeHeights();
			$('.profile-bates-wrapper > .row > div').css("min-height","30px");
			//console.log(window_width);
			if(window_width>=1189){
				$('.big > div').equalizeHeights();
			}
	}
		
		

}
$(document).ready(function(){
	// Left navigation
	$("#red").treeview({
		animated: "fast",
		collapsed: true,
		control: "#treecontrol",
		unique: true,
		persist: "cookie",
		toggle: function() {
			//window.console && console.log("%o was toggled", this);
		}
	});
	$('.bets input, .form-box input').iCheck({
	    checkboxClass: 'icheckbox_minimal',
	    radioClass: 'iradio_minimal',
	    increaseArea: '20%' // optional
	  });
	$(".mob-head").click(function(){
		event.preventDefault();
	})
	$(".filter-button").click(function(){
		event.preventDefault();
		$(".filters").slideToggle();
		$(".filter-button .icon-arrowdropup").toggle();
		$(".filter-button .icon-arrowdropdown").toggle();
	});

	// ####################################################

	// top navigation fix for mobile
	$(".top-navigation-wrapper .mob-view > a").click(function(){
		($(this).next("ul").css('visibility') === 'hidden') ? 
			(
				$(this).next("ul").css('visibility','visible'), 
				$(this).children("span").removeClass('icon-arrowdropdown'),
				$(this).children("span").addClass('icon-arrowdropup')
				) :
			(
				$(this).next("ul").css('visibility','hidden'),
				$(this).children("span").addClass('icon-arrowdropdown'),
				$(this).children("span").removeClass('icon-arrowdropup')
				)
	})



	// #######################################################

	bindModuleEventHandlers();	
});

var rtime = new Date(1, 1, 2000, 12,00,00);
	var timeout = false;
	var delta = 200;

$( window ).resize(function() {

	rtime = new Date();
    if (timeout === false) {
        timeout = true;
        setTimeout(resizeend, delta);
    }

	var window_width=$(window).width();
	//add classes
	if(window_width<=414){
		$("body").removeClass();
		$("body").addClass("mobile");
	}
	else if(window_width>=415 && window_width<=767){
		$("body").removeClass();
		$("body").addClass("big-mobile");
	}
	else if(window_width>=768 && window_width<=968){
		$("body").removeClass();
		$("body").addClass("tab-portrait");
	}
	else if(window_width>=969 && window_width<=1189){
		$("body").removeClass();
		$("body").addClass("tab-landscape");
	}
	else if(window_width>=1190 && window_width<=1235){
		$("body").removeClass();
		$("body").addClass("small-desktop");
	}
	else $("body").removeClass();


	// if($("body").hasClass("mobile")){
	// 	$(".left-sidebar").css("margin-left","");
	// }
	if($("body").hasClass("big-mobile")){
		$(".overlay").css("display","none");
		$(".left-sidebar").css("margin-left","");
		$(".right-top-container, .main-container").animate({"margin-left":"0"},0);
	}


	bindModuleEventHandlers();


});
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



window.onload=function(){
	tamingselect();
};
(function ($) {
    $.fn.multiAccordion = function() {
    	$(this).addClass("ui-accordion ui-accordion-icons ui-widget ui-helper-reset")
          .find("h3")
            .addClass("ui-accordion-header ui-helper-reset ui-state-default ui-corner-top ui-corner-bottom")
            .hover(function() { $(this).toggleClass("ui-state-hover"); })
            .prepend('<span class="ui-icon ui-icon-triangle-1-e"></span>')
            .click(function() {
              $(this)
                .toggleClass("ui-accordion-header-active ui-state-active ui-state-default ui-corner-bottom")
                .find("> .ui-icon").toggleClass("ui-icon-triangle-1-e ui-icon-triangle-1-s").end()
                .next().toggleClass("ui-accordion-content-active").slideToggle();
              return false;
            })
            .next()
              .addClass("ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom")
              .css("display", "block")
              .hide()
            .end().trigger("click");
    };
})(jQuery);
