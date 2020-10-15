<?php
  session_start();
  $con=mysql_connect("localhost","root","");
  $db=mysql_select_db("db2");
  
  if(isset($_POST['addtocart'])){
  	if(isset($_SESSION['shopping_cart'])){
  		$item_array_id=array($_SESSION['shopping_cart']['itemid']);
  		  foreach ($_SESSION['shopping_cart'] as $key => $value)
  		  {
  		  	$itemarray[]=$value['itemid'];
  		  }
  		
    		if(!in_array($_GET['id'], $itemarray)){
  			$count=count($_SESSION['shopping_cart']);
  			$item = array('itemid' =>$_GET['id'] ,
  		    'itemname' =>$_POST['hidden_name'] ,
  		    'itemprice' =>$_POST['hidden_price'] ,
  		    'itemqty' =>$_POST['qty'] , );
  		    $_SESSION['shopping_cart'][$count]=$item;
  		}
  		else {
  			echo '<script>alert("Item Already Added")</script>';
  			echo '<script>window.location="shopping_cart.php"</script>';
  		}
  	}
  	else{

  		$item = array('itemid' =>$_GET['id'] ,
  		'itemname' =>$_POST['hidden_name'] ,
  		'itemprice' =>$_POST['hidden_price'] ,
  		'itemqty' =>$_POST['qty'] , );
  		$_SESSION['shopping_cart'][0]=$item;
  	}
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Shopping World</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="jquery.min.js"></script>
<style type="text/css">
img{
		width: 200px;
		height: 200px;
	}
	</style>
</head>
<body>
	<br>
	<div class="container" style="width: 900px;">
		<h3 align="center">Shopping Cart</h3><br>
		
			  	<div class="card-columns">
		<?php
			$q="select * from shopping order by id asc";
			$res=mysql_query($q);
			if(mysql_num_rows($res)>0)
			{
				while ($row=mysql_fetch_array($res)) 
				{
			?>
		          
			  	
				<form method="post" action="shopping_cart.php?action=add&id=<?php echo $row['id']; ?>">
					
                  
					<div class="card" style="border:1px solid #333; background-color: #f1f1f1; border-radius: 5px; padding: 15px;" align="center">
						
						<img src="shop/<?php echo $row['image']; ?>" class="img-responsive"><br>
						<h4 class="text-info"><?php echo $row['name']; ?></h4>
						<h4 class="text-danger"><?php echo $row['price']; ?></h4>
						Quantity:
						<input type="text" name="qty" class="form-control" value="1">
						<input type="hidden" name="hidden_name" value="<?php echo $row['name']; ?>">
						<input type="hidden" name="hidden_price" value="<?php echo $row['price']; ?>">
						<input type="submit" name="addtocart" class="btn btn-success" value="Add to Cart" style="margin-top: 5px;">
					  

					</div>
			  </form>
			   
			<?php
               
				}
			}
		?>
		</div>
		
		<div style="clear:both;"></div><br>
		<h3>Order Details</h3>
		<div class="table-responsive">
			<table class="table teble-bordered">
				<tr>
					<th>Item Name</th>
					<th>Quantity</th>
					<th>Price</th>
					<th>Total</th>
					<th>Action</th>

				</tr>
				<?php
					if(!empty($_SESSION['shopping_cart'])){
						$total=0;
						foreach ($_SESSION['shopping_cart'] as $key => $value) {
							
						
				       ?>
				       <tr>
				       		<td><?php echo $value['itemname']; ?></td>
				       		<td><?php echo $value['itemqty']; ?></td>
				       		<td><?php echo $value['itemprice']; ?></td>
				       		<td><?php echo number_format($value['itemqty'] * $value['itemprice'],2); ?></td>
				       		<td> <button class="btn-danger btn"><a href="removeitem.php?id=<?php echo $value['itemid']; ?>" class="text-white"> Remove </a></button> </td>
				       </tr>
				   <?php
				   		$total=$total + ($value['itemqty'] * $value['itemprice']);

					}
				}
					?>

					<tr>
						<td colspan="3" align="right">Total</td>
						<td align="right"><?php echo number_format($total,2); ?></td>
					</tr>

					<?php
				?>
			</table>
			
		</div>



 </div>
    

</body>
</html>