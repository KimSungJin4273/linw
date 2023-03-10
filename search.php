<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$keyword = $_GET['keyword'];
	$minNumber = $_GET['minNumber'];
	$maxNumber = $_GET['maxNumber'];
	
	$url = 'https://www.barotem.com/product/lists/3006?page=1&sell=sell&group=3006r04&display=1&orderby=1&isSearch=1';
	$html = file_get_contents($url);
	$dom = new DOMDocument();
	libxml_use_internal_errors(true);
	$dom->loadHTML($html);
	$xpath = new DOMXPath($dom);
	
	$items = $xpath->query('//div[contains(@class, "col-inner") and contains(h3/text(), "'.$keyword.'")]');
	
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
		
		$results .= '<div class="item">';
		$results .= '<h3><a href="'.$link.'">'.$title.'</a></h3>';
		$results .= '<p>'.$price.'</p>';
		$results .= '</div>';
	}
	
	echo $results;
}
