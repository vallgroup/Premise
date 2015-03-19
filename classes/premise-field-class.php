<?php
/**
 * Premise Field Class
 *
 * Generate form fields using a multidimensional array of values
 *
 * @package Premise Framework
 * @subpackage Field Class
 */





/**
* Premise Field Class
*/
class PremiseField {


	/**
	 * holds initial agrumnets passed to the class
	 * 
	 * @var array
	 */
	protected $args = array();


	
	

	/**
	 * Defaults for each field
	 * 
	 * @var array
	 */
	protected $defaults = array(
		'type' 	  		  => 'text',		//i.e. textarea, select, checkbox, file
		'name' 	  		  => '',
		'id' 	  		  => '',
		'label' 	  	  => '',
		'placeholder' 	  => '',  			//also used as select default option if not empty
		'tooltip' 	  	  => '',  			//displays balloon style tooltip
		'value' 	  	  => '',  			//value from database
		'value_att' 	  => '',  			//Used for checkboxes and radio fields. if this is equal to 'value' the field will be checked
		'class' 	  	  => '',  			//custom class for easy styling
		'attribute' 	  => '',			//Additional html attributes to add to element i.e. onchange="premiseSelectBackground()"
		'options'		  => array(),		//holds different options depending on the type of field
		'template' 		  => 'default',		//default template
	);






	/**
	 * holds our field
	 * 
	 * @var array
	 */
	protected $field = array();




	

	/**
	 * will hold our button markup to our object assigned in prepare_field()
	 * 
	 * @var string
	 */
	protected $btn_upload_file;
	protected $btn_remove_file;
	protected $btn_choose_icon;
	protected $btn_remove_icon;






	/**
	 * Holds the html for this field(s)
	 * 
	 * @var string
	 */
	public $html = '';






	/**
	 * Holds the class that should be assigned to the field wrapper
	 * 
	 * @var string
	 */
	public $wrapper = 'text';







	/**
	 * Holds the field label including tooltip
	 * 
	 * @var string
	 */
	public $label = '';






	/**
	 * construct our object
	 * 
	 * @param array $args array holding one or more fields
	 */
	function __construct( $args ) {

		if( !empty( $args ) && is_array( $args ) )
			$this->args = $args;

		$this->field_init();

	}





	/**
	 * begin processing the field
	 */
	protected function field_init() {

		/**
		 * 
		 */
		$this->field = premise_parse_args( $this->args, $this->defaults );
		$this->prepare_field();

		if( 'raw' !== $this->field['template'] )
			$this->build_field();
		else 
			$this->raw_field();
				
	}






	/**
	 * This function builds our field and saves the html markup for it
	 */
	protected function build_field() {

		$html  = '<div class="field';
		$html .= !empty( $this->field['class'] ) ? ' ' . $this->field['class'] . '">' : '">';

		$html .= $this->label;

		$html .= '<div class="' . $this->wrapper . '">';

		$html .= $this->the_field();

		$html .= '</div></div>';

		$this->html .= $html;

	}







	/**
	 * Outputs only the necessary elements for any given field
	 * No wrappers, no label, nothing but the field.
	 */
	protected function raw_field() {
		$html = $this->the_field();

		$this->html .= $html;
	}









	protected function the_field() {
		$html ='';
		switch( $this->field['type'] ) {
			case 'select':
			case 'wp_dropdown_pages':
				$html .= $this->select_field();
				break;

			case 'textarea':
				$html .= $this->textarea();
				break;

			case 'checkbox':
				$html .= $this->checkbox();
				break;

			case 'radio':
				$html .= $this->radio();
				break;

			default:
				$html .= $this->input_field();
				break;
		}
		return $html;
	}







	protected function input_field() {

		$field  = '<input type="'. $this->field['type'] .'"';

		$field .= !empty( $this->field['placeholder'] ) ? 'placeholder="'.$this->field['placeholder'].'"' 	: '';

		$field .= !empty( $this->field['name'] ) 		? 'name="'. $this->field['name'] .'"' 				: '';
		$field .= !empty( $this->field['id'] ) && 'file' !== $this->wrapper 			? 'id="'. $this->field['id'] .'"' 					: '';
		$field .= !empty( $this->field['value'] ) 		? 'value="'. $this->field['value'] .'"' 			: '';
		$field .= !empty( $this->field_class )			? 'class="'. $this->field_class .'"'				: '';
		$field .= !empty( $this->field['attribute'] ) 	? $this->field['attribute'] 						: '';
		
		$field .= '>';

		/**
		 * add buttons if file or fa-icon field
		 */
		switch( $this->wrapper ) {
			case 'file':
				$field .= $this->btn_upload_file;
				$field .= $this->btn_remove_file;
				$field .= $this->file_field();
				break;

			case 'fa-icon':
				$field .= $this->btn_choose_icon;
				$field .= $this->btn_remove_icon;
				break;
		}

		return $field;

	}








