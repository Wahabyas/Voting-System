<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <title>Voting System - Login</title>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="style.css">

    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            color: #333;
        }

        header {
            width: 100%;
            background-color: #2c3e50;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            position: fixed;
            top: 0;
            z-index: 1000;
        }

        header .logo {
            font-size: 24px;
            font-weight: bold;
            color: #fff;
        }

        header nav ul {
            display: flex;
            list-style: none;
            gap: 30px;
        }

        header nav ul li {
            position: relative;
        }

        header nav ul li a {
            display: flex;
            justify-content: space-between;

            color: #fff;
            text-decoration: none;
            font-size: 16px;
            padding: 10px 15px;
            transition: background-color 0.3s ease;
        }

        header nav ul li a:hover {
            background: #1abc9c;
            border-radius: 4px;
        }

        /* Dropdown Menu */
        header nav ul li:hover .dropdown {
            display: block;
        }

        .dropdown {
            display: none;
            
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #fff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width:90px;
            margin-left: -10px;
            border-radius: 6px;
         
        }

        .dropdown a {
            color: #333;
            text-decoration: none;
            padding: 20px 20px;
            display: block;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .dropdown a:hover {
            background-color: #1abc9c;
            color: #fff;
        }

        .login-container {
            background-color: #fff;
            padding: 40px 35px;
            border-radius: 8px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 90%;
            margin-top: 100px;
        }

        .login-container h1 {
            font-size: 28px;
            margin-bottom: 25px;
            color: #2c3e50;
            font-weight: 500;
        }

        .form-input {
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #1abc9c;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background-color: #1abc9c;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-login:hover {
            background-color: #16a085;
        }

        .signup-link {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .signup-link a {
            color: #1abc9c;
            text-decoration: none;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
      

        
    </style>
</head>
<body>
    <header>
        <a href="#" class="brand">
            <i class='bx bxs-smile'></i>
            <span class="text" style="color: #fff;">Voting System (Voter)</span>
        </a>
        <nav>
            <ul>
                <li>
                    <a href="#">Menu</a>
                    <div class="dropdown">
                        <a href="voterlogin.php">Vote</a>
                        <a href="index.php">User</a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>

    <div class="login-container">
        <h1>Enter Voucher</h1>
			<div class="" id="alert-msg"></div>

        <form class="login_form" name="login_form" method="POST" action="controllers/login_process.php">
            <div class="form-input">
                <input type="text" name="username" placeholder="Voucher Code" required>
            </div>
           
            <button type="submit" class="btn-login" id="btn-login">Login</button>
            <div class="signup-link">
               To login, this Requires a Voucher From admin
            </div>
        </form>
    </div>

    <script type="text/javascript">
        document.oncontextmenu = document.body.oncontextmenu = function() {
            return false;
        };

        $(function() {
            $('form[name="login_form"]').on('submit', function(e) {
                e.preventDefault();

                var u_username = $(this).find('input[name="username"]').val();
                

                $('#alert-msg').html('');

                if (u_username === '') {
                    $('#alert-msg').html('<div class="alert alert-danger">Required Voucher!</div>');
                } else {
                    $.ajax({
                        type: 'POST',
                        url: 'controllers/voucherlogin.php',
                        data: {
                            username: u_username,
                          
                        },
                        beforeSend: function() {
                            $('#alert-msg').html('');
                        }
                    })
                    .done(function(response) {
                        var result = JSON.parse(response);

                        if (result.status === 'error') {
                            $('#alert-msg').html('<div class="alert alert-danger">' + result.message + '</div>');
                        } else if (result.status === 'success') {
                    $('#alert-msg').html('<div class="alert-success">Access Granted!</div>');

                            $('.btn-login').html('Successfully logged in. Redirecting...');
                            setTimeout(function() {
                                window.location.href = 'voterdashboard.php';
                            }, 3000);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
