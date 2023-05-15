<?php
session_start();
include('server.php');

if (!isset($_COOKIE['joiner'])){
    header("location: login.php");
    die();
}

$_SESSION['joiner'] = $_COOKIE['joiner'];

if (isset($_GET['logout'])){
    session_destroy();
    setcookie('joiner', $_SESSION['joiner'], 60);
    unset($_SESSION['name']);
    header("location: login.php");
}

if (isset($_GET['backhome'])){
    header("location: index.php");
}

// animation show //
$animation = "SELECT * FROM animation WHERE id = '$_GET[AnimationID]'";
$query = mysqli_query($conn, $animation);

// send comments //

if(isset($_POST['sendmsg'])){
    $comments = $_POST['comments'];
    $name = $_SESSION['joiner'];
    $send = "INSERT into commented(nameuser, comment) VALUES('$name', '$comments')";
    $send_query = mysqli_query($conn, $send);
}

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
                font-family: Mitn;
                src: url(font/MiTNThin.ttf);
            }

            @font-face{
                font-family: Mustica;
                src: url(font/MusticaPro-SemiBold.otf);
            }

            @font-face{
            font-family: Kanit;
            src: url(font/Kanit-SemiBold.ttf);
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
            section{
                display: flex;
                flex-direction: row;
                position: fixed;
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 3rem 8rem;
                justify-content: space-between;
            }

            .play{
                position: relative;
                display: grid;
                grid-template-rows: repeat(2, 22rem);
                justify-content: center;
                width: 30rem;
                height: 35rem; 
                margin: 1.5rem 1rem;               
            }

            .play .video{
                position: relative;
                border-radius: 1rem;
                background-color: white;
                width: 28rem;
                height: 20rem;
                pad: 0.5rem;
                padding: 1rem;
            }

            .logo-tv{
                position: relative;
                font-family: Mustica;
                color: #23024D;
                font-size: 2rem;
                width: 10rem;
                left: 37%;
                
            }

            .clip-place{
                position: relative;
                background-color: #6F4B9B;
                width: 26rem;
                height: 16rem;
            }

            .clip-place video{
                object-fit: cover;
                width: 100%; height: 100%;
            }

            .play .chat{
                position: relative;
                border-radius: 1rem;
                background-color: white;
                margin-left: 0.5rem;
                width: 27rem;
                height: 13rem;
                padding: 1rem;
            }
            .chat .typing-1{
                display: grid;
                grid-template-rows: repeat(2, 3.2rem);
                justify-content: center;
                position:relative;
                background-color: #23024D;
                width: 25rem;
                height: 11rem;
            }

            .head-chat p{
                text-align: center;
                position: relative;
                font-family: Mustica;
                color: white;
                font-size: 2rem;
                align-items: center;
            }

            .typing-1 .typing-2{
                display: flex;
                flex-direction: row;
                position:relative;
                background:white;
                width: 22rem;
                height: 7rem;
                border-radius: 2rem;
            }

            .profile{
                position:relative;
                margin: 1rem 1.8rem;
                width: 45px;
                height: 45px;
                border-radius: 5rem;
                background: #23024D;
                justify-content: center;
            }

            .profile img{
                position: relative;
                object-fit: cover;
                width: 100%; height: 100%;
            }

            .nameuser p{

                position: relative;  
                font-size: 1.5rem;
                margin: 0.8rem -0.5rem;
                width: 10rem;
                color: #23024D;
                font-family: Mitn;
                cursor: default;
            }


            .typ-box-1{
                position: absolute;
                top: 4.5rem;
                left: 3rem;
                width: 16rem;
                height: 1.5rem;
                font-size: 1.5rem;
                font-family: Mitn;
                color: #23024D;
                border-top: none;
                border-left: none;
                border-right: none;
                border-bottom: 3px solid black;
                outline: none;
                padding: 0.5rem;
                cursor: pointer;
            }

            .typ-box-1:focus{
                border-radius: 0.5rem;
                border: none;
                background: #997EBC;
                transform: scale(1.05);
                font-size: 1.5rem;
            }

            /************story tell*************/
            .story-1{
                position: relative;
                background-color: white;
                width: 40rem;
                height: 36rem;
                border-radius: 2rem;
                opacity: 92%;
                margin: 1rem 0;
                display: grid;
                grid-template-rows: 2fr 0fr;
                row-gap: 1rem;
                justify-items: center;
            }

            .story-tell{
                position: relative;
                background-color: #6F4B9B;
                margin-top: 2rem;
                width: 35rem;
                height: 30rem;
            }

            .text-story{
                display: grid;
                grid-template-rows: 0fr 0fr;
                row-gap: 0.5rem;
                position: relative;
                padding: 1.5rem;
            }

            .title{
                position: relative;
                display: grid;
                grid-template-columns: 0fr 0fr;
                column-gap: 0.6rem;
                box-sizing: border-box;
                width: 29rem;
                border-radius: 1rem;
                margin-top: 0.5rem;
                margin-left: 0.5rem;
                padding-bottom: 1rem;
                align-items: start;
            }

            .img-title{
                position: relative;
                width: 10rem;
                height: 10rem;
                right: -1.2rem;
                background-color: white;
                border-radius: 10rem;
            }

            .img-title img{
                width: 100%; height: 100%;
                object-fit: cover;
                border-radius: 10rem;               
            }
            .text-title{
                font-size: 2rem;
                font-family: Kanit;
                position: relative;
                box-sizing: border-box;
                padding-left: 1.5rem;
                padding-right: 1.5rem;
                border-radius: 2rem;
                width: 25rem;
                background-color: white;
                box-shadow: 0 2px 10px 0 black;
            }
            .text-title p{
                position: relative;
                width: 23.5rem;
                word-wrap: break-word;
            }

            .describe p{
                padding-left: 1.5rem;
                font-family: Mitn;
                color: white;
                font-size: 1.5rem;
                width: 29rem;
                word-wrap: break-word;
            }

            .scroll{
                overflow: auto;
            }

            /***************icon bar***************/
            .icon-bar {
                width: 14rem;
                height: 2.5rem;
                background-color: #997EBC;
                border-radius: 1rem 1rem 0 0;
                display: grid;
                grid-template-columns: 1fr 1fr 0fr;
                column-gap: 1rem;
                padding: 0.2rem 2rem;
                justify-content: center;
                position: relative;
                bottom: 0;
            }

            .back i{
                color: #6F4B9B;
                font-size: 2rem;
                position: relative;
            }

            .homepage i{
                color: #6F4B9B;
                font-size: 2rem;
                position: relative;
            }

            .youtube i{
                color: #6F4B9B;
                font-size: 2rem;
                position: relative;
            }

            i:hover{
                color: white;
                transition: 0.3s ease;
                cursor: pointer;
            }

            a:focus{
                text-shadow: 0 0 10px #EEE2FD;
                transition: 0.3s ease;
            }   

            /******** send comment *********/
            .send-message{
                position: absolute;
                margin: 0.5rem;
                margin-top: 1.2rem;
                right: 1rem;
                width: 2rem;
                height: 2rem;
                font-size: 2rem;
                background-color: white;
                border: none;
                cursor: pointer;
                border-radius: 0.5rem;
            }
            .send-message:hover{
                transform: scale(0.8);
                transition: 0.5s ease-in;
                box-shadow: 0 0 10px 0 #F3F1F1;
                background-color: #F3F1F1;
            }

            #bx-send{
                color: #23024D;
                text-underline-position: none;
            }

            #bx-send:hover{
                color: #997EBC;
                text-underline-position: none;
            }

            .send-message i{
                position: relative;
                color: black;
                transform: rotate(270deg);
                box-sizing: border-box;
            }

            textarea{
                resize: none;
            }

            /********************* responsive *******************************/
