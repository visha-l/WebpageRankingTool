
<html>
<head>
<?php include '../common/meta.html';?>
</head>
<body >


<?php
		session_start();
		if(!(isset($_SESSION['u_id']) && !empty($_SESSION['u_id'])))
		{
			header('Location:../USER/userlogin.php');
			
		}
		if(!(isset($_POST['total_row']) && !empty($_POST['total_row'])))
		{
			echo '<script>alert("Cart is empty");</script>';
		//	header('Location:buyinterface.php');
		}
		$php_uid=$_SESSION['u_id'];
		
		$php_rows=$_POST['total_row'];
		//unset($_SESSION)
		//echo 'total rows='.$php_rows."<br>";
	//	$php_cols=$_POST['last_col'];
		//echo 'last col='.$php_cols."<br>";


		$php_cdate=date('Y-m-d');	
	//	echo $php_cdate."<br>";

	//	echo $php_uid."<br>";



$servername = "localhost";
$username = "root";
$password = "";	
$dbname="DBMS_PROJECT";

$conn = new mysqli($servername,$username,$password,$dbname);

if($conn->connect_error)
{
	die("Connection Failed:" . $conn->connect_error);
}	







	for($i=0  ; $i<$php_rows; $i++)
	{
			$var= $i;

			$bookid=$_POST[$var.'b'];
			$qnty=$_POST[$var.'q'];
	//		echo "bookid".$bookid."<br>";
	//		echo "quantity".$qnty."<br>";



				/* update purchase history*/
				$sql = "insert into p_history values( '$bookid' , '$php_uid' , '$php_cdate', '$qnty' ) " ;
				$res = $conn->query($sql);

				if(!$res)
				{
					echo 'query not run successfully'.$conn->error;
				}
				/* update purchase history*/


				/*update book table quantity*/
				$sql = "update BOOK  set QUANTITY= (QUANTITY - '$qnty') where BOOKID='$bookid' ";
				$res = $conn->query($sql);

				if(!$res)
				{
					echo 'query book update not run successfully'.$conn->error;
				}
				/*update book table quantity*/


				/* update cart*/
				$sql = "delete from  cart where BOOKID='$bookid' and u_id='$php_uid' " ;
				$res = $conn->query($sql);


				if(!$res)
				{
					echo 'query  cart delete not run successfully'.$conn->error;
				}
				/* update cart*/





		}
	




//include 'address_form.php';

$sql = "select * from  u_purchase where  u_id='$php_uid' " ;
$res = $conn->query($sql);

if($res)
{
	if($res -> num_rows>0)
	{
		$row=$res->fetch_assoc();		
	//	echo 'already';
			echo '	<form action="../USER/u_purchase.php" method="post">
		  
		    <h1>Give Address</h1>
		    
		    <fieldset>
		      <legend><span class="number">1</span><span style="font-family:"Lily Script One", cursive;">Write your address</span></legend>
		      <label for="name">Address:</label>
		      <textarea id="name" name="address" rows="5" cols="25"  required  placeholder="'.$row['address'].'"></textarea><br><br>
		      <label for="name">Email ID:</label>
		      <input type="email" name="u_email" pattern="[a-zA-Z]{1,20}@[a-zA-Z]{3,20}.[a-zA-Z]{1,20}"  title="Enter Correct Email" value="'.$row['u_email'].'" required><br>
		      <label for="name">Contact</label>
		      <input type="text" name="u_contact" pattern="[0-9]{9,10}"  title="Enter ten characters"  value="'.$row['contact'].'" required><br>
		      
		    </fieldset>
		    
		    <button type="submit">Submit</button>
	</form>';
		
		
		

		
	}	
	else
	{
	//	echo 'not already';
			echo '	<form action="../USER/u_purchase.php" method="post">
		  
		    <h1>Give Address</h1>
		    
		    <fieldset>
		      <legend><span class="number">1</span><span style="font-family:"Lily Script One", cursive;">Write your address</span></legend>
		      <label for="name">Address:</label>
		      <textarea id="name" name="address" rows="5" cols="25" placeholder="type your address here.." required ></textarea><br><br>
		      <label for="name">Email ID:</label>
		      <input type="email" name="u_email" pattern="[a-zA-Z]{1,20}@[a-zA-Z]{3,20}.[a-zA-Z]{1,20}"  title="Enter Correct Email" required><br>
		      <label for="name">Contact</label>
		      <input type="text" name="u_contact" pattern="[0-9]{9,10}"  title="Enter ten characters" required><br>
		      
		    </fieldset>
		    
		    <button type="submit">Submit</button>
	</form>';
	
	}

}
else
{
echo 'query not run successfully'.$conn->error;
}




?>

</body>
<html>
