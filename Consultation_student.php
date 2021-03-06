<?php
    session_start();
    $student_id;
    $user_name_studet;
    $errorpafelocation = 'Location: /error_page.php?err_msg=';
    include '/php-files/db_connection.php';
    include '/php-files/new_messages_retrive.php';
    if (isset($_SESSION['user']) && $_SESSION['user_type'] == "Student") {
        // logged in
        $student_id = $_SESSION['user'];

         $query2 = 'SELECT Name FROM student_table WHERE Id='.$student_id;
        $result2 = mysqli_query($conn,$query2);
        

        if($result2 == NULL){
             $user_name_studet = $student_id;
        }else{
           $row2 = $result2->fetch_assoc();
            $user_name_studet = $row2["Name"];
        }


    } else {
        // not logged in
        //header ('Location : /index.php');
        header($errorpafelocation."You are not siggned in. Please sign in/sign up.&err_bttn=Sign up / Sign in&err_bttn_link=/index.php" );
     }

 

if (isset($_POST['submit'])) {
    $teacher_emaili = $_POST["faculty_email"];
    $requested_timei = $_POST["requested_time"];

    $date = date('Y-m-d G:i:s', strtotime($requested_timei));

    
    
    $sql123 = "INSERT INTO consultation_queue (student_Id, teacher_email, requested_time) VALUES (".$student_id.",'".$teacher_emaili."','".$date."')";
    
   $result = mysqli_query($conn,$sql123);
   $date = $sql123;
}
?>

<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="cse 470 project">
    <meta name="author" content="Heya mim erfan">
    <link rel="shortcut icon" type="image/x-icon" href="/fileStorage/bracu_logo.ico" />
    <title>Consultation Time Booking | BRACU CMS</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">BRACU CMS</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    
                        <?php
                           
    
    $query7 = 'SELECT * FROM messages WHERE User_to="'.$student_id.'" AND seen=0';
    $result_messages = mysqli_query($conn,$query7);
    $num_row = mysqli_num_rows($result_messages);
    ?>

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo "(".$num_row.")  "?><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">

<?php    if($result_messages != NULL){
        $counter = 0;
        while( $rowww = $result_messages->fetch_assoc() ){
                                $message_sender_name = $rowww["User_from"];
                                $message_body = $rowww["Message"];
                                $message_time = $rowww["time_stamp"];
                                
                                $str_size = 100;
                                if(strlen($message_body) >$str_size){
                                    $message_body = substr($message_body,0,$str_size) . " . . .";
                                }
                                 echo "
                            <li class=\"message-preview\">
                            <a href=\"#\">
                                <div class=\"media\">
                                    <div class=\"media-body\">
                                        <h5 class=\"media-heading\"><strong>From:</strong> ".$message_sender_name."</h5>
                                        <p class=\"small text-muted\"><i class=\"fa fa-clock-o\"></i>".$message_time."</p>
                                        ".$message_body."
                                    </div>
                                </div>
                            </a>
                        </li>";
                            }
    }else{
          echo "
                            <li class=\"message-preview\">
                            <a href=\"#\">
                                <div class=\"media\">
                                    <div class=\"media-body\">
                                        <h5 class=\"media-heading\"><strong>No new messages</strong></h5>
                                        
                                    </div>
                                </div>
                            </a>
                        </li>";
    }
                            
                           
                        ?>
                        
                        <li class="message-footer">
                            <a href="/php-files/all_messages.php">Read All Messages</a>
                        </li>
                    </ul>
                </li>
                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $user_name_studet; ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="/php-files/Profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="student_settings.php"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="/php-files/signout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                  <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="dashboard_student.php"><i class="fa fa-fw fa-dashboard"></i>Dashboard</a>
                    </li>
                      <li>
                        <a href="tables_materials.php"><i class="fa fa-fw fa-table"></i> Course Materials</a>
                    </li>
                      <li>
                        <a href="tables_facultyPresence.php"><i class="fa fa-fw fa-table"></i> Faculty Presence</a>
                    </li>
                       <li>
                        <a href="student_viewNotice.php"><i class="fa fa-fw fa-table"></i> Notice</a>
                    </li>
                    <li>
                    <li>
                        <a href="student_results.php"><i class="fa fa-fw fa-bar-chart-o"></i>Results</a>
                    </li>
                    
                    <li class="active">
                        <a href="Consultation_student.php"><i class="fa fa-fw fa-desktop"></i>Consultation Time Booking</a>
                    </li>
                    <li>
                        <a href="student_coursesequence.php"><i class="fa fa-fw fa-table"></i> Course Sequence</a>
                    </li>
                    <li>
                        <a href="student_complain.php"><i class="fa fa-fw fa-edit"></i> Complain</a>
                    </li>
                    <li>
                        <a href="student_settings.php"><i class="fa fa-fw fa-wrench"></i> Settings</a>
                    </li>
                    
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        
                        <h1 class="page-header">
                            Dashboard 
                        </h1>
                        
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="dashboard_student.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-fw fa-desktop"></i> Consultation
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    
                    <div class="col-lg-12">
                         
                        <h2>Consultation Booking Table</h2>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        
                                        <th>Course ID</th>
                                        <th>Course Title</th>
                                        <th>Faculty Name</th>
                                        
                                        <th>Availability</th>
                                        <th>Preferable Date & Time</th>
                                        <th>Request Here</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                            <?php
                            include '/php-files/db_connection.php';
                            $query = "SELECT * FROM dept_crs,teacher_table,teacher_courses,teacher_consultation where dept_crs.course_Id=teacher_courses.Course_id and teacher_table.Email=teacher_courses.Email and teacher_table.Email=teacher_consultation.teacher_email";

                            $result = mysqli_query($conn,$query);
                            
                            while ($row = $result->fetch_assoc()) {
                                $course_id = $row["course_Id"];
                                $course_title = $row["crs_title"];
                                $fac_name = $row["Name"];
                                $fac_email = $row["Email"];
                                $avail = $row["availability"];

                                
                               echo '
                                <form role="form" action="Consultation_student.php" method="post">
                                <input type="hidden" value = "'.$fac_email.'" name="faculty_email">
                                    <tr>
                                        <td>'.$course_id.'</td>
                                        <td>'.$course_title.'</td>
                                        <td>'.$fac_name.'</td>
                                        
                                        <td>'.$avail.'</td>
                                        <td><input type="datetime-local" name="requested_time"></td>
                                        <td><button type="submit" name = "submit" class="btn btn-success btn-block" onclick="">Request</button></td>
                                        
                                   </tr>
                                   </form>';
                            }

                           
                              ?>
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

</body>

</html>
