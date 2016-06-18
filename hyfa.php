<?php
//error_reporting(E_ALL | E_STRICT);
//ini_set('display_errors', 1);

$date = $_GET['date'];
$time = $_GET['time'];

$date = date_format(new DateTime($date), "j+F+Y,l");

$node_count = 12;

$curl_arr = array();
$master = curl_multi_init();

for ($i = 0; $i < $node_count; $i++) {
    $curl_arr[$i] = curl_init();
    curl_setopt_array($curl_arr[$i], array(
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
    curl_multi_add_handle($master, $curl_arr[$i]);
}

do {
    curl_multi_exec($master, $running);
} while ($running > 0);


for ($i = 0; $i < $node_count; $i++) {
    $results[] = curl_multi_getcontent($curl_arr[$i]);
}
//print_r($results);

$bucket = array();

for ($i = 0; $i < $node_count; $i++) {
    $response = $results[$i];

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
}

if (isset($bucket[$time.":00"]))
    foreach($bucket[$time.":00"] as $time)
    echo '<a href="http://hyfa.com.sg/book-pitch/">'.$time.'</a><br/>';
else
foreach ($bucket as $key=>$value){
    echo '<a href="http://hyfa.com.sg/book-pitch/">'.substr($key,0,5).'</a><br/>';
}

?>