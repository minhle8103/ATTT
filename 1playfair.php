<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Play-Fair | Thuật toán mã hóa</title>

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
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 750px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;    
            color: #007bff;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        .buttons {
            display: flex;
            margin-top: 15px;
            justify-content: space-between;
        }
        button {
            width: 100%;
            padding: 10px;
            margin: 12px 1%;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #007bff;
        }
        th, td {
            padding: 15px;
            text-align: center;
            font-size: 18px;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .pair-result {
            margin-top: 20px;
            text-align: left;
        }
        .pair-result p {
            font-size: 18px;
            margin: 5px 0;
        }
        .note {
            color: #dc3545;
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
            <h3 class="page-header"><i class="fa fa-files-o"></i>PLAY-FAIR</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.html">Home</a></li>
              <li><i class="icon_circle-slelected"></i>Play-Fair</li>
            </ol>
          </div>
        </div>
    <div class="container">
        <h2>Mã hóa Play-fair</h2>
        <form method="POST" onsubmit="return validateInput();">
            <input type="text" name="keyword" placeholder="Nhập từ khóa (keyword)" required />
            <textarea name="text" placeholder="Nhập chuỗi cần mã hóa hoặc giải mã" rows="4" required></textarea>
            <div class="buttons">
                <button type="submit" name="action" value="encrypt">Mã hóa</button>
                <button type="submit" name="action" value="decrypt">Giải mã</button>
            </div>
            <p class="error-message note"></p>
        </form>

        <h3>Ma trận 5x5:</h3>
        <table>
            <tbody>
                <?php
                $alphabet = 'ABCDEFGHIKLMNOPQRSTUVWXYZ';
                $matrix = [];

                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    $keyword = strtoupper(str_replace('J', 'I', $_POST['keyword']));
                    $keyArray = implode('', array_unique(str_split($keyword)));
                    $matrixKey = $keyArray . implode('', array_diff(str_split($alphabet), str_split($keyArray)));

                    $index = 0;
                    for ($i = 0; $i < 5; $i++) {
                        for ($j = 0; $j < 5; $j++) {
                            $matrix[$i][$j] = $matrixKey[$index++];
                        }
                    }
                } else {
                    $index = 0;
                    for ($i = 0; $i < 5; $i++) {
                        for ($j = 0; $j < 5; $j++) {
                            $matrix[$i][$j] = $alphabet[$index++];
                        }
                    }
                }

                foreach ($matrix as $row) {
                    echo "<tr>";
                    foreach ($row as $cell) {
                        echo "<td>$cell</td>";
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $text = strtoupper(str_replace('J', 'I', preg_replace('/\s+/', '', $_POST['text'])));

            class PlayfairCipher {
                private $matrix;

                public function __construct($matrix) {
                    $this->matrix = $matrix;
                }

                private function findPosition($char) {
                    for ($i = 0; $i < 5; $i++) {
                        for ($j = 0; $j < 5; $j++) {
                            if ($this->matrix[$i][$j] === $char) {
                                return [$i, $j];
                            }
                        }
                    }
                    return [-1, -1];
                }

                private function prepareText($input) {
                    $pairs = [];
                    $input .= (strlen($input) % 2 === 1) ? 'X' : '';

                    for ($i = 0; $i < strlen($input); $i += 2) {
                        $a = $input[$i];
                        $b = $input[$i + 1] ?? 'X';

                        if ($a === $b) {
                            $pairs[] = [$a, 'X'];
                            $i--;
                        } else {
                            $pairs[] = [$a, $b];
                        }
                    }

                    return $pairs;
                }

                public function encrypt($plaintext) {
                    $pairs = $this->prepareText($plaintext);
                    $ciphertext = '';

                    foreach ($pairs as [$a, $b]) {
                        [$row1, $col1] = $this->findPosition($a);
                        [$row2, $col2] = $this->findPosition($b);

                        if ($row1 === $row2) {
                            $cipherA = $this->matrix[$row1][($col1 + 1) % 5];
                            $cipherB = $this->matrix[$row2][($col2 + 1) % 5];
                        } elseif ($col1 === $col2) {
                            $cipherA = $this->matrix[($row1 + 1) % 5][$col1];
                            $cipherB = $this->matrix[($row2 + 1) % 5][$col2];
                        } else {
                            $cipherA = $this->matrix[$row1][$col2];
                            $cipherB = $this->matrix[$row2][$col1];
                        }

                        $ciphertext .= $cipherA . $cipherB;
                    }

                    return $ciphertext;
                }

                public function decrypt($ciphertext) {
                    $pairs = $this->prepareText($ciphertext);
                    $plaintext = '';

                    foreach ($pairs as [$a, $b]) {
                        [$row1, $col1] = $this->findPosition($a);
                        [$row2, $col2] = $this->findPosition($b);

                        if ($row1 === $row2) {
                            $plainA = $this->matrix[$row1][($col1 - 1 + 5) % 5];
                            $plainB = $this->matrix[$row2][($col2 - 1 + 5) % 5];
                        } elseif ($col1 === $col2) {
                            $plainA = $this->matrix[($row1 - 1 + 5) % 5][$col1];
                            $plainB = $this->matrix[($row2 - 1 + 5) % 5][$col2];
                        } else {
                            $plainA = $this->matrix[$row1][$col2];
                            $plainB = $this->matrix[$row2][$col1];
                        }

                        $plaintext .= $plainA . $plainB;
                    }

                    if (substr($plaintext, -1) === 'X') {
                        $plaintext = substr($plaintext, 0, -1);
                    }

                    return $plaintext;
                }
            }

            $cipher = new PlayfairCipher($matrix);
            $action = $_POST['action'];
            if ($action === "encrypt") {
                $resultText = $cipher->encrypt($text);
                echo "<div class='pair-result'><h3>Kết quả mã hóa:</h3>";
            } else {
                $resultText = $cipher->decrypt($text);
                echo "<div class='pair-result'><h3>Kết quả giải mã:</h3>";
            }

            echo "<p><strong>Kết quả:</strong> $resultText</p>";

            // Xuất file
            echo "<button onclick='downloadFile(\"" . $_POST['keyword'] . "\", \"$resultText\")'>Tải kết quả ra file</button>";
            echo "</div>";
        }
        ?>

        <!-- Nhập file -->
        <div>
            <label for="file-upload">Tải file chứa từ khóa và chuỗi mã hóa:</label>
            <input type="file" id="file-upload" onchange="loadFile(event)" />
        </div>
    </div>
</section>
    </section>
</section>
    <script>
    function validateInput() {
        const keyword = document.querySelector('input[name="keyword"]').value.trim();
        const text = document.querySelector('textarea[name="text"]').value.trim();
        const errorMessage = document.querySelector('.error-message');

        const validKeywordPattern = /^[A-Za-z]*$/;
        const validTextPattern = /^[A-Za-z\s]*$/;

        if (!validKeywordPattern.test(keyword) || keyword.length < 1 || new Set(keyword.toUpperCase()).size !== keyword.length) {
            errorMessage.textContent = 'Từ khóa chỉ được phép chứa ký tự A-Z, không để trống hoặc có ký tự lặp lại.';
            return false;
        }
        if (!validTextPattern.test(text) || text.length < 1) {
            errorMessage.textContent = 'Chuỗi chỉ chứa ký tự A-Z và không được để trống.';
            return false;
        }

        errorMessage.textContent = '';
        return true;
    }
    function loadFile(event) {
        const file = event.target.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            const content = e.target.result.split("\n");
            if (content.length >= 2) {
                document.querySelector('input[name="keyword"]').value = content[0].trim();
                document.querySelector('textarea[name="text"]').value = content[1].trim();
            }
        };
        reader.readAsText(file);
    }

    function downloadFile(keyword, resultText) {
        const blob = new Blob([keyword + "\n" + resultText], { type: 'text/plain' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'result.txt';
        link.click();
    }
    </script>
</body>
</html>
