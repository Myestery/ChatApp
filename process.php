<?php
require('includes/functions.php');

$ready=true;
if (isset($_POST["surname"]) && isset($_POST["middlename"]) && isset($_POST["firstname"]) && isset($_POST["nickname"]) && isset($_POST["email"]) && isset($_POST["country"]) && isset($_POST["password1"]) && isset($_POST["password2"]) && isset($_POST["dateofbirth"]) && isset($_POST["phone"])) {
    //check email
    $email = $_POST["email"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
        $emailErr = "Invalid email format";$ready=false;
        echo $emailErr;}
   
    // check surname
    if ($ready) {
        if (empty($_POST["surname"])) {
        echo "Please tell us your nickname";
         $ready=false;
        }else{$surname=$_POST["surname"];} 
        }

        //check password
    if($ready){
        $password1=($_POST["password1"]);
        $password2=($_POST["password2"]);
        if ($password1==$password2) {
          $password= sha1($password1);
        }else{$ready=false;echo"Passwords do not match";}
    }
        //check middlename
    if ($ready) {
    if (empty($_POST["middlename"])) {
        $middlename=" ";
    }else{$middlename=$_POST["middlename"];} 
    }
    //check nickname
    if ($ready) {
        if (empty($_POST["nickname"])) {
            echo "Please tell us your nickname"; $ready=false;
        }else{$nickname=$_POST["nickname"];} 
        }
    // check dateofbirth
    if ($ready) {
        if (empty($_POST["dateofbirth"])){$dateofbirth=" ";} 
            else{
           $dateofbirth=$_POST["dateofbirth"];} 
        }
    // check firstname
    if ($ready) {
        if (empty($_POST["firstname"])) {
            echo "Input a valid firstname"; $ready=false;
        }else{$firstname=$_POST["firstname"];} 
        }
    // check country
    if($ready){
        if(empty($_POST["country"])){echo "Input a country";
         $ready=false;
        }else{$country=$_POST["country"];}
    }      
    // check phone number
    if($ready){
        $phone=$_POST["phone"];
        if(empty($_POST["phone"])){echo "Input a phone number"; $ready=false;
        }else if (preg_match("/^[a-zA-Z ]*$/",$phone) || strlen($phone)<6) {
            echo "Input a valid phone number";
        }
    }   
    // remove unnecessary symbols and stringify the values
    if ($ready) {
    $surname=mysqli_real_escape_string($conn,stripcslashes(stripslashes($surname)));
    $firstname=mysqli_real_escape_string($conn,stripcslashes(stripslashes($firstname)));
    $middlename=mysqli_real_escape_string($conn,stripcslashes(stripslashes($middlename)));
    $nickname=mysqli_real_escape_string($conn,stripcslashes(stripslashes($nickname)));
    $email=mysqli_real_escape_string($conn,stripcslashes(stripslashes($email)));
    $phone=mysqli_real_escape_string($conn,stripcslashes(stripslashes($phone)));
    $dateofbirth=mysqli_real_escape_string($conn,stripcslashes(stripslashes($dateofbirth)));
    $country=mysqli_real_escape_string($conn,stripcslashes(stripslashes($country))); 


//checking for existing user with the same email
$user_check_query = "SELECT * FROM userinfo WHERE chatemail= '$email' LIMIT 1";
$exist = mysqli_query($conn, $user_check_query);
$user = mysqli_fetch_assoc($exist);
if($user){
    if($user['chatemail']===$email){$ready=false; echo"email already exists";}
}

//Register the user if there are no errors
if ($ready) {
    // save the userdata to an array
    $Userdata= array();
    $Userdata['surname']=$surname;
    $Userdata['firstname']=$firstname;
    $Userdata['middlename']=$middlename;
    $Userdata['nickname']=$nickname;
    $Userdata['country']=$country;
    $Userdata['email']=$email;
    $Userdata['phone']=$phone;
    $Userdata['dateofbirth']=$dateofbirth;
    $Userdata=json_encode($Userdata);
    $DisplayName= $surname." ".$firstname;
    $query ="INSERT INTO userinfo(chatemail,chatpassword,Userdata,DisplayName) VALUES('$email','$password','$Userdata','$DisplayName')";  
    mysqli_query($conn, $query);
    $_SESSION['chatname'] = $firstname;
    $_SESSION['newuser'] = "newuser";
    $user_check_query = "SELECT * FROM userinfo WHERE chatemail= '$email'";
    $result= mysqli_query($conn, $user_check_query)or die("failed to query database" .mysqli_error());
    $row= mysqli_fetch_array($result);
    $_SESSION['userid'] = $row['id'];
    $_SESSION['chatemail'] = $row['chatemail'];
    echo "signup successfull";
}
}
// LOGIN CHECK
}elseif (isset($_POST["useremail"]) && isset($_POST["userpassword"])) {
    $email = mysqli_real_escape_string($conn,stripcslashes($_POST["useremail"]));
    $password= sha1(mysqli_real_escape_string($conn,stripcslashes($_POST['userpassword'])));
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
        $emailErr = "Invalid email format";$ready=false;
        echo $emailErr;
    }else{
        $user_check_query = "SELECT * FROM userinfo WHERE chatemail= '$email'";
        $result= mysqli_query($conn, $user_check_query)or die("failed to query database" .mysqli_error());
        $row= mysqli_fetch_array($result);
        if(is_array($row)){
        if($row['chatemail']== $email && $row['chatpassword']==$password){
            $_SESSION['userid']=$row['id'];
            $_SESSION['chatemail'] = $row['chatemail'];
            $_SESSION['DisplayName'] = $row['DisplayName'];
            echo 'login successful';
        }else{ 
            echo 'password does not match';}
        }else{
           echo 'account does not exist';}
      
    }
}
elseif (isset($_GET['logout'])) {
    session_destroy();
    header('location:\/johnpaul/chatapp');
}
elseif (isset($_POST['message']) && isset($_POST['messageto'])) {
   sendmessage();
    }
else{
    header('location: login.php');
}


?>