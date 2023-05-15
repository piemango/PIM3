<?php
session_start();


if(isset($_SESSION['joiner'])){
    header("location: index.php");
}


 include('server.php');

 $errors=array();

 $error=0;

 
 if(isset($_POST['submitname'])){

    //user page

    $name = $_POST['username'];

    $_SESSION['name'] = $name;

    //error alert

    $_SESSION['ERRORS'] = $errors;

    //addmin page
    $addmin = 'addminpimthr33only';
    
    if($name == $addmin){
        $error=1;
        header('location: log_in.php');
    }
    elseif(mb_strlen($_POST['username'])<5){
        array_push($errors,'ชื่อของคุณต้องมีความยาวอย่างน้อย 5 ตัวอักษร'); 
        $_SESSION['ERRORS'] = 'ชื่อของคุณต้องมีความยาวอย่างน้อย 5 ตัวอักษร';
        $error=1;
        header("location: login.php");
    }
    elseif(mb_strlen($_POST['username'])>12){
        array_push($errors,'ชื่อของคุณต้องมีความยาวเพียง 12 ตัวอักษร'); 
        $_SESSION['ERRORS'] = 'ชื่อของคุณต้องมีความยาวเพียง 12 ตัวอักษร';
        $error=1;
        header("location: login.php");
    }

    
    $user_check = "SELECT * FROM users WHERE username = '$name'";
    $query = mysqli_query($conn, $user_check);
    $result = mysqli_fetch_assoc($query);

    if($result){
        if($result['username'] === $name){
            array_push($errors,'มีชื่อนี้ในระบบแล้ว');
            $_SESSION['ERRORS'] = 'มีชื่อนี้ในระบบแล้ว';
            $error = 1;
            header('location: login.php');
        }
    }

    // no error
    
    if($error==0){
        $insert = "INSERT into users(username) VALUES('$name')";
        $insert_run = mysqli_query($conn, $insert);
        header('location: index.php');
   
        $sql = "SELECT * FROM users WHERE username = '$name'";
        $name_join = mysqli_query($conn, $sql);
        if(mysqli_num_rows($name_join)>0){
            $row = mysqli_fetch_assoc($name_join);
            $_SESSION['joiner'] = $row['username'];
            setcookie('joiner', $row['username'], time()+60*60*24*30);
        
        }
        
    }

}

 $conn->close();

 ?>


<!DOCTYPE html>
<html lang="eng">
    <head>
        <title> PIMY 3 </title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" type="x-icon" href="kaprikorn.png">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
        <script type="text/javascript">
            function preventBack(){window.history.forward()};
            setTimeout("preventBack()", 0);
               window.onunload=function(){null;}
        </script>
        <style>
            @font-face{
                font-family: Mustica;
                src: url(font/MusticaPro-SemiBold.otf);
                /***font title***/
            }
            @font-face{
                 font-family: Dinomilk;
                 src: url(font/Dinomik.otf);
            }

            @font-face{
                 font-family: Mitn;
                 src: url(font/MiTNThin.ttf);
            }

            @font-face{
                 font-family: Kanit;
                 src: url(font/Kanit-SemiBold.ttf);
            }

            @font-face{
                 font-family: Subject;
                 src: url(font/FC\ Subject\ [Non-commercial\ use]\ Regular\ ver\ 1.00.otf);
            }


            *{
                 padding: 0;
                 margin: 0;
                 box-sizing: border-box;
            }

            body{
                 background: url("background.png");
                 background-size: cover;
                 background-position: center;
                 background-repeat: none;
                 background-attachment: fixed;
                 width: 100%;
                 height: 100%;
             }

