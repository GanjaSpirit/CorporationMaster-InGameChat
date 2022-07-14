<?php
@session_start();



$link = new mysqli("localhost", "watchd8_watchd", "!iL(Zd]0;Qx;", "watchd8_corporationmaster");
if ($link->connect_errno) {
    echo "Failed to connect to MySQL: (" . $link->connect_errno . ") " . $link->connect_error;
}
//echo $link->host_info . "- The website is still being worked on, i need to sleep after 8 hrs of work - Soon TM". "\n";
//$link->close();
?>
