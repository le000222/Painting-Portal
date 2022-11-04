<?php
session_start();
error_reporting(0);
include('includes/config.php');
$error = "";
$message= " ";
// Code for user Registration
if (isset($_POST['signup'])) {
    if(!isset($_POST["fullname"]) || !isset($_POST["emailid"]) || !isset($_POST["contactno"]) || !isset($_POST["billingaddress"]) || !isset($_POST["shippingaddress"])
        || !isset($_POST["password"]) || !isset($_POST["confirmpassword"])) {
            echo "missing";
            $error = "Please fill in all the information.";
        }
        else {
            if($_POST["fullname"] != "" && $_POST["emailid"] != "" && $_POST["contactno"] != "" && $_POST["billingaddress"] != "" && $_POST["shippingaddress"] != ""
                && $_POST["password"] != "" && $_POST["confirmpassword"] != "") {
                    if ($_POST["password"] == $_POST["confirmpassword"]) {
                        $sqlQuery = "SELECT email FROM users WHERE email = '".$_POST['emailid']."'";
                        $result = $pdo->query($sqlQuery);
                        $row = $result->fetch();
                        if ($row['email'] == $_POST['emailid']) {
                            $error = "Email already exists.";
                        }
                        else {
                            $sqlQuery = "INSERT INTO users (name, email, contactNo, password, shippingAddress, billingAddress)
						VALUES('".$_POST["fullname"]."', '".$_POST["emailid"]."', '".$_POST["contactno"]."', '".$_POST["password"]."',
						'".$_POST["billingaddress"]."','".$_POST["shippingaddress"]."')";
                            
                            try {
                                $result = $pdo->query( $sqlQuery );
                                $message = "Sign up successfully. Please log in to continue purchasing.";
                            }
                            catch(PDOException $e) {
                                $message = "Person Could not be added:  " . $e->getMessage();
                            }
                        }
                        
                        $pdo = null;
                    }
                    else {
                        $error = "Invalid input. Password must match.";
                    }
                }
        }
}

