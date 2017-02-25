require.config({
	"baseUrl": "/project/wp-content/themes/yeopress/js",
	"paths": {
		"jquery": "vendor/jquery/dist/jquery",
		"fancybox": "vendor/fancybox/jquery.fancybox",
		"owlCarousel": "vendor/owl.carousel/dist/owl.carousel.min",
		"general": "modules/general",
		"home": "modules/home"
	},
	'shim': {
		'owlCarousel': {
            deps: ['jquery']
        },
        'fancybox': {
            deps: ['jquery']
        },
        'general': {
            deps: ['owlCarousel']
        },
        'home': {
            deps: ['jquery']
        }
    }
});

require(['jquery', 'fancybox', 'general', 'home'], function($) {

	generalModule.init();
	homeModule.init();

});
