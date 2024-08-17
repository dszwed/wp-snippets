<?php

/**
 * Add new validation settings field for ACF field type image to set aspect ratio validation
 * If fields are empty validation will be skipped
 *
 * @source https://github.com/Hube2/acf-filters-and-functions/blob/master/acf-image-aspect-ratio-validation.php
 */
add_filter('acf/render_field_validation_settings/type=image', function ($field) {
    // the technique used for adding multiple fields to a
    // single setting is copied directly from the ACF Image
    // field code. any ACF field type can be used as a setting
    // field for other field types
    $args = array(
        'name' => 'ratio_width',
        'type' => 'number',
        'label' => __('Aspect Ratio', 'text-domain'),
        'default_value' => 0,
        'min' => 0,
        'step' => 1,
        'prepend' => __('Width'),
    );

    acf_render_field_setting($field, $args);

    $args = array(
        'name' => 'ratio_height',
        'type' => 'number',
        // notice that there's no label when appending a setting
        'label' => '',
        'default_value' => 0,
        'min' => 0,
        'step' => 1,
        'prepend' => __('Height', 'text-domain'),
        // this how we append a setting to the previous one
        'wrapper' => array(
            'data-append' => 'ratio_width',
            'width' => '',
            'class' => '',
            'id' => ''
        )
    );

    acf_render_field_setting($field, $args);

    $args = array(
        'name' => 'ratio_margin',
        'type' => 'number',
        'label' => '',
        'default_value' => 0,
        'min' => 0,
        'step' => .5,
        'prepend' => __('&plusmn;'),
        'append' => __('%'),
        'wrapper' => array(
            'data-append' => 'ratio_width',
            'width' => '',
            'class' => '',
            'id' => ''
        )
    );

    acf_render_field_setting($field, $args);
}, 20);

/**
 * Validation of image aspect ratio for Media library
 * Validation is working in Media Library popup
 */
add_filter('acf/validate_attachment/type=image', function ($errors, $file, $attachment, $field) {
    // check to make sure everything has a value
    if (empty($field['ratio_width']) || empty($field['ratio_height']) ||
        empty($file['width']) || empty($file['height'])) {
        // values we need are not set or otherwise empty
        return $errors;
    }

    // make sure all values are numbers, you never know
    $ratio_width = intval($field['ratio_width']);
    $ratio_height = intval($field['ratio_height']);

    // make sure we don't try to divide by 0
    if (!$ratio_width || !$ratio_height) {
        // cannot do calculations if something is 0
        return $errors;
    }
    $width = intval($file['width']);
    $height = intval($file['height']);

    $ratio_margin = !empty($field['ratio_margin']) ? floatval($field['ratio_margin']) : 0;

    // do simple ratio math to see how tall
    // the image is allowed to be based on width
    $allowed_height = $width/$ratio_width*$ratio_height;

    // get ratio margin and calc min/max
    $ratio_margin = $ratio_margin/100; // convert % to decimal
    $min = round($allowed_height - ($allowed_height*$ratio_margin));
    $max = round($allowed_height + ($allowed_height*$ratio_margin));

    if ($height < $min || $height > $max) {
        // does not meet the requirement, generate an error
        $errors['aspect_ratio'] = __('Image does not meet Aspect Ratio Requirements of ', 'text-domain').
            $ratio_width.__(':').$ratio_height.__('&plusmn;').$ratio_margin.__('%');
    }

    // return the errors
    return $errors;
}, 20, 4);