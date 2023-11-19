<?php
/**
 *  Validate if my custom field is populated
 */
add_filter( 'wpcf7_validate_my_custom_tag*', 'wp360_my_custom_tag_validation_handler'], 10, 2 );

/**
 * My custom tag validation handler
 *
 * @param \WPCF7_Validation $result
 * @param \WPCF7_FormTag $tag
 * @return \WPCF7_Validation
 */
function wp360_my_custom_tag_validation_handler($result, $tag): \WPCF7_Validation {
  $tag = new \WPCF7_FormTag( $tag );

  $name = $tag->name;

  //get value filled by the user
  $value = filter_input( INPUT_POST, $name, FILTER_VALIDATE_INT );

  if ( $tag->is_required() && !$value ) {
      $result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );
  }

  return $result;
}
