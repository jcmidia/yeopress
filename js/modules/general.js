var generalModule = (function($) {

	function initializer(){

		initCommonEvents();


		$(document).ready(function() {
			scrollEvents();
		});

		$(window).scroll(function() {
			scrollEvents();
		});
	}


	function initCommonEvents(){

		$('.owl-carousel').owlCarousel({
			items: 1,
			nav: true,
			dots: false,
			autoplay: true,
			loop: true,
			navText: ['<', '>']
		});

		$('.toggle-menu').click(function() {
			$('body').toggleClass('open');
		});
	}


	function scrollEvents(){
		
	}


	return {
		init: function(){
			initializer();
		}
	}

})(jQuery);