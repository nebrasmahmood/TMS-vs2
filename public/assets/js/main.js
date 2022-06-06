$.noConflict();

jQuery(document).ready(function($) {

	"use strict";

	[].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {
		new SelectFx(el);
	} );

	jQuery('.selectpicker').selectpicker;


	$('#menuToggle').on('click', function(event) {
		$('body').toggleClass('open');
		$('body').toggleClass('closeBody');
		$('body').toggleClass('fixed');
	});
	$('aside').on('mouseenter', function(event) {
		if(!$("body").hasClass('fixed') && event.pageX < 70){
            $('body').addClass('closeBody');
            $('body').removeClass('open');
            // $(".header-left").removeClass('open');
        }
	});
	$('aside').on('mouseleave', function(event) {
        if(!$("body").hasClass('fixed') && event.pageX > 70) {
            $('body').removeClass('closeBody');
            $('body').addClass('open');
        }
	});

	$(".open .sub-menu li").on("mouseenter", function(){
        if($("body").hasClass('open')) {
            $("aside").css("width", "280px")
            $("body").addClass("open")
        }
    })

    $(".search-trigger").click(function(e){
        $(".search-form input").val("")
    })

    $(document).ready(function() {
        setTimeout(function(){
            $(".preloader").hide();
        }, 500);
    });

	$('.search-trigger').on('click', function(event) {
		event.preventDefault();
		event.stopPropagation();
		$('.search-trigger').parent('.header-left').addClass('open');
	});

	$('.search-close').on('click', function(event) {
		event.preventDefault();
		event.stopPropagation();
		$('.search-trigger').parent('.header-left').removeClass('open');
	});

    // var currentUrl = window.location.href;

    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    var fullUrl = getUrl .protocol + "//" + getUrl.host + getUrl.pathname;
    if(baseUrl.slice(-1) == '/'){
        baseUrl = baseUrl.substring(0, baseUrl.length - 1);
    }
    if(fullUrl.slice(-1) == '/'){
        fullUrl = fullUrl.substring(0, fullUrl.length - 1);
    }


    $(`.nav.navbar-nav > li > a[href="${baseUrl}"]`).closest("li").addClass('active');
    $(`.sub-menu > li > a[href="${fullUrl}"]`).closest("li").addClass('active');


	// $('.user-area> a').on('click', function(event) {
	// 	event.preventDefault();
	// 	event.stopPropagation();
	// 	$('.user-menu').parent().removeClass('open');
	// 	$('.user-menu').parent().toggleClass('open');
	// });


});
