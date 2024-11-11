<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Hill | Thuật toán mã hóa</title>

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
    max-width: 600px;
    width: 100%;
}

h2 {
    text-align: center;
    margin: 0;
    padding-bottom: 20px;
}

label {
    font-weight: bold;
    color: #444;
    font-size: 15px;
}

input[type="text"], select {
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
    color: #333;
    background-color: #fafafa;
    box-shadow: inset 0px 2px 5px rgba(0, 0, 0, 0.05);
    
}

input[type="text"]:focus, select:focus {
    border-color: #4facfe;
    outline: none;
    box-shadow: 0px 0px 8px rgba(79, 172, 254, 0.3);
}

.buttons {
    display: flex;
    margin-top: 15px;
    justify-content: space-between;
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

button:active {
    background: linear-gradient(90deg, #4d0d9d 0%, #1549b0 100%);
    
}

button:focus {
    outline: none;
    box-shadow: 0px 0px 8px rgba(37, 117, 252, 0.4);
}

#keyMatrixInput {
    margin-bottom: 15px;
}

#result {
    margin-top: 20px;
    background-color: #f1f4f9;
    color: #333;
    padding: 15px;
    border-radius: 8px;
    font-weight: 500;
}

#saveToFile, #openFile, #clearBtn, #mahoa, #giaima {
    border-radius: 8px;
    color: #fff;
    padding: 10px 10px;
    margin-top: 10px;
    transition: background 0.3s ease, transform 0.2s ease;
}

