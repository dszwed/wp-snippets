<?php

/**
 * Disable Yoast SEO Schema breadcrumbs output
 * Helpful for cases when custom breadcrumbs with own schema are used
 */
add_filter('wpseo_schema_graph_pieces', function ($schema_pieces, $context): array {
    $index = 0;
    foreach ($schema_pieces as $schema_piece) {
        if (is_a($schema_piece, '\Yoast\WP\SEO\Generators\Schema\Breadcrumb')) {
            unset($schema_pieces[$index]);
            break;
        }

        $index++;
    }

    return $schema_pieces;
}, 10, 2);

/**
 * Remove breadcrumb piece from WebPage schema, custom breadcrumbs are used
 */
add_filter('wpseo_schema_webpage', function ($graph_piece, $context, $graph_piece_generator, $graph_piece_generators) {
    unset($graph_piece['breadcrumb']);
    return $graph_piece;
}, 10, 4);