@media screen and (min-width:210px) and (max-width: 250px){
    
            section{
                display: grid;
                grid-template-columns: 0fr;
                grid-template-rows: 0fr 0fr;
                row-gap: 0.5rem;
                column-gap: 0rem;
                position: relative;
                width: 10rem;
                height: auto;
                justify-content: center;
                justify-items: center;
                align-items: center;
                padding-top: 1rem;
                padding-bottom: 0rem;
                margin-left: 0rem;
            }

            .play{
                position: relative;
                display: grid;
                grid-template-rows: 0fr;
                row-gap: 1rem;
                justify-items: center;
                align-items: center;
                width: 12rem;
                height: 10rem; 
                padding-left: 0rem;     
                          
            }

            .play .video{
                display: grid;
                grid-template-rows: 0fr 0fr;
                row-gap: 0.3rem;
                position: relative;
                border-radius: 1rem;
                background-color: white;
                width: 12rem;
                height: 8.5rem;
                padding: 0.5rem;
                justify-items: center;
                justify-content: center;
            }

            .logo-tv{
                position: relative;    
                font-size: 1rem;
                width: 10rem;
                left: 35%;
                
            }

            .clip-place{
                position: relative;
                background-color: #6F4B9B;
                width: 10rem;
                height: 6rem;
            }

            .play .chat{
                display: none;
            }

            /************story tell*************/
            .story-1{
                position: relative;
                width: 12rem;
                height: 15rem;
                top: -2rem;
                display: grid;
                grid-template-columns: 0fr;
                grid-template-rows: 1fr 0fr;
                justify-content: center;
                justify-items: center;
            }

            .story-tell{
                position: relative;
                margin-top: 1rem;
                width: 10rem;
                height: 11.5rem;
            }

            .title{
                position: relative;
                display: grid;
                grid-template-columns: 0fr 0fr;
                column-gap: 0.6rem;
                box-sizing: border-box;
                width: 8rem;
                border-radius: 1rem;
                margin-top: 0.5rem;
                margin-left: 0.5rem;
                padding-bottom: 1rem;
                align-items: start;
            }
            .text-title{
                font-size: 1rem;
                position: relative;
                padding-left: 0rem;
                padding-right: 0rem;
                border-radius: 2rem;
                width: 7rem;
                padding-left: 0.5rem;
                top: -1rem;
                left: -0.5rem;
            }
            .text-title p{
                width: 5rem;
            }

            .describe p{
                padding-left: 0;
                font-size: 0.5rem;
                width: 6rem;
            }

            /***************icon bar***************/
            .icon-bar {
                width: 7rem;
                height: 1.5rem;;
                padding-top: 0.3rem;
            }

            .back i{
                font-size: 1rem;
            }

            .homepage i{
                font-size: 1rem;
            }

            .youtube i{
                font-size: 1rem;
            }


}

@media screen and (min-width:260px) and (max-width: 300px){

            section{
                display: grid;
                grid-template-columns: 0fr;
                grid-template-rows: 0fr 0fr;
                row-gap: 0.5rem;
                column-gap: 0rem;
                position: relative;
                width: 15rem;
                height: auto;
                justify-content: center;
                justify-items: center;
                align-items: center;
                padding-top: 2rem;
                padding-bottom: 0rem;
                margin-left: 0.5rem;
            }

            .play{
                position: relative;
                display: grid;
                grid-template-rows: 0fr;
                row-gap: 1rem;
                justify-items: center;
                align-items: center;
                width: 12rem;
                height: 10rem; 
                padding-left: 0rem;     
                          
            }

            .play .video{
                display: grid;
                grid-template-rows: 0fr 0fr;
                row-gap: 0.3rem;
                position: relative;
                border-radius: 1rem;
                background-color: white;
                width: 12rem;
                height: 8.5rem;
                padding: 0.5rem;
                justify-items: center;
                justify-content: center;
            }

            .logo-tv{
                position: relative;    
                font-size: 1rem;
                width: 10rem;
                left: 35%;
                
            }

            .clip-place{
                position: relative;
                background-color: #6F4B9B;
                width: 10rem;
                height: 6rem;
            }

            .play .chat{
                display: none;
            }

            /************story tell*************/
            .story-1{
                position: relative;
                width: 12rem;
                height: 15rem;
                top: -2rem;
                display: grid;
                grid-template-columns: 0fr;
                grid-template-rows: 1fr 0fr;
                justify-content: center;
                justify-items: center;
            }

            .story-tell{
                position: relative;
                margin-top: 1rem;
                width: 10rem;
                height: 11.5rem;
            }

            .title{
                position: relative;
                display: grid;
                grid-template-columns: 0fr 0fr;
                column-gap: 0.6rem;
                box-sizing: border-box;
                width: 8rem;
                border-radius: 1rem;
                margin-top: 0.5rem;
                margin-left: 0.5rem;
                padding-bottom: 1rem;
                align-items: start;
            }
            .text-title{
                font-size: 1rem;
                position: relative;
                padding-left: 0rem;
                padding-right: 0rem;
                border-radius: 2rem;
                width: 7rem;
                padding-left: 0.5rem;
                top: -1rem;
                left: -0.5rem;
            }
            .text-title p{
                width: 5rem;
            }

            .describe p{
                padding-left: 0;
                font-size: 0.5rem;
                width: 6rem;
            }

            /***************icon bar***************/
            .icon-bar {
                width: 7rem;
                height: 1.5rem;;
                padding-top: 0.3rem;
            }

            .back i{
                font-size: 1rem;
            }

            .homepage i{
                font-size: 1rem;
            }

            .youtube i{
                font-size: 1rem;
            }


}

