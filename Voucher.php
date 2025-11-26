<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

	<link rel="stylesheet" href="style.css">
    <title>Voucher Generator</title>
</head>

<body>

    <!-- Include Sidebar -->
    <?php include 'sidebar/sidebar.php'; ?>

    <?php 
    $Activeyear = $conn->fetchActive_year();
    foreach($Activeyear as $row){

        $Activeyear=$row['Year'];
    };
    ?>
    <!-- CONTENT -->
    <section id="content">
        
        <!-- Include Navbar / Header -->
        <?php include 'header/header.php'; ?>

        <!-- MAIN -->
        <main>
            <div class="container">
                <h1 class="page-title">Voucher Generator</h1>

                <!-- Form to generate multiple vouchers -->
                <div class="voucher-form">
                    <label for="voucherCount">Enter Number of Vouchers:</label>
                    <input type="number" id="voucherCount" placeholder="e.g., 100" min="1" class="input-field">
                    <button onclick="generateVouchers()" class="btn-generate">Generate Vouchers</button>
                </div>

                <!-- Section to display generated vouchers -->
                <div id="voucherList" class="voucher-list"></div>

                <!-- Print Button -->
                <button id="printButton" onclick="printVouchers()" class="btn-print" style="display: none;">Print Vouchers</button>
            </div>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->
    <script src="script.js"></script>

    <!-- Optional JavaScript -->
	<script>
    let generatedVouchers = [];

    function generateVouchers() {
        const voucherCount = document.getElementById('voucherCount').value;
        const voucherList = document.getElementById('voucherList');
        voucherList.innerHTML = '';  // Clear any previous vouchers
        generatedVouchers = []; // Clear previous generated vouchers

        if (!voucherCount || voucherCount < 1) {
            alert('Please enter a valid number of vouchers!');
            return;
        }

        for (let i = 0; i < voucherCount; i++) {
            const voucherCode = 'VOUCHER-' + Math.random().toString(36).substr(2, 8).toUpperCase();
            const voucherFor = 'Voucher for Product ' + (i + 1);
            const voucherValidity = 'Valid until: ' + new Date().toLocaleDateString();
            const Activeyear = <?php echo $Activeyear ?>


            const voucherCard = document.createElement('div');
            voucherCard.classList.add('voucher-card');
            voucherCard.innerHTML = `
                <p><strong>Voucher Code:</strong> ${voucherCode}</p>
                <p><strong>Voucher For:</strong> ${voucherFor}</p>
                <p><strong>Validity:</strong> ${voucherValidity}</p>
                <p><strong>Year:</strong> ${Activeyear}</p>
                
            `;

            voucherList.appendChild(voucherCard);

            generatedVouchers.push({
                voucherCode: voucherCode,
                voucherFor: voucherFor,
                voucherValidity: voucherValidity,
                Activeyear: Activeyear
            });
        }

        // Show the print button
        document.getElementById('printButton').style.display = 'block';
    }

    function printVouchers() {
        const printContents = document.getElementById('voucherList').innerHTML;
        const originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;

        // Send the generated vouchers to the server for insertion into the database
        insertVouchersToDatabase();
    }

    function insertVouchersToDatabase() {
        // Prepare the data to be sent to the server
        const vouchersData = generatedVouchers;

        // Send AJAX request to insert vouchers into the database
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "controllers/insert_vouchers.php", true);
        xhr.setRequestHeader("Content-Type", "application/json");

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                alert("Vouchers successfully inserted into the database!");
            }
        };

        xhr.send(JSON.stringify({ vouchers: vouchersData }));
    }
    </script>

</body>
<style>
	/* Reset default styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body and general layout */


.container {
    width: 80%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 30px;
}

h1.page-title {
    text-align: center;
    color: #333;
    font-size: 2.5rem;
    margin-bottom: 40px;
}

/* Form styling */
.voucher-form {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-bottom: 30px;
}

.voucher-form label {
    font-size: 1.2rem;
    color: #555;
    margin-top: 5px;
}

.input-field {
    padding: 10px;
    font-size: 1.2rem;
    width: 200px;
    border: 2px solid #ddd;
    border-radius: 5px;
    outline: none;
}

.input-field:focus {
    border-color: #4CAF50;
}

.btn-generate {
    padding: 10px 20px;
    font-size: 1.2rem;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-generate:hover {
    background-color: #45a049;
}

/* Voucher card styling */
.voucher-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 30px;
}

.voucher-card {
    background-color: #fff;
    border: 2px solid #eee;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.voucher-card:hover {
    transform: translateY(-5px);
}

.voucher-card p {
    font-size: 1rem;
    margin-bottom: 10px;
    color: #555;
}

.voucher-card strong {
    color: #333;
}

/* Print button styling */
.btn-print {
    padding: 10px 20px;
    font-size: 1.2rem;
    background-color: #ff5722;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    display: inline-block;
    margin-top: 20px;
}

.btn-print:hover {
    background-color: #e64a19;
}

</style>
</html>
