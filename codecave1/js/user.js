$( document ).ready(function() {

	



	$("body").queryLoader2();

	var WindowWidth = $( window ).width();
	var WindowHeight = $( window ).height();
	$("body").css("width", $("section").length * WindowWidth);
	$("section").css("width", WindowWidth);
	$("section").css("height", WindowHeight);
	$(".link").on("click", function(e){
		e.preventDefault();
		var UrlLink = $(this).data("link");
        $('html, body').stop().animate({
            scrollLeft: $("#"+UrlLink).offset().left
        }, 1000);
	})


	var PortfolioData = new Array;
	var FlickerData = new Array;

	var PortfolioDataUrl = 'https://spreadsheets.google.com/feeds/list/1_ZomKON51x2DLoaymzPW4SeFtUj6ZFrg6bZHCBXug0g/od6/public/values?alt=json'
	var FlickrDataUrl = 'https://api.flickr.com/services/rest/?method=flickr.people.getPhotos&api_key=4b0479c31e89d2f2b21169d26d83c649&user_id=22590518%40N04&format=json&nojsoncallback=1'


	AjaxCall(PortfolioDataUrl, "portfolio");
	AjaxCall(FlickrDataUrl, "flickr");

	function AjaxCall(APIUrl, ValueFor){
		$.ajax({
	        url: APIUrl,
	        type: 'GET',
	        dataType: "json",
	        success: function (data){
	        	CreateDataArray(data,ValueFor);
	        }
	    });
	}
	function CreateDataArray(data, ValueFor){
		if(ValueFor === "portfolio"){
			var size = Object.keys(data.feed.entry).length;
		    for(var i = 0; i < size; i++){
		        PortfolioData.push({v1: data.feed.entry[i]['gsx$websiteurl']['$t'], v2: data.feed.entry[i]['gsx$imageurl']['$t']});
		    }
		}
		if(ValueFor === "flickr"){
			var size = Object.keys(data.photos.photo).length;
			for(var i = 0; i < size; i++){
		        FlickerData.push({
		        	farm: data.photos.photo[i].farm, 
		        	id: data.photos.photo[i].id, 
		        	serect: data.photos.photo[i].secret, 
		        	server: data.photos.photo[i].server, 
		        	title: data.photos.photo[i].title
		        });
		    }
		}
	}
	setTimeout(function(){ 
		var NumberOfPortfolioSliderPage = 1;
		var NumberOfFlickerSliderPage = 2;
		var j = 1;
		var k = 0;
		(PortfolioData.length % 6 === 0) ? NumberOfPortfolioSliderPage = PortfolioData.length/6 : NumberOfPortfolioSliderPage = parseInt(PortfolioData.length/6) + 1;

		for(var t = 1; t <= NumberOfFlickerSliderPage; t++){
			$(".slider--main2").append("<li>");
			$(".slider--main2 >li:nth-child("+t+")").addClass("set"+t);
			$(".slider--main2 >li:nth-child("+t+")").append("<ul>");
			for ( k; k < FlickerData.length; k++){
				if (k === 0 ) { }
				else if ( k % 6 === 0) {
					$(".slider--main2 li.set"+t+" ul").append('<li><a target="_blank" href="https://www.flickr.com/photos/22590518@N04/'+FlickerData[k].id+'"><img src="https://farm'+FlickerData[k].farm+'.staticflickr.com/'+FlickerData[k].server+'/'+FlickerData[k].id+'_'+FlickerData[k].serect+'.jpg" alt=""></a></li>');
					k++;
					break; 
				}
				else {
					$(".slider--main2 li.set"+t+" ul").append('<li><a target="_blank" href="https://www.flickr.com/photos/22590518@N04/'+FlickerData[k].id+'"><img src="https://farm'+FlickerData[k].farm+'.staticflickr.com/'+FlickerData[k].server+'/'+FlickerData[k].id+'_'+FlickerData[k].serect+'.jpg" alt=""></a></li>');
					
				}
			}
		}

		for(var i = 1; i <= NumberOfPortfolioSliderPage; i++){
			$(".slider--main").append("<li>");
			$(".slider--main >li:nth-child("+i+")").addClass("set"+i);
			$(".slider--main >li:nth-child("+i+")").append("<ul>");
			for ( j; j < PortfolioData.length; j++){
				if ( j % 6 === 0) {
					$(".slider--main li.set"+i+" ul").append('<li><a href="'+PortfolioData[j].v1+'"><img class="images" src="'+PortfolioData[j].v2+'" alt=""><span></span></a></li>');
					j++;
					break; 
				}
				else {
					$(".slider--main li.set"+i+" ul").append('<li><a href="'+PortfolioData[j].v1+'"><img class="images" src="'+PortfolioData[j].v2+'" alt=""><span></span></a></li>'); 
				}
			}
		}
	}, 1000);

	setTimeout(function(){ 
		var unslider = $('.slider').unslider({
	    	dots: true,
	    	delay: 5000,
	    	fluid: false,
	    	keys: false 
	    });
	},2000);

	
  var nameSuccess = false, emailSuccess = false, messageSuccess = false;
  
  var $elements = $("input, textarea");
  $elements.on("focus", function() {
    var $selected = $(this);
    $elements.each(function() {
      var $this = $(this);
      if($this !== $selected)
        $(this).parent().css("opacity", 0.5);
        // $(this).css("background-color", "white");
    });
    $selected.parent().css("opacity", 1);
  });
  
  $("#contact-name").on("blur", validateName);
  $("#contact-email").on("blur", validateEmail);
  $("#contact-message").on("blur", validateMessage);
  
  $(".form").submit(function() {
  	// return false;
    validateName();
    validateEmail();
    validateMessage();
    
    if(nameSuccess && emailSuccess && messageSuccess) {
      //$(".form").slideUp();
      return true;
    }
    else if(!nameSuccess){
    	$("#contact-name").focus(); 
    	return false;
    } 
    else if(!emailSuccess){
    	$("#contact-email").focus();
    	return false;
    } 
    else if(!messageSuccess){
    	$("#contact-message").focus();
    	return false;
    } 
    else return false;
  });

function validateName(){
  var $name = $("#contact-name");
    var text = $name.val().trim();
    if(text.length < 2) {
      $name.parent().removeClass("has-success").addClass("has-error");
      nameSuccess = false;
    }
    else{
      $name.parent().removeClass("has-error").addClass("has-success");
      nameSuccess = true;
    }
}
  
  function validateEmail(){
    var $email = $("#contact-email");
    var text = $email.val().trim();
    var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
    var match = pattern.test(text);
    if(match) {
      $email.parent().removeClass("has-error").addClass("has-success");
      emailSuccess = true;
    }
    else{
      $email.parent().removeClass("has-success").addClass("has-error");
      emailSuccess = false;
    }
  }
  
  function validateMessage(){
    var $message = $("#contact-message");
    var text = $message.val().trim();
    
    if(text.length > 1) {
      $message.parent().removeClass("has-error").addClass("has-success");
      messageSuccess = true;
    }
    else {
      $message.parent().removeClass("has-success").addClass("has-error");
      messageSuccess = false;
    }
  }



})



