<?php

// 검색어 및 범위 지정
$keyword = '밸브';
$minNumber = 150;
$maxNumber = 180;

// 크롤링 대상 URL
$url = 'https://www.barotem.com/product/lists/3006?page=1&sell=sell&group=3006r04&display=1&orderby=1&isSearch=1';

// 1분에 한 번씩 실행
while (true) {

  // HTML 데이터 가져오기
  $html = file_get_contents($url);

  // DOMDocument 객체 생성
  $dom = new DOMDocument();

  // HTML 데이터 로드
  @$dom->loadHTML($html);

  // DOMXPath 객체 생성
  $xpath = new DOMXPath($dom);

  // 검색어가 포함된 항목 검색
  $items = $xpath->query('//div[contains(@class, "col-inner") and contains(h3/text(), "'.$keyword.'")]');

  // 범위에 맞는 항목 필터링
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

  // 검색 결과 출력
  $results = '';
  foreach ($items as $item) {
    $title = $xpath->query('.//h3/text()', $item)->item(0)->nodeValue;
    $link = $xpath->query('.//a/@href', $item)->item(0)->nodeValue;
    $price = $xpath->query('.//span[contains(@class, "price")]/text()', $item)->item(0)->nodeValue;
    $results .= '
      <div>
        <a href="'.$link.'">'.$title.'</a>
        <span>'.$price.'</span>
      </div>
    ';
  }
  echo $results;

  // 1분 대기
  sleep(60);

}

?>
