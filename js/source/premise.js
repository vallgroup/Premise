jQuery(function($){

	Premise.init();
	

	console.log('Premise initiated successfully')

});


Premise = {
	loadingTimer: '<span class="premise-ajax-timer"><i class="fa fa-3x fa-spinner fa-spin"></i></span>',




	init: function() {

		/**
		 * initiates the forms javascript
		 */
		PremiseField.init();		

	}
}