@media screen and (min-width:310px) and (max-width: 340px){
    section{
                display: grid;
                grid-template-columns: 0fr;
                grid-template-rows: 0fr 0fr;
                row-gap: 2rem;
                column-gap: 0rem;
                position: relative;
                width: 12rem;
                height: auto;
                justify-content: center;
                justify-items: center;
                align-items: center;
                padding-top: 2.5rem;
                padding-bottom: 0rem;
                padding-right: 0rem;
            }

            .play{
                position: relative;
                display: grid;
                grid-template-rows: 0fr;
                row-gap: 1rem;
                justify-items: center;
                align-items: center;
                width: 12rem;
                height: 10rem; 
                padding-left: 0rem;     
                          
            }

            .play .video{
                display: grid;
                grid-template-rows: 0fr 0fr;
                row-gap: 0.5rem;
                position: relative;
                border-radius: 1rem;
                background-color: white;
                width: 15rem;
                height: 11rem;
                padding: 0.5rem;
                justify-items: center;
                justify-content: center;
            }

            .logo-tv{
                position: relative;    
                font-size: 1rem;
                width: 15rem;
                left: 40%;
                
            }

            .clip-place{
                position: relative;
                background-color: #6F4B9B;
                width: 12rem;
                height: 8rem;
            }

            .play .chat{
                display: none;
            }

            /************story tell*************/
            .story-1{
                position: relative;
                width: 15rem;
                height: 18rem;
                top: -1rem;
                display: grid;
                grid-template-columns: 0fr;
                grid-template-rows: 1fr 0fr;
                justify-content: center;
                justify-items: center;
            }

            .story-tell{
                position: relative;
                margin-top: 1rem;
                width: 12rem;
                height: 14rem;
            }

            .title{
                position: relative;
                display: grid;
                grid-template-columns: 0fr 0fr;
                column-gap:1rem;
                box-sizing: border-box;
                width: 8rem;
                border-radius: 1rem;
                margin-top: 0.5rem;
                margin-left: 0.5rem;
                padding-bottom: 1rem;
                align-items: start;
            }
            .text-title{
                font-size: 1.2rem;
                position: relative;
                padding-left: 0rem;
                padding-right: 0rem;
                border-radius: 2rem;
                width: 7rem;
                padding-left: 0.5rem;
                top: -1rem;
                left: -0.5rem;
            }
            .text-title p{
                width: 5rem;
            }

            .describe p{
                padding-left: 0;
                font-size: 0.5rem;
                width: 6rem;
            }

            /***************icon bar***************/
            .icon-bar {
                width: 7rem;
                height: 1.5rem;;
                padding-top: 0.3rem;
            }

            .back i{
                font-size: 1rem;
            }

            .homepage i{
                font-size: 1rem;
            }

            .youtube i{
                font-size: 1rem;
            }

}

@media screen and (min-width:341px) and (max-width: 370px){
    section{
                display: grid;
                grid-template-columns: 0fr;
                grid-template-rows: 0fr 0fr;
                row-gap: 2rem;
                column-gap: 0rem;
                position: relative;
                width: 12rem;
                height: auto;
                justify-content: center;
                justify-items: center;
                align-items: center;
                padding-top: 3rem;
                padding-bottom: 0rem;
                margin-left: 2.5rem;
            }

            .play{
                position: relative;
                display: grid;
                grid-template-rows: 0fr;
                row-gap: 1rem;
                justify-items: center;
                align-items: center;
                width: 12rem;
                height: 10rem; 
                padding-left: 0rem;     
                          
            }

            .play .video{
                display: grid;
                grid-template-rows: 0fr 0fr;
                row-gap: 0.5rem;
                position: relative;
                border-radius: 1rem;
                background-color: white;
                width: 15rem;
                height: 11rem;
                padding: 0.5rem;
                justify-items: center;
                justify-content: center;
            }

            .logo-tv{
                position: relative;    
                font-size: 1rem;
                width: 15rem;
                left: 40%;
                
            }

            .clip-place{
                position: relative;
                background-color: #6F4B9B;
                width: 12rem;
                height: 8rem;
            }

            .play .chat{
                display: none;
            }

            /************story tell*************/
            .story-1{
                position: relative;
                width: 15rem;
                height: 18rem;
                top: -1rem;
                display: grid;
                grid-template-columns: 0fr;
                grid-template-rows: 1fr 0fr;
                justify-content: center;
                justify-items: center;
            }

            .story-tell{
                position: relative;
                margin-top: 1rem;
                width: 12rem;
                height: 14rem;
            }

            .title{
                position: relative;
                display: grid;
                grid-template-columns: 0fr 0fr;
                column-gap:1rem;
                box-sizing: border-box;
                width: 8rem;
                border-radius: 1rem;
                margin-top: 0.5rem;
                margin-left: 0.5rem;
                padding-bottom: 1rem;
                align-items: start;
            }
            .text-title{
                font-size: 1.2rem;
                position: relative;
                padding-left: 0rem;
                padding-right: 0rem;
                border-radius: 2rem;
                width: 7rem;
                padding-left: 0.5rem;
                top: -1rem;
                left: -0.5rem;
            }
            .text-title p{
                width: 5rem;
            }

            .describe p{
                padding-left: 0;
                font-size: 0.5rem;
                width: 6rem;
            }

            /***************icon bar***************/
            .icon-bar {
                width: 7rem;
                height: 1.5rem;;
                padding-top: 0.3rem;
            }

            .back i{
                font-size: 1rem;
            }

            .homepage i{
                font-size: 1rem;
            }

            .youtube i{
                font-size: 1rem;
            }

}