/*****************************************home*****************************************/

            .home{
                margin: 0;
                padding-top: 10%;
                position: relative;
                justify-content: center;
                box-sizing: border-box;
            }

            .contrainer{
                box-sizing: border-box;
                display: grid;
                grid-template-rows: 0fr 0fr;
                 box-sizing: border-box;
                 text-align: center;
                 justify-items: center;
                 position: relative;
            }

            /************* logo web **************/

            .logo{
                display: grid;
                grid-template-rows: 0fr 0fr;
                position: relative;
            }

            .head{
                display: grid;
                grid-template-columns: 0fr 0fr 0fr;
                column-gap: 1rem;
                text-align: center;
                justify-content: center;
               
            }

            .head p{
                font-family: Subject;
                 font-size: 8rem;
                 color: white;
            }

            .head img{
                position: relative;
                width: 105px; height:100px;
                top: 0.5rem;
            }
            .logo h1{
                position: relative;
                 font-family: Mustica;
                 font-size: 2rem;
                 top: -0.5rem;
                 color: white;
                 margin-bottom:3rem;
            }

            /************* form login ***************/

            form{
                 display: grid;
                 grid-template-rows: 0fr 0fr 0fr;
                 row-gap: 1rem;
                 position: relative;
                 text-align: center;
                 align-items: center;
                 justify-items: center;
                 box-sizing: border-box;
            }

            .input{
                position: relative;
            }
            .username{                 
                 font-size: 2rem;
                 font-family: Dinomilk, Mitn;
                 padding-top: 0.5rem;
                 padding-bottom: 0.51rem;
                 box-sizing: border-box;
                 border-radius: 3rem;
                 border: none;
                 padding-left: 5.5rem;
                 padding-right: 2rem;  
                 color: #23024D; 
                 width: 40rem;  
                 position: relative; 
            }

            .username:focus{
                 background-color: #EEE2FD;
                 outline-style: none;
                 box-shadow:0 0 10px 0 #997EBC;
                 color: #997EBC;
            }

            .icon{
                 box-sizing: border-box;
                 position: absolute;
                 color: #23024D;
                 font-size: 2.5rem;
                 margin-left: 1.6rem;
                 top: 0.5rem;
                 cursor: none;
                 z-index: 1;
            }

            .btn{
                 font-family: Mustica;
                 position: relative;
                 font-size: 2rem;
                 padding: 0.3rem;
                 border-radius: 1.5rem;
                 border: none;
                 width: 6rem;
                 cursor: pointer;
                 top: 1.5rem;
                 box-sizing: border-box;
                 
            }

            .btn:hover{
                 background-color: #997EBC;
                 box-shadow: 0 0 20px 0 #997EBC;
                 color:white;
                 transition: 1s ease;
            }

            .error{
                position: relative;
                font-family: Kanit;
                 font-size: 1.6rem;
                 color: #E7417A; 
                 top: 0.25rem;
            }

            .error-show{
                 background-color: #F7F749;
                 opacity: 80%;
                 border-radius: 2rem;
                 width:35rem;
                 height: 3rem;
                 position: relative;
                 text-align: center;
                justify-content: center;

            }

            /********************* responsive *******************************/
            @media screen and (min-width:210px) and (max-width: 250px){

                .head{
                column-gap: 0.5rem;
            }
                
                .home{
                padding: 0rem;
                padding-top: 25%;
            }

            .contrainer{
                 padding: 0rem;
            }
                .head p{
                font-size: 2.5rem;
                }
                .head img{
                width: 35px; height:30px;
                top: 0.15rem
                }
                .logo h1{
                 font-size:0.6rem;
                 top: -0.1rem;
                 margin-bottom:1.5rem;
                }
                .username{                 
                 font-size: 0.7rem;
                 width: 13rem;  
                 padding-left: 2rem;
                }
                .username:hover{                 
                 background-color: #CEC2FC;
                }
                .icon{
                 font-size: 0.8rem;
                 margin-left: 0.7rem;
                 top: 0.55rem;
                }
                .btn{
                     font-size: 0.8rem;
                     padding: 0.2rem;
                     border-radius: 5rem;
                     width:2rem;
                     top: 0.2rem;
                }
                .error{
                    position: relative;
                     font-size: 0.5rem;
                     color: #E7417A; 
                     top: 0.2rem;
                }
                .error-show{
                    position: relative;
                     top: -0.5rem;
                     border-radius: 5rem;
                     width: 11rem;
                     height: 1.3rem;
                } 
            }

            @media screen and (min-width:260px) and (max-width: 300px){

                .head{
                     column-gap: 0.5rem;
                }

                .home{
                     padding: 0rem;
                     padding-top: 12rem;
                }

                .contrainer{
                    padding: 0rem;
                }
                .head p{
                    font-size: 3.5rem;
                }
                .head img{
                    width: 55px; height:50px;
                    top: 0.15rem
                }
                .logo h1{
                    font-size:1rem;
                    top: -0.1rem;
                    margin-bottom:1.5rem;
                }
                .username{                 
                    font-size: 1rem;
                    width: 16rem;  
                    padding-left: 3rem;
                }
                .username:hover{                 
                    background-color: #CEC2FC;
                }
                .icon{
                    font-size: 1.2rem;
                    margin-left: 1rem;
                    top: 0.55rem;
                }
                .btn{
                    font-size: 1rem;
                    padding: 0.5rem;
                    border-radius: 5rem;
                    width:3rem;
                    top: 1.4rem;
                }
                .error{
                    position: relative;
                    font-size: 0.7rem;
                    color: #E7417A; 
                    top: 0.2rem;
                }
                .error-show{
                    position: relative;
                    top: -0.2rem;
                    border-radius: 5rem;
                    width: 15rem;
                    height: 1.5rem;
                } 
            }

@media screen and (min-width:310px) and (max-width: 340px){
.head{
     column-gap: 0.5rem;
}

.home{
     padding: 0rem;
     padding-top: 35%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 3.5rem;
}
.head img{
    width: 55px; height:50px;
    top: 0.15rem
}
.logo h1{
    font-size:1rem;
    top: -0.1rem;
    margin-bottom:1.5rem;
}
.username{                 
    font-size: 1rem;
    width: 18rem;  
    padding-left: 3rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 1.2rem;
    margin-left: 1rem;
    top: 0.55rem;
}
.btn{
    font-size: 1rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:3rem;
    top: 1rem;
}
.error{
    position: relative;
    font-size: 0.8rem;
    color: #E7417A; 
    top: 0.2rem;
}
.error-show{
    position: relative;
    top: -0.4rem;
    border-radius: 5rem;
    width: 17rem;
    height: 1.5rem;
} 
}

@media screen and (min-width:341px) and (max-width: 370px){
.head{
     column-gap: 0.5rem;
}

.home{
     padding: 0rem;
     padding-top: 50%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 4.5rem;
}
.head img{
    width: 65px; height:60px;
    top: 0.15rem
}
.logo h1{
    font-size:1.2rem;
    top: -0.1rem;
    margin-bottom:1.5rem;
}
.username{                 
    font-size: 1.2rem;
    width: 20rem;  
    padding-left: 3.15rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 1.5rem;
    margin-left: 1rem;
    top: 0.5rem;
}
.btn{
    font-size: 1.2rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:4rem;
    top: 1rem;
}
.error{
    position: relative;
    font-size: 0.8rem;
    color: #E7417A; 
    top: 0.2rem;
}
.error-show{
    position: relative;
    top: -0.4rem;
    border-radius: 5rem;
    width: 18rem;
    height: 1.5rem;
} 
}



@media screen and (min-width:371px) and (max-width: 389px){
.head{
     column-gap: 0.5rem;
}

.home{
     padding: 0rem;
     padding-top: 48%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 5rem;
}
.head img{
    width: 70px; height:65px;
    top: 0.15rem
}
.logo h1{
    font-size:1.5rem;
    top: -0.3rem;
    margin-bottom:1.5rem;
}
.username{                 
    font-size: 1.4rem;
    width: 22rem;  
    padding-left: 3.2rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 1.7rem;
    margin-left: 1rem;
    top: 0.6rem;
}
.btn{
    font-size: 1.4rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:4rem;
    top: 1rem;
}
.error{
    position: relative;
    font-size: 1rem;
    color: #E7417A; 
    top: 0.2rem;
}
.error-show{
    position: relative;
    top: -0.2rem;
    border-radius: 5rem;
    width: 21rem;
    height: 1.9rem;
} 
}

