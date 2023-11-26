 <?php include "database.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>PHP Quizzer!</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
</head>

<body>
  <div id="container">
      <header>
        <div class="container">
          <h1>Exam Hero</h1>
	</div>
      </header>


  <main>
  <div class="container">
    <h2>DSE Fighter! Ready! Set! Go!</h2>

  <?php
	//Get the total questions
	$query="select count(*) as total from questions";
	$results = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  $row = $results->fetch_assoc();
  $total = $row['total'];
 ?>

<a href="question.php">隨機測驗</a>

<h2>歷屆試題</h2>
<a href="question.php?year=2014">2014</a>
<a href="question.php?year=2015">2015</a>
<a href="question.php?year=2016">2016</a>
<a href="question.php?year=2017">2017</a>
<a href="question.php?year=2018">2018</a>
<a href="question.php?year=2019">2019</a>
<a href="question.php?year=2020">2020</a>
2021 2022 2023


<HR>
<h2><a href="https://www.edb.gov.hk/attachment/tc/curriculum-development/kla/technology-edu/curriculum-doc/ICT_C&amp;A%20Guide_c_final.pdf">
  課程大綱</a></h2>


<h2>A 資訊處理</h2>
  <p>A01: 資訊處理簡介<br>1.1 資訊系統<br>1.2 數據和資訊<br>1.3 資訊處理<br>1.4 資訊時代</p>
  <p>A02: 數據控制及數據組織<br>2.1 數據分級<br>2.2 數據控制<br>2.3 數據庫的功能<br>2.4 檔案存取方式</p>
  <p>A03: 數據表示<br>3.1 數字系統與表示法<br>3.2 字符編碼<br>3.3 條碼編碼<br>3.4 模擬及數碼數據<br>3.5 多媒體</p>

  <p>A04: 試算表<br>
  4.1 試算表簡介<br>
  4.2 數據輸入<br>
  <a href="question.php?chapter=HA1_CH4_2">4.3 公式</a><br>
  4.4 函數<br>
  4.5 儲存格參照<br>
  4.6 數據操縱和演示<br>
  4.7 數據分析</p>

  <p>A05: 數據庫<br>5.1 數據庫簡介<br>5.2 Access物件<br>5.3 數據庫結構<br>5.4 數據庫設計<br>5.5 數據操縱<br>5.6 基本查詢<br>5.7 Access函數</p>
<h2>B 電腦系統基礎</h2>
  <p>B01: 輸入及輸出設備<br>1.1 輸入-處理-輸出周期<br>1.2 輸入設備<br>1.3 輸出設備<br>1.4 電腦應用</p>
  <p>B02: 電腦硬件<br>2.1 主機<br>2.2 中央處理器<br>2.3 儲存設備<br>2.4 電腦種類<br>2.5 硬件最新發展</p>
  <p>B03: 電腦軟件<br>3.1 電腦系統<br>3.2 系統軟件<br>3.3 應用軟件<br>3.4 運作方式</p>

<h2>C 互聯網及其應用</h2>
  <p>C01: 建網及互聯網基本知識<br>1.1 網絡簡介<br>1.2 網絡架構<br>1.3 網絡服務<br>1.4 網絡硬件<br>1.5 互聯網接達方法</p>
  <p>C02: 互聯網協定<br>2.1 傳輸控制協定/互聯網協定(TCP/IP)<br>2.2 互聯網協定(IP)位址<br>2.3 網域名稱系統(DNS)<br>2.4 劃一資源定位(URL)<br>2.5 網絡協定</p>
  <p>C03: 互聯網服務及應用<br>3.1 互聯網的應用<br>3.2 網上服務<br>3.3 資訊搜尋<br>3.4 網絡多媒體<br>3.5 流式傳輸</p>
  <p>C04: 初級網頁創作<br>4.1 網頁基本構件<br>4.2 超文本標示語言<br>4.3 網站架構<br>4.4 網頁界面設計<br>4.5 發佈網站</p>
  <p><a href="question.php?hashtag=網絡安全">C05: 網絡安全和私隱威脅</a><br>
  5.1 網絡安全風險<br>5.2 改善網絡保安的有效措施<br>5.3 網絡私隱威脅<br>5.4 保護網絡私隱的方法</p>
  <p>C06: 網絡保安措施<br>6.1 資訊加密技術<br>6.2 認證方法<br>6.3 網上交易中的安全措施<br>6.4 最新網絡安全措施</p>

<h2>D 計算思維與程式編寫</h2>
  <p>D01: 問題建構和分析<br>1.1 界定問題<br>1.2 分析問題<br>1.3 拆解問題<br>1.4 辨別相似問題的共同元素<br>1.5 設計用戶界面和元件<br>1.6 解難程序</p>
  <p>D02:算法設計(一)<br>2.1 算法<br>2.2 算法的基本控制結構</p>
  <p>D03:算法設計(二)<br>3.1 追蹤表<br>3.2 數據結構<br>3.3 陣列的基本算法<br>3.4 邏輯錯誤<br>3.5 運用模組化的好處</p>
  <p>D04: Python 編程入門<br>4.1 程式開發<br>4.2 基礎編程概念<br>4.3 選擇<br>4.4 迭代</p>
  <p>D05: Python 綜合解難<br>5.1 列表<br>5.2 列表綜合應用<br>5.3 Python 字串的綜合應用<br>5.4 綜合編程</p>
  <p>D06: 程式測試和除錯<br>6.1 測試程式<br>6.2 程式錯誤及除錯<br>6.3 程式設計<br>6.4 算法比較</p>

<h2>E 資訊及通訊科技對社會的影響</h2>
  <p>E01: 科技創新<br>1.1 人工智能和數據科學<br>1.2 3D 打印技術<br>1.3 3D 視覺化</p>
  <p>E02: 健康及道德議題<br>2.1 健康與安全<br>2.2 網絡成癮<br>2.3 資訊自由<br>2.4 網絡欺凌<br>2.5 信息可靠性<br>2.6 數碼平等和數碼隔閡<br>2.7 資訊科技與環境</p>
  <p>E03: 知識產權<br>3.1 知識產權<br>3.2 版權<br>3.3 侵犯版權<br>3.4 教學與版權<br>3.5 保護知識產權<br>3.6 軟件特許使用權<br>3.7 保護知識產權的科技</p>

  <HR>
  <h2 id=hashtag>關鍵詞語</h2>

<?php
  $query="select hashtag, description_zh from hashtags";
  $results = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  while($row = $results->fetch_assoc()) {
    echo "<a href='question.php?keyword=$row[hashtag],$row[description_zh]'>#$row[hashtag] </a> ";
  }
  ?>





      </div>
    </div>
    </main>


    <footer>
      <div class="container">
      	   Copyright CO Wong
      </div>
    </footer>
  </body>
</html>