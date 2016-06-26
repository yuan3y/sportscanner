<?php
$date = date_format(new DateTime($date), "j+F+Y,l");
$node_count_hyfa = 10;

$curl_arr_hyfa = array();
$master_hyfa = curl_multi_init();

for ($i = 0; $i < $node_count_hyfa; $i++) {
    $curl_arr_hyfa[$i] = curl_init();
    curl_setopt_array($curl_arr_hyfa[$i], array(
        CURLOPT_URL => "http://hyfa.com.sg/book-pitch/PitchSlots",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "date=" . $date . "&pitchID=" . ($i+1),
        CURLOPT_HTTPHEADER => array(
            "accept: application/json, text/javascript, */*; q=0.01",
            "accept-encoding: gzip, deflate",
            "accept-language: en,en-GB;q=0.8,zh-CN;q=0.6,zh;q=0.4,zh-TW;q=0.2,fr;q=0.2",
            "cache-control: no-cache",
            "connection: keep-alive",
            "content-type: application/x-www-form-urlencoded; charset=UTF-8",
            "origin: http://hyfa.com.sg",
            "pragma: no-cache",
            "referer: http://hyfa.com.sg/book-pitch/",
            "x-requested-with: XMLHttpRequest"
        ),
    ));
    curl_multi_add_handle($master_hyfa, $curl_arr_hyfa[$i]);
}

do {
    curl_multi_exec($master_hyfa, $running);
} while ($running > 0);


for ($i = 0; $i < $node_count_hyfa; $i++) {
    $results_hyfa[] = curl_multi_getcontent($curl_arr_hyfa[$i]);
}
//print_r($results_hyfa);

$bucket = array();

// For each pitch...
for ($i = 0; $i < $node_count_hyfa; $i++) {
    $response = $results_hyfa[$i];

    $res_arr = json_decode($response);

    # Create a DOM parser object
    $dom = new DOMDocument();

    # Parse the HTML from Google.
    # The @ before the method call suppresses any warnings that
    # loadHTML might throw because of invalid HTML in the page.
    @$dom->loadHTML($res_arr->{"slots"});

    # Iterate over all the <a> tags
    foreach ($dom->getElementsByTagName('input') as $input) {
        if (!$input->attributes->getNamedItem("disabled")) {
            $v = $input->getAttribute('value');
            if (isset($bucket[$v])) $bucket[$v][]= $i+1;
            else {
                $bucket[$v] = array();
                $bucket[$v][] = $i+1;
            }
        }
    }

    curl_multi_remove_handle($master_hyfa, $curl_arr_hyfa[$i]);
    curl_close($curl_arr_hyfa[$i]);
}

$name = 1;
foreach ($rangeArray as $key => $value) {
    ${"time$name"} = $bucket[$value.":00"];
    $name++;
}

$resultArray = array();
for ($i = 1; $i <= $range; $i++) {
    $resultArray[] = ${'time'.$i};
}

if (count($resultArray) === 1) {
    //print_r($time1);
    foreach ($time1 as $key => $value) {
        echo "<a href='http://hyfa.com.sg/book-pitch/' target='_blank'>Hyfa ";
        if ($value <= 2){
            echo "(7 aside)";
        }elseif ($value >=3 && $value <=10) {
            echo "(5 aside)";
        }
        echo " - Pitch ".$value."</a><br/>";
    }
} else{
    $isect = call_user_func_array('array_intersect', $resultArray);
    //print_r($isect);
    foreach ($isect as $key => $value) {
        echo "<a href='http://hyfa.com.sg/book-pitch/' target='_blank'>Hyfa ";
        if ($value <= 2){
            echo "(7 aside)";
        }elseif ($value >=3 && $value <=10) {
            echo "(5 aside)";
        }
        echo " - Pitch ".$value."</a><br/>";    }
}

curl_multi_close($master_hyfa);

?>