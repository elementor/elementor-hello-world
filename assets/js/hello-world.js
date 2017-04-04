( function( $ ) {
	var WidgetHelloWorldHandler = function( $scope, $ ) {
		console.log( $scope );
	};
	
	// Make sure you run this code under Elementor..
	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/hello-world.default', WidgetHelloWorldHandler );
	} );
} )( jQuery );
