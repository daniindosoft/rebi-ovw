<?php
/* Instantiate class */
require_once("pager.php"); 
$p = new Pager; 
/* Show many results per page? */
$limit = 100; 
/* Find the start depending on $_GET['page'] (declared if it's null) */
$start = $p->findStart($limit); 
/* Find the number of rows returned from a query; Note: Do NOT use a LIMIT clause in this query */
$count = mysql_num_rows(mysql_query("SELECT field FROM table")); 
/* Find the number of pages based on $count and $limit */
$pages = $p->findPages($count, $limit); 
/* Now we use the LIMIT clause to grab a range of rows */
$result = mysql_query("SELECT * FROM table LIMIT ".$start.", ".$limit); 
/* Now get the page list and echo it */
$pagelist = $p->pageList($_GET['page'], $pages); 
echo $pagelist; 
/* Or you can use a simple "Previous | Next" listing if you don't want the numeric page listing */
//$next_prev = $p->nextPrev($_GET['page'], $pages); 
//echo $next_prev; 
/* From here you can do whatever you want with the data from the $result link. */