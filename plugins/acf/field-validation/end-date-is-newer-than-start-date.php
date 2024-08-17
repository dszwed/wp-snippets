<?php

add_filter('acf/validate_value/name={end_date_field_name}', function ($valid, $value, $field, $input_name) {

    // Bail early if value is already invalid.
    if ($valid !== true) {
        return $valid;
    }

    $start_date_raw = $_POST['acf']['{start_date_field_key}'];
    $timezone = wp_timezone();

    try {
        $start = new \DateTime($start_date_raw, $timezone);
        $end = new \DateTime($value, $timezone);
    } catch (\Exception $e) {
        //just in case there was validation before date fields were filled
        return true;
    }

    //If Start Date is after End Date
    if ($start >= $end) {
        $valid = __('End date cannot be earlier than the start date. Please check.', 'text-domain');
    }

    return $valid;
}, 10, 4);