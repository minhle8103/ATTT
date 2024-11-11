<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Mã hoán vị | Thuật toán mã hóa</title>

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
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #e0eafc, #cfdef3);
    color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
}

.container {
    background-color: #fff;
    padding: 25px 35px;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    max-width: 500px;
    width: 100%;
    
}



.title-background {
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

form {
    display: flex;
    flex-direction: column;
    gap: 18px;
}

label {
    font-weight: bold;
    color: #444;
    font-size: 15px;
}

textarea, input[type="text"] {
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
    resize: none;
    font-size: 16px;
    color: #333;
    background-color: #fafafa;
    box-shadow: inset 0px 2px 5px rgba(0, 0, 0, 0.05);
    transition: border-color 0.3s ease;
}

textarea:focus, input[type="text"]:focus {
    border-color: #4facfe;
    outline: none;
    box-shadow: 0px 0px 8px rgba(79, 172, 254, 0.3);
}

.result-box {
    background-color: #f1f4f9;
    color: #333;
    font-weight: 500;
}

.buttons {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
}

.buttons button {
    background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%);
    border: none;
    border-radius: 8px;
    padding: 10px;
    margin: 12px 1%;
    color: #fff;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.2s ease;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
}

.buttons button:hover {
    background: linear-gradient(90deg, #5f0db2 0%, #1b62d8 100%);
    transform: translateY(-2px);
}

.buttons button:active {
    background: linear-gradient(90deg, #4d0d9d 0%, #1549b0 100%);
    transform: translateY(0);
}

.buttons button:focus {
    outline: none;
    box-shadow: 0px 0px 8px rgba(37, 117, 252, 0.4);
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
            <h3 class="page-header"><i class="fa fa-files-o"></i> MÃ HOÁN VỊ</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.html">Home</a></li>
              <li><i class="icon_circle-slelected"></i>Mã hoán vị</li>
            </ol>
          </div>
        </div>
    <div class="container">
        <h2> Mã hóa Mã Hoán Vị</h2>
        <form id="form">
            <label for="text">Nhập văn bản:</label>
            <textarea id="text" name="text" rows="1"></textarea>

            <label for="key">Nhập khóa:</label>
            <input type="text" id="key" name="key">

            <label for="result">Kết quả:</label>
            <input type="text" id="result" class="result-box" readonly>

            <div class="buttons">
                <button type="button" onclick="processText('encrypt')">Mã hóa</button>
                <button type="button" onclick="processText('decrypt')">Giải mã</button>
                <button type="button" onclick="resetForm()">Làm mới</button>
                <!-- Nút Xuất file -->
                <button type="button" onclick="exportToFile()">Xuất file</button>
                
                <!-- Nút Mở file -->
                <button type="button" onclick="document.getElementById('fileInput').click()">Mở file</button>
                <input type="file" id="fileInput" style="display:none;" onchange="openFile(event)">
            </div>
        </form>
    </div>
    </section>
    </section>
  </section>

    <script>
        // Hàm mã hóa và giải mã
        function processText(action) {
            const text = document.getElementById("text").value;
            const key = document.getElementById("key").value;

            if (text && key) {
                const keyArray = key.split(',').map(Number);
                let result = '';

                if (action === 'encrypt') {
                    result = encrypt(text, keyArray);
                } else if (action === 'decrypt') {
                    result = decrypt(text, keyArray);
                }

                document.getElementById("result").value = result;
            } else {
                alert("Vui lòng nhập văn bản và khóa hợp lệ.");
            }
        }

        function encrypt(text, keyArray) {
            const keyLength = keyArray.length;
            const rows = Math.ceil(text.length / keyLength);
            const paddedText = text.padEnd(rows * keyLength);
            const grid = [];

            for (let i = 0; i < rows; i++) {
                grid.push(paddedText.slice(i * keyLength, (i + 1) * keyLength));
            }

            let encrypted = '';
            for (let i = 0; i < keyLength; i++) {
                const colIndex = keyArray.indexOf(i + 1);
                if (colIndex !== -1) {
                    for (let j = 0; j < rows; j++) {
                        encrypted += grid[j][colIndex] || '';
                    }
                }
            }
            return encrypted;
        }

        function decrypt(encrypted, keyArray) {
            const keyLength = keyArray.length;
            const rows = Math.ceil(encrypted.length / keyLength);
            const decryptedArray = Array.from({ length: rows }, () => Array(keyLength).fill(''));
            let index = 0;

            for (let i = 0; i < keyLength; i++) {
                const colIndex = keyArray.indexOf(i + 1);
                if (colIndex !== -1) {
                    for (let j = 0; j < rows; j++) {
                        if (index < encrypted.length) {
                            decryptedArray[j][colIndex] = encrypted[index++];
                        }
                    }
                }
            }

            return decryptedArray.map(row => row.join('')).join('').trim();
        }

        // Hàm tải kết quả về file
        function exportToFile() {
            const result = document.getElementById("result").value;
            if (result) {
                const blob = new Blob([result], { type: "text/plain" });
                const link = document.createElement("a");
                link.href = URL.createObjectURL(blob);
                link.download = "hang.txt";
                link.click();
            } else {
                alert("Không có kết quả để lưu.");
            }
        }

        // Hàm mở file và hiển thị nội dung
        function openFile(event) {
            const input = event.target;
            const reader = new FileReader();
            
            reader.onload = function() {
                document.getElementById("text").value = reader.result;
            };

            if (input.files.length > 0) {
                reader.readAsText(input.files[0]);
            }
        }

        // Hàm làm mới form
        function resetForm() {
            document.getElementById("form").reset();
            document.getElementById("result").value = "";
        }
    </script>
</body>
</html>
