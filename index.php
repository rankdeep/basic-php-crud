<?php

//database connection using config file
include("config.php");

$id = $name = $mobile = $email = $city = "";
$update = false;

if(isset($_GET['id']) && isset($_GET['action'])){

    $id = $_GET['id'];
    //fetch user data based on id
    $select_query = "SELECT * FROM user_details WHERE id=$id";
    $result = mysqli_query($conn, $select_query);
        
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
        $update_query = "UPDATE user_details SET name='$name',email='$email',city='$city',mobile='$mobile' WHERE id=$id";
        $result = mysqli_query($conn, $update_query);
        $update = true;
        header("Location:index.php");

    }else{
    
    if($_GET['action']=='delete'){
    
        //delete user row from table based on id
        $delete_query = "DELETE FROM user_details WHERE id=$id";
        $result = mysqli_query($conn, $delete_query);
        header("Location:index.php");
    }
}
}else{

    //check If form submitted, insert form data into users table.
	if(isset($_POST['save'])){
		
        $name = $_POST['name'];
		$email = $_POST['email'];
		$city = $_POST['city'];
		$mobile = $_POST['mobile'];

        if(!empty($name) && !empty($email) && !empty($city) && !empty($mobile)){
            //insert user data into table
            $query = "INSERT INTO user_details(name,email,city,mobile) VALUES('$name','$email','$city','$mobile')";
		    $result = mysqli_query($conn, $query);
            header("Location:index.php");
        }else{
            echo "One or more fields are Empty. Please complete the User Form.";
            echo "<br><br>";
        }
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
        a:link, a:visited {
            background-color: grey;
            color: white;
            padding: 2px 8px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        a:hover, a:active {
            background-color: #454B1B;
        }

    </style>
</head>

<body>
<form action="" method="post" name="form1">
    <fieldset>
        <legend>User Information</legend>
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
				    <td><input type="submit" name="update" value="Update"></td>
			    </tr>
                <?php }else { ?>
                <tr> 
				    <td><input type="submit" name="save" value="Save"></td>
                    <td><input type="reset" name="reset" value="Reset"></td>
			    </tr>
                <?php } ?>
		</table>
    </fieldset>
</form>

<table width='80%' border=1 class="center">

    <tr>
        <th>NAME</th> <th>MOBILE</th> <th>EMAIL</th> <th>CITY</th> <th>UPDATE</th> <th>DELETE</th>
    </tr>
    
    <?php 
    
    //fetch all users data from database
    $query = "SELECT * FROM user_details ORDER BY id DESC";
    $result = mysqli_query($conn, $query);
    echo "<h2>View User Data</h2>";
    while($user_data = mysqli_fetch_array($result)) {         
        echo "<tr>";
        echo "<td>".$user_data['name']."</td>";
        echo "<td>".$user_data['mobile']."</td>";
        echo "<td>".$user_data['email']."</td>";
        echo "<td>".$user_data['city']."</td>";    
        echo "<td><a href='index.php?id=$user_data[id]&action=update'>Update</a></td>";
        echo "<td><a href='index.php?id=$user_data[id]&action=delete'>Delete</a></td>";
        echo "</tr>";
    }
    ?>
    
</table>
</body>
</html>