@media screen and (min-width:371px) and (max-width: 389px){
    section{
                display: grid;
                grid-template-columns: 0fr;
                grid-template-rows: 0fr 0fr;
                row-gap: 2rem;
                column-gap: 0rem;
                position: relative;
                width: 12rem;
                height: auto;
                justify-content: center;
                justify-items: center;
                align-items: center;
                padding-top: 3rem;
                padding-bottom: 0rem;
                margin-left: 2.5rem;
            }

            .play{
                position: relative;
                display: grid;
                grid-template-rows: 0fr;
                row-gap: 1rem;
                justify-items: center;
                align-items: center;
                width: 12rem;
                height: 10rem; 
                padding-left: 0rem;     
                          
            }

            .play .video{
                display: grid;
                grid-template-rows: 0fr 0fr;
                row-gap: 0.5rem;
                position: relative;
                border-radius: 1rem;
                background-color: white;
                width: 15rem;
                height: 11rem;
                padding: 0.5rem;
                justify-items: center;
                justify-content: center;
            }

            .logo-tv{
                position: relative;    
                font-size: 1rem;
                width: 15rem;
                left: 40%;
                
            }

            .clip-place{
                position: relative;
                background-color: #6F4B9B;
                width: 12rem;
                height: 8rem;
            }

            .play .chat{
                display: none;
            }

            /************story tell*************/
            .story-1{
                position: relative;
                width: 15rem;
                height: 18rem;
                top: -1rem;
                display: grid;
                grid-template-columns: 0fr;
                grid-template-rows: 1fr 0fr;
                justify-content: center;
                justify-items: center;
            }

            .story-tell{
                position: relative;
                margin-top: 1rem;
                width: 12rem;
                height: 14rem;
            }

            .title{
                position: relative;
                display: grid;
                grid-template-columns: 0fr 0fr;
                column-gap:1rem;
                box-sizing: border-box;
                width: 8rem;
                border-radius: 1rem;
                margin-top: 0.5rem;
                margin-left: 0.5rem;
                padding-bottom: 1rem;
                align-items: start;
            }
            .text-title{
                font-size: 1.2rem;
                position: relative;
                padding-left: 0rem;
                padding-right: 0rem;
                border-radius: 2rem;
                width: 7rem;
                padding-left: 0.5rem;
                top: -1rem;
                left: -0.5rem;
            }
            .text-title p{
                width: 5rem;
            }

            .describe p{
                padding-left: 0;
                font-size: 0.5rem;
                width: 6rem;
            }

            /***************icon bar***************/
            .icon-bar {
                width: 7rem;
                height: 1.5rem;;
                padding-top: 0.3rem;
            }

            .back i{
                font-size: 1rem;
            }

            .homepage i{
                font-size: 1rem;
            }

            .youtube i{
                font-size: 1rem;
            }

}

@media screen and (min-width:390px) and (max-width: 420px){
    section{
                display: grid;
                grid-template-columns: 0fr;
                grid-template-rows: 0fr 0fr;
                row-gap:5rem;
                column-gap: 0rem;
                position: relative;
                width: 12rem;
                height: auto;
                justify-content: center;
                justify-items: center;
                align-items: center;
                padding-top: 3rem;
                padding-bottom: 0rem;
                margin-left: 3.8rem;
            }

            .play{
                position: relative;
                display: grid;
                grid-template-rows: 0fr;
                row-gap: 1rem;
                justify-items: center;
                align-items: center;
                width: 12rem;
                height: 10rem; 
                padding-left: 0rem;     
                          
            }

            .play .video{
                display: grid;
                grid-template-rows: 0fr 0fr;
                row-gap: 0.5rem;
                position: relative;
                border-radius: 1rem;
                background-color: white;
                width: 18rem;
                height: 14rem;
                padding: 1rem;
                justify-items: center;
                justify-content: center;
            }

            .logo-tv{
                position: relative;    
                font-size: 1.5rem;
                width: 15rem;
                left: 35%;
                
            }

            .clip-place{
                position: relative;
                background-color: #6F4B9B;
                width: 14rem;
                height: 10rem;
            }

            .play .chat{
                display: none;
            }

            /************story tell*************/
            .story-1{
                position: relative;
                width: 18rem;
                height: 25rem;
                top: -1rem;
                display: grid;
                grid-template-columns: 0fr;
                grid-template-rows: 1fr 0fr;
                justify-content: center;
                justify-items: center;
            }

            .story-tell{
                position: relative;
                margin-top: 1rem;
                width: 16rem;
                height: 21rem;
            }

            .title{
                position: relative;
                display: grid;
                grid-template-columns: 0fr 0fr;
                column-gap:1rem;
                box-sizing: border-box;
                width: 8rem;
                border-radius: 1rem;
                margin-top: 0.5rem;
                margin-left: 0.5rem;
                padding-bottom: 1rem;
                align-items: start;
            }
            .text-title{
                font-size: 1.5rem;
                position: relative;
                padding-left: 0rem;
                padding-right: 0rem;
                border-radius: 2rem;
                width: 10rem;
                padding-left: 0.5rem;
                top: -1rem;
                left: -0.5rem;
            }
            .text-title p{
                width: 6rem;
            }

            .describe p{
                padding-left: 0;
                font-size: 1rem;
                width: 6rem;
            }

            /***************icon bar***************/
            .icon-bar {
                width: 7rem;
                height: 1.5rem;;
                padding-top: 0.3rem;
            }

            .back i{
                font-size: 1rem;
            }

            .homepage i{
                font-size: 1rem;
            }

            .youtube i{
                font-size: 1rem;
            }

}

