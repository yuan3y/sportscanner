<?php
include('simple_html_dom.php');

$date = $_GET['date'];
$time = $_GET['time'];

$html = file_get_html('http://www.thecage.com.sg/booking_bukittimah5/week_view.php?date='.$date);

// grab all links from site and spot the date
$links = array();
foreach($html->find('a') as $a) {
	$href=$a->href;

 if (strpos($href,$date) && strpos($href,$time)){
 	$links[] = $href;
 	echo "<a href='http://www.thecage.com.sg/booking_calendar/week_view.php' target='_blank'>Court ";
 	echo substr($href, strpos($href,"loc=loc")+7,1);
 	echo "</a><br/>";
 }
}
?>