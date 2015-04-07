<?php 
/**
 * Premise Library
 *
 * This holds global and general used throughout the Premise Framework.
 *
 * @package Library
 * @subpackage Premise
 */




/*

	PREMISE GLOBAL LIBRARY
---------------------------------------------------
 */


/**
 * Premise Head
 *
 * Inserts the apropriate links and scripts into head of DOM
 * 
 * @return string html
 */
function premise_head() {
	$rootPath 	= $_SERVER['DOCUMENT_ROOT'];
	$premPath 	= PREMISE_PATH;
	$dir 		= str_replace($rootPath, '', $premPath);

	$css  = '<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">';
	$css .= '<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />';
	$css .= '<link rel="stylesheet" href="'. $dir .'/includes/minicolors/jquery.minicolors.css" id="PremiseMinicolors">';
	$css .= '<link rel="stylesheet" href="'. $dir .'/css/premise.min.css" id="PremiseCSS">';

	$js   = '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>';
	$js  .= '<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>';
	$js  .= '<script src="'. $dir .'/includes/minicolors/jquery.minicolors.min.js" id="PremiseMinicolorsJS"></script>';
	$js  .= '<script src="'. $dir .'/includes/dropzone/dropzone.js" id="PremiseDropZoneJS"></script>';
	$js  .= '<script src="'. $dir .'/js/premise.min.js" id="PremiseJS"></script>';

	echo $css;
	echo $js;
}











/*

	PREMISE FORMS LIBRARY
---------------------------------------------------
 */


/**
 * create a field instance
 * 
 * @param  array   $args multidimensional array to build field
 * @param  boolean $echo true to echo (default). false to return it
 * @return string        html markup for each field
 */
function premise_field( $args = array(), $echo = true ) {
	$html = '';
	
	if( array_key_exists( 'options', $args ) || (count($args) == count($args, COUNT_RECURSIVE) ) ) {
		$field = new PremiseField( $args );
		$html .= $field->get_field();
	}
	else{
		foreach ( $args as $arg ) {
			$field = new PremiseField( $arg );
			$html .= $field->get_field();
		}
	}
	
	if( !$echo )
		return $html;
	else
		echo $html;
	
}





/**
 * create a field section
 *
 * This function outputs the fields within a field-section container
 * 
 * @param  array   $args multidimensional array to build field section
 * @param  boolean $echo true to echo, false to return it
 * @return string        html markup for field section
 */
function premise_field_section( $args = array(), $echo = true ) {
	$defaults = array(
		'container'             => true,
		'container_title'       => '',
		'container_desc'        => '',
		'container_class'       => '',
		'container_inner_class' => '',
		'fields' 				=> array(),
	);

	$field_section = premise_parse_args( $args, $defaults );

	$html  = ( true === $field_section['container'] ) ? '<div class="field-section' : '';
	$html .= ( true === $field_section['container'] && !empty( $field_section['container_class'] ) ) ? ' ' . $field_section['container_class'] . '">' : '">';

	$html .= !empty( $field_section['container_inner_class'] ) ? '<div class="' . $field_section['container_inner_class'] . '">' : '';

	$html .= !empty( $field_section['container_title'] ) ? '<h3>' . $field_section['container_title'] . '</h3>' : '';

	$html .= !empty( $field_section['container_desc'] ) ? '<p>' . $field_section['container_desc'] . '</p>' : '';

	$html .= premise_field( $field_section['fields'], false );

	$html .= !empty( $field_section['container_inner_class'] ) ? '</div>' : '';

	$html .= ( true === $field_section['container'] ) ? '</div>' : '';

	if( !$echo )
		return $html;
	else
		echo $html;
	
}






/**
 * parse arguments with a set of default values
 * 
 * @param  array|object $args     set of arguments to parse
 * @param  string|array $defaults set of defaults
 * @return array                  array of parsed arguments
 */
function premise_parse_args( $args, $defaults = '' ) {
    if ( is_object( $args ) )
            $r = get_object_vars( $args );
    elseif ( is_array( $args ) )
            $r =& $args;

    if ( is_array( $defaults ) )
            return array_merge( $defaults, $r );
    return $r;
}






 ?>