@media screen and (min-width:480px) and (max-width: 540px){
    section{
                display: grid;
                grid-template-columns: 0fr;
                grid-template-rows: 0fr 0fr;
                row-gap:5rem;
                column-gap: 0rem;
                position: relative;
                width: 12rem;
                height: auto;
                justify-content: center;
                justify-items: center;
                align-items: center;
                padding-top: 3rem;
                padding-bottom: 0rem;
                margin-left: 6rem;
            }

            .play{
                position: relative;
                display: grid;
                grid-template-rows: 0fr;
                row-gap: 1rem;
                justify-items: center;
                align-items: center;
                width: 12rem;
                height: 10rem; 
                padding-left: 0rem;     
                          
            }

            .play .video{
                display: grid;
                grid-template-rows: 0fr 0fr;
                row-gap: 0.5rem;
                position: relative;
                border-radius: 1rem;
                background-color: white;
                width: 18rem;
                height: 14rem;
                padding: 1rem;
                justify-items: center;
                justify-content: center;
            }

            .logo-tv{
                position: relative;    
                font-size: 1.5rem;
                width: 15rem;
                left: 35%;
                
            }

            .clip-place{
                position: relative;
                background-color: #6F4B9B;
                width: 14rem;
                height: 10rem;
            }

            .play .chat{
                display: none;
            }

            /************story tell*************/
            .story-1{
                position: relative;
                width: 18rem;
                height: 25rem;
                top: -1rem;
                display: grid;
                grid-template-columns: 0fr;
                grid-template-rows: 1fr 0fr;
                justify-content: center;
                justify-items: center;
            }

            .story-tell{
                position: relative;
                margin-top: 1rem;
                width: 16rem;
                height: 21rem;
            }

            .title{
                position: relative;
                display: grid;
                grid-template-columns: 0fr 0fr;
                column-gap:1rem;
                box-sizing: border-box;
                width: 8rem;
                border-radius: 1rem;
                margin-top: 0.5rem;
                margin-left: 0.5rem;
                padding-bottom: 1rem;
                align-items: start;
            }
            .text-title{
                font-size: 1.5rem;
                position: relative;
                padding-left: 0rem;
                padding-right: 0rem;
                border-radius: 2rem;
                width: 10rem;
                padding-left: 0.5rem;
                top: -1rem;
                left: -0.5rem;
            }
            .text-title p{
                width: 6rem;
            }

            .describe p{
                padding-left: 0;
                font-size: 1rem;
                width: 6rem;
            }

            /***************icon bar***************/
            .icon-bar {
                width: 7rem;
                height: 1.5rem;;
                padding-top: 0.3rem;
            }

            .back i{
                font-size: 1rem;
            }

            .homepage i{
                font-size: 1rem;
            }

            .youtube i{
                font-size: 1rem;
            }

}

@media screen and (min-width:600px) and (max-width: 660px){
    section{
                display: grid;
                grid-template-columns: 0fr;
                grid-template-rows: 0fr 0fr;
                row-gap: 13rem;
                column-gap: 0rem;
                position: relative;
                width: 12rem;
                height: auto;
                justify-content: center;
                justify-items: center;
                align-items: center;
                padding-top: 3rem;
                padding-bottom: 0rem;
                margin-left: 10rem;
            }

            .play{
                position: relative;
                display: grid;
                grid-template-rows: 0fr;
                row-gap: 1rem;
                justify-items: center;
                align-items: center;
                width: 12rem;
                height: 10rem; 
                padding-left: 0rem;     
                          
            }

            .play .video{
                display: grid;
                grid-template-rows: 0fr 0fr;
                row-gap: 0.5rem;
                position: relative;
                border-radius: 1rem;
                background-color: white;
                width:25rem;
                height: 20.5rem;
                padding: 1rem;
                justify-items: center;
                justify-content: center;
            }

            .logo-tv{
                position: relative;    
                font-size: 1.8rem;
                width: 15rem;
                left: 25%;
                
            }

            .clip-place{
                position: relative;
                background-color: #6F4B9B;
                width: 22rem;
                height: 16rem;
            }

            .play .chat{
                display: none;
            }

            /************story tell*************/
            .story-1{
                position: relative;
                width: 25rem;
                height: 30rem;
                top: -1rem;
                display: grid;
                grid-template-columns: 0fr;
                grid-template-rows: 1fr 0fr;
                justify-content: center;
                justify-items: center;
            }

            .story-tell{
                position: relative;
                margin-top: 1rem;
                width: 23em;
                height: 26rem;
            }

            .title{
                position: relative;
                display: grid;
                grid-template-columns: 0fr 0fr;
                column-gap:1rem;
                box-sizing: border-box;
                width: 8rem;
                border-radius: 1rem;
                margin-top: 0.5rem;
                margin-left: 0.5rem;
                padding-bottom: 1rem;
                align-items: start;
            }
            .text-title{
                font-size: 2rem;
                position: relative;
                padding-left: 0rem;
                padding-right: 0rem;
                border-radius: 2rem;
                width: 15rem;
                padding-left: 0.5rem;
                top: -1rem;
                left: -0.5rem;
            }
            .text-title p{
                width: 6rem;
            }

            .describe p{
                padding-left: 0;
                font-size: 1.5rem;
                width: 6rem;
            }

            /***************icon bar***************/
            .icon-bar {
                width: 10rem;
                height: 2rem;;
                padding-top: 0.3rem;
            }

            .back i{
                font-size: 1.5rem;
            }

            .homepage i{
                font-size: 1.5rem;
            }

            .youtube i{
                font-size: 1.5rem;
            }


}

@media screen and (min-width:600px) and (max-width: 660px) and (min-height: 300px) and (max-height: 400px){
    section{
                display: grid;
                grid-template-columns: 0fr;
                grid-template-rows: 0fr 0fr;
                row-gap: 13rem;
                column-gap: 0rem;
                position: relative;
                width: 12rem;
                height: auto;
                justify-content: center;
                justify-items: center;
                align-items: center;
                padding-top: 3rem;
                padding-bottom: 0rem;
                margin-left: 10rem;
            }

            .play{
                position: relative;
                display: grid;
                grid-template-rows: 0fr;
                row-gap: 1rem;
                justify-items: center;
                align-items: center;
                width: 12rem;
                height: 10rem; 
                padding-left: 0rem;     
                          
            }

            .play .video{
                display: grid;
                grid-template-rows: 0fr 0fr;
                row-gap: 0.5rem;
                position: relative;
                border-radius: 1rem;
                background-color: white;
                width:25rem;
                height: 20.5rem;
                padding: 1rem;
                justify-items: center;
                justify-content: center;
            }

            .logo-tv{
                position: relative;    
                font-size: 1.8rem;
                width: 15rem;
                left: 25%;
                
            }

            .clip-place{
                position: relative;
                background-color: #6F4B9B;
                width: 22rem;
                height: 16rem;
            }

            .play .chat{
                display: none;
            }

            /************story tell*************/
            .story-1{
                position: relative;
                width: 25rem;
                height: 30rem;
                top: -1rem;
                display: grid;
                grid-template-columns: 0fr;
                grid-template-rows: 1fr 0fr;
                justify-content: center;
                justify-items: center;
            }

            .story-tell{
                position: relative;
                margin-top: 1rem;
                width: 23em;
                height: 26rem;
            }

            .title{
                position: relative;
                display: grid;
                grid-template-columns: 0fr 0fr;
                column-gap:1rem;
                box-sizing: border-box;
                width: 8rem;
                border-radius: 1rem;
                margin-top: 0.5rem;
                margin-left: 0.5rem;
                padding-bottom: 1rem;
                align-items: start;
            }
            .text-title{
                font-size: 2rem;
                position: relative;
                padding-left: 0rem;
                padding-right: 0rem;
                border-radius: 2rem;
                width: 15rem;
                padding-left: 0.5rem;
                top: -1rem;
                left: -0.5rem;
            }
            .text-title p{
                width: 6rem;
            }

            .describe p{
                padding-left: 0;
                font-size: 1.5rem;
                width: 6rem;
            }

            /***************icon bar***************/
            .icon-bar {
                width: 10rem;
                height: 2rem;;
                padding-top: 0.3rem;
            }

            .back i{
                font-size: 1.5rem;
            }

            .homepage i{
                font-size: 1.5rem;
            }

            .youtube i{
                font-size: 1.5rem;
            }

}

