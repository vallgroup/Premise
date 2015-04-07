/*

	Ajax

 */



/**
 * create elements needed for an AJax request if they 
 * don't already exist in the DOM
 * 
 * @return {string} output html dialog on to DOM
 */
function premisePrepareAjax() {
	var body 	 = document.body;
	var ajax     = document.getElementById('premise-ajax'),
	ajax_overlay = document.getElementById('premise-ajax-overlay'),
	ajax_inner   = document.getElementById('premise-ajax-inner'),
	ajax_content = document.getElementById('premise-ajax-content');

	if( !ajax ) {
		var ajax = document.createElement('div');

		ajax.className = 'premise-ajax';
        ajax.id = 'premise-ajax';
        ajax.style.display = 'none';

        body.appendChild(ajax);
	}

	if( !ajax_overlay ) {
		var ajax_overlay = document.createElement('div');

		ajax_overlay.className = 'premise-ajax-overlay';
        ajax_overlay.id = 'premise-ajax-overlay';

        ajax.appendChild(ajax_overlay);
	}

	if( !ajax_inner ) {
		var ajax_inner = document.createElement('div');

		ajax_inner.className = 'premise-ajax-inner';
		ajax_inner.id = 'premise-ajax-inner';

		ajax.appendChild(ajax_inner);
	}

	if( !ajax_content ) {
		var ajax_content = document.createElement('div');

		ajax_content.className = 'premise-ajax-content';
		ajax_content.id = 'premise-ajax-content';

		ajax_content.innerHTML = Premise.loadingTimer

		ajax_inner.appendChild(ajax_content);
	}

	jQuery(ajax).fadeIn('fast')

	jQuery(document).on('click', '.premise-ajax-overlay', premiseCloseAjax)

	return ajax_content;
}






/**
 * close ajax dialog and remove content div
 */
function premiseCloseAjax() {
	jQuery('#premise-ajax').fadeOut('fast')
	jQuery('#premise-ajax-content').remove()
	return false;
}







/**
 * Process ajax request
 * 
 * @param  {object} data data needed to process ajax request
 * @return {string}      output HTML returned by the ajax request into the ajax dialog
 */
function premiseLoadAjax(url, data) {
	data = 'undefined' !== typeof data ? data : null
	url = 'string' === typeof url ? url : null

	if( !url ) {
		console.error('ERROR: premiseLoadAjax(). Empty url.') 
		return false;
	}

	if( !data ) {
		console.error('ERROR: premiseLoadAjax(). Empty data.') 
		return false;
	}

	var ajaxDiv = premisePrepareAjax()

	if( url && data ){
		jQuery.post(url, data, function(res){
			jQuery(ajaxDiv).html(res);
		})
	}
	else {
		jQuery(ajaxDiv).load(data)
	}

	return false;
}

