<?php


add_action( 'init', 'nf_styler_register_form_style_css' );
function nf_styler_register_form_style_css() {
	add_action( 'ninja_forms_before_form_display', 'nf_styler_form_style_css' );
}
function nf_styler_form_style_css( $form_id ) {
	$cont_styles = $label_styles = $field_styles = '';

	$style_setting = get_option( 'nf_styler_'.$form_id );
	$styler_enabled = empty($style_setting['enabled'])?'': $style_setting['enabled'];
	if( $styler_enabled!= '1'){
		return;
	}
	 // echo '<pre>';
	 //print_r( $style_setting );
	// FORM Container STYLE
	$cont_styles .= empty( $style_setting['width'] ) ? '': 'width:'.$style_setting['width'].';';
	$cont_styles .= empty( $style_setting['height'] ) ? '': 'height:'.$style_setting['height'].';';
	$cont_styles .= empty( $style_setting['border_color'] ) ? '': 'border:'.$style_setting['border_width'].' '.$style_setting['border_style'].' '.$style_setting['border_color'].';';
	$cont_styles .= empty( $style_setting['background_color'] ) ? '': 'background-color:'.$style_setting['background_color'].';';
	$cont_styles .= empty( $style_setting['padding'] ) ? '': 'padding:'.$style_setting['padding'].';';
	$cont_styles .= empty( $style_setting['margin'] ) ? '': 'margin:'.$style_setting['margin'].';';

	// FORM Field STYLE
	$field_styles .= empty( $style_setting['fields']['font_color'] ) ? '': 'color:'.$style_setting['fields']['font_color'].';';
	$field_styles .= empty( $style_setting['fields']['border_color'] ) ? '': 'border:'.$style_setting['fields']['border_width'].' '.$style_setting['fields']['border_style'].' '.$style_setting['fields']['border_color'].';';
	$field_styles .= empty( $style_setting['fields']['background_color'] ) ? '': 'background-color:'.$style_setting['fields']['background_color'].';';
	$field_styles .= empty( $style_setting['fields']['padding'] ) ? '': 'padding:'.$style_setting['fields']['padding'].';';
	$field_styles .= empty( $style_setting['fields']['margin'] ) ? '': 'margin:'.$style_setting['fields']['margin'].';';
	// FORM LABEL STYLE
	$label_styles .= empty( $style_setting['label']['min_width'] ) ? '': 'min-width:'.$style_setting['label']['min_width'].';';
	$label_styles .= empty( $style_setting['label']['font_color'] ) ? '': 'color:'.$style_setting['label']['font_color'].';';
	$label_styles .= empty( $style_setting['label']['background_color'] ) ? '': 'background-color:'.$style_setting['label']['background_color'].';';

?>
	<style>
	#ninja_forms_form_<?php echo $form_id; ?>_cont{
	<?php echo $cont_styles; ?>
	}
	#ninja_forms_form_<?php echo $form_id; ?>_cont .textarea-wrap .ninja-forms-field, #ninja_forms_form_<?php echo $form_id; ?>_cont .text-wrap .ninja-forms-field{
	<?php echo $field_styles; ?>
	}
	#ninja_forms_form_<?php echo $form_id; ?>_cont .field-wrap label{
	<?php echo $label_styles; ?>
	}

	</style>


<?php
}