@media screen and (min-width:390px) and (max-width: 420px){
.head{
     column-gap: 0.5rem;
}

.home{
     padding: 0rem;
     padding-top: 48%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 5.8rem;
}
.head img{
    width: 75px; height:70px;
    top: 0.2rem
}
.logo h1{
    font-size:1.5rem;
    top: -0.4rem;
    margin-bottom:1.5rem;
}
.username{                 
    font-size: 1.4rem;
    width: 23rem;  
    padding-left: 3.2rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 1.7rem;
    margin-left: 1rem;
    top: 0.6rem;
}
.btn{
    font-size: 1.5rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:4rem;
    top: 1rem;
}
.error{
    position: relative;
    font-size: 1.1rem;
    color: #E7417A; 
    top: 0.19rem;
}
.error-show{
    position: relative;
    top: -0.2rem;
    border-radius: 5rem;
    width: 22.5rem;
    height: 1.9rem;
} 
}

@media screen and (min-width:480px) and (max-width: 540px){
.head{
     column-gap: 0.5rem;
}

.home{
     padding: 0rem;
     padding-top: 38%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 6rem;
}
.head img{
    width: 75px; height:70px;
    top: 0.2rem
}
.logo h1{
    font-size:1.5rem;
    top: -0.4rem;
    margin-bottom:1.5rem;
}
.username{                 
    font-size: 1.5rem;
    width: 26rem;  
    padding-left: 3.3rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 1.7rem;
    margin-left: 1rem;
    top: 0.6rem;
}
.btn{
    font-size: 1.7rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:4.2rem;
    top: 1rem;
}
.error{
    position: relative;
    font-size: 1.2rem;
    color: #E7417A; 
    top: 0.25rem;
}
.error-show{
    position: relative;
    top: -0.2rem;
    border-radius: 5rem;
    width: 25rem;
    height: 2.3rem;
} 
}

@media screen and (min-width:600px) and (max-width: 660px){
.head{
     column-gap: 0.5rem;
}

.home{
     padding: 0rem;
     padding-top: 42%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 7rem;
}
.head img{
    width: 85px; height:80px;
    top: 0.2rem
}
.logo h1{
    font-size:1.8rem;
    top: -0.4rem;
    margin-bottom:2rem;
}
.username{                 
    font-size: 1.8rem;
    width: 32rem;  
    padding-left: 3.5rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 1.9rem;
    margin-left: 1rem;
    top: 0.75rem;
}
.btn{
    font-size: 2rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:5rem;
    top: 1.7rem;
}
.error{
    position: relative;
    font-size: 1.4rem;
    color: #E7417A; 
    top: 0.25rem;
}
.error-show{
    position: relative;
    top: 0.1rem;
    border-radius: 5rem;
    width: 30rem;
    height: 2.5rem;
} 
}

@media screen and (min-width:600px) and (max-width: 660px) and (min-height: 300px) and (max-height: 400px){
.head{
     column-gap: 0.5rem;
}

.home{
     padding: 0rem;
     padding-top: 3.5%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 5rem;
}
.head img{
    width: 65px; height:60px;
    top: 0.2rem
}
.logo h1{
    font-size:1.2rem;
    top: -0.4rem;
    margin-bottom:1.4rem;
}
.username{                 
    font-size: 1.5rem;
    width: 32rem;  
    padding-left: 3.5rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 1.9rem;
    margin-left: 1rem;
    top: 0.5rem;
}
.btn{
    font-size: 1.5rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:5rem;
    top: 1rem;
}
.error{
    position: relative;
    font-size: 1rem;
    color: #E7417A; 
    top: 0.25rem;
}
.error-show{
    position: relative;
    top: 0.1rem;
    border-radius: 5rem;
    width: 25rem;
    height: 2rem;
} 
}

@media screen and (min-width:710px) and (max-width: 770px){
.head{
     column-gap: 0.8rem;
}

.home{
     padding: 0rem;
     padding-top: 35%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 9rem;
}
.head img{
    width: 105px; height:100px;
    top: 0.7rem
}
.logo h1{
    font-size:2rem;
    top: -0.6rem;
    margin-bottom:2.5rem;
}
.username{                 
    font-size: 2.2rem;
    width:40rem;  
    padding-left: 4rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 2.3rem;
    margin-left: 1rem;
    top: 0.8rem;
}
.btn{
    font-size: 2.2rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:6rem;
    top: 2.5rem;
}
.error{
    position: relative;
    font-size: 1.8rem;
    color: #E7417A; 
    top: 0.28rem;
}
.error-show{
    position: relative;
    top: 0.3rem;
    border-radius: 5rem;
    width: 38rem;
    height: 3.3rem;
} 
}

@media screen and (min-width:800px) and (max-width: 850px){
.head{
     column-gap: 0.8rem;
}

.home{
     padding: 0rem;
     padding-top: 36%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 11rem;
}
.head img{
    width: 120px; height:115px;
    top: 1.2rem
}
.logo h1{
    font-size:2.5rem;
    top: -1rem;
    margin-bottom:3.5rem;
}
.username{                 
    font-size: 2.5rem;
    width:45rem;  
    padding-left: 4.5rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 2.3rem;
    margin-left: 1.3rem;
    top: 1rem;
}
.btn{
    font-size: 2.5rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:7rem;
    top: 3.5rem;
}
.error{
    position: relative;
    font-size: 2rem;
    color: #E7417A; 
    top: 0.28rem;
}
.error-show{
    position: relative;
    top: 0.5rem;
    border-radius: 5rem;
    width: 42rem;
    height: 3.6rem;
} 
}

