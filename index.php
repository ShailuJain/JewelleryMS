<?php
//static components is the actual page where every damn thing is included and there is a div in that file having class as include which will hold the current page. i.e the $include_page.

//title will be set in the static components file as title tag
$title = "Dashboard";
//the page to be included in the include div of the static-components page
$include_page = 'dashboard.php';
//including the static-components page.
include_once 'helpers/static-components.php';