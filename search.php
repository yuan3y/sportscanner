<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Sportscanner</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
<link rel="stylesheet" href="styles.css">
</head>
<?php
include('simple_html_dom.php');
$date = $_GET['date'];
$startTime = $_GET['startTime'];
$endTime = $_GET['endTime'];
$range = $endTime - $startTime;
?>
<body>
<center>
<div class="searchBox">
<h1>Find futsal pitches</h1>
<form action="search.php" method="GET">
<input type='date' name='date' style="width:295px; font-size:20px; height:40px;" value='<?php echo date("Y-m-d");?>'>
<br><br>
<select name='startTime' class="searchBoxTime">
  <option selected disabled>Start</option>
  <option value="07:00">7:00 am</option>
  <option value="08:00">8:00 am</option>
  <option value="09:00">9:00 am</option>
  <option value="10:00">10:00 am</option>
  <option value="11:00">11:00 am</option>
  <option value="12:00">12:00 pm</option>
  <option value="13:00">1:00 pm</option>
  <option value="14:00">2:00 pm</option>
  <option value="15:00">3:00 pm</option>
  <option value="16:00">4:00 pm</option>
  <option value="17:00">5:00 pm</option>
  <option value="18:00">6:00 pm</option>
  <option value="19:00">7:00 pm</option>
  <option value="20:00">8:00 pm</option>
  <option value="21:00">9:00 pm</option>
  <option value="22:00">10:00 pm</option>
  <option value="23:00">11:00 pm</option>
</select>
<select name='endTime' class="searchBoxTime">
  <option selected disabled>End</option>
  <option value="09:00">9:00 am</option>
  <option value="10:00">10:00 am</option>
  <option value="11:00">11:00 am</option>
  <option value="12:00">12:00 pm</option>
  <option value="13:00">1:00 pm</option>
  <option value="14:00">2:00 pm</option>
  <option value="15:00">3:00 pm</option>
  <option value="16:00">4:00 pm</option>
  <option value="17:00">5:00 pm</option>
  <option value="18:00">6:00 pm</option>
  <option value="19:00">7:00 pm</option>
  <option value="20:00">8:00 pm</option>
  <option value="21:00">9:00 pm</option>
  <option value="22:00">10:00 pm</option>
  <option value="23:00">11:00 pm</option>
  <option value="24:00">12 Midnight</option>  
</select>
<br><br>
<input type="submit" value="Search" class="btn">
</form>
<br>
</div>
<div id="results"><?php
$i=0;
$rangeArray = array();
array_push($rangeArray, $startTime);

while ($i < ($range-1)) {
  $startTime = strtotime($startTime) + 60*60;
  $startTime = date('H:i', $startTime);
  array_push($rangeArray, $startTime);
  $i++;
}

include('kallang.php');
include('bukittimah5.php');
include('bukittimah11.php');
include('offside.php');
include('hyfa.php');
?></div>

<script>
var theDiv = document.getElementById("results");

if(theDiv.innerHTML.length == 0){
    theDiv.innerHTML = "No available pitches within this time range :(";
    theDiv.style.display="inline";
}
</script>
</center>

</body>
</html>