@media screen and (min-width:900px) and (max-width: 960px){
.head{
     column-gap: 1rem;
}

.home{
     padding: 0rem;
     padding-top: 34%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 13rem;
}
.head img{
    width: 130px; height:125px;
    top: 1.8rem
}
.logo h1{
    font-size:3rem;
    top: -1rem;
    margin-bottom:4rem;
}
.username{                 
    font-size: 2.8rem;
    width:50rem;  
    padding-left: 5rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 2.5rem;
    margin-left:1.5rem;
    top: 1.1rem;
}
.btn{
    font-size: 3rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:8rem;
    top: 5rem;
}
.error{
    position: relative;
    font-size: 2.3rem;
    color: #E7417A; 
    top: 0.28rem;
}
.error-show{
    position: relative;
    top: 0.8rem;
    border-radius: 5rem;
    width: 48rem;
    height: 4.2rem;
} 
}

@media screen and (min-width:1020px) and (max-width: 1080px){
.head{
     column-gap: 1rem;
}

.home{
     padding: 0rem;
     padding-top: 40%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 10rem;
}
.head img{
    width: 120px; height:115px;
    top: 0.8rem
}
.logo h1{
    font-size:2.5rem;
    top: -1rem;
    margin-bottom:2.6rem;
}
.username{                 
    font-size: 2.8rem;
    width:58rem;  
    padding-left: 5.5rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 3rem;
    margin-left:1.6rem;
    top: 0.8rem;
}
.btn{
    font-size: 2rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:6rem;
    top: 3rem;
}
.error{
    position: relative;
    font-size:2rem;
    color: #E7417A; 
    top: 0.2rem;
}
.error-show{
    position: relative;
    top: 1rem;
    border-radius: 5rem;
    width: 48rem;
    height: 3.5rem;
} 
}

@media screen and (min-width:1080px) and (max-width: 1100px) and (min-height:2300px) and (max-height:2350px){
.head{
     column-gap: 1.5rem;
}

.home{
     padding: 0rem;
     padding-top: 70%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 15rem;
}
.head img{
    width: 155px; height:150px;
    top:1.7rem
}
.logo h1{
    font-size:3rem;
    top: -1.6rem;
    margin-bottom:5rem;
}
.username{                 
    font-size: 3rem;
    width:58rem;  
    padding-left: 5.5rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 3rem;
    margin-left:1.6rem;
    top: 0.8rem;
}
.btn{
    font-size: 3rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:8rem;
    top: 3rem;
}
.error{
    position: relative;
    font-size:2.5rem;
    color: #E7417A; 
    top: 0.3rem;
}
.error-show{
    position: relative;
    top: 1rem;
    border-radius: 5rem;
    width: 53rem;
    height: 4.5rem;
} 
}

@media screen and (min-width:1020px) and (max-width: 1080px) and (min-height: 600px) and (max-height: 1000px){
.head{
     column-gap: 1rem;
}

.home{
     padding: 0rem;
     padding-top: 3%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 10rem;
}
.head img{
    width: 120px; height:115px;
    top: 0.8rem
}
.logo h1{
    font-size:2.5rem;
    top: -1rem;
    margin-bottom:2.6rem;
}
.username{                 
    font-size: 2.8rem;
    width:58rem;  
    padding-left: 5.5rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 3rem;
    margin-left:1.6rem;
    top: 0.8rem;
}
.btn{
    font-size: 2rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:6rem;
    top: 3rem;
}
.error{
    position: relative;
    font-size:2rem;
    color: #E7417A; 
    top: 0.2rem;
}
.error-show{
    position: relative;
    top: 1rem;
    border-radius: 5rem;
    width: 48rem;
    height: 3.5rem;
} 
}

@media screen and (min-width:1230px) and (max-width: 1280px) and (min-height:800px){
.head{
     column-gap: 1.5rem;
}

.home{
     padding: 0rem;
     padding-top: 5%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 12rem;
}
.head img{
    width: 150px; height:145px;
    top: 2.5rem
}
.logo h1{
    font-size:3rem;
    top: -1rem;
    margin-bottom:4rem;
}
.username{                 
    font-size: 3.5rem;
    width:70rem;  
    padding-left: 6rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 3.5rem;
    margin-left:1.6rem;
    top: 1rem;
}
.btn{
    font-size: 3rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:9rem;
    top: 5rem;
}
.error{
    position: relative;
    font-size:2.5rem;
    color: #E7417A; 
    top: 0.35rem;
}
.error-show{
    position: relative;
    top: 1rem;
    border-radius: 5rem;
    width: 60rem;
    height: 4.5rem;
} 
}



@media screen and (min-width:1900px) and (min-height: 1080px) {
.head{
     column-gap: 1.5rem;
}

.home{
     padding: 0rem;
     padding-top: 5%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 16rem;
}
.head img{
    width: 180px; height:175px;
    top: 1.6rem
}
.logo h1{
    font-size:4rem;
    top: -1rem;
    margin-bottom:4rem;
}
.username{                 
    font-size: 5rem;
    width:95rem;  
    padding-left: 8.5rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 5rem;
    margin-left:2rem;
    top: 1.2rem;
}
.btn{
    font-size: 4rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:11rem;
    top: 5rem;
}
.error{
    position: relative;
    font-size:3.8rem;
    color: #E7417A; 
    top: 0.6rem;
}
.error-show{
    position: relative;
    top: 1.5rem;
    border-radius: 5rem;
    width: 80rem;
    height: 7rem;
} 
}

@media screen and (min-width:1440px) and (max-width:1900px) and (min-height: 900px){
.head{
     column-gap: 1.5rem;
}

.home{
     padding: 0rem;
     padding-top: 5%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 14rem;
}
.head img{
    width: 165px; height:160px;
    top: 1rem
}
.logo h1{
    font-size:3rem;
    top: -1rem;
    margin-bottom:4rem;
}
.username{                 
    font-size: 3rem;
    width:80rem;  
    padding-left: 7rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 3em;
    margin-left:1.8rem;
    top: 1rem;
}
.btn{
    font-size: 3rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:8rem;
    top: 5.5rem;
}
.error{
    position: relative;
    font-size:2.8rem;
    color: #E7417A; 
    top: 0.28rem;
}
.error-show{
    position: relative;
    top: 1rem;
    border-radius: 5rem;
    width: 65rem;
    height: 4.8rem;
} 
}

