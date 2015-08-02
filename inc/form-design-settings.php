<?php
class NF_Styler_Form_Design_Settings {

	private static $style_setting;

	function __construct() {
		add_action( 'nf_styler_form_design_settings', array( $this, 'create_form_design_settings' ) );
		add_action( 'nf_styler_field_design_settings', array( $this, 'create_field_design_settings' ) );
		add_action( 'nf_styler_label_design_settings', array( $this, 'create_label_design_settings' ) );
	}

	//Plugin starting point.
	public static function setup() {
		if ( ! self::is_ninjaform_installed() ) {
			return;
		}
		$class = __CLASS__;
		new $class;
	}

	public static function create_form_design_settings( $form_id ) {
		$setting = get_option( 'nf_styler_'.$form_id );
		self::$style_setting = $setting;
?>

	<table class="styler-form-table form-table" >
		<tbody>
		<tr valign ="top">
				<th scope="row">Enable Styler for this form ?</th>
				<td>

				<input type="checkbox" class="checkbox " <?php  checked(self::get( 'form','enabled' ),'1'); ?> name="styler[enabled]" value="1">
					<p class="description">Styles and layout will only apply if this checkbox is checked</p>
				</td>
			</tr>
			<tr valign ="top">
				<th scope="row">Width</th>
				<td>

				<input type="text" class="small-text " name="styler[width]" value="<?php echo self::get( 'form','width' ); ?>">
					<p class="description">Form width in px or percentage e.g 500px or 90% or auto </p>
				</td>
			</tr>
			<tr valign ="top">
				<th scope="row">Height</th>
				<td><input type="text" class="small-text" name="styler[height]" value="<?php echo self::get( 'form','height' ); ?>">
					<p class="description">Form height in px or percentage e.g 500px or 90% or auto </p>
				</td>
			</tr>

			<tr valign ="top">
				<th scope="row">Border</th>
				<td>
				<?php
		$border_width = self::get( 'form','border_width' );
		$border_style = self::get( 'form','border_style' );
?>
				<select name="styler[border_width]">
					<option <?php selected( $border_width, '0px' ) ?> value="1px">0px</option>
					<option <?php selected( $border_width, '1px' ) ?> value="1px">1px</option>
					<option <?php selected( $border_width, '2px' ) ?> value="2px">2px</option>
					<option <?php selected( $border_width, '3px' ) ?> value="3px">3px</option>
					<option <?php selected( $border_width, '4px' ) ?> value="4px">4px</option>
					<option <?php selected( $border_width, '5px' ) ?> value="5px">5px</option>
					<option <?php selected( $border_width, '6px' ) ?> value="6px">6px</option>
					<option <?php selected( $border_width, '7px' ) ?> value="7px">7px</option>
					<option <?php selected( $border_width, '8px' ) ?> value="8px">8px</option>
					<option <?php selected( $border_width, '9px' ) ?> value="9px">9px</option>
					<option <?php selected( $border_width, '10px' ) ?> value="10px">10px</option>
				</select>
				<select name="styler[border_style]">
					<option <?php selected( $border_style, 'solid' ) ?> value="solid">solid</option>
					<option <?php selected( $border_style, 'dotted' ) ?> value="dotted">dotted</option>
					<option <?php selected( $border_style, 'dashed' ) ?> value="dashed">dashed</option>
					<option <?php selected( $border_style, 'double' ) ?> value="double">double</option>
					<option <?php selected( $border_style, 'groove' ) ?> value="groove">groove</option>
					<option <?php selected( $border_style, 'ridge' ) ?> value="ridge">ridge</option>
					<option <?php selected( $border_style, 'inset' ) ?> value="inset">inset</option>
					<option <?php selected( $border_style, 'outset' ) ?> value="outset">outset</option>
				</select>
				<input type="text" name="styler[border_color]" value="<?php echo self::get( $style_setting['border_color'] ); ?>" class="styler-color-picker" >

				</td>
			</tr>

			<tr valign ="top">
				<th scope="row">Background Color</th>
				<td><input type="text" class="regular-text styler-color-picker" name="styler[background_color]" value="<?php echo self::get( 'form','background_color' ); ?>">
					<p class="description">Form background color</p>
				</td>
			</tr>

			<tr valign ="top">
				<th scope="row">Padding</th>
				<td><div class="nf_styler_slider"></div><input type="text" class="small-text" name="styler[padding]" value="<?php echo self::get( 'form','padding' ); ?>">
				<?php //echo self::get_slider_labels(); ?>
				</td>
			</tr>

			<tr valign ="top">
				<th scope="row">Margin</th>
				<td><div class="nf_styler_slider"></div><input type="text" class="small-text" name="styler[margin]" value="<?php echo self::get( 'form','margin' ); ?>">
				</td>
			</tr>

		</tbody>
	</table>


 <?php }

