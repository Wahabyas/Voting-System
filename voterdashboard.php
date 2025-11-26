<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- My CSS -->
    <link rel="stylesheet" href="style.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <title>Voting System</title>
</head>
<body>
    <?php include 'sidebar/sidebarVoucher.php'; ?>
    <!-- CONTENT -->
    <section id="content">
        <?php include 'header/headerVoucher.php'; ?>

        <?php 
            $conn = new class_model();
            $Activeyear = $conn->fetchActive_year();
            foreach($Activeyear as $row){
                $Activeyear = $row['Year'];
                $Year_idd = $row['Year_id'];
            }
        ?>


        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Vote for Your Candidate <?php echo $Voucher_code ; //this is the nameofvoter  ?></h1>
                    <ul class="breadcrumb">
                        <li><a href="#">Dashboard</a></li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li><a class="active" href="#">Voting</a></li>
                    </ul>
                </div>
            </div>

            <!-- Voting Form -->
            <div class="voting-form">
                <h3>Active Year: <?php echo $Activeyear; ?> Election</h3>
                <form id="voteForm" action="" method="POST">
    <!-- Add Voucher Code as a hidden input -->
    <input type="hidden" name="Voucher_code" value="<?php echo htmlspecialchars($Voucher_code); ?>">
    <input type="hidden" name="Activeyear" value="<?php echo htmlspecialchars($Year_idd); ?>">
            <?php $ifvoted = $conn->select_vote($Voucher_code,$Year_idd);
            if ($ifvoted === false){
            ?>
    <?php 
        $office = $conn->fetch_office($Activeyear);
        foreach ($office as $row) {
            $position_id = $row['Office_id'];
            $elective_office = $row['Electiveoffice'];
    ?>
    <div class="position">
        <h4><?php echo $elective_office; ?></h4>
        <?php
            $Office_and_year = $conn->fetchcandidatebyyear_and_position($position_id, $Activeyear);
            foreach ($Office_and_year as $candidate) {
                $candidate_fullname = $candidate['Candidate_fullname'];
                $profile_picture = $candidate['profile_picture'];
                $Balotno = $candidate['Balotno'];
                $candidate_id = $candidate['Candidate_id'];

        ?>
        <div class="candidates">
            <div class="candidate">
                <label>
                    <input type="radio" name="vote_<?php echo $position_id; ?>" value="<?php echo $candidate_id; ?>" required >
                    <span style="margin-top: 13px;"><?php echo $Balotno ; ?></span>
                    <img src="uploads/profile_pictures/<?php echo $profile_picture; ?>" alt="<?php echo $candidate_fullname; ?>" class="candidate-img">
                  

                    <span><?php echo $candidate_fullname; ?></span>
                </label>
            </div>
        </div>
        <?php } // End candidates loop ?>
    </div>
    <?php } // End office loop ?>
    
    <!-- Submit Button -->
    <div class="submit-container">
        <button type="submit" class="btn-submit">Submit Vote</button>
    </div>
</form>
            </div><?php }elseif($ifvoted === true){ ?>
                <div class="position">
        <h4>You've Already Voted</h4>
     
        <div class="candidates">
            <div class="candidate">
                <label>
                  
                 
              
                </label>
            </div>
        </div>
    
    </div>

         <?php   } ?>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->
    
    <script src="script.js"></script>
    <script>
  $(document).ready(function() {
    $("#voteForm").submit(function(e) {
        e.preventDefault(); // Prevent the form from submitting normally

        var formData = $(this).serialize(); // Serialize form data
        console.log(formData); // Log the data to check
        $.ajax({
            url: 'controllers/submit_vote.php', // URL to handle the submission
            type: 'POST',
            data: formData,
           success: function(response) {
    console.log(response);  // Log the full response from the server
    if(response == 1) {
        alert("Your vote has been submitted successfully.");
        window.location.reload();
    } else {
        alert("error");
    }
}
,
            error: function() {
                alert("An error occurred while submitting your vote.");
            }
        });
    });
});



    </script>
    <style>

        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        .head-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .left h1 {
            font-size: 28px;
            color: #333;
            margin: 0;
        }

        .breadcrumb {
            list-style: none;
            display: flex;
            padding: 0;
        }

        .breadcrumb li {
            font-size: 14px;
        }

        .breadcrumb li a {
            color: #0066cc;
            text-decoration: none;
        }

        .breadcrumb li a:hover {
            text-decoration: underline;
        }

        .bx-chevron-right {
            margin: 0 5px;
        }

        /* Voting form styles */
        .voting-form {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: 30px auto;
            font-size: 16px;
            line-height: 1.5;
        }

        .voting-form h3 {
            font-size: 22px;
            color: #333;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .position {
            margin-bottom: 30px;
        }

        .position h4 {
            font-size: 20px;
            color: #333;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .candidates {
            display: flex;
            justify-content: space-evenly;
           
            gap: 0px;
        }

        .candidate {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 45%;
        }

        .candidate label {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 16px;
            color: #333;
            font-weight: 600;
        }

        .candidate-img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
            border: 3px solid #ddd;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .submit-container {
            text-align: center;
            margin-top: 30px;
        }

        .btn-submit {
            background-color: #0066cc;
            color: #fff;
            border: none;
            padding: 12px 30px;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-submit:hover {
            background-color: #005bb5;
        }
    </style>
</body>
</html>