/*********************************************************/
@media screen and (min-width:300px) and (max-width:320px) and (min-height:220px) and (max-height:250px) {

.head{
column-gap: 0.5rem;
}

.home{
padding: 0rem;
padding-top: 8%;
}

.contrainer{
 padding: 0rem;
}
.head p{
font-size: 2.5rem;
}
.head img{
width: 35px; height:30px;
top: 0.15rem
}
.logo h1{
 font-size:0.6rem;
 top: -0.1rem;
 margin-bottom:1.5rem;
}
.username{                 
 font-size: 0.7rem;
 width: 13rem;  
 padding-left: 2rem;
}
.username:hover{                 
 background-color: #CEC2FC;
}
.icon{
 font-size: 0.8rem;
 margin-left: 0.7rem;
 top: 0.55rem;
}
.btn{
     font-size: 0.8rem;
     padding: 0.2rem;
     border-radius: 5rem;
     width:2rem;
     top: 0.2rem;
}
.error{
    position: relative;
     font-size: 0.5rem;
     color: #E7417A; 
     top: 0.2rem;
}
.error-show{
    position: relative;
     top: -0.5rem;
     border-radius: 5rem;
     width: 11rem;
     height: 1.3rem;
} 
}

@media screen and (max-height:280px) and (min-width: 600px) and (max-width: 660px){

.head{
     column-gap: 0.5rem;
}

.home{
     padding: 0rem;
     padding-top: 3%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 3.5rem;
}
.head img{
    width: 55px; height:50px;
    top: 0.15rem
}
.logo h1{
    font-size:1rem;
    top: -0.1rem;
    margin-bottom:1.5rem;
}
.username{                 
    font-size: 1rem;
    width: 16rem;  
    padding-left: 3rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 1.2rem;
    margin-left: 1rem;
    top: 0.55rem;
}
.btn{
    font-size: 1rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:3rem;
    top: 0.4rem;
}
.error{
    position: relative;
    font-size: 0.7rem;
    color: #E7417A; 
    top: 0.2rem;
}
.error-show{
    position: relative;
    top: -0.2rem;
    border-radius: 5rem;
    width: 15rem;
    height: 1.5rem;
} 
}

@media screen and (min-width:650px) and (max-width: 680px) and (min-height: 300px)  and (max-height: 320px){
.head{
     column-gap: 0.5rem;
}

.home{
     padding: 0rem;
     padding-top: 3%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 3.5rem;
}
.head img{
    width: 55px; height:50px;
    top: 0.15rem
}
.logo h1{
    font-size:1rem;
    top: -0.1rem;
    margin-bottom:1.5rem;
}
.username{                 
    font-size: 1rem;
    width: 18rem;  
    padding-left: 3rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 1.2rem;
    margin-left: 1rem;
    top: 0.55rem;
}
.btn{
    font-size: 1rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:3rem;
    top: 1rem;
}
.error{
    position: relative;
    font-size: 0.8rem;
    color: #E7417A; 
    top: 0.2rem;
}
.error-show{
    position: relative;
    top: -0.4rem;
    border-radius: 5rem;
    width: 17rem;
    height: 1.5rem;
} 
}

@media screen and (min-width:690px) and (min-height: 300px)  and (max-height: 320px){
.head{
     column-gap: 0.5rem;
}

.home{
     padding: 0rem;
     padding-top: 3%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 3.5rem;
}
.head img{
    width: 55px; height:50px;
    top: 0.15rem
}
.logo h1{
    font-size:1rem;
    top: -0.1rem;
    margin-bottom:1.5rem;
}
.username{                 
    font-size: 1rem;
    width: 18rem;  
    padding-left: 3rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 1.2rem;
    margin-left: 1rem;
    top: 0.55rem;
}
.btn{
    font-size: 1rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:3rem;
    top: 1rem;
}
.error{
    position: relative;
    font-size: 0.8rem;
    color: #E7417A; 
    top: 0.2rem;
}
.error-show{
    position: relative;
    top: -0.4rem;
    border-radius: 5rem;
    width: 17rem;
    height: 1.5rem;
} 
}

@media screen and (min-width:550px) and (max-width: 570px) and (min-height: 300px)  and (max-height: 320px){
.head{
     column-gap: 0.5rem;
}

.home{
     padding: 0rem;
     padding-top: 5%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 3.5rem;
}
.head img{
    width: 55px; height:50px;
    top: 0.15rem
}
.logo h1{
    font-size:1rem;
    top: -0.1rem;
    margin-bottom:1.5rem;
}
.username{                 
    font-size: 1rem;
    width: 18rem;  
    padding-left: 3rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 1.2rem;
    margin-left: 1rem;
    top: 0.55rem;
}
.btn{
    font-size: 1rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:3rem;
    top: 1rem;
}
.error{
    position: relative;
    font-size: 0.8rem;
    color: #E7417A; 
    top: 0.2rem;
}
.error-show{
    position: relative;
    top: -0.4rem;
    border-radius: 5rem;
    width: 17rem;
    height: 1.5rem;
} 
}

@media screen and (min-width:500px) and (max-width: 540px) and (max-height: 320px){
.head{
     column-gap: 0.5rem;
}

.home{
     padding: 0rem;
     padding-top: 6%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 3.5rem;
}
.head img{
    width: 55px; height:50px;
    top: 0.15rem
}
.logo h1{
    font-size:1rem;
    top: -0.1rem;
    margin-bottom:1.5rem;
}
.username{                 
    font-size: 1rem;
    width: 18rem;  
    padding-left: 3rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 1.2rem;
    margin-left: 1rem;
    top: 0.55rem;
}
.btn{
    font-size: 1rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:3rem;
    top: 1rem;
}
.error{
    position: relative;
    font-size: 0.8rem;
    color: #E7417A; 
    top: 0.2rem;
}
.error-show{
    position: relative;
    top: -0.4rem;
    border-radius: 5rem;
    width: 17rem;
    height: 1.5rem;
} 
}