@media screen and (min-width:710px) and (max-width: 770px){
    section{
                display: grid;
                grid-template-columns: 0fr;
                grid-template-rows: 0fr 0fr;
                row-gap: 13rem;
                column-gap: 0rem;
                position: relative;
                width: 12rem;
                height: auto;
                justify-content: center;
                justify-items: center;
                align-items: center;
                padding-top: 3rem;
                padding-bottom: 0rem;
                margin-left: 10rem;
            }

            .play{
                position: relative;
                display: grid;
                grid-template-rows: 0fr;
                row-gap: 1rem;
                justify-items: center;
                align-items: center;
                width: 12rem;
                height: 10rem; 
                padding-left: 0rem;     
                          
            }

            .play .video{
                display: grid;
                grid-template-rows: 0fr 0fr;
                row-gap: 0.5rem;
                position: relative;
                border-radius: 1rem;
                background-color: white;
                width:25rem;
                height: 20.5rem;
                padding: 1rem;
                justify-items: center;
                justify-content: center;
            }

            .logo-tv{
                position: relative;    
                font-size: 1.8rem;
                width: 15rem;
                left: 25%;
                
            }

            .clip-place{
                position: relative;
                background-color: #6F4B9B;
                width: 22rem;
                height: 16rem;
            }

            .play .chat{
                display: none;
            }

            /************story tell*************/
            .story-1{
                position: relative;
                width: 25rem;
                height: 30rem;
                top: -1rem;
                display: grid;
                grid-template-columns: 0fr;
                grid-template-rows: 1fr 0fr;
                justify-content: center;
                justify-items: center;
            }

            .story-tell{
                position: relative;
                margin-top: 1rem;
                width: 23em;
                height: 26rem;
            }

            .title{
                position: relative;
                display: grid;
                grid-template-columns: 0fr 0fr;
                column-gap:1rem;
                box-sizing: border-box;
                width: 8rem;
                border-radius: 1rem;
                margin-top: 0.5rem;
                margin-left: 0.5rem;
                padding-bottom: 1rem;
                align-items: start;
            }
            .text-title{
                font-size: 2rem;
                position: relative;
                padding-left: 0rem;
                padding-right: 0rem;
                border-radius: 2rem;
                width: 15rem;
                padding-left: 0.5rem;
                top: -1rem;
                left: -0.5rem;
            }
            .text-title p{
                width: 6rem;
            }

            .describe p{
                padding-left: 0;
                font-size: 1.5rem;
                width: 6rem;
            }

            /***************icon bar***************/
            .icon-bar {
                width: 10rem;
                height: 2rem;;
                padding-top: 0.3rem;
            }

            .back i{
                font-size: 1.5rem;
            }

            .homepage i{
                font-size: 1.5rem;
            }

            .youtube i{
                font-size: 1.5rem;
            }


}

@media screen and (min-width:800px) and (max-width: 850px){
    section{
                display: grid;
                grid-template-columns: 0fr;
                grid-template-rows: 0fr 0fr;
                row-gap: 13rem;
                column-gap: 0rem;
                position: relative;
                width: 12rem;
                height: auto;
                justify-content: center;
                justify-items: center;
                align-items: center;
                padding-top: 3rem;
                padding-bottom: 0rem;
                margin-left: 10rem;
            }

            .play{
                position: relative;
                display: grid;
                grid-template-rows: 0fr;
                row-gap: 1rem;
                justify-items: center;
                align-items: center;
                width: 12rem;
                height: 10rem; 
                padding-left: 0rem;     
                          
            }

            .play .video{
                display: grid;
                grid-template-rows: 0fr 0fr;
                row-gap: 0.5rem;
                position: relative;
                border-radius: 1rem;
                background-color: white;
                width:25rem;
                height: 20.5rem;
                padding: 1rem;
                justify-items: center;
                justify-content: center;
            }

            .logo-tv{
                position: relative;    
                font-size: 1.8rem;
                width: 15rem;
                left: 25%;
                
            }

            .clip-place{
                position: relative;
                background-color: #6F4B9B;
                width: 22rem;
                height: 16rem;
            }

            .play .chat{
                display: none;
            }

            /************story tell*************/
            .story-1{
                position: relative;
                width: 25rem;
                height: 30rem;
                top: -1rem;
                display: grid;
                grid-template-columns: 0fr;
                grid-template-rows: 1fr 0fr;
                justify-content: center;
                justify-items: center;
            }

            .story-tell{
                position: relative;
                margin-top: 1rem;
                width: 23em;
                height: 26rem;
            }

            .title{
                position: relative;
                display: grid;
                grid-template-columns: 0fr 0fr;
                column-gap:1rem;
                box-sizing: border-box;
                width: 8rem;
                border-radius: 1rem;
                margin-top: 0.5rem;
                margin-left: 0.5rem;
                padding-bottom: 1rem;
                align-items: start;
            }
            .text-title{
                font-size: 2rem;
                position: relative;
                padding-left: 0rem;
                padding-right: 0rem;
                border-radius: 2rem;
                width: 15rem;
                padding-left: 0.5rem;
                top: -1rem;
                left: -0.5rem;
            }
            .text-title p{
                width: 6rem;
            }

            .describe p{
                padding-left: 0;
                font-size: 1.5rem;
                width: 6rem;
            }

            /***************icon bar***************/
            .icon-bar {
                width: 10rem;
                height: 2rem;;
                padding-top: 0.3rem;
            }

            .back i{
                font-size: 1.5rem;
            }

            .homepage i{
                font-size: 1.5rem;
            }

            .youtube i{
                font-size: 1.5rem;
            }


}

