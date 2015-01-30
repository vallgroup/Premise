



premiseInit()





/*

	Global

 */

function premiseInit() {

	jQuery(function($){

		premiseFormsInit()

	})
	console.log('Premise initiated successfully')

}






/*

	Forms

 */

function premiseFormsInit() {
	premiseDateField()
	premiseMinicolors()
}



function premiseDateField( el ) {
	el = 'undefined' !== typeof el ? jQuery(el) : jQuery('.premise-date-field')

	el.datepicker();
}



function premiseMinicolors( el ) {
	el = 'undefined' !== typeof el ? jQuery(el) : jQuery('.premise-minicolors')

	el.minicolors();
}