<?php

session_start();

if(isset($_SESSION['id'])){
    header("location: post.php");
}

include('server.php');

$error=0;

if(isset($_POST['addmin_page'])){

    $addmin_name = $_POST['addmin_name'];
    $_SESSION['name_addmin'] = $addmin_name;
    $password_name = $_POST['addmin_password'];

    if($error==0){
        $addmin_page = "SELECT * FROM addmin WHERE addmin_name = '$addmin_name' AND addmin_password = '$password_name'";
        $addmin = mysqli_query($conn, $addmin_page);
        if(mysqli_num_rows($addmin) > 0){
            $rows = mysqli_fetch_assoc($addmin);
            if($rows['addmin_name'] = $addmin_name AND $rows['addmin_password'] = $password_name){
                header('location: post.php');
            }
            else{
                header('location: log_in.php');
            }
        }
    } 

    $sql = "SELECT * FROM addmin WHERE addmin_name = '$addmin_name' AND addmin_password = '$password_name'";
    $name_join = mysqli_query($conn, $sql);
        if(mysqli_num_rows($name_join)>0){
            $row = mysqli_fetch_assoc($name_join);
            $_SESSION['addmin'] = $row['addmin_name'];
            $_SESSION['id'] = $row['id'];
            setcookie('addmin', $row['addmin_name'], time()+60*60*24*30);
        }
    
}


if(isset($_GET['login_page'])){
    session_destroy();
    header('location: login.php');
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="eng">
    <head>
        <title> PIMY 3 - addmin </title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="x-icon" href="kaprikorn.png">
        <script type="text/javascript">
            function preventBack(){window.history.forward()};
            setTimeout("preventBack()", 0);
               window.onunload=function(){null;}
        </script>
        <style>
            @font-face{
                font-family: Kanit;
                src: url(font/Kanit-SemiBold.ttf);
            }

            *{
                margin: 0;
                padding: 0;
                box-sizing: border-box;

            }

            body{
                background: url('addminpage.png');
                background-repeat: no-repeat;
                background-position: center;
                background-attachment: fixed;
                background-size: cover;
                width: 100%;
                height: 100%;

            }

            .container{
                position: relative;
                margin: 5rem;
                justify-content: center;
            }

            form{
                box-sizing: border-box;
                padding: 5rem;
                position: relative;
                display: grid;
                grid-template-rows: 0fr 0fr 0fr;
                row-gap: 2.5rem;
                justify-content: center;
                justify-items: center;
                height: 32rem;
                

            }
            input{
                position: relative;
                width: 30rem;
                height: 4rem;
                font-size: 2rem;
                border-radius: 5rem;
                padding: 1rem;
                border: none;
                font-family: Kanit;
                color: #888463;
                background-color: aliceblue;
            }

            input:focus{
                background-color: #f6e77d;
                box-shadow: 0 0 10px 0 #e2d263;
                border: none;
                outline: none;
                color: #a4a081;
            }


            button{
                top: 2rem;
                position: relative;
                width: 10rem;
                height: 3rem;
                font-size: 1.6rem;
                border-radius: 5rem;
                border: none;
                font-family: Kanit;
                color: #888463;
                background-color: #e2d263;
            }
            button:hover{
                background-color: #f6e77d;
                box-shadow: 0 0 10px 0 #e2d263;
                color: #a4a081;
            }

            a{
                text-decoration: none;
                position: relative;
                font-size: 1.5rem;
                color: #888463;
            }

            a:hover{
                color: #a4a081;
            }

        </style>
    
    </head>
    <body>
        <div class="container">
            <form method="post">
                <input type="text" name="addmin_name" required placeholder="ชื่อแอดมิน (ภาษาอังกฤษ)">
                <input type="text" name="addmin_password" required placeholder="รหัสแอดมิน 8 หลัก (254x/ดด/วว)">
                <button type="submit" name="addmin_page">เข้าสู่ระบบ</button>

            </form>



        </div>

    </body>  
</html>