@media screen and (min-width:450px) and (max-width: 490px) and (min-height: 300px)  and (max-height: 320px){
.head{
     column-gap: 0.5rem;
}

.home{
     padding: 0rem;
     padding-top: 6%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 3.5rem;
}
.head img{
    width: 55px; height:50px;
    top: 0.15rem
}
.logo h1{
    font-size:1rem;
    top: -0.1rem;
    margin-bottom:1.5rem;
}
.username{                 
    font-size: 1rem;
    width: 18rem;  
    padding-left: 3rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 1.2rem;
    margin-left: 1rem;
    top: 0.55rem;
}
.btn{
    font-size: 1rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:3rem;
    top: 1rem;
}
.error{
    position: relative;
    font-size: 0.8rem;
    color: #E7417A; 
    top: 0.2rem;
}
.error-show{
    position: relative;
    top: -0.4rem;
    border-radius: 5rem;
    width: 17rem;
    height: 1.5rem;
} 
}

@media screen and (min-width:790px) and (max-width:830px) and (min-height: 340px) and (max-height: 370px){
.head{
     column-gap: 0.5rem;
}

.home{
     padding: 0rem;
     padding-top: 5%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 4.5rem;
}
.head img{
    width: 65px; height:60px;
    top: 0.15rem
}
.logo h1{
    font-size:1.2rem;
    top: -0.1rem;
    margin-bottom:1.5rem;
}
.username{                 
    font-size: 1.2rem;
    width: 20rem;  
    padding-left: 3.15rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 1.5rem;
    margin-left: 1rem;
    top: 0.5rem;
}
.btn{
    font-size: 1.2rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:4rem;
    top: 1rem;
}
.error{
    position: relative;
    font-size: 0.8rem;
    color: #E7417A; 
    top: 0.2rem;
}
.error-show{
    position: relative;
    top: -0.4rem;
    border-radius: 5rem;
    width: 18rem;
    height: 1.5rem;
} 
}

@media screen and (min-width:831px) and (max-width:900px) and (min-height: 340px) and (max-height: 370px){
.head{
     column-gap: 0.5rem;
}

.home{
     padding: 0rem;
     padding-top: 5%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 4.5rem;
}
.head img{
    width: 65px; height:60px;
    top: 0.15rem
}
.logo h1{
    font-size:1.2rem;
    top: -0.1rem;
    margin-bottom:1.5rem;
}
.username{                 
    font-size: 1.2rem;
    width: 20rem;  
    padding-left: 3.15rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 1.5rem;
    margin-left: 1rem;
    top: 0.5rem;
}
.btn{
    font-size: 1.2rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:4rem;
    top: 1rem;
}
.error{
    position: relative;
    font-size: 0.8rem;
    color: #E7417A; 
    top: 0.2rem;
}
.error-show{
    position: relative;
    top: -0.4rem;
    border-radius: 5rem;
    width: 18rem;
    height: 1.5rem;
} 
}

@media screen and (min-width:700px) and (max-width:780px) and (min-height: 340px) and (max-height: 370px){
.head{
     column-gap: 0.5rem;
}

.home{
     padding: 0rem;
     padding-top: 5%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 4.5rem;
}
.head img{
    width: 65px; height:60px;
    top: 0.15rem
}
.logo h1{
    font-size:1.2rem;
    top: -0.1rem;
    margin-bottom:1.5rem;
}
.username{                 
    font-size: 1.2rem;
    width: 20rem;  
    padding-left: 3.15rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 1.5rem;
    margin-left: 1rem;
    top: 0.5rem;
}
.btn{
    font-size: 1.2rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:4rem;
    top: 1rem;
}
.error{
    position: relative;
    font-size: 0.8rem;
    color: #E7417A; 
    top: 0.2rem;
}
.error-show{
    position: relative;
    top: -0.4rem;
    border-radius: 5rem;
    width: 18rem;
    height: 1.5rem;
} 
}

@media screen and (min-width:700px) and (max-width:780px) and (min-height: 340px) and (max-height: 370px){
.head{
     column-gap: 0.5rem;
}

.home{
     padding: 0rem;
     padding-top: 5%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 4.5rem;
}
.head img{
    width: 65px; height:60px;
    top: 0.15rem
}
.logo h1{
    font-size:1.2rem;
    top: -0.1rem;
    margin-bottom:1.5rem;
}
.username{                 
    font-size: 1.2rem;
    width: 20rem;  
    padding-left: 3.15rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 1.5rem;
    margin-left: 1rem;
    top: 0.5rem;
}
.btn{
    font-size: 1.2rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:4rem;
    top: 1rem;
}
.error{
    position: relative;
    font-size: 0.8rem;
    color: #E7417A; 
    top: 0.2rem;
}
.error-show{
    position: relative;
    top: -0.4rem;
    border-radius: 5rem;
    width: 18rem;
    height: 1.5rem;
} 
}

@media screen and (min-width:600px) and (max-width:699px) and (min-height: 340px) and (max-height: 370px){
.head{
     column-gap: 0.5rem;
}

.home{
     padding: 0rem;
     padding-top: 5%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 4.5rem;
}
.head img{
    width: 65px; height:60px;
    top: 0.15rem
}
.logo h1{
    font-size:1.2rem;
    top: -0.1rem;
    margin-bottom:1.5rem;
}
.username{                 
    font-size: 1.2rem;
    width: 20rem;  
    padding-left: 3.15rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 1.5rem;
    margin-left: 1rem;
    top: 0.5rem;
}
.btn{
    font-size: 1.2rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:4rem;
    top: 1rem;
}
.error{
    position: relative;
    font-size: 0.8rem;
    color: #E7417A; 
    top: 0.2rem;
}
.error-show{
    position: relative;
    top: -0.4rem;
    border-radius: 5rem;
    width: 18rem;
    height: 1.5rem;
} 
}

