<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Sportscanner - Search results</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
</head>
<?php
include('simple_html_dom.php');

$date = $_GET['date'];
$time = $_GET['time'];
?>
<form action="search.php" method="GET">
<input type='date' name='date' value='<?php echo $date;?>'>
<select name='time'>
  <option <?php if($time == '07:00'){echo("selected");}?> value="07:00">7:00 am</option>
  <option <?php if($time == '08:00'){echo("selected");}?> value="08:00">8:00 am</option>
  <option <?php if($time == '09:00'){echo("selected");}?> value="09:00">9:00 am</option>
  <option <?php if($time == '10:00'){echo("selected");}?> value="10:00">10:00 am</option>
  <option <?php if($time == '11:00'){echo("selected");}?> value="11:00">11:00 am</option>
  <option <?php if($time == '12:00'){echo("selected");}?> value="12:00">12:00 pm</option>
  <option <?php if($time == '13:00'){echo("selected");}?> value="13:00">1:00 pm</option>
  <option <?php if($time == '14:00'){echo("selected");}?> value="14:00">2:00 pm</option>
  <option <?php if($time == '15:00'){echo("selected");}?> value="15:00">3:00 pm</option>
  <option <?php if($time == '16:00'){echo("selected");}?> value="16:00">4:00 pm</option>
  <option <?php if($time == '17:00'){echo("selected");}?> value="17:00">5:00 pm</option>
  <option <?php if($time == '18:00'){echo("selected");}?> value="18:00">6:00 pm</option>
  <option <?php if($time == '19:00'){echo("selected");}?> value="19:00">7:00 pm</option>
  <option <?php if($time == '20:00'){echo("selected");}?> value="20:00">8:00 pm</option>
  <option <?php if($time == '21:00'){echo("selected");}?> value="21:00">9:00 pm</option>
  <option <?php if($time == '22:00'){echo("selected");}?> value="22:00">10:00 pm</option>
  <option <?php if($time == '23:00'){echo("selected");}?> value="23:00">11:00 pm</option>
</select>
<input type="submit" value="Search">
</form>
<br>

<?php
$html_kallang = file_get_html('http://www.thecage.com.sg/booking_calendar/week_view.php?date='.$date);

// grab all links from site and spot the date
$links = array();
foreach($html_kallang->find('a') as $a) {
	$href=$a->href;

 if (strpos($href,$date) && strpos($href,$time)){
 	$links[] = $href;
 	echo "<a href='http://www.thecage.com.sg/booking_calendar/day_view.php?date=" . $date . "' target='_blank'>The Cage - Kallang Pitch ";
 	echo substr($href, strpos($href,"loc=loc")+7,1);
 	echo "</a><br/>";
 }
}


$html_bukittimah11 = file_get_html('http://www.thecage.com.sg/booking_bukittimah11/day_view.php?date='.$date);
// grab all links from site and spot the date
$links = array();

foreach($html_bukittimah11->find('a') as $a) {
	$href=(string)$a->href;
	//echo $href;
//NOTE the bukit timah 11 aside has a bug where the day is wrong. so we only search through the time
 if (strpos($href,$time)){
 	$links[] = $href;
 	echo "<a href='http://www.thecage.com.sg/booking_bukittimah11/day_view.php?date=" . $date . "' target='_blank'>The Cage - Bukit Timah (11 aside) Pitch ";
 	echo substr($href, strpos($href,"loc=loc")+7,1);
 	echo "</a><br/>";
 }
}

$html_bukittimah5 = file_get_html('http://www.thecage.com.sg/booking_bukittimah5/day_view.php?date='.$date);
// grab all links from site and spot the date
$links = array();

foreach($html_bukittimah5->find('a') as $a) {
	$href=(string)$a->href;
	//echo $href;
//NOTE the bukit timah 5 aside has a bug where the day is wrong. so we only search through the time
 if (strpos($href,$time)){
 	$links[] = $href;
 	echo "<a href='http://www.thecage.com.sg/booking_bukittimah5/day_view.php?date=" . $date . "' target='_blank'>The Cage - Bukit Timah (5 aside) Pitch ";
 	echo substr($href, strpos($href,"loc=loc")+7,1);
 	echo "</a><br/>";
 }
}

//include('thecage-bukittimah.php');
//include('thecage-kallang.php');

include('offside.php');
include('hyfa.php');

?>
</html>
