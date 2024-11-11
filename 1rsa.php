<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>RSA | Thuật toán mã hóa</title>

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
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
            width: 550px;
            text-align: center;
        }
        .main {
            width: 93%;
            padding: 0 20px;
            padding-bottom: 20px;
        }
        .title-background {
            width: 100%;
            background-color: #d3e4ff;
            padding: 15px 0;
        }
        
        form {
            padding-top: 10px;
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
        .key-label {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 15px;
            padding: 0 10px;
        }
        .key-label input {
            width: 48%;
        }
        .output {
            margin-top: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
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
                        <h3 class="page-header"><i class="fa fa-files-o"></i> RSA</h3>
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="index.html">Home</a></li>
                            <li><i class="icon_circle-slelected"></i>RSA</li>
                        </ol>
                    </div>
                </div>
                <div class="container">
                    <h2>Mã hóa RSA</h2>
                    <form method="POST" enctype="multipart/form-data">
                        <input type="text" id="in" name="in" placeholder="Nhập đầu vào" required>
                        <div class="key-label">
                            <input type="text" id="p" name="p" placeholder="Nhập p" required>
                            <input type="text" id="q" name="q" placeholder="Nhập q" required>
                            <input type="text" id="e" name="e" placeholder="Nhập e" required>
                        </div>
                        <div class="buttons">
                            <button type="button" onclick="generateKeys()">Tạo khóa</button>
                            <button type="button" onclick="encrypt()">Mã hóa</button>
                            <button type="button" onclick="decrypt()">Giải mã</button>
                            <button type="reset" onclick="clearInputs()">Nhập lại</button>
                        </div>
                        <div class="key-label">
                            <input type="text" id="publicKeyLabel" placeholder="Khóa công khai" readonly>
                            <input type="text" id="privateKeyLabel" placeholder="Khóa bí mật" readonly>
                        </div>
                    </form>
                    <div class="output">
                        <h3>Kết quả</h3>
                        <p id="result"></p>
                        <button style="width: 50%" onclick="downloadFile()">Xuất kết quả ra file</button>
                    </div>
                    <label for="fileInput">Chọn file cần mã hóa, giải mã:</label>
                    <input type="file" id="fileInput" name="fileInput" accept=".txt" onchange="readFile(event)" />
                </div>
            </section>
        </section>
    </section>
    <script>
    let p, q, n, phi, e, d;

    function isPrime(num) {
        num = Number(num);  // Chuyển đổi thành kiểu Number nếu chưa
        if (num <= 1) return false;
        for (let i = 2; i <= Math.sqrt(num); i++) {
            if (num % i === 0) return false;
        }
        return true;
    }

    function gcd(a, b) {
        while (b !== 0n) {
            let temp = b;
            b = a % b;
            a = temp;
        }
        return a;
    }

    function extendedEuclid(a, b) {
        let r1 = a, r2 = b;
        let t1 = 0n, t2 = 1n, t;
        while (r2 > 0n) {
            let q = r1 / r2; 
            let r = r1 % r2;
            r1 = r2;
            r2 = r;
            t = t1 - q * t2;
            t1 = t2;
            t2 = t;
        }
        if (r1 === 1n) {
            return t1 > 0n ? t1 : t1 + a;
        }
        throw new Error("Không thể tìm d, vui lòng kiểm tra lại các giá trị.");
    }

    function generateKeys() {
        p = BigInt(document.getElementById("p").value);
        q = BigInt(document.getElementById("q").value);
        e = BigInt(document.getElementById("e").value);

        // Kiểm tra xem p, q, e có phải là số nguyên tố không
        if (!isPrime(p) || !isPrime(q)) {
            alert("p và q phải là số nguyên tố.");
            return;
        }

        n = p * q;
        phi = (p - 1n) * (q - 1n);

        if (gcd(e, phi) !== 1n) {
            alert("e và phi(n) không nguyên tố cùng nhau.");
            return;
        }

        if (!isPrime(Number(e))) {
            alert("e phải là một số nguyên tố.");
            return;
        }

        d = extendedEuclid(phi, e);

        document.getElementById("publicKeyLabel").value = `(${e}, ${n})`;
        document.getElementById("privateKeyLabel").value = `(${d}, ${n})`;
    }


    function encrypt() {
        generateKeys();
        let m = BigInt(document.getElementById("in").value);
        if (m >= n) {
            alert("Giá trị của m phải nhỏ hơn n.");
            return;
        }
        let c = m ** e % n;
        document.getElementById("result").innerText = `Bản mã: ${c.toString()}`;
    }

    function decrypt() {
        generateKeys();
        let c = BigInt(document.getElementById("in").value);
        if (c >= n) {
            alert("Giá trị của c phải nhỏ hơn n.");
            return;
        }
        let m = c ** d % n;
        document.getElementById("result").innerText = `Bản rõ: ${m.toString()}`;
    }

    function clearInputs() {
        document.getElementById("in").value = "";
        document.getElementById("p").value = "";
        document.getElementById("q").value = "";
        document.getElementById("e").value = "";
        document.getElementById("publicKeyLabel").value = "";
        document.getElementById("privateKeyLabel").value = "";
        document.getElementById("result").innerText = "";
    }
    function readFile(event) {
        const file = event.target.files[0];
    
        if (file) {
            const reader = new FileReader();
        
            reader.onload = function(e) {
                const content = e.target.result;
                const lines = content.split('\n');
            
                // Đảm bảo có ít nhất 4 dòng trong file
                if (lines.length >= 4) {
                    document.getElementById("in").value = lines[0].split(":")[1].trim();  // Dòng đầu tiên vào input đầu vào
                    document.getElementById("p").value = lines[1].split(":")[1].trim();   // Dòng thứ 2 vào input p
                    document.getElementById("q").value = lines[2].split(":")[1].trim();   // Dòng thứ 3 vào input q
                    document.getElementById("e").value = lines[3].split(":")[1].trim();
                } else {
                    alert("File không có đủ 4 dòng dữ liệu.");
                }
            };
            reader.readAsText(file);  // Đọc file dưới dạng văn bản
        }
    }

    function downloadFile() {
        const resultText = `${document.getElementById("result").innerText}
                            p: ${document.getElementById("p").value}
                            q: ${document.getElementById("q").value}
                            e: ${document.getElementById("e").value}`;

        // Tạo blob chứa nội dung file
        const blob = new Blob([resultText], { type: 'text/plain' });
        const url = URL.createObjectURL(blob);

        // Tạo phần tử <a> để tải file
        const a = document.createElement('a');
        a.href = url;
        a.download = 'rsa_results.txt';
        a.click();
    
        // Hủy URL tạo ra để giải phóng bộ nhớ
        URL.revokeObjectURL(url);
    }
    </script>
</body>
</html>