@media screen and (min-width:900px) and (max-width: 960px){
    section{
                display: grid;
                grid-template-columns: 0fr;
                grid-template-rows: 0fr 0fr;
                row-gap: 13rem;
                column-gap: 0rem;
                position: relative;
                width: 12rem;
                height: auto;
                justify-content: center;
                justify-items: center;
                align-items: center;
                padding-top: 3rem;
                padding-bottom: 0rem;
                margin-left: 10rem;
            }

            .play{
                position: relative;
                display: grid;
                grid-template-rows: 0fr;
                row-gap: 1rem;
                justify-items: center;
                align-items: center;
                width: 12rem;
                height: 10rem; 
                padding-left: 0rem;     
                          
            }

            .play .video{
                display: grid;
                grid-template-rows: 0fr 0fr;
                row-gap: 0.5rem;
                position: relative;
                border-radius: 1rem;
                background-color: white;
                width:25rem;
                height: 20.5rem;
                padding: 1rem;
                justify-items: center;
                justify-content: center;
            }

            .logo-tv{
                position: relative;    
                font-size: 1.8rem;
                width: 15rem;
                left: 25%;
                
            }

            .clip-place{
                position: relative;
                background-color: #6F4B9B;
                width: 22rem;
                height: 16rem;
            }

            .play .chat{
                display: none;
            }

            /************story tell*************/
            .story-1{
                position: relative;
                width: 25rem;
                height: 30rem;
                top: -1rem;
                display: grid;
                grid-template-columns: 0fr;
                grid-template-rows: 1fr 0fr;
                justify-content: center;
                justify-items: center;
            }

            .story-tell{
                position: relative;
                margin-top: 1rem;
                width: 23em;
                height: 26rem;
            }

            .title{
                position: relative;
                display: grid;
                grid-template-columns: 0fr 0fr;
                column-gap:1rem;
                box-sizing: border-box;
                width: 8rem;
                border-radius: 1rem;
                margin-top: 0.5rem;
                margin-left: 0.5rem;
                padding-bottom: 1rem;
                align-items: start;
            }
            .text-title{
                font-size: 2rem;
                position: relative;
                padding-left: 0rem;
                padding-right: 0rem;
                border-radius: 2rem;
                width: 15rem;
                padding-left: 0.5rem;
                top: -1rem;
                left: -0.5rem;
            }
            .text-title p{
                width: 6rem;
            }

            .describe p{
                padding-left: 0;
                font-size: 1.5rem;
                width: 6rem;
            }

            /***************icon bar***************/
            .icon-bar {
                width: 10rem;
                height: 2rem;;
                padding-top: 0.3rem;
            }

            .back i{
                font-size: 1.5rem;
            }

            .homepage i{
                font-size: 1.5rem;
            }

            .youtube i{
                font-size: 1.5rem;
            }


}

@media screen and (min-width:1020px) and (max-width: 1080px){
    body{
        justify-content: center;
        align-items: center;
    }
    section{
                display: flex;
                flex-direction: row;
                position: fixed;
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 3rem 2rem;
                justify-content: center;
                align-items: center;
            }
            .story-1{
                position: relative;
                width: 26rem;
            }

            .story-tell{
                position: relative;
                margin-top: 1rem;
                width: 23em;
                height: 31rem;
                
            }
            .text-title{
                font-size:2rem;
                width: 15rem;
               
            }
            .text-title p{
                width: 12rem;
            }

            .describe p{
                padding-left: 0;
                font-size: 1.5rem;
                width: 20rem;
            }


}

@media screen and (min-width:1080px) and (max-width: 1100px) and (min-height:2300px) and (max-height:2350px){
    section{
                display: grid;
                grid-template-columns: 0fr;
                grid-template-rows: 0fr 0fr;
                row-gap: 13rem;
                column-gap: 0rem;
                position: relative;
                width: 12rem;
                height: auto;
                justify-content: center;
                justify-items: center;
                align-items: center;
                padding-top: 3rem;
                padding-bottom: 0rem;
                margin-left: 10rem;
            }

            .play{
                position: relative;
                display: grid;
                grid-template-rows: 0fr;
                row-gap: 1rem;
                justify-items: center;
                align-items: center;
                width: 12rem;
                height: 10rem; 
                padding-left: 0rem;     
                          
            }

            .play .video{
                display: grid;
                grid-template-rows: 0fr 0fr;
                row-gap: 0.5rem;
                position: relative;
                border-radius: 1rem;
                background-color: white;
                width:25rem;
                height: 20.5rem;
                padding: 1rem;
                justify-items: center;
                justify-content: center;
            }

            .logo-tv{
                position: relative;    
                font-size: 1.8rem;
                width: 15rem;
                left: 25%;
                
            }

            .clip-place{
                position: relative;
                background-color: #6F4B9B;
                width: 22rem;
                height: 16rem;
            }

            .play .chat{
                display: none;
            }

            /************story tell*************/
            .story-1{
                position: relative;
                width: 25rem;
                height: 30rem;
                top: -1rem;
                display: grid;
                grid-template-columns: 0fr;
                grid-template-rows: 1fr 0fr;
                justify-content: center;
                justify-items: center;
            }

            .story-tell{
                position: relative;
                margin-top: 1rem;
                width: 23em;
                height: 26rem;
            }

            .title{
                position: relative;
                display: grid;
                grid-template-columns: 0fr 0fr;
                column-gap:1rem;
                box-sizing: border-box;
                width: 8rem;
                border-radius: 1rem;
                margin-top: 0.5rem;
                margin-left: 0.5rem;
                padding-bottom: 1rem;
                align-items: start;
            }
            .text-title{
                font-size: 2rem;
                position: relative;
                padding-left: 0rem;
                padding-right: 0rem;
                border-radius: 2rem;
                width: 15rem;
                padding-left: 0.5rem;
                top: -1rem;
                left: -0.5rem;
            }
            .text-title p{
                width: 6rem;
            }

            .describe p{
                padding-left: 0;
                font-size: 1.5rem;
                width: 6rem;
            }

            /***************icon bar***************/
            .icon-bar {
                width: 10rem;
                height: 2rem;;
                padding-top: 0.3rem;
            }

            .back i{
                font-size: 1.5rem;
            }

            .homepage i{
                font-size: 1.5rem;
            }

            .youtube i{
                font-size: 1.5rem;
            }

}

