<?php
  session_start();
  if(empty($_SESSION['id_user'])){
    header("Location: ../index.php");
    exit();
  }
  require_once("../db.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: "Lato", sans-serif;
        }

        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }

        .sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .sidenav a:hover {
            color: #f1f1f1;
        }

        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }

        #main {
            transition: margin-left .5s;
            padding: 16px;
        }

        @media screen and (max-height: 450px) {
          .sidenav {padding-top: 15px;}
          .sidenav a {font-size: 18px;}
        }
        </style>
        <style>
        table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            border: 1px solid #ddd;
        }

        th, td {
            text-align: left;
            padding: 16px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }
        </style>
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>JOB PORTAL</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

    <!--Navigation Bar-->
    <header>
	<nav class="navbar navbar-default">
  <div class="topnav">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="../index.php" style="text-decoration:none; color:white;"><i class="fa fa-fw fa-home"></i>Job Portal</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
     <div class="topnav">
       <ul class="nav navbar-nav navbar-right">
         <li><a href="profile.php" style="text-decoration:none; color:white;"><i class="fa fa-id-badge"></i>Profile</a></li>
         <li><a href="../logout.php" style="text-decoration:none; color:white;"><i class="fa fa-fw fa-user"></i>Logout</a></li>
       </ul>
     </div><!-- /.navbar-collapse -->
   </div><!-- /.container-fluid -->
 </nav>
</header>

  <div class="container">

    <?php  if(isset($_SESSION['jobApplySuccess'])){ ?>
      <div class="row">
        <div class="col-md-12">
          <div class="alert alert-success">
          You have sucessfully Applied!
          </div>
          <div class="alert alert-success">
          Check your email for further update!!!You will be noticed if eligible!!!
          </div>
        </div>
      </div>
    <?php unset($_SESSION['jobApplySuccess'] ); }?>

    <!--other-->
      <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="applied-jobs.php">Applied Jobs</a>
        <a href="resume.php">My Resume</a>
      </div>
    <!--Search And Apply To Job Posts-->
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; My Activities</span><br><br>
          <span style="font-size:30px;cursor:pointer" onclick="">&#9776; Active Jobs</span><br><br>
          <table class="table table-striped">
            <thead>
              <th>Company</th>
              <th>Job Name</th>
              <th>Job Description</th>
              <th>Minimum Salary</th>
              <th>Maximum Salary</th>
              <th>Experience</th>
              <th>Qualification</th>
              <th>Created At</th>
              <th>Action</th>
            </thead>
            <tbody>
              <?php
                $sql="SELECT * FROM job_post INNER JOIN company ON job_post.id_company=company.id_company";
                $result=$conn->query($sql);
                if($result->num_rows>0){
                //output data
                while($row=$result->fetch_assoc())
                {
                  $sql1="SELECT * FROM apply_job_post WHERE id_user='$_SESSION[id_user]' AND id_jobpost='$row[id_jobpost]'";
                  $result1=$conn->query($sql1);

                  ?>
                  <tr>
                    <td><a href="viewcompany.php?id=<?php echo $row['id_company']; ?>&id_jobpost=<?php echo $row['id_jobpost']; ?>"><?php echo $row['companyname']; ?></td>
                    <td><?php echo $row['jobtitle']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['minimumsalary']; ?></td>
                    <td><?php echo $row['maximumsalary']; ?></td>
                    <td><?php echo $row['experience']; ?></td>
                    <td><?php echo $row['qualification']; ?></td>
                    <td><?php echo date("d-M-Y", strtotime($row['createdat'])); ?></td>
                    <?php
                    if($result1->num_rows>0){
                      ?>
                      <td><strong>Applied</strong></td>
                      <?php
                    }else{
                      ?>
                      <td><a href="apply-job-post.php?id=<?php echo $row['id_jobpost']; ?>">Apply</a></td>
                    <?php } ?>
                  </tr>
                  <?php
                }
              }
              $conn->close();
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <style>
  * {box-sizing: border-box;}

/* Style the navbar */
.topnav {
overflow: hidden;
background-color: #228B22;
}
</style>

<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";
}
</script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <s<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>
