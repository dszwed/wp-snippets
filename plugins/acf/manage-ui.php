<?php

/**
 * Disable ACF UI on environments other than development
 */
add_filter('acf/settings/show_admin', function () {
    return in_array(wp_get_environment_type(),  ['production', 'staging']);
});

/**
 * Disable ACF CT and CPT UI
 */
add_filter('acf/settings/enable_post_types', '__return_false');

/**
 * Disable ACF Option pages UI
 */
add_filter('acf/settings/enable_options_pages_ui', '__return_false');
