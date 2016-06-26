<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Sportscanner</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
</head>
<?php
include('simple_html_dom.php');
$date = $_GET['date'];
$startTime = $_GET['startTime'];
$endTime = $_GET['endTime'];
$range = $endTime - $startTime;
?>
<form action="search.php" method="GET">
<input type='date' name='date' value='<?php echo $date;?>'>
Start:
<select name='startTime'>
  <option <?php if($startTime == '07:00'){echo("selected");}?> value="07:00">7:00 am</option>
  <option <?php if($startTime == '08:00'){echo("selected");}?> value="08:00">8:00 am</option>
  <option <?php if($startTime == '09:00'){echo("selected");}?> value="09:00">9:00 am</option>
  <option <?php if($startTime == '10:00'){echo("selected");}?> value="10:00">10:00 am</option>
  <option <?php if($startTime == '11:00'){echo("selected");}?> value="11:00">11:00 am</option>
  <option <?php if($startTime == '12:00'){echo("selected");}?> value="12:00">12:00 pm</option>
  <option <?php if($startTime == '13:00'){echo("selected");}?> value="13:00">1:00 pm</option>
  <option <?php if($startTime == '14:00'){echo("selected");}?> value="14:00">2:00 pm</option>
  <option <?php if($startTime == '15:00'){echo("selected");}?> value="15:00">3:00 pm</option>
  <option <?php if($startTime == '16:00'){echo("selected");}?> value="16:00">4:00 pm</option>
  <option <?php if($startTime == '17:00'){echo("selected");}?> value="17:00">5:00 pm</option>
  <option <?php if($startTime == '18:00'){echo("selected");}?> value="18:00">6:00 pm</option>
  <option <?php if($startTime == '19:00'){echo("selected");}?> value="19:00">7:00 pm</option>
  <option <?php if($startTime == '20:00'){echo("selected");}?> value="20:00">8:00 pm</option>
  <option <?php if($startTime == '21:00'){echo("selected");}?> value="21:00">9:00 pm</option>
  <option <?php if($startTime == '22:00'){echo("selected");}?> value="22:00">10:00 pm</option>
  <option <?php if($startTime == '23:00'){echo("selected");}?> value="23:00">11:00 pm</option>
</select>
End:
<select name='endTime'>
  <option <?php if($endTime == '08:00'){echo("selected");}?> value="08:00">8:00 am</option>
  <option <?php if($endTime == '09:00'){echo("selected");}?> value="09:00">9:00 am</option>
  <option <?php if($endTime == '10:00'){echo("selected");}?> value="10:00">10:00 am</option>
  <option <?php if($endTime == '11:00'){echo("selected");}?> value="11:00">11:00 am</option>
  <option <?php if($endTime == '12:00'){echo("selected");}?> value="12:00">12:00 pm</option>
  <option <?php if($endTime == '13:00'){echo("selected");}?> value="13:00">1:00 pm</option>
  <option <?php if($endTime == '14:00'){echo("selected");}?> value="14:00">2:00 pm</option>
  <option <?php if($endTime == '15:00'){echo("selected");}?> value="15:00">3:00 pm</option>
  <option <?php if($endTime == '16:00'){echo("selected");}?> value="16:00">4:00 pm</option>
  <option <?php if($endTime == '17:00'){echo("selected");}?> value="17:00">5:00 pm</option>
  <option <?php if($endTime == '18:00'){echo("selected");}?> value="18:00">6:00 pm</option>
  <option <?php if($endTime == '19:00'){echo("selected");}?> value="19:00">7:00 pm</option>
  <option <?php if($endTime == '20:00'){echo("selected");}?> value="20:00">8:00 pm</option>
  <option <?php if($endTime == '21:00'){echo("selected");}?> value="21:00">9:00 pm</option>
  <option <?php if($endTime == '22:00'){echo("selected");}?> value="22:00">10:00 pm</option>
  <option <?php if($endTime == '23:00'){echo("selected");}?> value="23:00">11:00 pm</option> 
  <option <?php if($endTime == '24:00'){echo("selected");}?> value="24:00">12 Midnight</option>
</select>
<input type="submit" value="Search">
</form>

<br>
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
</html>

