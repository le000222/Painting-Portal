<?php
include('includes/config.php');
error_reporting(0);
session_start();

if (isset($_POST['checkout']) && $_SESSION['login'] == 1) {
    header("Location: payment-methods.php");
    exit;
}
else if (isset($_POST['checkout']) && $_SESSION['login'] == 0) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['remove_code'])) {
    foreach($_POST['remove_code'] as $painting) {
        $sqlQuery = "DELETE FROM cart WHERE pid='".$painting."'";
        $result = $pdo->query($sqlQuery);
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

	    <title>My Cart</title>
	    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
	    <link rel="stylesheet" href="assets/css/main.css">
	    <link rel="stylesheet" href="assets/css/green.css">
	    <link rel="stylesheet" href="assets/css/owl.carousel.css">
		<link rel="stylesheet" href="assets/css/owl.transitions.css">
		<!--<link rel="stylesheet" href="assets/css/owl.theme.css">-->
		<link href="assets/css/lightbox.css" rel="stylesheet">
		<link rel="stylesheet" href="assets/css/animate.min.css">
		<link rel="stylesheet" href="assets/css/rateit.css">
		<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">

		<!-- Demo Purpose Only. Should be removed in production -->
		<link rel="stylesheet" href="assets/css/config.css">

		<link href="assets/css/green.css" rel="alternate stylesheet" title="Green color">
		<link href="assets/css/blue.css" rel="alternate stylesheet" title="Blue color">
		<link href="assets/css/red.css" rel="alternate stylesheet" title="Red color">
		<link href="assets/css/orange.css" rel="alternate stylesheet" title="Orange color">
		<link href="assets/css/dark-green.css" rel="alternate stylesheet" title="Darkgreen color">
		<!-- Demo Purpose Only. Should be removed in production : END -->

		
		<!-- Icons/Glyphs -->
		<link rel="stylesheet" href="assets/css/font-awesome.min.css">

        <!-- Fonts --> 
		<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="assets/images/favicon.ico">

		<!-- HTML5 elements and media queries Support for IE8 : HTML5 shim and Respond.js -->
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->

	</head>
    <body class="cnt-home">
	
		
	
		<!-- ============================================== HEADER ============================================== -->
<header class="header-style-1">
<?php include('includes/top-header.php');?>
<?php include('includes/main-header.php');?>
<?php include('includes/menu-bar.php');?>
</header>
<!-- ============================================== HEADER : END ============================================== -->
<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="#">Home</a></li>
				<li class='active'>Shopping Cart</li>
			</ul>
		</div><!-- /.breadcrumb-inner -->
	</div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content outer-top-xs">
	<div class="container">
		<div class="row inner-bottom-sm">
			<div class="shopping-cart">
				<div class="col-md-12 col-sm-12 shopping-cart-table ">
					<div class="table-responsive">
						<form name="cart" method="post">	
                            <?php

							if (!isset($_POST['submit'])) {
								$sql = "SELECT * FROM cart WHERE pid ='".$_GET['pid']."'";
								$result = $pdo->query($sql);
								$row = $result->fetch();
								if ($row['pid'] != $_GET['pid']) {
									$quantity = 1;
									$sql = "INSERT INTO cart (pid, quantity) VALUES('".$_GET['pid']."', ".$quantity.")";
								}
								else {
									$quantity = $row['quantity'];
									$quantity += 1;
									$sql = "UPDATE cart SET quantity = ".$quantity." WHERE pid = '".$_GET['pid']."'";
								}
								$pdo->query($sql);
							}

                        	?>
                    		<table class="table table-bordered" method="POST">
                    			<thead>
                    				<tr>
                    					<th class="cart-romove item">Remove</th>
                    					<th class="cart-description item">Image</th>
                    					<th class="cart-product-name item">Painting Title</th>
                    			
                    					<th class="cart-qty item">Quantity</th>
                    					<th class="cart-sub-total item">Price Per unit</th>
                    					<th class="cart-sub-total item">Shipping Charge</th>
                    					<th class="cart-total last-item">Grand Total</th>
                    				</tr>
                    			</thead><!-- /thead -->
                    			<tfoot>
                    				<tr>
                    					<td colspan="7">
                    						<div class="shopping-cart-btn">
                    							<span class="">
                    								<a href="index.php" class="btn btn-upper btn-primary outer-left-xs">Continue Shopping</a>
													<input type="submit" name="submit" value="Update shopping cart" class="btn btn-upper btn-primary pull-right outer-right-xs">
												</span>
                    						</div><!-- /.shopping-cart-btn -->
                    					</td>
                    				</tr>
                    			</tfoot>
                    			<tbody>
                                <?php
                                    $sqlQuery = "SELECT * FROM paintings INNER JOIN cart WHERE paintings.pid = cart.pid";
                                    $result = $pdo->query($sqlQuery);
									$rows = $result -> fetchAll();

                                    foreach ($rows as $row) {
                            	?>
                				<tr>
                					<td class="remove-item">
										<input type="checkbox" name="remove_code[]" value="<?php echo $row['pid']; ?>" />
									</td>
                					<td class="cart-image">
										<img src="admin/paintingImages/<?php echo $row['paintingImage']; ?>" alt="" width="114" height="146">
                					</td>
                					
                					<td class="cart-product-name-info">
                						<h4 class='cart-product-description'>
                							<?php echo $row['paintingTitle']; ?>
                						</h4>
                					</td>
                					
                					<td class="cart-product-quantity">
                						<div class="quant-input">
											<div class="arrows">
												<div class="arrow plus gradient"><span class="ir"><i class="icon fa fa-sort-asc"></i></span></div>
												<div class="arrow minus gradient"><span class="ir"><i class="icon fa fa-sort-desc"></i></span></div>
											</div>
											
                				            <input type="text" value="<?php echo $row['quantity']; ?>" name="quantity" />
											<?php
												$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

												$sqlQuery = "UPDATE cart SET quantity = ".$quantity." WHERE pid = '".$row['pid']."'";
												$result = $pdo->query($sqlQuery);

											?>
                			             </div>
                		            </td>
                		            
                					<td class="cart-product-sub-total">
                						<span class="cart-sub-total-price">
											<?php
											echo $row['paintingPrice'];
											?>.00
                						 </span>
                					</td>
                					
                                    <td class="cart-product-sub-total">
										<span class="cart-sub-total-price">
											<?php 
											echo "$".$row['shippingCharge'];
											?>.00
										</span>
                                    </td>
                
                					<td class="cart-product-grand-total">
										<span class="cart-grand-total-price">
											<?php
											$price = $row['paintingPrice'] * $quantity; 
											$total = $price + $row['shippingCharge'];
											$sqlQuery = "UPDATE cart SET price = '".$total."' WHERE pid = '".$row['pid']."'";
											$result = $pdo->query($sqlQuery);
											$quantity = 1;
                                            echo "$".$total; 
											?>.00
										</span>
                					</td>
                				</tr>
                
                				<?php
									}
                				?>
                    			</tbody><!-- /tbody -->
                    		</table><!-- /table -->
                		</form>
    				</div>
				</div><!-- /.shopping-cart-table -->
							
				<div class="col-md-4 col-sm-12 estimate-ship-tax">
                	<table class="table table-bordered">
                		<thead>
                			<tr>
                				<th>
                					<span class="estimate-title">Shipping Address</span>
                				</th>
                			</tr>
                		</thead>
                		<tbody>
            				<tr>
            					<td>
            						<div class="form-group">
            						<?php 
                                    if ($_SESSION['login'] == 1){
                                        $sqlQuery = "SELECT * FROM users";
                                        $result = $pdo->query($sqlQuery);
                                        $rows = $result->fetchAll();
                                        foreach ($rows as $row){
                                            if ($row['name'] == $_SESSION['welcomeName']){
                                                $_SESSION['loginID'] = $row['id'];
                                                echo $row['shippingAddress'];
                                            }
                                        }
                                    }
            						?>
            		
            						</div>
            					
            					</td>
            				</tr>
                		</tbody><!-- /tbody -->
                	</table><!-- /table -->
                </div>

                <div class="col-md-4 col-sm-12 estimate-ship-tax">
                	<table class="table table-bordered">
                		<thead>
                			<tr>
                				<th>
                					<span class="estimate-title">Billing Address</span>
                				</th>
                			</tr>
                		</thead>
                		<tbody>
                				<tr>
                					<td>
                						<div class="form-group">
                						<?php
                						if ($_SESSION['login'] == 1) {
                                            $sqlQuery = "SELECT * FROM users";
                                            $result = $pdo->query($sqlQuery);
                                            $rows = $result->fetchAll();
                                            foreach ($rows as $row){
                                                if ($row['name'] == $_SESSION['welcomeName']){
                                                    echo $row['billingAddress'];
                                                }
                                            }
                                        }
                						?>
                		
                						</div>
                					
                					</td>
                				</tr>
                		</tbody><!-- /tbody -->
                	</table><!-- /table -->
                </div>
                
                <div class="col-md-4 col-sm-12 cart-shopping-total">
                    <form method="post">
                	<table class="table table-bordered">
                		<thead>
                			<tr>
                				<th>
                					
                					<div class="cart-grand-total">
                						Grand Total<span class="inner-left-md">
										<?php 
										$sqlQuery = "SELECT price FROM cart";
										$result = $pdo->query($sqlQuery);
										while ($row = $result->fetch()) {
											$grandTotal += $row['price'];
										}
										echo "$".$grandTotal;  ?>.00</span>
                					</div>
                				</th>
                			</tr>
                		</thead><!-- /thead -->
                		<tbody>
                				<tr>
                					<td>
                						<div class="cart-checkout-btn pull-right">
<!--                 							<button type="submit" name="ordersubmit" class="btn btn-primary">PROCCED TO CHEKOUT</button> -->
                							<input type="submit" name="checkout" value="PROCCED TO CHEKOUT" class="btn btn-primary" />
                                            <?php
												
                                            ?>
                						</div>
                					</td>
                				</tr>
                		</tbody><!-- /tbody -->
                	</table>
                    </form>
                	<?php
                	if (isset($_POST['ordersubmit'])) {
                	    $_SESSION['proceed'] = $_POST['ordersubmit'];
                	    header("Location: login.php");
                	    exit;
                	}
                	 ?>
                </div>			
            </div>
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