// Code for User login
if (isset($_POST['login'])) {
    if ($_POST['email'] != "" && $_POST['password'] != "") {
        $sqlQuery = "SELECT * FROM users WHERE email='".$_POST['email']."' AND password='".$_POST['password']."'";
        $result = $pdo->query($sqlQuery);
        $row = $result->fetch();
        
        if ($_POST["email"] == $row[2]) {
            if ($_POST["password"] == $row[4]) {
                $_SESSION['welcomeName'] = $row['name'];
                $_SESSION['userId'] = $row['id'];
                $_SESSION['login'] = 1;
                header("Location: my-cart.php");
                exit;
            }
            else {
                $error = "Invalid email or password";
            }
        }
        else {
            $error = "Invalid email or password";
        }
    }
    else {
        $error = "Please fill in email and password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Meta -->
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="description" content="">
		<meta name="author" content="">
	    <meta name="keywords" content="MediaCenter, Template, eCommerce">
	    <meta name="robots" content="all">

	    <title>Paintings Portal | Sign-in | Signup</title>

	    <!-- Bootstrap Core CSS -->
	    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
	    
	    <!-- Customizable CSS -->
	    <link rel="stylesheet" href="assets/css/main.css">
	    <link rel="stylesheet" href="assets/css/green.css">
	    <link rel="stylesheet" href="assets/css/owl.carousel.css">
		<link rel="stylesheet" href="assets/css/owl.transitions.css">
		<!--<link rel="stylesheet" href="assets/css/owl.theme.css">-->
		<link href="assets/css/lightbox.css" rel="stylesheet">
		<link rel="stylesheet" href="assets/css/animate.min.css">
		<link rel="stylesheet" href="assets/css/rateit.css">
		<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">

		
		<link rel="stylesheet" href="assets/css/config.css">

		<link href="assets/css/green.css" rel="alternate stylesheet" title="Green color">
		<link href="assets/css/blue.css" rel="alternate stylesheet" title="Blue color">
		<link href="assets/css/red.css" rel="alternate stylesheet" title="Red color">
		<link href="assets/css/orange.css" rel="alternate stylesheet" title="Orange color">
		<link href="assets/css/dark-green.css" rel="alternate stylesheet" title="Darkgreen color">
		

		
		<!-- Icons/Glyphs -->
		<link rel="stylesheet" href="assets/css/font-awesome.min.css">

        <!-- Fonts --> 
		<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="assets/images/favicon.ico">
<script type="text/javascript">
function valid()
{
 if(document.register.password.value!= document.register.confirmpassword.value)
{
alert("Password and Confirm Password Field do not match  !!");
document.register.confirmpassword.focus();
return false;
}
return true;
}
</script>
<script>
function userAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'email='+$("#email").val(),
type: "POST",
success:function(data){
$("#user-availability-status1").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>

</head>
<body class="cnt-home">
	
<!-- ============================================== HEADER ============================================== -->
<header class="header-style-1">

<!-- ============================================== TOP MENU ============================================== -->
<?php include('includes/top-header.php');?>
<!-- ============================================== TOP MENU : END ============================================== -->
<?php include('includes/main-header.php');?>
	<!-- ============================================== NAVBAR ============================================== -->
<?php include('includes/menu-bar.php');?>
<!-- ============================================== NAVBAR : END ============================================== -->

</header>

<!-- ============================================== HEADER : END ============================================== -->
<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="home.html">Home</a></li>
				<li class='active'>Authentication</li>
			</ul>
		</div><!-- /.breadcrumb-inner -->
	</div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content outer-top-bd">
	<div class="container">
		<div class="sign-in-page inner-bottom-sm">
			<div class="row">
				<!-- Sign-in -->			
                <div class="col-md-6 col-sm-6 sign-in">
                	<h4 class="">sign in</h4>
                	<p class="">Hello, Welcome to your account.</p>
                	<form class="register-form outer-top-xs" method="post">
                    	<span style="color:red;" >
                            <?php
							echo $error;
                            ?>
                    	</span>
                    	
                		<div class="form-group">
                		    <label class="info-title" for="exampleInputEmail1">Email Address <span>*</span></label>
                		    <input type="email" name="email" class="form-control unicase-form-control text-input" id="exampleInputEmail1" >
                		</div>
                		
                	  	<div class="form-group">
                		    <label class="info-title" for="exampleInputPassword1">Password <span>*</span></label>
                		 <input type="password" name="password" class="form-control unicase-form-control text-input" id="exampleInputPassword1" >
                		</div>
                		
                		<div class="radio outer-xs">
                		  	<a href="forgot-password.php" class="forgot-password pull-right">Forgot your Password?</a>
                		</div>
    	  				<button type="submit" class="btn-upper btn btn-primary checkout-page-button" name="login">Login</button>
					</form>					
				</div>
                <!-- Sign-in -->

                <!-- create a new account -->
                <div class="col-md-6 col-sm-6 create-new-account">
                	<h4 class="checkout-subtitle">create a new account</h4>
                	<p class="text title-tag-line">Create your own Shopping account.</p>
                	<form class="register-form outer-top-xs" role="form" method="post" name="register" onSubmit="return valid();">
                    	<div class="form-group">
                	    	<label class="info-title" for="fullname">Full Name <span>*</span></label>
                	    	<input type="text" class="form-control unicase-form-control text-input" id="fullname" name="fullname" required="required">
                	  	</div>
                    
                		<div class="form-group">
                	    	<label class="info-title" for="exampleInputEmail2">Email Address <span>*</span></label>
                	    	<input type="email" class="form-control unicase-form-control text-input" id="email" onBlur="userAvailability()" name="emailid" required >
                	    	       <span id="user-availability-status1" style="font-size:12px;"></span>
                	  	</div>
                    
                    	<div class="form-group">
                	    	<label class="info-title" for="contactno">Contact No. <span>*</span></label>
                	    	<input type="text" class="form-control unicase-form-control text-input" id="contactno" name="contactno" maxlength="10" required >
                	  	</div>
                    	  	
                	  	<div class="form-group">
                	    	<label class="info-title" for="billingaddress">Billing Address <span>*</span></label>
                	    	<input type="text" class="form-control unicase-form-control text-input" id="billingaddress" name="billingaddress" maxlength="50" required >
                	  	</div>
                    	  	
                	  	<div class="form-group">
                	    	<label class="info-title" for="shippingaddress">Shipping Address <span>*</span></label>
                	    	<input type="text" class="form-control unicase-form-control text-input" id="shippingaddress" name="shippingaddress" maxlength="50" required >
                	  	</div>
                    
                    	<div class="form-group">
                	    	<label class="info-title" for="password">Password. <span>*</span></label>
                	    	<input type="password" class="form-control unicase-form-control text-input" id="password" name="password"  required >
                	  	</div>
                    
                    	<div class="form-group">
                	    	<label class="info-title" for="confirmpassword">Confirm Password. <span>*</span></label>
                	    	<input type="password" class="form-control unicase-form-control text-input" id="confirmpassword" name="confirmpassword" required >
                	  	</div>
                    
                    
                	  	<button type="submit" name="signup" class="btn-upper btn btn-primary checkout-page-button" id="submit">Sign Up</button>
                	</form>

                	<?php 
					echo $message; 
					echo $error;
					?>

                	<span class="checkout-subtitle outer-top-xs">Sign Up Today And You'll Be Able To :  </span>
                	<div class="checkbox">
                	  	<label class="checkbox">
                		  	Speed your way through the checkout.
                		</label>		
                		<label class="checkbox">
                 			Keep a record of all your purchases.
                		</label>
                	</div>
                </div>	<!-- create a new account -->			
            </div><!-- /.row -->
    	</div>
    </div>
</div>
<?php include('includes/footer.php');?>
	<script src="assets/js/jquery-1.11.1.min.js"></script>
	
	<script src="assets/js/bootstrap.min.js"></script>
	
	<script src="assets/js/bootstrap-hover-dropdown.min.js"></script>
	<script src="assets/js/owl.carousel.min.js"></script>
	
	<script src="assets/js/echo.min.js"></script>
	<script src="assets/js/jquery.easing-1.3.min.js"></script>
	<script src="assets/js/bootstrap-slider.min.js"></script>
    <script src="assets/js/jquery.rateit.min.js"></script>
    <script type="text/javascript" src="assets/js/lightbox.min.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
	<script src="assets/js/scripts.js"></script>

	
	
	<script src="switchstylesheet/switchstylesheet.js"></script>
	
	<script>
		$(document).ready(function(){ 
			$(".changecolor").switchstylesheet( { seperator:"color"} );
			$('.show-theme-options').click(function(){
				$(this).parent().toggleClass('open');
				return false;
			});
		});

		$(window).bind("load", function() {
		   $('.show-theme-options').delay(2000).trigger('click');
		});
	</script>
</body>
</html>