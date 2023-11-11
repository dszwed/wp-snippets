<?php
add_action( 'wpcf7_init', function(){
  //@see more features https://contactform7.com/2022/12/16/form-tag-features/
  wpcf7_add_form_tag( ['my-custom-tag', 'my-custom-tag*'], 'wp360_my_custom_tag_handler', true );
});

/**
 * @param \WPCF7_FormTag $tag
 * @return string
 */
function wp360_my_custom_tag_handler( $tag ): string {
  $tag = new \WPCF7_FormTag( $tag );

    if ( empty( $tag->name ) ) {
        return '';
    }

    $validation_error = wpcf7_get_validation_error( $tag->name );

    $class = wpcf7_form_controls_class( $tag->type );

    if ( $validation_error ) {
        $class .= ' wpcf7-not-valid';
    }

    $atts = array();

    $atts['class'] = $tag->get_class_option( $class );
    $atts['id'] = $tag->get_id_option();

    if ( $tag->is_required() ) {
        $atts['aria-required'] = 'true';
    }

    $atts['aria-invalid'] = $validation_error ? 'true' : 'false';
    $atts['name'] = $tag->name;

    $atts = wpcf7_format_atts( $atts );

    return sprintf(
        '<span class="wpcf7-form-control-wrap %s"><input %s>%s</span>',
        sanitize_html_class( $tag->name ),
        $atts,
        $validation_error
    );
}
