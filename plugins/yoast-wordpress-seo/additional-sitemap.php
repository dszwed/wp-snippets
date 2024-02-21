<?php
//Add an extra sitemap from file to Yoast sitemaps

add_filter( 'wpseo_sitemap_index', function(string $sitemap_content): string {

    $sitemap_content .= '
        <sitemap>
        <loc>'. home_url('foo/bar.xml') . '</loc>
        <lastmod>2024-01-18T14:13:00+00:00</lastmod>
        </sitemap>';

    return $sitemap_content;
});