@media screen and (min-width:1020px) and (max-width: 1080px) and (min-height: 600px) and (max-height: 1000px){
    section{
                display: flex;
                flex-direction: row;
                position: fixed;
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 3rem 2rem;
                justify-content: center;
            }
}

@media screen and (min-width:1230px) and (max-width: 1280px) and (min-height:800px){

}



@media screen and (min-width:1900px) and (min-height: 1080px) {

    body{
        justify-content: center;
        align-items: center;
    }
    section{
                display: grid;
                grid-template-columns: 0fr 0fr;
                column-gap: 5rem;
                position: fixed;
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 3rem 4rem;
                justify-content: center;
                align-items: center;
            }
            .story-1{
                position: relative;
                width: 35rem;
            }

            .story-tell{
                position: relative;
                margin-top: 1rem;
                width: 31rem;
                height: 31rem;
                
            }
            .text-title{
                font-size: 2.5rem;
                width: 8;
               
            }
            .text-title p{
                width: 6rem;
            }

            .describe p{
                padding-left: 0;
                font-size: 1.5rem;
                width: 20rem;
            }


}

@media screen and (min-width:1440px) and (max-width:1900px) and (min-height: 900px){
    section{
                display: grid;
                grid-template-columns: 0fr 0fr;
                column-gap: 5rem;
                position: fixed;
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 3rem 4rem;
                justify-content: center;
                align-items: center;
            }
            .story-1{
                position: relative;
                width: 35rem;
            }

            .story-tell{
                position: relative;
                margin-top: 1rem;
                width: 31rem;
                height: 31rem;
                
            }
            .text-title{
                font-size: 2.5rem;
                width: 8;
               
            }
            .text-title p{
                width: 6rem;
            }

            .describe p{
                padding-left: 0;
                font-size: 1.5rem;
                width: 20rem;
            }

}

/*********************************************************/
@media screen and (min-width:300px) and (max-width:320px) and (min-height:220px) and (max-height:250px) {

}

@media screen and (max-height:280px) and (min-width: 600px) and (max-width: 660px){

}

@media screen and (min-width:650px) and (max-width: 680px) and (min-height: 300px)  and (max-height: 320px){

}

@media screen and (min-width:690px) and (min-height: 300px)  and (max-height: 320px){

}

@media screen and (min-width:550px) and (max-width: 570px) and (min-height: 300px)  and (max-height: 320px){

}

@media screen and (min-width:500px) and (max-width: 540px) and (max-height: 320px){

}

@media screen and (min-width:450px) and (max-width: 490px) and (min-height: 300px)  and (max-height: 320px){
 
}

@media screen and (min-width:790px) and (max-width:830px) and (min-height: 340px) and (max-height: 370px){

}

@media screen and (min-width:831px) and (max-width:900px) and (min-height: 340px) and (max-height: 370px){

}

@media screen and (min-width:700px) and (max-width:780px) and (min-height: 340px) and (max-height: 370px){

}

@media screen and (min-width:700px) and (max-width:780px) and (min-height: 340px) and (max-height: 370px){

}

@media screen and (min-width:600px) and (max-width:699px) and (min-height: 340px) and (max-height: 370px){

}

@media screen and (min-height:371px) and (max-height: 390px) {

}

@media screen and (min-height:371px) and (max-height: 390px) and (min-width:600px){

}

@media screen and (min-height:390px) and (max-height: 420px){

}

@media screen and (min-width:720px) and (max-width: 860px) and (min-height:480px) and (max-height: 540px){

}

@media screen and (min-width:700px) and (max-width:720px) and (max-height: 540px){

}

@media screen and (min-height:600px) and (max-height: 660px) and (min-width:900px){

}

@media screen and (min-height:710px) and (max-height: 770px) and (min-width:1024px){

}

@media screen and (min-height:800px) and (max-height: 850px) and (min-width:1180px) and (max-width: 1280px){

}

@media screen and (min-height:900px) and (max-height: 960px) and (min-width:1280px) and (max-width: 1440px){

}

@media screen and (min-height:1020px) and (max-height: 1080px) and (min-width:1300px) and (max-width: 1370px){

}

        </style>
    </head>
<body>
    <section class="animation">
            <?php
            while($row = mysqli_fetch_assoc($query)){ 
                    $animation_file = $row['animation_file'];
                    $animation_name = $row['animation_name'];
                    $story = $row['story'];
            ?>

        <div class="play">
            <div class="video">
            
                <div class="clip-place">
                    <video src="<?php echo $animation_file;?>" controls auto-play></video>
                </div>
                <div class="logo-tv">
                    <p>PIMY 3</p>
                </div>
            </div>
            <form class="chat" method="post">
                <div class="typing-1">
                    <div class="head-chat">
                        <p>comment</p>
                    </div>
                    <div class="typing-2">
                        <div class="profile">
                            <img src="user.png">
                        </div>
                        <div class="nameuser">
                            <p><?php echo $_SESSION['joiner'];?></p>
                        </div>
                        <div class="typ-box">
                            <input type="text" class="typ-box-1" name="comments">
                        </div>

                        <button class="send-message" type="submit" name="sendmsg"><i class='bx bx-send' id="bx-send" ></i></button>
                    </div> 
                </div>
            </form>

        </div>
        <div class="story-1">
            <div class="story-tell scroll">
                <div class="text-story">
                    <div class="title">
                        <div class="text-title">
                            <p><?php echo $animation_name;?></p>
                        </div>
                    </div>
                    <div class="describe">
                        <p> <?php echo $story; ?></p>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="icon-bar">
                    <form class="back" method="get" >
                    <a href="animation.php? logout='1'"><i class='bx bxs-door-open'></i></a>
                    </form>
                    <form class="homepage" method="get">
                        <a href="animation.php? backhome='1'"><i class='bx bxs-home' ></i></a>
                    </form>
                    <div class="youtube">
                        <a href="https://www.youtube.com/channel/UCx7mF0j6vV025dI43FqL-YA"><i class='bx bxl-youtube'></i></a>
                    </div>
            </div>
        </div>

    </section>
    
    
</body>
</html>