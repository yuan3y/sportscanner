<?php
$loc_bukittimah5 = array();

$html_bukittimah5 = file_get_html('http://www.thecage.com.sg/booking_bukittimah5/day_view.php?date='.$date);

// grab all links from site and spot the date
foreach($html_bukittimah5->find('a') as $a) {
  $href=$a->href;
  $full_url = "http://www.thecage.com.sg/" . $href;

// parse url
  $parts = parse_url($full_url);
// find GET parameters of url
  parse_str($parts['query'], $query);

// search through range of time and returns locations
foreach ($rangeArray as $key => $time) {
  if ($query['start_time'] == $time){
	array_push($loc_bukittimah5,$query['loc']);
  }
}

}

// count duplicate location from array
$uniqueLoc = array_count_values($loc_bukittimah5);

foreach ($uniqueLoc as $key => $value) {
    if ($value == $i+1){
    	echo "<a href='http://www.thecage.com.sg/booking_bukittimah5/day_view.php?date=" . $date . "' target='_blank'>The Cage Bukit Timah (5 aside) - Pitch ";
        echo substr($key, -1);
        echo "</a><br/>";
    }
}
?>