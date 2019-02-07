<?php 
//-----------------------------------------------------------
//     Date Module
//-----------------------------------------------------------

##--> GET CURRENT TIME and format the hour, minutes and seconds.  Add 1900 to the year to get the full 4 digit year.
date_default_timezone_set('UTC');
$localtime = localtime();
$Now = localtime();
// pre SPLIT() deprecation
//SPLIT() has been DEPRECATED as of PHP 5.3.0 and REMOVED as of PHP 6.0.0. Relying on this feature is highly discouraged.
list($sec, $min, $hour, $mday,$mon,$year,$wday,$yday,$isDST) = $Now;
// post SPLIT() deprecation
// use PREG_SPLIT()
// list($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isDST) = preg_split("/:/", $colonized);
$year += 1900;
// UNIX datetime
$time = sprintf("%02d%02d%02d", $hour, $min, $sec);
$date = sprintf("%04d%02d%02d", $year, $mon, $day);

$days = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
$daysAbr = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
$months = array('January','February','March','April','May','June','July','August','September','October','November','December');
$months2 = array('1','2','3','4','5','6','7','8','9','10','11','12');
$months3 = array('01','02','03','04','05','06','07','08','09','10','11','12');

// for common datetime/MYSQL
$Utime = sprintf("%02d:%02d:%02d", $hour, $min, $sec);
$Udate = sprintf("%04d-%02d-%02d", $year, $mon, $day);

$datetimeUNIX = $date .''. $time;
$datetime = $Udate .' '. $Utime;

$properdate = $months[$mon].' '.$mday.', '.$year;
$fulldate = $daysAbr[$wday].', '.$months[$mon].' '.$mday.', '.$year;

?>
