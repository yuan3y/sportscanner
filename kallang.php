<?php
$loc_kallang = array();

$html_kallang = file_get_html('http://www.thecage.com.sg/booking_calendar/day_view.php?date='.$date);

// grab all links from site and spot the date
foreach($html_kallang->find('a') as $a) {
  $href=$a->href;
  $full_url = "http://www.thecage.com.sg/" . $href;

// parse url
  $parts = parse_url($full_url);
// find GET parameters of url
  parse_str($parts['query'], $query);

// search through range of time and returns locations
foreach ($rangeArray as $key => $time) {
  if ($query['start_time'] == $time){
	array_push($loc_kallang,$query['loc']);
  }
}

}

// count duplicate location from array
$uniqueLoc = array_count_values($loc_kallang);

foreach ($uniqueLoc as $key => $value) {
    if ($value == $i+1){
    	echo "<a href='http://www.thecage.com.sg/booking_calendar/day_view.php?date=" . $date . "' target='_blank'>The Cage Kallang (5 aside) - Pitch ";
        echo substr($key, -1);
        echo "</a><br/>";
    }
}
?>