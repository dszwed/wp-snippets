`SELECT * FROM `wp_posts` WHERE `post_content` LIKE '%[shortcode_name%' AND `post_status` = 'publish' AND `post_type` IN ('post','page')`