@media screen and (min-width:500px) and (max-width:599px) and (min-height: 340px) and (max-height: 370px){
.head{
     column-gap: 0.5rem;
}

.home{
     padding: 0rem;
     padding-top: 3%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 4.5rem;
}
.head img{
    width: 65px; height:60px;
    top: 0.15rem
}
.logo h1{
    font-size:1.2rem;
    top: -0.1rem;
    margin-bottom:1.5rem;
}
.username{                 
    font-size: 1.2rem;
    width: 20rem;  
    padding-left: 3.15rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 1.5rem;
    margin-left: 1rem;
    top: 0.5rem;
}
.btn{
    font-size: 1.2rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:4rem;
    top: 1rem;
}
.error{
    position: relative;
    font-size: 0.8rem;
    color: #E7417A; 
    top: 0.2rem;
}
.error-show{
    position: relative;
    top: -0.4rem;
    border-radius: 5rem;
    width: 18rem;
    height: 1.5rem;
} 
}

@media screen and (min-height:371px) and (max-height: 390px) {
.head{
     column-gap: 0.5rem;
}

.home{
     padding: 0rem;
     padding-top: 4%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 5rem;
}
.head img{
    width: 70px; height:65px;
    top: 0.15rem
}
.logo h1{
    font-size:1.5rem;
    top: -0.3rem;
    margin-bottom:1.5rem;
}
.username{                 
    font-size: 1.4rem;
    width: 22rem;  
    padding-left: 3.2rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 1.7rem;
    margin-left: 1rem;
    top: 0.6rem;
}
.btn{
    font-size: 1.4rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:4rem;
    top: 1rem;
}
.error{
    position: relative;
    font-size: 1rem;
    color: #E7417A; 
    top: 0.2rem;
}
.error-show{
    position: relative;
    top: -0.2rem;
    border-radius: 5rem;
    width: 21rem;
    height: 1.9rem;
} 
}

@media screen and (min-height:371px) and (max-height: 390px) and (min-width:600px){
.head{
     column-gap: 0.5rem;
}

.home{
     padding: 0rem;
     padding-top:3%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 5rem;
}
.head img{
    width: 70px; height:65px;
    top: 0.15rem
}
.logo h1{
    font-size:1.5rem;
    top: -0.3rem;
    margin-bottom:1.5rem;
}
.username{                 
    font-size: 1.4rem;
    width: 22rem;  
    padding-left: 3.2rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 1.7rem;
    margin-left: 1rem;
    top: 0.6rem;
}
.btn{
    font-size: 1.4rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:4rem;
    top: 1rem;
}
.error{
    position: relative;
    font-size: 1rem;
    color: #E7417A; 
    top: 0.2rem;
}
.error-show{
    position: relative;
    top: -0.2rem;
    border-radius: 5rem;
    width: 21rem;
    height: 1.9rem;
} 
}

@media screen and (min-height:390px) and (max-height: 420px){
.head{
     column-gap: 0.5rem;
}

.home{
     padding: 0rem;
     padding-top: 4%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 5.8rem;
}
.head img{
    width: 75px; height:70px;
    top: 0.2rem
}
.logo h1{
    font-size:1.5rem;
    top: -0.4rem;
    margin-bottom:1.5rem;
}
.username{                 
    font-size: 1.4rem;
    width: 23rem;  
    padding-left: 3.2rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 1.7rem;
    margin-left: 1rem;
    top: 0.6rem;
}
.btn{
    font-size: 1.5rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:4rem;
    top: 1rem;
}
.error{
    position: relative;
    font-size: 1.1rem;
    color: #E7417A; 
    top: 0.19rem;
}
.error-show{
    position: relative;
    top: -0.2rem;
    border-radius: 5rem;
    width: 22.5rem;
    height: 1.9rem;
} 
}

@media screen and (min-width:720px) and (max-width: 860px) and (min-height:480px) and (max-height: 540px){
.head{
     column-gap: 0.5rem;
}

.home{
     padding: 0rem;
     padding-top: 8%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 6rem;
}
.head img{
    width: 75px; height:70px;
    top: 0.2rem
}
.logo h1{
    font-size:1.5rem;
    top: -0.4rem;
    margin-bottom:1.5rem;
}
.username{                 
    font-size: 1.5rem;
    width: 26rem;  
    padding-left: 3.3rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 1.7rem;
    margin-left: 1rem;
    top: 0.6rem;
}
.btn{
    font-size: 1.7rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:4.2rem;
    top: 1rem;
}
.error{
    position: relative;
    font-size: 1.2rem;
    color: #E7417A; 
    top: 0.25rem;
}
.error-show{
    position: relative;
    top: -0.2rem;
    border-radius: 5rem;
    width: 25rem;
    height: 2.3rem;
} 
}

@media screen and (min-width:700px) and (max-width:720px) and (max-height: 540px){
.head{
     column-gap: 0.5rem;
}

.home{
     padding: 0rem;
     padding-top: 12%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 6rem;
}
.head img{
    width: 75px; height:70px;
    top: 0.2rem
}
.logo h1{
    font-size:1.5rem;
    top: -0.4rem;
    margin-bottom:1.5rem;
}
.username{                 
    font-size: 1.5rem;
    width: 26rem;  
    padding-left: 3.3rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 1.7rem;
    margin-left: 1rem;
    top: 0.6rem;
}
.btn{
    font-size: 1.7rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:4.2rem;
    top: 1rem;
}
.error{
    position: relative;
    font-size: 1.2rem;
    color: #E7417A; 
    top: 0.25rem;
}
.error-show{
    position: relative;
    top: -0.2rem;
    border-radius: 5rem;
    width: 25rem;
    height: 2.3rem;
} 
}

