<?php 
/**
 * Premise Library
 *
 * This holds global and general used throughout the Premise Framework.
 *
 * @package Library
 * @subpackage Premise
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

	$html .= !empty( $field_section['container_title'] ) ? '<p>' . $field_section['container_desc'] . '</p>' : '';

	$html .= premise_field( $field_section['fields'], false );

	$html .= !empty( $field_section['container_inner_class'] ) ? '</div>' : '';

	$html  = ( true === $field_section['container'] ) ? '</div>' : '';
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