<?php


add_action( 'wp_enqueue_scripts', 'nf_styler_frontend_scripts' );

function nf_styler_frontend_scripts() {
	wp_enqueue_style( 'nf_styler_css',  NF_STYLER_URL.'/css/nfstyler.css' );
}

function nf_styler_ul_open( $field_id, $data ) {
	global $nf_styler_row;
	global $nf_styler_enabled;
	global $ninja_forms_loading, $ninja_forms_processing;
	if ( isset ( $ninja_forms_loading ) ) {
		$form_id = $ninja_forms_loading->get_form_ID();
		$form_data = $ninja_forms_loading->get_all_form_settings();
		$pages = $ninja_forms_loading->get_form_setting( 'mp_pages' );
		$field_row = $ninja_forms_loading->get_field_settings( $field_id );
	} else {
		$form_id = $ninja_forms_processing->get_form_ID();
		$form_data = $ninja_forms_processing->get_all_form_settings();
		$pages = $ninja_forms_processing->get_form_setting( 'mp_pages' );
		$field_row = $ninja_forms_processing->get_field_settings( $field_id );
	}
	$style_setting = get_option( 'nf_styler_'.$form_id );
	$nf_styler_enabled = empty($style_setting['enabled'])?'': $style_setting['enabled'];
	if( $nf_styler_enabled!= '1'){
		return;
	}
	if ( isset( $form_data['ajax'] ) ) {
		$ajax = $form_data['ajax'];
	}else {
		$ajax = 0;
	}


	$field_data = $field_row['data'];

	if ( !empty( $field_data['styler_row'] ) ) {
		$current_field_row = $field_data['styler_row'];
	}else{
		$current_field_row = $nf_styler_row+1;
	}

	if ( !isset( $nf_styler_row ) ) {
		$nf_styler_row = 0;
	}
	//start new row
	if ( $current_field_row > $nf_styler_row ) {
		// not the first row - so close previous row container before starting new row
		if ( $nf_styler_row != 0 ) { ?>
				<div style="clear:both"></div>
				</div>
		<?php }
?>
			<div class="nf-styler-row">
			<?php
	}

			$col_size = empty( $field_data['styler_size_col'])?'1':$field_data['styler_size_col'];
			$col_no = empty( $field_data['styler_col'])?'1':$field_data['styler_col'];

?>
				<div class="nf-styler-col-<?php echo $col_no;?> nf-styler-col nf-styler-colsize-<?php echo $col_size; ?>">

 		<?php
	$nf_styler_row= empty( $field_data['styler_row'])?$current_field_row:$field_data['styler_row'];

}
add_action( 'ninja_forms_display_before_field', 'nf_styler_ul_open', 11, 2 );
function nf_styler_ul_close( $field_id, $data ) {
	global $nf_styler_row,$nf_styler_enabled;
	if( $nf_styler_enabled!= '1'){
		return;
	}


?>
	</div>
	<?php

}
add_action( 'ninja_forms_display_after_field', 'nf_styler_ul_close', 9, 2 );

add_action( 'ninja_forms_display_after_fields', 'nf_styler_close_last_row' );

function nf_styler_close_last_row( $form_id ) {
	global $nf_styler_row,$nf_styler_enabled;
	if( $nf_styler_enabled!= '1'){
		return;
	}
	echo '</div>';
}


function nf_styler_reorder_fields( $field_results, $form_id ) {
	$style_setting = get_option( 'nf_styler_'.$form_id );
	$nf_styler_enabled = empty($style_setting['enabled'])?'': $style_setting['enabled'];
	if( $nf_styler_enabled!= '1'){
		return $field_results;
	}
	$field_layout_settings =get_styler_field_layout_settings( $form_id );
	$sort = array();
	foreach ( $field_results as $key => $fielddata ) {
		if ( !empty( $field_layout_settings['nf_styler_field_layout_'.$fielddata['id']] ) ) {
			$field_results[$key]['styler_row']=$field_layout_settings['nf_styler_field_layout_'.$fielddata['id']]->row;
			$field_results[$key]['styler_col']=$field_layout_settings['nf_styler_field_layout_'.$fielddata['id']]->col;
			// sort
			$sort['row'][$key] = $field_layout_settings['nf_styler_field_layout_'.$fielddata['id']]->row;
			$sort['col'][$key] = $field_layout_settings['nf_styler_field_layout_'.$fielddata['id']]->col;
		}else {
			$field_results[$key]['styler_row']='9999';
			$field_results[$key]['styler_col']='9999';
			//sort
			$sort['row'][$key] = '9999';
			$sort['col'][$key] = '9999';
		}

	}
	// sort by row asc and then col asc
	array_multisort( $sort['row'], SORT_ASC, $sort['col'], SORT_ASC, $field_results );
	return $field_results;

}
add_filter( 'ninja_forms_display_fields_array', 'nf_styler_reorder_fields', 100, 2 );
