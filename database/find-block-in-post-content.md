`SELECT * FROM 'wp_posts' WHERE 'post_content' LIKE '%core/image%' AND 'post_status' = 'publish' AND 'post_type' IN ('post','page')`

With URL

```
SELECT CONCAT('https://www.thepunterspage.com/', post_name)
FROM wp_posts
WHERE post_content LIKE '%core/image%' AND post_status = 'publish' AND post_type IN ('post','page')
```
