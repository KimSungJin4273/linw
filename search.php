<?php
header('Content-Type: text/html; charset=utf-8');
$url = $_GET['url'];
$keyword = $_GET['keyword'];
$minNumber = $_GET['minNumber'];
$maxNumber = $_GET['maxNumber'];

$html = file_get_contents($url);

$dom = new DOMDocument();
@$dom->loadHTML($html);

$xpath = new DOMXPath($dom);

$items = $xpath->query('//div[contains(@class, "col-inner")]');
$filteredItems = array();

foreach ($items as $item) {
    $title = $xpath->query('.//h3/a/text()', $item)->item(0)->nodeValue;
    if (stripos($title, $keyword) !== false) {
        $price = $xpath->query('.//span[contains(@class, "price")]/text()', $item)->item(0)->nodeValue;
        $price = preg_replace('/[^0-9]/', '', $price);
        if ($minNumber && $maxNumber) {
            if ($price >= $minNumber && $price <= $maxNumber) {
                $link = $xpath->query('.//h3/a/@href', $item)->item(0)->nodeValue;
                $filteredItems[] = array('title' => $title, 'price' => $price, 'link' => $link);
            }
        } else {
            $link = $xpath->query('.//h3/a/@href', $item)->item(0)->nodeValue;
            $filteredItems[] = array('title' => $title, 'price' => $price, 'link' => $link);
        }
    }
}

$results = '';
foreach ($filteredItems as $item) {
    $results .= '<div class="item">';
    $results .= '<h3><a href="' . $item['link'] . '">' . $item['title'] . '</a></h3>';
    $results .= '<p class="price">$' . number_format($item['price']) . '</p>';
    $results .= '</div>';
}

echo $results;
?>
