<?php
class Ninja_LayoutStyler {

	/**
	 * Add necessary hooks and filters functions
	 *
	 * @author Aman Saini
	 * @since  1.0
	 */
	function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'add_styler_script' ) );
		add_action ('nf_styler_form_design_setting_cont',  array( $this, 'form_design_setting_cont' ) );
	}

	//Plugin starting point.
	public static function setup() {
		if ( ! self::is_ninjaform_installed() ) {
			return;
		}
		$class = __CLASS__;
		new $class;
	}

	function add_styler_script() {
		 // Add the color picker css file
        wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'gridster', NF_STYLER_URL.'/css/gridster.css' );
		wp_enqueue_style( 'nouislider', NF_STYLER_URL.'/css/jquery.nouislider.min.css' );
		wp_enqueue_script( 'nouislider', NF_STYLER_URL.'/js/jquery.nouislider.all.min.js' );
		wp_enqueue_script( 'gridster', NF_STYLER_URL.'/js/gridster.js' );
		wp_enqueue_script( 'nflayoutstyler', NF_STYLER_URL.'/js/styler.js', array( 'jquery', 'gridster','nouislider','wp-color-picker' ) );

	}
	// Adds the design setting container
	function form_design_setting_cont( $form_id ){ ?>

				<div  class="postbox-container">
				<div id="advanced-sortables" class="meta-box-sortables ui-sortable">
				<div class="postbox nfstyler_form_design_cont">
				<div class="handlediv" title="Click to toggle"><br></div>

				<h3 class="hndle ui-sortable-handle"><div class=" dashicons-before dashicons-admin-settings"><span> Form Settings</span></div></h3>
				<div class="inside">
				<?php do_action('nf_styler_form_design_settings_before',$form_id); ?>

				<?php do_action('nf_styler_form_design_settings',$form_id); ?>

				<?php do_action('nf_styler_form_design_settings_after',$form_id); ?>

				</div> <!-- inside -->
				</div><!-- nfstyler_form_design -->

				<div class="postbox nfstyler_form_design_cont">
				<div class="handlediv" title="Click to toggle"><br></div>

				<h3 class="hndle ui-sortable-handle"><div class=" dashicons-before dashicons-admin-settings"><span> Label Settings</span></div></h3>
				<div class="inside">
				<?php do_action('nf_styler_label_design_settings_before',$form_id); ?>

				<?php do_action('nf_styler_label_design_settings',$form_id); ?>

				<?php do_action('nf_styler_label_design_settings_after',$form_id); ?>

				</div> <!-- inside -->
				</div><!-- nfstyler_form_design -->

						<div class="postbox nfstyler_form_design_cont">
				<div class="handlediv" title="Click to toggle"><br></div>

				<h3 class="hndle ui-sortable-handle"><div class=" dashicons-before dashicons-admin-settings"><span> Field Settings</span></div></h3>
				<div class="inside">
				<?php do_action('nf_styler_field_design_settings_before',$form_id); ?>

				<?php do_action('nf_styler_field_design_settings',$form_id); ?>

				<?php do_action('nf_styler_field_design_settings_after',$form_id); ?>

				</div> <!-- inside -->
				</div><!-- nfstyler_form_design -->

				</div><!-- advanced-sortables -->
				</div><!-- postbox-container -->


	<?php }

	/*
	 * Check if Ninja form is  installed
	 */
	private static function is_ninjaform_installed() {
		return defined( 'NINJA_FORMS_VERSION' );
	}

}