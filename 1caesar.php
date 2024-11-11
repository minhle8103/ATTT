<!DOCTYPE html>
<html lang="vi">
<head>
     <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
  <meta name="author" content="GeeksLabs">
  <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
  <link rel="shortcut icon" href="img/favicon.png">

  <title>Caesar | Thuật toán mã hóa</title>

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
        /* Thiết lập toàn bộ trang */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #e0eafc, #cfdef3);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }
        
        /* Hộp chứa form */
        .container {
            background: white;
            width: 100%;
            max-width: 420px;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            text-align: center;
            transition: all 0.3s;
        }
        .container:hover {
            box-shadow: 0 6px 15px rgba(0,0,0,0.3);
        }
        
        /* Tiêu đề */
        h1 {
            background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%);
            padding: 15px;
            border-radius: 10px;
            color: #fff;
            text-align: center;
            font-size: 26px;
            font-weight: 600;
            margin-bottom: 20px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.15);
        }

        /* Ô nhập liệu */
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border 0.3s;
        }
        input[type="text"]:focus, input[type="number"]:focus {
            border-color: #4e54c8;
            outline: none;
            box-shadow: 0 0 5px rgba(78, 84, 200, 0.3);
        }

        /* Nút bấm */
        input[type="submit"] {
            width: 48%;
            padding: 12px;
            margin-top: 15px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
            color: white;
            transition: background 0.3s;
        }
        input[name="encrypt"] {
            background: #4CAF50;
        }
        input[name="encrypt"]:hover {
            background: #45a049;
        }
        input[name="decrypt"] {
            background: #f44336;
        }
        input[name="decrypt"]:hover {
            background: #e53935;
        }
        .buttons {
            display: flex;
            margin-top: 15px;
            justify-content: center;
        }

        button {
            width: 35%;
            padding: 10px;
            margin: 10px 10px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
            background: linear-gradient(90deg, #5f0db2 0%, #1b62d8 100%);
            transform: translateY(-2px);
        }

        button:active {
            background: linear-gradient(90deg, #4d0d9d 0%, #1549b0 100%);
        }

        button:focus {
            outline: none;
            box-shadow: 0px 0px 8px rgba(37, 117, 252, 0.4);
        }
       
        /* Nút chọn tệp */
        #file-upload {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
        }
        

        /* Kết quả */
        .result {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            background: #e7f4e4;
            font-size: 18px;
            color: #333;
        }
    </style>
     <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
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
            <h3 class="page-header"><i class="fa fa-files-o"></i> CAESAR</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.html">Home</a></li>
              <li><i class="icon_circle-slelected"></i>Caesar</li>
            </ol>
          </div>
        </div>
<div class="container">
    <h2>Mã hóa Caesar</h2>
    <form method="post">
        <div >
            <label for="file-upload">Tải file chứa văn bản mã hóa:</label>
            <input type="file" id="file-upload" onchange="loadFile(event)" />
        </div>
        <input type="text" name="text" placeholder="Nhập văn bản" required>
        <input type="number" name="shift" placeholder="Nhập số dịch chuyển" required>
        <div class="buttons">
            <button type="submit" name="encrypt">Mã hóa</button>
            <button type="submit" name="decrypt">Giải mã</button>
        </div>
        <?php
    // Hàm mã hóa và giải mã Caesar
    function caesarCipher($text, $shift, $decrypt = false) {
        $result = "";  // Khởi tạo một chuỗi rỗng để lưu kết quả mã hóa/giải mã

        // Điều chỉnh số dịch chuyển nếu nó lớn hơn 26 (vì có 26 chữ cái trong bảng chữ cái tiếng Anh)
        $shift = $shift % 26;  
        
        // Nếu yêu cầu giải mã, thay đổi hướng dịch chuyển (giải mã là dịch chuyển ngược lại)
        if ($decrypt) {
            $shift = 26 - $shift;  
        }
    
        // Duyệt qua từng ký tự trong chuỗi văn bản
        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];  // Lấy ký tự tại vị trí $i trong chuỗi văn bản
    
            // Kiểm tra xem ký tự có phải là chữ cái hay không
            if (ctype_alpha($char)) {
                // Nếu là chữ cái, xác định mã ASCII của ký tự và xác định là chữ hoa hay chữ thường
                $ascii_offset = ctype_upper($char) ? ord('A') : ord('a');
                
                // Áp dụng công thức mã hóa Caesar, tính toán và chuyển sang ký tự mới
                $encrypted_char = chr(($ascii_offset + (ord($char) - $ascii_offset + $shift) % 26));
                
                // Thêm ký tự đã mã hóa vào chuỗi kết quả
                $result .= $encrypted_char;
            } else {
                // Nếu ký tự không phải là chữ cái (ví dụ dấu cách hoặc dấu câu), giữ nguyên
                $result .= $char;
            }
        }
        
        // Trả về chuỗi kết quả
        return $result;  
    }

    // Kiểm tra xem yêu cầu là phương thức POST (tức là người dùng đã gửi form)
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Lấy dữ liệu từ form: văn bản cần mã hóa/giải mã và số dịch chuyển
        $text = $_POST['text'];
        $shift = $_POST['shift'];
        
        // Kiểm tra xem người dùng có yêu cầu giải mã không (nếu có thì $_POST['decrypt'] sẽ tồn tại)
        $isDecrypt = isset($_POST['decrypt']);
        
        // Gọi hàm caesarCipher để thực hiện mã hóa/giải mã
        $output = caesarCipher($text, $shift, $isDecrypt);
        
        // Hiển thị kết quả trên trang
        echo "<div class='result'><strong>Kết quả:</strong> $output</div>";

        // Hiển thị nút để tải kết quả về dưới dạng file .txt
        echo "<button onclick='downloadFile(\"$output\")'>Tải kết quả ra file</button>";
    }
?>
    </form>
      </section>
    </section>
  </section>
    <script>
        function loadFile(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                const content = e.target.result.split("\n");
                if (content.length >= 2) {
                    document.querySelector('input[name="text"]').value = content[1].trim();
                }
            };
            reader.readAsText(file);
        }

        function downloadFile(resultText) {
            const blob = new Blob([resultText], { type: 'text/plain' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'result.txt';
            link.click();
        }
    </script>

    <!-- Nhập file -->

</body>
</html>
