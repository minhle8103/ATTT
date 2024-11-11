<!DOCTYPE html>
<html lang="vi">
<head>
   <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Diffie-Hellman | Thuật toán mã hóa</title>

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <!-- Custom styles -->
    <style>
        body {  
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #e0eafc, #cfdef3);
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        h2 {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        p {
            font-size: 16px;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

        .formula {
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
</head>
<body>
    <section id="container" class="">
    <?php include "header.php" ?>
    <?php include "sidebar.php" ?>

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-files-o"></i> DIFIE-HELLMAN</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.html">Home</a></li>
              <li><i class="icon_circle-slelected"></i>Diffie-Hellman</li>
            </ol>
          </div>
        </div>
    <div class="container">
        <h2>Mã hóa Diffie-Hellman</h2>
        <form method="POST" action="">
            <input type="number" name="p" placeholder="Nhập số nguyên tố p" required>
            <input type="number" name="alpha" placeholder="Nhập số gốc alpha (α)" required>
            <input type="number" name="alicePrivateKey" placeholder="Khóa riêng của Alice " required>
            <input type="number" name="bobPrivateKey" placeholder="Khóa riêng của Bob " required>
            <button type="submit">Tính khóa chung</button>
        </form>
        <?php
        function isPrime($n) {
            if ($n <= 1) return false;
            for ($i = 2; $i * $i <= $n; $i++) {
                if ($n % $i == 0) return false;
            }
            return true;
        }

        function calculatePublicKey($alpha, $privateKey, $p) {
            return bcpowmod($alpha, $privateKey, $p);
        }

        function calculateSharedKey($publicKey, $privateKey, $p) {
            return bcpowmod($publicKey, $privateKey, $p);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $p = intval($_POST['p']);
            $alpha = intval($_POST['alpha']);
            $alicePrivateKey = intval($_POST['alicePrivateKey']);
            $bobPrivateKey = intval($_POST['bobPrivateKey']);

            // Kiểm tra đầu vào
            if (!isPrime($p)) {
                echo "<p class='error'>Lỗi: p phải là số nguyên tố!</p>";
                exit;
            }
            if ($alpha <= 0) {
                echo "<p class='error'>Lỗi: alpha (α) phải là số dương!</p>";
                exit;
            }

            // Kiểm tra nếu alpha giống nhau
            if ($alpha !== intval($_POST['alpha'])) {
                echo "<p class='error'>Lỗi: Cơ số (α) của Alice và Bob không giống nhau!</p>";
                exit;
            }

            // Tính toán khóa công khai
            $alicePublicKey = calculatePublicKey($alpha, $alicePrivateKey, $p);
            $bobPublicKey = calculatePublicKey($alpha, $bobPrivateKey, $p);

            // Tính toán khóa chung
            $aliceSharedKey = calculateSharedKey($bobPublicKey, $alicePrivateKey, $p);
            $bobSharedKey = calculateSharedKey($alicePublicKey, $bobPrivateKey, $p);

            echo "<p>Số nguyên tố (p): $p</p>";
            echo "<p>Số gốc alpha (α): $alpha</p>";
            echo "<p>Khóa riêng của Alice (X<sub>A</sub>): $alicePrivateKey</p>";
            echo "<p>Khóa riêng của Bob (X<sub>B</sub>): $bobPrivateKey</p>";
            echo "<p>________________________________________</p>";
            echo "<p class='formula'>Công thức tính khóa công khai của Alice:</br> Y<sub>A</sub> = α<sup>X<sub>A</sub></sup> mod p = $alpha<sup>$alicePrivateKey</sup> mod $p = $alicePublicKey</p>";
            echo "<p class='formula'>Công thức tính khóa công khai của Bob:</br> Y<sub>B</sub> = α<sup>X<sub>B</sub></sup> mod p = $alpha<sup>$bobPrivateKey</sup> mod $p = $bobPublicKey</p>";
            echo "<p>Khóa chung tính bởi Alice:</br> K = Y<sub>B</sub><sup>X<sub>A</sub></sup> mod p = $bobPublicKey<sup>$alicePrivateKey</sup> mod $p = $aliceSharedKey</p>";
            echo "<p>Khóa chung tính bởi Bob:</br> K = Y<sub>A</sub><sup>X<sub>B</sub></sup> mod p = $alicePublicKey<sup>$bobPrivateKey</sup> mod $p = $bobSharedKey</p>";

            // Kiểm tra khóa chung có giống nhau không
            if ($aliceSharedKey === $bobSharedKey) {
                echo "<p class='success'>Khóa chung được trao đổi thành công: $aliceSharedKey</p>";
            } else {
                echo "<p class='error'>Lỗi: Khóa chung không khớp!</p>";
            }
        }
        ?>    
    </div>
</section>
</section>
</section>
</body>
</html>
