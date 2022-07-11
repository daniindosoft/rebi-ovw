<?php
function findStart($limit) { 
    if ((!isset($_GET['page'])) || ($_GET['page'] == "1")) { 
        $start = 0; 
        $_GET['page'] = 1; 
    } else { 
        $start = ($_GET['page']-1) * $limit; 
    } 
    return $start; 
}
  

function findPages($count, $limit) { 
     $pages = (($count % $limit) == 0) ? $count / $limit : floor($count / $limit) + 1; 
     return $pages; 
} 

function pageList($curpage, $pages) 
{ 
    $page_list  = ""; 

    if (($curpage != 1) && ($curpage)) { 
       $page_list .= "  <a href=\" ".$_SERVER['PHP_SELF']."?page=1\" title=\"First Page\">«</a> "; 
    } 
    if (($curpage-1) > 0) { 
       $page_list .= "<a href=\" ".$_SERVER['PHP_SELF']."?page=".($curpage-1)."\" title=\"Previous Page\"><</a> "; 
    } 

    for ($i=1; $i<=$pages; $i++) { 
        if ($i == $curpage) { 
            $page_list .= "<b>".$i."</b>"; 
        } else { 
            $page_list .= "<a href=\" ".$_SERVER['PHP_SELF']."?page=".$i."\" title=\"Page ".$i."\">".$i."</a>"; 
        } 
        $page_list .= " "; 
      } 
     /* Print the Next and Last page links if necessary */
     if (($curpage+1) <= $pages) { 
        $page_list .= "<a href=\"".$_SERVER['PHP_SELF']."?page=".($curpage+1)."\" title=\"Next Page\">></a> "; 
     } 
     if (($curpage != $pages) && ($pages != 0)) { 
        $page_list .= "<a href=\"".$_SERVER['PHP_SELF']."?page=".$pages."\" title=\"Last Page\">»</a> "; 
     } 
     $page_list .= "</td>\n"; 
     return $page_list; 
}

function nextPrev($curpage, $pages) { 
 $next_prev  = ""; 
    if (($curpage-1) <= 0) { 
        $next_prev .= "Previous"; 
    } else { 
        $next_prev .= "<a href=\"".$_SERVER['PHP_SELF']."?page=".($curpage-1)."\">Previous</a>"; 
    } 
        $next_prev .= " | "; 
    if (($curpage+1) > $pages) { 
        $next_prev .= "Next"; 
    } else { 
        $next_prev .= "<a href=\"".$_SERVER['PHP_SELF']."?page=".($curpage+1)."\">Next</a>"; 
    } 
        return $next_prev; 
    } 
} 
?> 