#saveToFile:hover, #openFile:hover,#mahoa:hover, #giaima:hover, #clearBtn:hover {
    background: linear-gradient(90deg, #5f0db2 0%, #1b62d8 100%);
    transform: translateY(-2px);
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
            <h3 class="page-header"><i class="fa fa-files-o"></i> HILL</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.html">Home</a></li>
              <li><i class="icon_circle-slelected"></i>Hill</li>
            </ol>
          </div>
        </div>
    <div class="container">
        <h2>Mã hóa Hill</h2>
        <label for="text">Nhập văn bản:</label>
        <input type="text" id="text" placeholder="Nhập văn bản">
        <br>
        <br>
        <label for="matrix_size">Kích thước ma trận:</label>
        <select id="matrix_size">
            <option value="2">2x2</option>
            <option value="3">3x3</option>
        </select>
        <br><br>
        <div id="keyMatrixInput"></div>
        <div class="buttons">
            <button onclick="encryptText()" type="button" id="mahoa">Mã hóa</button>
            <button onclick="decryptText()" type="button" id="giaima">Giải mã</button>
            <button type="button" id="saveToFile">Xuất file</button>
            <button type="button" id="openFile">Mở file</button>
            <button type="button" id="clearBtn">Nhập lại</button>
        </div>
        <h3>Kết quả:</h3>
        <div id="result"></div>
    </div>
</section>
</section>
</section>

    <script>
        function mod(n, m) {
            return ((n % m) + m) % m;
        }

        function modInverse(a, m) {
            for (let x = 1; x < m; x++) {
                if ((a * x) % m === 1) return x;
            }
            return null;
        }

        function matrixDet(matrix) {
            if (matrix.length === 2) {
                return matrix[0][0] * matrix[1][1] - matrix[0][1] * matrix[1][0];
            } else if (matrix.length === 3) {
                return matrix[0][0] * (matrix[1][1] * matrix[2][2] - matrix[1][2] * matrix[2][1]) -
                       matrix[0][1] * (matrix[1][0] * matrix[2][2] - matrix[1][2] * matrix[2][0]) +
                       matrix[0][2] * (matrix[1][0] * matrix[2][1] - matrix[1][1] * matrix[2][0]);
            }
            return 0;
        }

        function matrixInverse(matrix, modulus) {
            const det = mod(matrixDet(matrix), modulus);
            const detInverse = modInverse(det, modulus);
            if (detInverse === null) return null;

            let inverse = [];
            if (matrix.length === 2) {
                inverse = [
                    [matrix[1][1] * detInverse, -matrix[0][1] * detInverse],
                    [-matrix[1][0] * detInverse, matrix[0][0] * detInverse]
                ];
            } else if (matrix.length === 3) {
                inverse = [
                    [
                        (matrix[1][1] * matrix[2][2] - matrix[1][2] * matrix[2][1]) * detInverse,
                        (matrix[0][2] * matrix[2][1] - matrix[0][1] * matrix[2][2]) * detInverse,
                        (matrix[0][1] * matrix[1][2] - matrix[0][2] * matrix[1][1]) * detInverse
                    ],
                    [
                        (matrix[1][2] * matrix[2][0] - matrix[1][0] * matrix[2][2]) * detInverse,
                        (matrix[0][0] * matrix[2][2] - matrix[0][2] * matrix[2][0]) * detInverse,
                        (matrix[0][2] * matrix[1][0] - matrix[0][0] * matrix[1][2]) * detInverse
                    ],
                    [
                        (matrix[1][0] * matrix[2][1] - matrix[1][1] * matrix[2][0]) * detInverse,
                        (matrix[0][1] * matrix[2][0] - matrix[0][0] * matrix[2][1]) * detInverse,
                        (matrix[0][0] * matrix[1][1] - matrix[0][1] * matrix[1][0]) * detInverse
                    ]
                ];
            }

            return inverse.map(row => row.map(value => mod(value, modulus)));
        }

        function textToMatrix(text, size) {
            text = text.replace(/ /g, '').toUpperCase();
            const blocks = [];
            for (let i = 0; i < text.length; i += size) {
                const block = [];
                for (let j = 0; j < size; j++) {
                    block.push(text.charCodeAt(i + j) - 65);
                }
                blocks.push(block);
            }
            return blocks;
        }

        function matrixToText(matrix) {
            let text = '';
            matrix.forEach(block => {
                block.forEach(value => {
                    text += String.fromCharCode(value + 65);
                });
            });
            return text;
        }

        function hillEncrypt(text, keyMatrix) {
            const size = keyMatrix.length;
            const blocks = textToMatrix(text, size);
            const encryptedBlocks = blocks.map(block => {
                return block.map((_, i) => {
                    return mod(
                        block.reduce((sum, value, j) => sum + keyMatrix[i][j] * value, 0),
                        26
                    );
                });
            });
            return matrixToText(encryptedBlocks);
        }

        function hillDecrypt(text, keyMatrix) {
            const inverseKeyMatrix = matrixInverse(keyMatrix, 26);
            if (!inverseKeyMatrix) {
                return 'Ma trận khóa không có nghịch đảo, không thể giải mã.';
            }
            const size = inverseKeyMatrix.length;
            const blocks = textToMatrix(text, size);
            const decryptedBlocks = blocks.map(block => {
                return block.map((_, i) => {
                    return mod(
                        block.reduce((sum, value, j) => sum + inverseKeyMatrix[i][j] * value, 0),
                        26
                    );
                });
            });
            return matrixToText(decryptedBlocks);
        }

        function getKeyMatrix() {
            const matrix_size = parseInt(document.getElementById("matrix_size").value);
            const keyMatrix = [];
            for (let i = 0; i < matrix_size; i++) {
                keyMatrix[i] = [];
                for (let j = 0; j < matrix_size; j++) {
                    keyMatrix[i][j] = parseInt(document.getElementById(`key_${i}_${j}`).value);
                }
            }
            return keyMatrix;
        }

        function encryptText() {
            const text = document.getElementById("text").value;
            const keyMatrix = getKeyMatrix();
            document.getElementById("result").innerText = hillEncrypt(text, keyMatrix);
        }

        function decryptText() {
            const text = document.getElementById("text").value;
            const keyMatrix = getKeyMatrix();
            document.getElementById("result").innerText = hillDecrypt(text, keyMatrix);
        }

        document.getElementById("matrix_size").addEventListener("change", function () {
            const matrix_size = parseInt(this.value);
            let html = '';
            for (let i = 0; i < matrix_size; i++) {
                for (let j = 0; j < matrix_size; j++) {
                    html += `<label>Key ${i},${j}:</label><input type="number" id="key_${i}_${j}" placeholder="Key ${i},${j}" style="width: 50px; margin: 2px;">`;
                }
                html += '<br>';
            }
            document.getElementById("keyMatrixInput").innerHTML = html;
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
                        document.getElementById('text').value = e.target.result;
                    };
                    reader.readAsText(file);
                }
            };
            input.click();
        });


            document.getElementById('clearBtn').addEventListener('click', function() {
            document.getElementById('text').value = '';
            document.getElementById('matrix_size').value = '';
            document.getElementById('keyMatrixInput').textContent = '';
            document.getElementById('result').classList.remove('show');
        });
        // Trigger the initial matrix size input setup
        document.getElementById("matrix_size").dispatchEvent(new Event("change"));
    </script>
</body>
</html>
