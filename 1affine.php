<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
  <meta name="author" content="GeeksLabs">
  <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
  <link rel="shortcut icon" href="img/favicon.png">

  <title>Affine | Thuật toán mã hóa</title>

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
        /* Căn chỉnh và thiết kế tổng thể */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
            width: 500px;
            text-align: center;
        }
        h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .buttons {
            display: flex;
            margin-top: 15px;
            justify-content: center;
        }
        button {
            width: 35%;
            padding: 10px;
            margin: 10px 1%;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .result {
            margin-top: 20px;
            font-weight: bold;
            color: #333;
            font-size: 18px;
        }
    </style>
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
  <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
      <script src="js/lte-ie7.js"></script>
    <![endif]-->

    <!-- =======================================================
      Theme Name: NiceAdmin
      Theme URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
      Author: BootstrapMade
      Author URL: https://bootstrapmade.com
    ======================================================= -->
</head>

<body>
  <!-- container section start -->
  <section id="container" class="">
    <?php include "header.php" ?>
    <?php include "sidebar.php" ?>

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-files-o"></i> AFFINE</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.html">Home</a></li>
              <li><i class="icon_circle-slelected"></i>Affine</li>
            </ol>
          </div>
        </div>
        <div class="container">
    <h2>Mã hóa Affine</h2>
    <form method="post">
    <input type="file" id="fileInput" accept=".txt" onchange="loadFile(event)">
    <br><br>
        <input type="text" name="a" placeholder="Nhập hệ số a" required>
        <input type="text" name="b" placeholder="Nhập hệ số b" required>
        <input type="text" name="plaintext" placeholder="Nhập văn bản cần mã hóa hoặc giải mã" required>
        
        <!-- Nút mã hóa và giải mã -->
        <div class="buttons">
        <button type="submit" name="action" value="encrypt">Mã hóa</button>
        <button type="submit" name="action" value="decrypt">Giải mã</button>
        </div>
        <!-- Kết quả -->
        <div class="result">
            <?php
            $result = "";
            
            function gcd($a, $b) {
                while ($b != 0) {
                    $temp = $b;
                    $b = $a % $b;
                    $a = $temp;
                }
                return $a;
            }

            function modInverse($a, $m) {
                $a = $a % $m;
                for ($x = 1; $x < $m; $x++) {
                    if (($a * $x) % $m == 1)
                        return $x;
                }
                throw new Exception("Không tìm thấy nghịch đảo modulo!");
            }
            function isValidB($b) {
                // Kiểm tra xem b có phải là số nguyên không và nằm trong phạm vi từ 1 đến 25
                if (is_numeric($b)) {
                    $b = (int)$b;  // Chuyển đổi giá trị thành số nguyên
                    return ($b >= 1 && $b <= 25);  // Kiểm tra nếu b nằm trong khoảng từ 1 đến 25
                }
                return false;  // Nếu b không phải là số hợp lệ
            }
            
            function affineEncrypt($text, $a, $b) {
                if (gcd($a, 26) != 1) {
                    throw new Exception("Giá trị 'a' phải là số nguyên tố cùng nhau với 26.");
                }
                $result = "";
                $text = strtoupper($text);

                foreach (str_split($text) as $char) {
                    if (ctype_alpha($char)) {
                        $x = ord($char) - ord('A');
                        $encryptedChar = chr((($a * $x + $b) % 26) + ord('A'));
                        $result .= $encryptedChar;
                    } else {
                        $result .= $char;
                    }
                }
                return $result;
            }

            function affineDecrypt($text, $a, $b) {
                if (gcd($a, 26) != 1) {
                    throw new Exception("Giá trị 'a' phải là số nguyên tố cùng nhau với 26.");
                }
                $result = "";
                $text = strtoupper($text);
                $a_inv = modInverse($a, 26);

                foreach (str_split($text) as $char) {
                    if (ctype_alpha($char)) {
                        $y = ord($char) - ord('A');
                        $decryptedChar = chr((($a_inv * ($y - $b + 26)) % 26) + ord('A'));
                        $result .= $decryptedChar;
                    } else {
                        $result .= $char;
                    }
                }
                return $result;
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                try {
                    $a = (int)$_POST["a"];
                    $b = $_POST["b"];
                    if (!isValidB($b)) {
                        throw new Exception("Giá trị 'b' phải là số nguyên trong phạm vi từ 1 đến 25.");
                    }
                    $b = (int)$b;            
                    $text = $_POST["plaintext"];
                    $action = $_POST["action"];

                    if ($action == "encrypt") {
                        $result = affineEncrypt($text, $a, $b);
                        echo "Kết quả mã hóa: " . $result;
                    } elseif ($action == "decrypt") {
                        echo "Kết quả giải mã: " . affineDecrypt($text, $a, $b);
                    }
                    // Tạo nút lưu kết quả vào file
                    echo "<br><button class='save-btn' id='saveButton' data-a='$a' data-b='$b' data-result='$result' type='button' onclick='handleSaveFile()'>Lưu kết quả</button>";
                } catch (Exception $e) {
                    echo "Lỗi: " . $e->getMessage();
                }
            }
            ?>
        </div>
    </form>
</div>

        <!-- page end-->
      </section>
    </section>
  </section>
  <!-- container section end -->

  <!-- javascripts -->
  <script>
    // Hàm tải file và điền giá trị a, b và văn bản từ file lên form
    function loadFile(event) {
        const file = event.target.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            const content = e.target.result.split("\n");
            if (content.length >= 2) {
                document.querySelector('input[name="a"]').value = content[0].trim();
                document.querySelector('input[name="b"]').value = content[1].trim();
                document.querySelector('input[name="plaintext"]').value = content[2].trim();
            }
        };
        reader.readAsText(file);
    }

    // Hàm lưu kết quả vào file
    function handleSaveFile() {
        const a = document.getElementById('saveButton').getAttribute('data-a');
        const b = document.getElementById('saveButton').getAttribute('data-b');
        const resultText = document.getElementById('saveButton').getAttribute('data-result');
        const blob = new Blob([a + "\n" + b + "\n" + resultText], { type: 'text/plain' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'result.txt';  // Tên file khi tải xuống
        link.click();
    }
</script>
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <!-- nice scroll -->
  <script src="js/jquery.scrollTo.min.js"></script>
  <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
  <!-- jquery validate js -->
  <script type="text/javascript" src="js/jquery.validate.min.js"></script>

  <!-- custom form validation script for this page-->
  <script src="js/form-validation-script.js"></script>
  <!--custome script for all page-->
  <script src="js/scripts.js"></script>


</body>

</html>
