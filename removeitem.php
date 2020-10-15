<?php
 include'shopping_cart.php';
 		foreach ($_SESSION['shopping_cart'] as $key => $value) {
 			if($value['itemid']==$_GET['id']){
 				unset($_SESSION['shopping_cart'][$key]);
 				echo '<script>alert("Item Removed")</script>';
                echo '<script>window.location="shopping_cart.php"</script>';
 			}
 		}
?>