<?php if(!isset($_POST["submitID"])){ ?>
<!DOCTYPE html>
<html>
<head>
    <title>ID configuration for issue</title>
    <link rel = "stylesheet" href ="css/configure_id.css"/>
</head>
<body>
<header>
    <div class="head_top">
        <div class="logo_name"><img class="siyanelogo" src="images/siyane_logo.jpg">

            <h1>LIBRARY</h1>
            <h3>Siyane National College of Education<br />Veyangoda</h3>

        </div>
    </div>

        <div class="bgimage">
            <nav>
                <ul>
                    <li><a href="#">HOME</a></li>
                    <li><a href="#">ADMIN PROFILE</a></li>
                    <li class="logout"><a href="#">LOGOUT</a></li>
                </ul>
            </nav>
        </div>
</header>

<div class="idconfigureform">
    <form align="center" method="POST" action="configure_id_for_issue.php" autocomplete="off">
        <div class="container">

            <label for="memberId"><b>Enter Member ID:</b></label><br />
            <input id="memberId" name="memberID" type="text"  required autofocus/><br />

            <button class="Submitbtn" name="submitID" type="submit">Submit</button>
            <button class="cancelbtn" onclick="window.location='Administration Page.php'" name="cancel" type="button" >Cancel</button>
        </div>
    </form>
</div>


</body>
</html>



<?php }
include("../database.php");
include("../table.php");
include("../member.php");
include("../book_session.php");
$dbObj=database::getInstance();
$dbObj->connect('localhost','root','','lms_db');
SESSION_start();
if(isset($_POST['submitID'])) {
    $m = new member();

    $result = $m->load($dbObj, $_POST["memberID"]);

?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Member Details and Previous Records</title>
        <link rel = "stylesheet" href="css/issuePage.css"/>
    </head>
    <body>
    <header>
        <div class="head_top">
            <div class="logo_name"><img class="siyanelogo" src="images/siyane_logo.jpg">

                <h1>LIBRARY</h1>
                <h3>Siyane National College of Education</br >Veyangoda</h3>

            </div>
        </div>
        <article class="backgroundimage">
            <div class="bgimage">
                <nav>
                    <ul>
                        <li><a href="#">HOME</a></li>
                        <li><a href="#">ADMIN PROFILE</a></li>
                        <li class="logout"><a href="#">LOGOUT</a></li>
                    </ul>
                </nav>
            </div>
    </header>




    <?php
    if(!$result){?>

        <div class = "MessageBox"><?php echo "Member does not exist..Incorrect Member ID!!" ?><a href="configure_id_for_issue.php"><img class="closeIcon" src="images/closebtn.png"/></a></div>
    <?php   }


    else {
        $_SESSION['id']=$m->id;
        $_SESSION['member_name']=$m->member_name;
        $_SESSION['member_type']=$m->member_type;
        $max_no_borrowals=null;
        if($m->member_type=="Academic Staff"){
            $max_no_borrowals=5;
        }
        elseif ($m->member_type=="Internal Student(2nd year)"||$m->member_type=="Internship Student"||$m->member_type=="Clerical Staff"){
            $max_no_borrowals=3;
        }
        elseif($m->member_type=="Internal Student(1st year)" ||$m->member_type== "Minor Staff" ||
            $m->member_type=="Secondment Staff" ||$m->member_type== "Temporary Staff"){
            $max_no_borrowals=2;
        }
        $sql2 = "SELECT book_id,book_title,session_status FROM book_sessions WHERE member_id='$m->id' and session_status!='returned'";
        $bs = new book_session();
        $result2 = $bs->featuredLoad($dbObj, $sql2);
        $numOfRows = mysqli_num_rows($result2);

    ?>
    <div style="overflow:auto;">
        <table style="width:100%">
            <caption>Member Details & Previous Records</caption>
            <tr>
                <th>Member ID</th>
                <th>Name with Initials</th>

                <th>Member Type</th>
                <th>Maximum No of Borrowable Books</th>
                <th class="bookdetail" colspan="4">Books to be retruned</th>


            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><p><b>No.</b></p></td>
                <td><p><b>Accession No</b></p></td>
                <td><p><b>Title</b></p></td>
                <td><p><b>Status</b></p></td>

            </tr>
            <tr>

                <td rowspan="<?php echo $numOfRows?>"> <?php echo $_SESSION['id']?></td>
                <td rowspan="<?php echo $numOfRows?>"> <?php echo $_SESSION['member_name']?></td>
                <td rowspan="<?php echo $numOfRows?>"> <?php echo $_SESSION['member_type']?></td>
                <td rowspan="<?php echo $numOfRows?>"> <?php echo $max_no_borrowals?></td>
            <?php
            for($i=0;$i<$numOfRows;$i++){?>

                <td><?php echo $i+1 ?></td>

                <?php

                foreach (mysqli_fetch_assoc($result2) as $key=>$value) {
                        ?><td ><?php echo $value ?></td>
                        <?php
                    }?>

                </tr>

            <?php } ?>

        </table>
        <form class="clicks" action="issueBook.php" method="post">

        <button class="SubmitBtn" type="submit" name="GotoIssueForm">Go to Issuing Form</button>
        <button class="cancelBtn" type="button" onclick="window.location='Administration page.php'" name="cancel">Cancel</button>

        </form>

    </div>
    </article>
    <?php } ?>
    </body>
    </html>
<?php $dbObj->closeConnection();}
?>
