<!-- End session and display score -->
<?php session_start(); ?>
<?php 
$score = $_SESSION['score'];
$total = $_SESSION['total'];
$percentage = round(($score / $total) * 100, 2);
if (isset($_GET['title'])) {
    $title = $_GET['title'];
} else {
    $title = "";
}
$date = date("F j, Y");
$time = date("g:i a");
?>


<html>
<head>
    <meta charset="utf-8" />
    <title>Exam Hero</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background: #f0f0f0;
        margin: 0;
        padding: 0;
    }
    .certificate {
        margin: 50px auto;
        padding: 25px;
        background: #fff;
        border: 1px solid #ddd;
        width: 80%;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    .certificate h1 {
        margin-top: 0;
    }
    .certificate h2 {
        color: #666;
    }
    .certificate p {
        font-size: 1.2em;
        color: #333;
    }
    </style>
    <script src="js/jquery-3.7.1.min.js"></script>
</head>
<body>
    <div class="certificate">
        <h1>Exam Hero</h1>
        <h2>恭喜您完成測試!</h2>
        <p></p>
        <p><strong><?php echo $title; ?></strong></p>
        <p>您在這次的測驗中得到了：</p>
        <p><big><strong><?php echo "$score / $total ($percentage%)"; ?></strong></big></p>
        <p>日期：<?php echo $date; ?> <?php echo $time; ?></p>
        <p> <a href="index.php">回到主頁</a></p>
    </div>
</body>
</html>
<?php session_destroy();?>