	public static function create_field_design_settings( $form_id ) {

?>

			<table class=" styler-form-table form-table" >
		<tbody>
		<tr valign ="top">
				<th scope="row">Font Color</th>
				<td><input type="text" class="regular-text styler-color-picker" name="styler[fields][font_color]" value="<?php echo self::get( 'fields','font_color'); ?>">
					<p class="description"></p>
				</td>
			</tr>

			<tr valign ="top">
				<th scope="row">Border</th>
				<td>
				<?php
		$border_width = self::get( 'fields','border_width' );
		$border_style = self::get( 'fields','border_style' );
?>
				<select name="styler[fields][border_width]">
					<option <?php selected( $border_width, '0px' ) ?> value="1px">0px</option>
					<option <?php selected( $border_width, '1px' ) ?> value="1px">1px</option>
					<option <?php selected( $border_width, '2px' ) ?> value="2px">2px</option>
					<option <?php selected( $border_width, '3px' ) ?> value="3px">3px</option>
					<option <?php selected( $border_width, '4px' ) ?> value="4px">4px</option>
					<option <?php selected( $border_width, '5px' ) ?> value="5px">5px</option>
					<option <?php selected( $border_width, '6px' ) ?> value="6px">6px</option>
					<option <?php selected( $border_width, '7px' ) ?> value="7px">7px</option>
					<option <?php selected( $border_width, '8px' ) ?> value="8px">8px</option>
					<option <?php selected( $border_width, '9px' ) ?> value="9px">9px</option>
					<option <?php selected( $border_width, '10px' ) ?> value="10px">10px</option>
				</select>
				<select name="styler[fields][border_style]">
					<option <?php selected( $border_style, 'solid' ) ?> value="solid">solid</option>
					<option <?php selected( $border_style, 'dotted' ) ?> value="dotted">dotted</option>
					<option <?php selected( $border_style, 'dashed' ) ?> value="dashed">dashed</option>
					<option <?php selected( $border_style, 'double' ) ?> value="double">double</option>
					<option <?php selected( $border_style, 'groove' ) ?> value="groove">groove</option>
					<option <?php selected( $border_style, 'ridge' ) ?> value="ridge">ridge</option>
					<option <?php selected( $border_style, 'inset' ) ?> value="inset">inset</option>
					<option <?php selected( $border_style, 'outset' ) ?> value="outset">outset</option>
				</select>
				<input type="text" name="styler[fields][border_color]" value="<?php echo self::get( 'fields','border_color' ); ?>" class="styler-color-picker" >

				</td>
			</tr>

			<tr valign ="top">
				<th scope="row">Background Color</th>
				<td><input type="text" class="regular-text styler-color-picker" name="styler[fields][background_color]" value="<?php echo self::get( 'fields','background_color'); ?>">
					<p class="description">Field background color</p>
				</td>
			</tr>

			<tr valign ="top">
				<th scope="row">Padding</th>
				<td><div class="nf_styler_slider"></div><input type="text" class="small-text" name="styler[fields][padding]" value="<?php echo self::get( 'fields','padding' ); ?>">
				</td>
			</tr>

			<tr valign ="top">
				<th scope="row">Margin</th>
				<td><div class="nf_styler_slider"></div><input type="text" class="small-text" name="styler[fields][margin]" value="<?php echo self::get( 'fields','margin' ); ?>">
				</td>
			</tr>

		</tbody>
	</table>

  <?php  }

	public static function create_label_design_settings( $form_id ) {

?>

			<table class=" styler-form-table form-table" >
		<tbody>
			<tr valign ="top">
				<th scope="row">Min Width</th>
				<td><input type="text" class="regular-text" name="styler[label][min_width]" value="<?php echo self::get( 'label','min_width' ); ?>">
					<p class="description">Add minimum width for label in px or percentage e.g 100px or 20% or auto </p>
				</td>
			</tr>
		<tr valign ="top">
				<th scope="row">Font Color</th>
				<td><input type="text" class="regular-text styler-color-picker" name="styler[label][font_color]" value="<?php echo self::get( 'label','font_color' ); ?>">
					<p class="description"></p>
				</td>
			</tr>

			<tr valign ="top">
				<th scope="row">Background Color</th>
				<td><input type="text" class="regular-text styler-color-picker" name="styler[label][background_color]" value="<?php echo self::get( 'label','background_color' ); ?>">
					<p class="description">Label background color</p>
				</td>
			</tr>
			</tbody>
	</table>

  <?php

	}

	public static function get( $type, $name  ) {
			$settings = self::$style_setting;
		switch ($type) {
			case 'form':
				$val = !empty( $settings[$name])?$settings[$name]:'';
				break;
			case 'label':
				$val = !empty( $settings['label'][$name])?$settings['label'][$name]:'';
				break;
			case 'fields':
				$val = !empty( $settings['fields'][$name])?$settings['fields'][$name]:'';
				break;
			default:
				$val = !empty( $settings[$name])?$settings[$name]:'';
				break;
		}

		return $val;
	}


	private static function is_ninjaform_installed() {
		return defined( 'NINJA_FORMS_VERSION' );
	}

}
