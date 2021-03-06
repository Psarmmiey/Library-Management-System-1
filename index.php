
<!DOCTYPE html>
<html>
	<head>
		<title>Library-Home</title>
		<link rel = "stylesheet" href ="css/mainpage.css"/>
	</head>
<body>
	<header>
	<div class="head_top">
		<div class="logo_name"><img class="siyanelogo" src="Images/siyane_logo.jpg"/>
			<h1>LIBRARY</h1>
		<h3>Siyane National College of Education<br />Veyangoda</h3>
	</div>
	</div>
	<div class="bgimage">
	<nav>
		<ul class="navbar">
			<li><a href="#">HOME</a></li>
			<li class="adminprof"><a href="admin/Admin%20Login.php">ADMIN LOGIN</a></li>
		</ul>
	</nav>
	</div>
	</header>
	
	<form class="memberLoginForm" method="POST" action="" autocomplete="off">
        <h2 align="center">User Login</h2>
		<div class="imgcontainer"><img src="Images/login-bg.png" alt="" class="loginimge"/></div>
		<div class="container">
            <span class="warningMsg"><?php $msg;?></span>
		<label for="user"><b>Username</b></label><br />
		<input id="user" name="uname" type="text" placeholder="Enter Username" value="<?php if (isset($_POST['uname'])) echo $_POST['uname']; ?>" required autofocus/><br />
		<label for="psw"><b>Password</b></label><br />
		<input id="psw" name="Psw" type="password" placeholder="Enter Password" required/><br />
		<button class="subBtn" name="SubmitBotton" type="submit">Login</button>
		<button class="cancelbtn" type="button">Cancel</button>
		</div>
	</form>

    <?php
        include("database.php");
        include("table.php");
        include("login.php");
        $dbObj=database::getInstance();
        $dbObj->connect('localhost','root','','lms_db');
        $msg='';

    if(isset($_POST["SubmitBotton"])) {
        if (empty($_POST['uname']) || empty($_POST['Psw'])) {
            $msg= "Username or password is invalid";
        } else {
            $user_name = $_POST['uname'];
            $password = $_POST['Psw'];
            $enPass = md5("$password");
            $login = new login();
            $result = $login->load($dbObj,$user_name);
            $numOfRows = mysqli_num_rows($dbObj->getResult());

            $lst_login_date=date('Y-m-d');

            if ($numOfRows == 1 && $login->password==$enPass) {
                header("Location:member/Member Page.php");
                $login->last_login_date=$lst_login_date;
                $login->update($dbObj);
                $_SESSION['id'] = $user_name;
                header("Location:member/Member Page.php");
            } else {
                $msg= "Your Username or Password is invalid";
            }
        }
    }
    ?>
	
	
	<div class="slideshow "></div>
	
	<section class="linkarea">
	<h3>Quick Links</h3>
	<a href="http://www.siyanencoe.sch.lk/" target="_blank" >SNCoE Website</a><hr />
	<div class="stretch"><strong>Contact Information</strong> <br />
		<p class="hidden">This text is hidden.</p>
		<b>President :</b> <i class="TPnumber">+94333832157</i><br />
		<b>Vice President (Administration) :</b> <i class="TPnumber">+94332287213</i><br />
		<b>Vice President (Academic) :</b><i class="TPnumber"> +94333832156</i><br />
		<b>Registrar :</b><i class="TPnumber"> +94332287587</i><br />
		<b>Fax :</b> <i class="TPnumber">+94332287213</i>
	</div>
	
	</section>
	</body>
</html>