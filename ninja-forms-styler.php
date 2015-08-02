<?php
/*
	Plugin Name: Ninja Forms - Styler
	Description: Build Awesome Layout for Ninja Forms with Layout Styler.
	Author: Aman Saini
	Author URI: http://webholics.in
	Plugin URI: http://webholics.in
	Version: 1.0.1
	Requires at least: 3.5
	Tested up to: 4.2
*/

// don't load directly
if ( !defined( 'ABSPATH' ) ) die( '-1' );

define( "NF_STYLER_DIR", WP_PLUGIN_DIR . "/" . basename( dirname( __FILE__ ) ) );
define( "NF_STYLER_URL", plugins_url() . "/" . basename( dirname( __FILE__ ) ) );



add_action( 'admin_init', 'ninja_forms_register_tab_layout_styler' , 11 );


function ninja_forms_register_tab_layout_styler() {
	if ( defined( 'NINJA_FORMS_VERSION' ) ) {
		if ( isset( $_REQUEST['form_id'] ) ) {
			$form_id = absint( $_REQUEST['form_id'] );
		}else {
			$form_id = '';
		}

		$args = array(
			'name' => __( 'Form Styler', 'ninja-forms' ),
			'page' => 'ninja-forms',
			'display_function' => 'ninja_forms_tab_layout_styler',
			'save_function' => 'ninja_forms_save_layout_styler',
			'disable_no_form_id' => true,
			'show_save' => true,
			'tab_reload' => false,
		);
		ninja_forms_register_tab( 'layout_styler', $args );
	}
}



function ninja_forms_tab_layout_styler() {
	global $ninja_forms_fields;
	if ( isset( $_REQUEST['form_id'] ) ) {
		$form_id = absint( $_REQUEST['form_id'] );
	}else {
		$form_id = '';
	}

	$fields = ninja_forms_get_fields_by_form_id( $form_id );

	$field_layout_settings =get_styler_field_layout_settings( $form_id );

?>
	<div id="nflayoutstyler">
	<div class="nflayoutstyler-rt-cont gridster ">
	<input type="hidden" id="field-layout-data" name="styler[field_layout]" value="">
	<ul class="menu nflayoutstylerfield-list" >
<?php
	$i =1;
	if ( is_array( $fields ) and !empty( $fields ) ) {
		foreach ( $fields as $field ) {

			nflayoutstyler_field( $field, $i , $field_layout_settings );
			$i++;
		}
	}
?>
		</ul>


	</div>
	</div>

<?php do_action( 'nf_styler_form_design_setting_cont', $form_id );
}

function nflayoutstyler_field( $field, $row , $field_layout_settings ) {
	global $ninja_forms_fields;
	$field_id =  $field['id'];
	$field_row = ninja_forms_get_field_by_id( $field_id );
	$field_type = $field_row['type'];

	if ( isset( $ninja_forms_fields[$field_type]['use_li'] ) && $ninja_forms_fields[$field_type]['use_li'] ) {

		if ( !isset( $field_layout_settings['nf_styler_field_layout_'.$field_id] ) ) {
			// new elemet - add it to last
			$field_layout_settings['nf_styler_field_layout_'.$field_id] = new stdClass();
			$field_layout_settings['nf_styler_field_layout_'.$field_id]->row=100;
			$field_layout_settings['nf_styler_field_layout_'.$field_id]->col=1;
			$field_layout_settings['nf_styler_field_layout_'.$field_id]->size_x=1;
			$field_layout_settings['nf_styler_field_layout_'.$field_id]->size_y=1;
		}

		$field_type = $ninja_forms_fields[$field_type]['name'];


		$field_layout = $field_layout_settings['nf_styler_field_layout_'.$field_id];

?>

<li  data-row="<?php echo $field_layout->row; ?>" data-col="<?php echo $field_layout->col; ?>" data-sizex="<?php echo $field_layout->size_x; ?>" data-sizey="<?php echo $field_layout->size_y; ?>" id="nf_styler_field_layout_<?php echo $field_id; ?>" class=" ninja-forms-no-nest _text-li">

				<dl class="menu-item-bar">
					<dt class="menu-item-handle" id="ninja_forms_metabox_field_<?php echo $field_id; ?>">
						<span class="item-title ninja-forms-field-title" id="nf_styler_field<?php echo $field_id; ?>_title"><?php echo $field['data']['label']; ?></span>
						<span class="item-controls">
							<span class="item-type"><span class="spinner" style="margin-top: -2px; float: left; display: none;"></span><span class="item-type-name"><?php echo $field_type; ?></span></span>

						</span>
					</dt>
				</dl>

</li>
<?php }

}


function ninja_forms_save_layout_styler() {
	global $wpdb;
	$form_id = $_POST['_form_id'];
	if ( isset( $form_id ) ) {
		update_option( 'nf_styler_'.$form_id, $_POST['styler'] );
	}

	// update field in db
	$field_layout_settings = get_styler_field_layout_settings( $form_id );

	$field_results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".NINJA_FORMS_FIELDS_TABLE_NAME." WHERE form_id = %d ", $form_id ), ARRAY_A );
	if ( is_array( $field_results ) and !empty( $field_results ) ) {

		foreach ( $field_results as $key => $field_result ) {

			$field_id =  $field_result['id'];
			$field_data = unserialize( $field_result['data'] );
			if ( !empty( $field_layout_settings['nf_styler_field_layout_'.$field_id] ) ) {
				$field_data['styler_row']=$field_layout_settings['nf_styler_field_layout_'.$field_id]->row;
				$field_data['styler_col']=$field_layout_settings['nf_styler_field_layout_'.$field_id]->col;
				$field_data['styler_size_col']=$field_layout_settings['nf_styler_field_layout_'.$field_id]->size_x;
			}else {
				$field_data['styler_row']=9999;
				$field_data['styler_col']=9999;
				$field_data['styler_size_col']=1;
			}
			$args = array(
				'update_array' => array(
					'data'  => serialize( $field_data ),
				),
				'where'   => array(
					'id'   => $field_id,
				),
			);

			ninja_forms_update_field( $args );
		}

	}

}

function get_styler_field_layout_settings( $form_id ) {
	$field_layout = $field_layout_settings = array();
	$style_setting = get_option( 'nf_styler_'.$form_id );
	if ( !empty( $style_setting ) ) {
		$field_layout = json_decode( stripslashes( $style_setting['field_layout'] ) );
		foreach ( $field_layout as $layout_array ) {
			foreach ( $layout_array as $key => $obj ) {
				$field_layout_settings[$key] = $obj;
			}
		}
	}

	return $field_layout_settings;
}



//Add Admin class
require_once NF_STYLER_DIR.'/inc/class-admin.php';
add_action( 'plugins_loaded', array( 'Ninja_LayoutStyler', 'setup' ) );
require_once NF_STYLER_DIR.'/inc/form-design-settings.php';
add_action( 'plugins_loaded', array( 'NF_Styler_Form_Design_Settings', 'setup' ) );

// form dispay - add rows & cols
require_once NF_STYLER_DIR.'/inc/form-display.php';
// form styles in frontend
require_once NF_STYLER_DIR.'/inc/form-styles.php';