	protected function textarea() {
		
		$field = '<textarea ';

		$field .= !empty( $this->field['name'] ) ? 'name="'.$this->field['name'].'"' : '';
		$field .= !empty( $this->field['id'] ) ? 'id="'.$this->field['id'].'"' : '';
		$field .= !empty( $this->field['placeholder'] ) ? 'placeholder="'.$this->field['placeholder'].'"' : '';
		$field .= !empty( $this->field['attribute'] ) ? $this->field['attribute'] : '';

		$field .= '>'.$this->field['value'].'</textarea>';

		return $field;
	}







	protected function checkbox() {
		
		$field  = '<input type="'. $this->field['type'] .'"';
		
		$field .= !empty( $this->field['name'] ) 		? 'name="'. $this->field['name'] .'"' 		: '';
		$field .= !empty( $this->field['id'] ) 			? 'id="'. $this->field['id'] .'"' 			: '';
		$field .= !empty( $this->field['value_att'] ) 	? 'value="'. $this->field['value_att'] .'"' : '';
		$field .= !empty( $this->field['class'] ) 		? 'class="'. $this->field['class'] .'"' 	: '';
		$field .= !empty( $this->field['attribute'] ) 	? $this->field['attribute'] 				: '';

		$field .= ($this->field['value'] == $this->field['value_att']) ? 'checked="checked"' : '';

		$field .= '>';

		$field .= '<label ';
		$field .= !empty( $this->field['id'] ) 			? 'for="'. $this->field['id'] .'"' 		: '';
		$field .= '>'. $this->field['options']['label'] .'</label>';

		return $field;

	}







	protected function radio() {
		if( !empty( $this->field['options'] ) && is_array( $this->field['options'] ) ) {
			
			$field = '';

			foreach ( $this->field['options'] as $radio ) {
				
				$field  .= '<input type="'.$this->field['type'].'"';
				
				$field .= !empty( $this->field['attribute'] ) 	? $this->field['attribute'] 		: '';
				$field .= !empty( $this->field['name'] ) 		? 'name="'.$this->field['name'].'"' : '';
				$field .= !empty( $radio['id'] ) 				? 'id="'.$radio['id'].'"' 			: '';
				$field .= !empty( $radio['value_att'] ) 		? 'value="'.$radio['value_att'].'"' : '';
				
				$field .= ($this->field['value'] == $radio['value_att']) ? 'checked="checked"' : '';

				$field .= '>';

				$field .= '<label ';
				$field .= !empty( $radio['id'] ) ? 'for="'.$radio['id'].'">' : '';
				$field .= $radio['label'].'</label>';

			}

			return $field;

		}
	}






	protected function select_field() {
		
		if( 'wp_dropdown_pages' == $this->field['type'] ) {
			$field = $this->do_wp_dropdown_pages();
		}
		else {
			$field  = '<select '.$this->field['attribute'].' name="'.$this->field['name'].'" id="'.$this->field['id'].'">';
			$field .= !empty( $this->field['placeholder'] ) ? '<option>'.$this->field['placeholder'].'</option>' : '';
			$field .= $this->select_options();
			$field .= '</select>';
		}

		return $field;
	}







	protected function file_field() {
		
		$field  = '<div '.$this->field['attribute'].' data-action="'.$this->field['options']['url'].'" id="'.$this->field['id'].'" data-name="'.$this->field['name'].'" style="display:none;"></div>';

		return $field;
	}







