<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Barotem 상품 검색</title>
  </head>
  <body>
    <form method="POST" action="search.php">
      <label>검색어:</label>
      <input type="text" name="keyword">
      <br><br>
      <label>최소 가격:</label>
      <input type="number" name="min_price">
      <br><br>
      <label>최대 가격:</label>
      <input type="number" name="max_price">
      <br><br>
      <input type="submit" value="검색">
    </form>
  </body>
</html>
