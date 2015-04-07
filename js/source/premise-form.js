/*

	Forms

 */

PremiseField = {

	fields: {
		file: null,
		imgUpload: null,
	},



	dropzone: null,



	/**
	 * Initiate premise fields
	 */
	init: function() {

		this.fields.file = jQuery('.file .premise-file-url');
		this.fields.imgUpload = jQuery('.file .premise-image-uploader > div');

		premiseFormsInit();
		this.dropzoneReady();
	},





	dropzoneReady: function() {

		if ( ! this.fields.imgUpload ) {
			console.log('no file found');
			return false;
		}

		var el = this.fields.imgUpload;

		var id   = 'undefined' !== typeof el.attr('id')          ? '#'+el.attr('id')      : null;
		console.log(el);
		var url  = 'undefined' !== typeof el.attr('data-action') ? el.attr('data-action') : '/';
		var name = 'undefined' !== typeof el.attr('data-name')   ? el.attr('data-name')   : 'file';

		var params = { 
			url:              url,
			paramName:        name,
			uploadMultiple:   true,
			autoProcessQueue: false
		}

		jQuery(document).trigger('premiseBeforeDropZone', params, el);

		this.dropzone = new Dropzone( id, params );
	}
}






function premiseFormsInit() {
	Dropzone.autoDiscover = false;
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



// function premiseUploadFile( elID ) {
// 	elID = 'undefined' !== typeof elID ? jQuery(elID) : null

// 	if( !elID )
// 		return false;
// 	else
// 		var el = elID;

// 	var id = 'undefined' !== typeof el.attr('id') ? '#'+el.attr('id') : null
// 	var url = 'undefined' !== typeof el.attr('data-action') ? el.attr('data-action') : '/'
// 	var name = 'undefined' !== typeof el.attr('data-name') ? el.attr('data-name') : 'file'

// 	var params = { 
// 		url:  url,
// 		paramName: name,
// 		uploadMultiple: true,
// 		autoProcessQueue: false
// 	}

// 	jQuery(document).trigger('premiseBeforeDropZone');

// 	Premise.Dropzone = new Dropzone( id, params );
// }