
(function ($) {
    $(function() {
        $('.nfstyler_form_design_cont .handlediv').click(function(){
            $(this).parent().toggleClass('closed');
        })

         $('.styler-color-picker').wpColorPicker();

         $('.nf_styler_slider').each(function(){
            var inp_val = $(this).next().val();
            if( inp_val != ''){
               inp_val =  inp_val.replace('px', '');
            }else{
                inp_val =1;
            }

             $(this).noUiSlider({
            start: inp_val ,
            step: 1,
            range: {
                'min': [  0 ],
                'max': [ 100 ]
                },
            format: {
              to: function ( value ) {
                return Math.round(value) + 'px';
              },
              from: function ( value ) {
                return value.replace('px', '');
              }
            }

        }).on({
         slide: function(){

                  $(this).Link('lower').to($(this).next());
                }
        })

         })

   nf_styler_gridster = $(".gridster ul").gridster({
        widget_margins: [5, 5],
        widget_base_dimensions: [250, 42],
         resize: {
            enabled: true,
            max_size: [2, 1],
            min_size: [1, 1]
          },
        max_cols: 2,
         serialize_params: function($w, wgd) {
            field_obj={};
            var id =$w.attr('id');
             field_obj[id]={
                col: wgd.col,
                row: wgd.row,
                size_x: wgd.size_x,
                size_y: wgd.size_y
              };
            return field_obj;
        },
    }).data('gridster');

   $('#ninja_forms_admin').submit(function(event) {
    s = nf_styler_gridster.serialize();
    $('#field-layout-data').val(JSON.stringify(s))
    console.log(JSON.stringify(s))
    return true;
   });

    })

}) (jQuery);