@media screen and (min-height:600px) and (max-height: 660px) and (min-width:900px){
.head{
     column-gap: 0.5rem;
}

.home{
     padding: 0rem;
     padding-top: 11%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 7rem;
}
.head img{
    width: 85px; height:80px;
    top: 0.2rem
}
.logo h1{
    font-size:1.8rem;
    top: -0.4rem;
    margin-bottom:2rem;
}
.username{                 
    font-size: 1.8rem;
    width: 32rem;  
    padding-left: 3.5rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 1.9rem;
    margin-left: 1rem;
    top: 0.75rem;
}
.btn{
    font-size: 2rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:5rem;
    top: 1.7rem;
}
.error{
    position: relative;
    font-size: 1.4rem;
    color: #E7417A; 
    top: 0.25rem;
}
.error-show{
    position: relative;
    top: 0.1rem;
    border-radius: 5rem;
    width: 30rem;
    height: 2.5rem;
} 
}

@media screen and (min-height:710px) and (max-height: 770px) and (min-width:1024px){
.head{
     column-gap: 0.8rem;
}

.home{
     padding: 0rem;
     padding-top: 9.5%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 9rem;
}
.head img{
    width: 105px; height:100px;
    top: 0.7rem
}
.logo h1{
    font-size:2rem;
    top: -0.6rem;
    margin-bottom:2.5rem;
}
.username{                 
    font-size: 2.2rem;
    width:40rem;  
    padding-left: 4rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 2.3rem;
    margin-left: 1rem;
    top: 0.8rem;
}
.btn{
    font-size: 2.2rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:6rem;
    top: 2.5rem;
}
.error{
    position: relative;
    font-size: 1.8rem;
    color: #E7417A; 
    top: 0.28rem;
}
.error-show{
    position: relative;
    top: 0.3rem;
    border-radius: 5rem;
    width: 38rem;
    height: 3.3rem;
} 
}

@media screen and (min-height:800px) and (max-height: 850px) and (min-width:1180px) and (max-width: 1280px){
.head{
     column-gap: 0.8rem;
}

.home{
     padding: 0rem;
     padding-top: 9%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 11rem;
}
.head img{
    width: 120px; height:115px;
    top: 1.2rem
}
.logo h1{
    font-size:2.5rem;
    top: -1rem;
    margin-bottom:3.5rem;
}
.username{                 
    font-size: 2.5rem;
    width:45rem;  
    padding-left: 4.5rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 2.3rem;
    margin-left: 1.3rem;
    top: 1rem;
}
.btn{
    font-size: 2.5rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:7rem;
    top: 3.5rem;
}
.error{
    position: relative;
    font-size: 2rem;
    color: #E7417A; 
    top: 0.28rem;
}
.error-show{
    position: relative;
    top: 0.5rem;
    border-radius: 5rem;
    width: 42rem;
    height: 3.6rem;
} 
}

@media screen and (min-height:900px) and (max-height: 960px) and (min-width:1280px) and (max-width: 1440px){
.head{
     column-gap: 1rem;
}

.home{
     padding: 0rem;
     padding-top: 8%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 13rem;
}
.head img{
    width: 130px; height:125px;
    top: 1.8rem
}
.logo h1{
    font-size:3rem;
    top: -1rem;
    margin-bottom:4rem;
}
.username{                 
    font-size: 2.8rem;
    width:50rem;  
    padding-left: 5rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 2.5rem;
    margin-left:1.5rem;
    top: 1.1rem;
}
.btn{
    font-size: 3rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:8rem;
    top: 5rem;
}
.error{
    position: relative;
    font-size: 2.3rem;
    color: #E7417A; 
    top: 0.28rem;
}
.error-show{
    position: relative;
    top: 0.8rem;
    border-radius: 5rem;
    width: 48rem;
    height: 4.2rem;
} 
}

@media screen and (min-height:1020px) and (max-height: 1080px) and (min-width:1300px) and (max-width: 1370px){
.head{
     column-gap: 1rem;
}

.home{
     padding: 0rem;
     padding-top: 15%;
}

.contrainer{
    padding: 0rem;
}
.head p{
    font-size: 10rem;
}
.head img{
    width: 120px; height:115px;
    top: 0.8rem
}
.logo h1{
    font-size:2.5rem;
    top: -1rem;
    margin-bottom:2.6rem;
}
.username{                 
    font-size: 2.8rem;
    width:58rem;  
    padding-left: 5.5rem;
}
.username:hover{                 
    background-color: #CEC2FC;
}
.icon{
    font-size: 3rem;
    margin-left:1.6rem;
    top: 0.8rem;
}
.btn{
    font-size: 2rem;
    padding: 0.5rem;
    border-radius: 5rem;
    width:6rem;
    top: 3rem;
}
.error{
    position: relative;
    font-size:2rem;
    color: #E7417A; 
    top: 0.2rem;
}
.error-show{
    position: relative;
    top: 1rem;
    border-radius: 5rem;
    width: 48rem;
    height: 3.5rem;
} 
}










                           
        </style>
    </head>
    <body>
        <div class="home">
            <div class="contrainer">
                <div class="logo">
                    <div class="head">
                       <img src="light.png">
                       <p>PIM3</p>
                       <img src="star.png">
                    </div>
                    <h1>WELCOME</h1>
                </div>
                <div class="form">
                    <form  method="post" id="form" class="form" >
                        <div class="input">
                            <div class="icon"><i class='bx bx-search-alt'></i></div>
                            <input name="username" class="username" type="text" placeholder="Who're you? (5-12 ตัวอักษร)" 
                            required oninvalid="this.setCustomValidity('Please tell your name')" oninput="this.setCustomValidity('')">
                        </div>
                        <div class="errors">
                        
                        <?php if(isset($_SESSION['ERRORS'])) : ?>
                        <div class="error-show">
                        <div class="error">
                            <?php 

                               echo $_SESSION['ERRORS']; 

                             ?>
                        </div>
                        <?php endif ?>
                        </div>
                        </div>
                        <button name="submitname" type="submit" class="btn">GO</button>   
                    </form>
                    
                </div>

            </div>

        </div>
    </body>
</html>