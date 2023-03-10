<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $keyword = $_POST["keyword"];
    $minNumber = $_POST["minNumber"];
    $maxNumber = $_POST["maxNumber"];
    
    $html = file_get_contents('https://linw.net/search?q=' . urlencode($keyword));
    $dom = new DOMDocument();
    @$dom->loadHTML($html);
    $xpath = new DOMXPath($dom);
    $items = $xpath->query('//div[contains(@class, "col-inner") and h3[contains(text(), "'.$keyword.'")]]');
    if ($minNumber && $maxNumber) {
        $filteredItems = array();
        foreach ($items as $item) {
            $price = $xpath->query('.//span[contains(@class, "price")]/text()', $item)->item(0)->nodeValue;
            $price = preg_replace('/[^0-9]/', '', $price);
            if ($price >= $minNumber && $price <= $maxNumber) {
                array_push($filteredItems, $item);
            }
        }
        $items = $filteredItems;
    }
    $results = '';
    foreach ($items as $item) {
        $title = $xpath->query('.//h3/text()', $item)->item(0)->nodeValue;
        $link = $xpath->query('.//a/@href', $item)->item(0)->nodeValue;
        $price = $xpath->query('.//span[contains(@class, "price")]/text()', $item)->item(0)->nodeValue;
        $results .= '
';
        $results .= '
'.$title.'
';
        $results .= '
'.$price.'

';
        $results .= '
';
    }
    echo $results;
}
?>
