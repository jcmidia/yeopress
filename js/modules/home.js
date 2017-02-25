var homeModule = (function($) {

	function initializer(){

	}


	return {
		init: function(){
			if ($('body').hasClass('home')) {
				initializer();
			}
		}
	}

})(jQuery);