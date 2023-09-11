<?php
// https://stackoverflow.com/questions/47038098/order-by-meta-value-asc-in-sql-query-is-not-sorting-prices-correctly

$sql = "SELECT * from table_name
INNER JOIN table_name ON table_name.column= table_name.column
where table_name.meta_key = 'meta_key_name'
ORDER BY CAST(meta_value as unsigned) DESC"; // if meta value need to best cast

// alt

$sql = "SELECT * from table_name
INNER JOIN table_name ON table_name.column= table_name.column
where table_name.meta_key = 'meta_key_name'
ORDER BY (meta_value + 0) DESC"; // if meta value need to best cast

// example

$sql = "SELECT * from wp_posts
INNER JOIN wp_postmeta ON wp_posts.ID= wp_postmeta.post_id
where wp_postmeta.meta_key = '_chamak_credit_amount'
ORDER BY CAST(meta_value as unsigned) DESC";