<?php

add_filter( 'wpcf7_before_send_mail', 'wp360_before_send_mail', 10, 3);

/**
 * Change email before send form depending on field value
 *
 * @param \WPCF7_ContactForm $contact_form
 * @param boolean $abort
 * @param \WPCF7_Submission $submission
 * @return \WPCF7_ContactForm
 */
function wp360_before_send_mail($contact_form, $abort, $submission): \WPCF7_ContactForm {
    //get posted data
    $field_name = $submission->get_posted_data('field_name');

    //identify form before change email
    if($field_name) {
        $properties = $contact_form->get_properties();
        $properties['mail']['recipient'] = 'new@email.com';
        $contact_form->set_properties($properties);
    }

    return $contact_form;
}
