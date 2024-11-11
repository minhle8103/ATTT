<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Vigenère | Thuật toán mã hóa</title>

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
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f0f0f0;
            margin: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            background: #fffafa;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            text-align: center;
        }
        .main {
            width: 93%;
            padding: 0 20px;
            padding-bottom: 20px;
        }
        .title-background {
            width: 100%;
            background-color: #d3e4ff; /* Màu nền cho tiêu đề */
            padding: 15px 0;
            display: inline-block;
        }
        h1 {
            color: #333;
            margin: 0;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
            text-align: left;
        }
        input, textarea {
            width: 95%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .buttons {
            display: flex;
            margin-top: 15px;
            justify-content: space-between;
        }
        button {
            width: 100px;
            padding: 10px;
            margin: 12px 1%;
            background-color: #d3e4ff;
            color: black;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #add8e6;
        }
        .output {
            margin-top: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .solution-output {
            margin-top: 10px;
            text-align: left;
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
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
            <h3 class="page-header"><i class="fa fa-files-o"></i> VIGENÈRE</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.html">Home</a></li>
              <li><i class="icon_circle-slelected"></i>Vigenère</li>
            </ol>
          </div>
        </div>
    <div class="container">
        <h2>Mã hóa Vigenère</h2>
        <div class="main">
        <form id="vigenereForm">
            <label for="message">Nhập Chuỗi :</label>
            <textarea id="message" rows="4" required></textarea>

            <label for="key">Nhập khóa :</label>
            <input type="text" id="key" required>
            
            <div class="buttons">
                <button type="button" id="encryptBtn">Mã hóa</button>
                <button type="button" id="decryptBtn">Giải mã</button>
                <button type="button" id="saveToFile">Xuất file</button>
                <button type="button" id="openFile">Mở file</button>
                <button type="button" id="clearBtn">Nhập lại</button>
            </div>
        </form>

        <div id="output" class="output">
            <h3>Kết quả:</h3>
            <p id="result"></p>
        </div>

        <div class="solution-output" id="solution">
            <!-- Nội dung cách giải sẽ hiển thị ở đây -->
        </div>
    </div>
    </div>
</section>
    </section>
  </section>

    <script>
        document.getElementById('encryptBtn').addEventListener('click', function() {
            let key = document.getElementById('key').value.toUpperCase();
            let message = document.getElementById('message').value.toUpperCase();

            const result = vigenereEncrypt(message, key);
            document.getElementById('result').textContent = result;
            document.getElementById('result').classList.add('show');
        });

        document.getElementById('decryptBtn').addEventListener('click', function() {
            let key = document.getElementById('key').value.toUpperCase();
            let message = document.getElementById('message').value.toUpperCase();

            const result = vigenereDecrypt(message, key);
            document.getElementById('result').textContent = result;
            document.getElementById('result').classList.add('show');
        });

        document.getElementById('saveToFile').addEventListener('click', function() {
            const text = document.getElementById('result').textContent;
            const blob = new Blob([text], { type: 'text/plain' });
            const a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = 'vigenere_result.txt';
            a.click();
        });

        document.getElementById('openFile').addEventListener('click', function() {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = '.txt';
            input.onchange = function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('message').value = e.target.result;
                    };
                    reader.readAsText(file);
                }
            };
            input.click();
        });

        document.getElementById('clearBtn').addEventListener('click', function() {
            document.getElementById('message').value = '';
            document.getElementById('key').value = '';
            document.getElementById('result').textContent = '';
            document.getElementById('solution').innerHTML = '';
            document.getElementById('result').classList.remove('show');
        });

        function vigenereEncrypt(message, key) {
            let solutionSteps = "";
            let result = "";
            for (let i = 0, j = 0; i < message.length; i++) {
                const c = message[i];
                if (c >= 'A' && c <= 'Z') {
                    const m = c.charCodeAt(0) - 65;
                    const k = key[j % key.length].charCodeAt(0) - 65;
                    const encryptedChar = String.fromCharCode((m + k) % 26 + 65);
                    solutionSteps += `${c} + ${key[j % key.length]} = ${encryptedChar}<br>`;
                    result += encryptedChar;
                    j++;
                } else {
                    result += c;
                }
            }
            document.getElementById('solution').innerHTML = solutionSteps;
            return result;
        }

        function vigenereDecrypt(message, key) {
            let solutionSteps = "";
            let result = "";
            for (let i = 0, j = 0; i < message.length; i++) {
                const c = message[i];
                if (c >= 'A' && c <= 'Z') {
                    const m = c.charCodeAt(0) - 65;
                    const k = key[j % key.length].charCodeAt(0) - 65;
                    const decryptedChar = String.fromCharCode((m - k + 26) % 26 + 65);
                    solutionSteps += `${c} - ${key[j % key.length]} = ${decryptedChar}<br>`;
                    result += decryptedChar;
                    j++;
                } else {
                    result += c;
                }
            }
            document.getElementById('solution').innerHTML = solutionSteps;
            return result;
        }
    </script>
</body>
</html>