	protected function select_options() {
		
		$options = '';

		if( is_array( $this->field['value'] ) ) {
			foreach ( $this->field['options'] as $key => $value ) {
				$options .= '<option  value="'.$value.'"';
				$options .= (is_array( $this->field['value'] ) && in_array( $value, $this->field['value'] ) ) ? 'selected' : '';
				$options .= '>'.$key.'</option>';
			}
		}
		else {
			foreach ($this->field['options'] as $key => $value) {
				$options .= '<option  value="'.$value.'"';
				$options .= ($this->field['value'] == $value) ? 'selected="selected"' : '';
				$options .= '>'.$key.'</option>';
			}	
		}

		return $options;
	}








	protected function do_wp_dropdown_pages() {
		
		$new_defaults = array(  
			'depth' 				=> 0, 
			'child_of' 				=> 0,
    		'selected' 				=> $this->field['value'], 
    		'name' 					=> $this->field['name'],
    		'id' 					=> $this->field['id'],
    		'show_option_none' 		=> $this->field['placeholder'], 
    		'show_option_no_change' => '',
    		'option_none_value' 	=> '', 
    	);
		
		$this->field = premise_parse_args( $this->field, $new_defaults );

		/**
		 * Make sure this never gets echoed.
		 */
		$this->field['echo'] = 0;
		
		return wp_dropdown_pages( $this->field );
	}






	/**
	 * Prepare our field. This function assigns the values to the 
	 * class properties needed to build a particular field
	 */
	protected function prepare_field() {
		$this->field['id'] = !empty( $this->field['id'] ) ? $this->field['id'] : $this->field['name'];

		$this->label  = !empty( $this->field['label'] ) 												? '<label for="'.$this->field['id'].'">'.$this->field['label'].'</label>' 	: '';
		$this->label .= ( !empty( $this->field['label'] ) && !empty( $this->field['tooltip'] ) ) 		? '<span class="tooltip"><i>'.$this->field['tooltip'].'</i></span>' 		: '';

		/**
		 * Set the field['type'] value
		 */
		switch( $this->field['type'] ) {
			case 'select':
			case 'wp_dropdown_pages':
				$this->wrapper = 'select';
				break;


			case 'datepicker':
				$this->field['type'] = 'text';
				$this->field_class = 'premise-date-field';
				break;

			case 'color':
			case 'minicolors':
				$this->wrapper = 'color';
				$this->field['type'] = 'text';
				$this->field_class = 'premise-minicolors';
				$this->field['template'] = 'default';
				break;

			case 'file':
				$this->wrapper = 'file';
				$this->field['type'] = 'text';
				$this->field_class = 'premise-file-url';
				$this->btn_upload_file = '<a class="premise-btn-upload" href="javascript:void(0);" onclick="premiseUploadFile(\'#'.$this->field['id'].'\')"><i class="fa fa-fw fa-upload"></i></a>';
				$this->btn_remove_file = '<a class="premise-btn-remove" href="javascript:void(0);" onclick="premiseRemoveFile(this)"><i class="fa fa-fw fa-times"></i></a>';
				break;

			case 'fa-icon':
				$this->wrapper = 'fa-icon';
				$this->field['type'] = 'text';
				$this->field_class = 'premise-insert-icon';
				$this->btn_choose_icon = '<a href="javascript:;" class="premise-choose-icon" onclick="premiseChooseIcon(this);"><i class="fa fa-fw fa-th"></i></a>';
				$this->btn_remove_icon = '<a href="javascript:;" class="premise-remove-icon" onclick="premiseRemoveIcon(this);"><i class="fa fa-fw fa-times"></i></a>';
				break;

			case 'checkbox':
			case 'radio':
				$this->wrapper = ( 'radio' == $this->field['type'] ) 											? 'radio'																	: 'checkbox';
				$this->label  = !empty( $this->field['label'] ) 												? '<p class="label">'.$this->field['label'].'</p>' 							: '';
				$this->label .= ( !empty( $this->field['label'] ) && !empty( $this->field['tooltip'] ) ) 		? '<span class="tooltip"><i>'.$this->field['tooltip'].'</i></span>' 		: '';
				break;

			default :
				$this->label  = !empty( $this->field['label'] ) 												? '<label for="'.$this->field['id'].'">'.$this->field['label'].'</label>' 	: '';
				$this->label .= ( !empty( $this->field['label'] ) && !empty( $this->field['tooltip'] ) ) 		? '<span class="tooltip"><i>'.$this->field['tooltip'].'</i></span>' 		: '';
				break;
		}

	}







	public function get_field() {
		return $this->html;
	}


}
?>