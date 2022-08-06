<?php

//database connection using config file
include("config.php");

$id = $name = $mobile = $email = $city = "";
$update = false;

if(isset($_GET['id']) && isset($_GET['action'])){

    $id = $_GET['id'];
    //fetch user data based on id
    $query = "SELECT * FROM users WHERE id=$id";
    $result = mysqli_query($conn, $query);
        
    while($user_data = mysqli_fetch_array($result)){
    
        $name = $user_data['name'];
        $email = $user_data['email'];
        $city = $user_data['city'];
        $mobile = $user_data['mobile'];
    }
    if(isset($_POST['update'])){

        $id = $_POST['id'];
        $name=$_POST['name'];
        $mobile=$_POST['mobile'];
        $email=$_POST['email'];
        $city=$_POST['city'];
            
        //update user data
        $result = mysqli_query($conn, "UPDATE users SET name='$name',email='$email',city='$city',mobile='$mobile' WHERE id=$id");
        $update = true;
        header("Location:index.php");

    }else{
    
    if($_GET['action']=='delete'){
    
        //delete user row from table based on id
        $query = "DELETE FROM users WHERE id=$id";
        $result = mysqli_query($conn, $query);
        header("Location:index.php");
    }
}

}else{

    //Check If form submitted, insert form data into users table.
	if(isset($_POST['save'])){
		
        $name = $_POST['name'];
		$email = $_POST['email'];
		$city = $_POST['city'];
		$mobile = $_POST['mobile'];
						
		//Insert user data into table
		$result = mysqli_query($conn, "INSERT INTO users(name,email,city,mobile) VALUES('$name','$email','$city','$mobile')");
		
		//show message when user added
		echo "User added successfully";
        header("Location:index.php");
    }
}
?>

<html>
<head>    
    <title>User Form</title>
    <style>
        table.center{
            margin-left: auto;
            margin-right: auto;
        }
        h2{
            text-align: center;
        }
    </style>
</head>

<body>

<form action="" method="post" name="form1">
		<table width="25%" border="0"class="center">

            <h2>User Form</h2>
            <tr>
                <td><input type="hidden" name="id" value=<?php echo $id;?>></td>
            </tr>
			<tr> 
				<td>Name</td>
				<td><input type="text" name="name" placeholder="Enter Name" value=<?php echo $name;?>></td>
			</tr>
			<tr> 
				<td>Email</td>
				<td><input type="text" name="email" placeholder="Enter Email Address" value=<?php echo $email;?>></td>
			</tr>
			<tr> 
				<td>City</td>
				<td><input type="text" name="city" placeholder="Enter City" value=<?php echo $city;?>></td>
			</tr>
			<tr> 
				<td>Mobile</td>
				<td><input type="text" name="mobile" placeholder="Enter Mobile Number" value=<?php echo $mobile;?>></td>
			</tr>
            <?php if(isset($_GET['action'])){?>
            <tr>
				<td><input type="submit" name="update" value="update"></td>
			</tr>
            <?php }else { ?>
            <tr> 
				<td><input type="submit" name="save" value="save"></td>
                <td><input type="reset" name="reset" value="reset"></td>
			</tr>
            <?php } ?>

		</table>
</form>

<table width='80%' border=1 class="center">

    <tr>
        <th>Name</th> <th>Mobile</th> <th>Email</th><th>City</th> <th>Action</th>
    </tr>
    
    <?php  
    
    //Fetch all users data from database
    $query = "SELECT * FROM users ORDER BY id DESC";
    $result = mysqli_query($conn, $query);
    echo "<h2>View User Data</h2>";
    while($user_data = mysqli_fetch_array($result)) {         
        echo "<tr>";
        echo "<td>".$user_data['name']."</td>";
        echo "<td>".$user_data['mobile']."</td>";
        echo "<td>".$user_data['email']."</td>";
        echo "<td>".$user_data['city']."</td>";    
        echo "<td><a href='index.php?id=$user_data[id]&action=update'>Update</a> | <a href='index.php?id=$user_data[id]&action=delete'>Delete</a></td></tr>";        
    }
    ?>
    
</table>

</body>
</html>