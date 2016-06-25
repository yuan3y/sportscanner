<?php
// number of pitches
$node_count = 4;
$curl_arr = array();
$master = curl_multi_init();

for ($i = 0; $i < $node_count; $i++) {
    $curl_arr[$i] = curl_init();
    curl_setopt_array($curl_arr[$i], array(
        CURLOPT_URL => "http://offside.com.sg/wp-content/plugins/booking-system/frontend-ajax.php",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => "action=dopbs_load_schedule&calendar_id=1&year=2016&groundId=1&pitchId=". ($i+1) . "&date=" . $date,
        CURLOPT_HTTPHEADER => array(
            "accept: application/json, text/javascript, */*; q=0.01",
            "accept-encoding: gzip, deflate",
            "accept-language: en,en-GB;q=0.8,zh-CN;q=0.6,zh;q=0.4,zh-TW;q=0.2,fr;q=0.2",
            "cache-control: no-cache",
            "connection: keep-alive",
            "content-type: application/x-www-form-urlencoded; charset=UTF-8",
            "origin: http://offside.com.sg",
            "pragma: no-cache",
            "referer: http://offside.com.sg/#section-thomson",
            "x-requested-with: XMLHttpRequest"
        ),

    ));
    curl_multi_add_handle($master, $curl_arr[$i]);
}

do {
    curl_multi_exec($master, $running);
} while ($running > 0);

for ($i = 0; $i < $node_count; $i++) {
    $results[] = curl_multi_getcontent($curl_arr[$i]);
}


// For each pitch..
for ($i = 0; $i < $node_count; $i++) {
    // each time finds an available, add to checkcount. if checkcount matches the number of hours in range ($range), will print result
    $checkCount = 0;
    $response = $results[$i];
	$json_array = json_decode($response, TRUE);

    foreach ($rangeArray as $key => $value) {
        $availability = $json_array[$date]['hours'][$value]['status'];
        if ($availability == "available"){
            $checkCount++;
        }
    }
        if ($checkCount == $range){
            echo "<a href='http://offside.com.sg/#section-thomson' target='_blank'>Offside Pitch -  ";
            echo $i+1;
            echo "</a><br/>";
        }

    curl_multi_remove_handle($master, $curl_arr[$i]);
    curl_close($curl_arr[$i]);
}

curl_multi_close($master);
?>