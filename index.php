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

if(isset($_POST['sendmsg'])){
    $nameuser = $_SESSION['joiner'];
    $comments = $_POST['comments'];
    $insert = "INSERT into commented(nameuser, comment) VALUES('$nameuser', '$comments')";
    $insert_run = mysqli_query($conn, $insert);
    unset($comments);
    header("location: index.php");
}

$show_comment = "SELECT * FROM commented";
$show_comment_run = $conn->query($show_comment);

//show file//
$select_char = "SELECT * FROM charactor ORDER BY id DESC";
$selectChar_query = mysqli_query($conn, $select_char);

$select_ani = "SELECT * FROM animation ORDER BY id DESC";
$selectAni_query = mysqli_query($conn, $select_ani);


?>


<!DOCTYPE html>
<html lang="eng">
    <head>
        <title> PIMY 3 </title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="home.css">
        <link rel="icon" type="x-icon" href="kaprikorn.png">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
        <script type="text/javascript">
            function preventBack(){window.history.forward()};
            setTimeout("preventBack()", 0);
               window.onunload=function(){null;}
        </script>
        
        <style>
            /****** chat ******/
            .scroll{
                overflow-y: auto;
            }

            @font-face{
                font-family: Mitn;
                src: url(font/MiTNThin.ttf);
            }

            @font-face{
                font-family: Mustica;
                src: url(font/MusticaPro-SemiBold.otf);
                   /***font title***/
                }

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
 
 *{
     padding: 0;
     margin: 0;
     box-sizing: border-box;
 }


/*****************************************home*****************************************/

/*********** icon *****************/

#down-1{
    position: absolute;
    left: 19rem;
}
#down-2{
    position: absolute;
    left: 18rem;
}
.down i{
    position: relative;
    font-size: 4rem;
    color: #23024D;
    cursor: pointer;
}
#down-1:hover{
    background-color: #E0F4FF;
    color: #6F4B9B;
    border-radius: 5rem;

}
#down-2:hover{
    background-color: #FFE0FE;
    color: #6F4B9B;
    border-radius: 5rem;

}
#animation.close{
   display: none;
}

#character.close{
    display: none;
}

/*.chat{

}
/*********** icon *****************/

.chat-popup i{
    display: none;
}


body::-webkit-scrollbar{
    display: none;
}
body{
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    width: 100%;
    height: 100%;
    background: #F3F2F9;
}

.header{
    z-index: 5;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    grid-gap: 1rem;
    background-color: #23024D;
    width: 100%;
    height: 13.1rem;
    margin: 0;
    position: relative;  
    justify-content: center;
    align-items: center;
}

.background-header{
    background-color: #23024D;
    width: 100%;
    height: 13.1rem;
    margin: 0;
    position: fixed;
    box-sizing: border-box;  
    z-index: 5;
}

.background-header img{
    object-fit: cover;
    width: 100%; height: 13.1rem;
    box-sizing: border-box;
}

.header .title-header{
    position: fixed;
    width: 500px;
    height:80px;
    top: 3rem;
    z-index:6;
    box-sizing: border-box;
}

.icon-bar{
    z-index: 6;
    width: 13rem;
    height: 2rem;
    background-color: #F3F2F9;
    border-radius: 2rem;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    column-gap: 0.5rem;
    position: fixed;
    top: 9.5rem;
    padding-left: 1.5rem;
    align-items: center;
}

.youtube i{
    color: #6F4B9B;
    font-size: 1.8rem;
    margin-top: 0.1rem;
    position: relative;
}

.back i{
    color: #6F4B9B;
    font-size: 1.8rem;
    margin-top: 0.1rem;
    position: relative;
}

.homepage i{
    color: #6F4B9B;
    font-size: 1.8rem;
    margin-top: 0.1rem;
    position: relative;
}

.icon-bar:hover .homepage i{
    color: #6F4B9B;
}

.icon-bar:hover{
    background-color: #997EBC;
}

.icon-bar:hover .back:hover i, .youtube:hover i{
    color: white;
    transition: 1s ease-out;
}



a:focus{
    text-shadow: 0 0 10px #EEE2FD;
}

/*******************chat ****************************/
.header-chat{
    display: flex;
    flex-direction: column;
    grid-gap: 1rem;
    position: fixed;
    height: 5rem;
    width: 18.2rem;
    background: #23024D;
    right: 0;
    top: 13rem;
    z-index: 3;
}

.header-chat h1{
    position: relative;
    font-family: Mustica;
    font-size: 2rem;
    color: white;
    margin-top: 0.5rem;
    margin-left: 4.7rem;
}

.header-chat .chat-line{
    position: relative;
    background-color: white;
    width: 100%;
    height: 1rem;
    right: 0;
}

/***********typ message************/

.typing{
    display: flex;
    flex-direction: row;
    position: fixed;
    background: #6F4B9B;
    width: 18.2rem;
    height: 8rem;
    right: 0;
    top: 36rem;
    z-index: 5;
}

.profile{
    position:relative;
    margin: 1rem;
    width: 40px;
    height: 40px;
    border-radius: 5rem;
    background: white;
    justify-content: center;
}

.profile img{
    position: relative;
    object-fit: cover;
    width: 100%; height: 100%;

}



.nameuser {
    display: grid;
    position: relative;
    background-color: #23024D;
    top: 1.2rem;
    height: 2rem;
    padding-left:0.5rem;   
    padding-right:0.5rem;  
    font-size: 1rem;
    color: #e7eaec;
    font-family: Mitn;
    border-radius: 1rem;
    box-sizing: border-box;
    cursor: default;
}

.send-message{
    position: absolute;
    margin: 0.5rem;
    margin-top: 1.2rem;
    right: 1rem;
    width: 2rem;
    height: 2rem;
    font-size: 2rem;
    background-color: #997EBC;
    border: none;
    cursor: pointer;
    border-radius: 0.5rem;
}
.send-message:hover{
    transform: scale(0.9);
    transition: 0.5s ease-in;
    box-shadow: 0 0 10px 0 #23024D;
    background-color: #23024D;
}
.send-message i{
    position: relative;
    color: black;
    transform: rotate(270deg);
    box-sizing: border-box;
}


#bx-send:hover{
    color: white;
    text-underline-position: none;
}

.typ-box-1{
    position: absolute;
    top: 4.5rem;
    left: 1rem;
    width: 16rem;
    height: 2.3rem;
    font-size: 1.5rem;
    font-family: Mitn;
    color: #23024D;
    background: #F8F2FF;
    border: none;
    outline: none;
    border-radius: 0.2rem;
    padding: 0.5rem;
    cursor: pointer;
}

.typ-box-1:focus{
    background: #997EBC;
    transform: scale(1.05);
    font-size: 1.5rem;
}

            .chat{
                background: #412465;
                width: 18.2rem;
                height: 19rem;
                top: 17rem;
                right: 0;
                z-index: 2;
                padding-top: 2rem;
                padding-bottom: 1rem;
                padding-left: 0.5rem;
                position: fixed;
            }

            .show-comment{
                display: flex;
                flex-direction: column;
                grid-gap: 1rem;
                width: 100%;
                position: relative;
                z-index: 2;
            }

            .comment{
                position: relative;
                box-sizing: border-box;
                background: #F8F2FF;
                padding: 0.5rem;
                width: 15rem;
                margin-left: 1rem;
                border-radius: 1rem 1rem 0 1rem;
                font-family: Mitn;
                font-size: 1rem;
            }

            .user-acc{
                display: flex;
                flex-direction: row;
                padding: 0.5rem;
            }

            .profile-up{
                position:relative;
                width: 40px;
                height: 40px;
                border-radius: 5rem;
                background: white;
                justify-content: center;
                margin-right: 1rem;
            }

            .profile-up img{
                position: relative;
                object-fit: cover;
                width: 100%; height: 100%;
            }

            .nameuser-up{
                position: relative;
                font-family: Mitn;
                font-size: 1rem;
                color: white;
                background: #23024D;
                padding-left: 0.5rem;   
                padding-right: 0.5rem;
                margin-top: 0.25rem;
                height: 2rem;
                border-radius: 1rem;
                font-family: Mitn;
            }

            .typ-box-up p{
                word-wrap: break-word;
                width: 14rem; 
            }

            textarea{
                resize: none;
            }

            /**** show model pic *****/
            .catalog{
                display: grid;
                grid-template-rows: 0fr 0fr;
                row-gap: 2rem;
                justify-items: center;
                align-items: center;
                top: 11rem;
                margin-left: 2rem;
                margin-right: 2rem;
                position: absolute;
                padding-top:4rem;
                padding-bottom: 1.5rem;
                width: 69rem;
                min-height: 100vh;
                box-sizing: border-box;
            }
            .video-pic{
                position: relative;
                display: grid;
                grid-template-rows: 0fr 0fr;
                row-gap: 1rem;   
                margin-top: 1rem;
                margin-left: 2.5rem;
                margin-right: 2.5rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 63rem;
            }
            .profile-pic{
                position: relative;
                display: grid;
                grid-template-rows: 0fr 0fr;
                row-gap: 1rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 63rem;
            }

            .item-main{
                display: grid;    
                grid-template-columns: 1fr 1fr 1fr;
                column-gap: 5rem;
                row-gap: 1.5rem;
            }

            .character{
                display: grid;
                grid-template-columns: 0fr 0fr;
                column-gap: 3rem;
                position: relative;
                margin-left: -0.1rem;
                padding-left: 1rem;
                padding-right: 1rem;
                width: 16rem;
                height: 4.5rem;
                background-color: #FFE0FE;
                border-radius: 2rem;
                text-align: center;
            }

            .animation{
                display: grid;
                grid-template-columns: 0fr 0fr;
                column-gap:3rem;
                position: relative;
                margin-left: -0.1rem;
                padding-left: 1rem;
                padding-right: 1rem;
                width: 17rem;
                height: 4.5rem;
                background-color: #E0F4FF;
                border-radius: 2rem;
                text-align: center;
            }

            .character p{
                position: relative;
                margin: 0;
                left: 0;
                color: #23024D;
                font-size: 3rem;
                font-family: Mustica;
                height: 6rem;
            }

            .animation p{
                position: relative;
                margin: 0;
                left: 0;
                color: #23024D;
                font-size: 3rem;
                font-family: Mustica;
                height: 6rem;
            }

            .item-on{
                padding: 2rem;
                position: relative;
                justify-content: center;
                width: 18rem;
                display: grid;
                grid-template-rows: 0fr 0fr;
                row-gap: 2rem;
                text-align: center;
            }

            .item-on:hover{
                background-color: #FBEBFB;
                border-radius: 2rem;
                transition: 2s ease-out;
            }

            .item-on-video{
                padding: 2rem;
                position: relative;
                justify-content: center;
                width: 18rem;
                display: grid;
                grid-template-rows: 0fr 0fr;
                row-gap: 2rem;
                text-align: center;
            }

            .item-on-video:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #EBF4FB;
                border-radius: 2rem;
            }

            .item-on-video:hover .pic-item,  .item-on:hover .pic-item{
                outline: none;
                width: 15rem;
                height: 15rem;
                box-shadow: 0 0 10px 0 #23024D;
                transition: 0.5s ease-in;
            }

            .item-on p{
                position: relative;
            }

            .pic-item{
                position: relative;
                background-color: white;
                width: 15rem;
                height: 15rem;
                border-radius: 100%;
                outline: 0.5rem solid #23024D;
                cursor: pointer;
            }

            .pic-item img{
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 100%;
            }
            .name-item{
                position: relative;
                box-sizing: border-box;
                background: #23024D;
                width:14rem;
                padding: 0.5rem;                
                border-radius: 2.5rem;
                color: white;
                font-family: Mitn;
                font-size: 2rem; 
                justify-content: center;
                left: 0.5rem;
            }
            
            .name-item p{
                position: relative;
                width:13rem;
                word-wrap: break-word;  
            }

            .name-item-video{
                position: relative;
                box-sizing: border-box;
                background: #23024D;
                width:14rem;
                padding: 0.5rem;                
                border-radius: 2.5rem;
                color: white;
                font-family: Mitn;
                font-size: 2rem; 
                justify-content: center;
                left: 0.5rem; 
            }

            .name-title p{
                position: relative;
                width:13rem;
                word-wrap: break-word;             
            }

            .item-on-video:hover .name-item-video{
                background: #E0F4FF;
                color: black;
                border: 0.1rem solid black;
                transition: 0.5s ease-in;
            }
            .item-on:hover  .name-item{
                background: #FFE0FE;
                color: black;
                border: 0.1rem solid black;
                transition: 0.5s ease-in;
            }

/********************* responsive *******************************/
@media screen and (min-width:210px) and (max-width: 250px){

    #chat-talk.notchat{
       display: none;
    }

    .chat-talk {
        display: block;
        position: fixed;
        top: 5rem;
        left: 0rem;
        width: 15rem;
        padding-left: 1.4rem;
    }

    .chat-popup{
        display: visible;
        position: fixed;
        top: 83%;
        background-color: #23024D;
        z-index: 5;
        right: 1rem;
        padding: 0.5rem;
        border-radius: 2rem;
        cursor: pointer;
    }
    .chat-popup i{
        display: block;
        position: relative;
        font-size: 1.5rem;
        color: white;

    }

    .background{
        display: grid;
        grid-template-columns: 0fr;
        grid-template-rows: 0fr 0fr;
        row-gap: 1rem;
}

    .header{
    width: 100%;
    height:5rem;
    position: fixed;

}

.background-header{
    width: 100%;
    height: 5rem;
    margin: 0;
    position: fixed;
}

.background-header img{
    width: 100%; height: 5rem;
}

.header .title-header{
    position: fixed;
    width: 14rem;
    height:2rem;
    top: 3%;
}

.icon-bar{
    position: fixed;
    width: 8rem;
    height: 1.4rem;
    top: 3.15rem;
    padding-left: 0rem;
    justify-items: center;
}

.youtube i{
    font-size: 1.2rem;
}

.back i{
    font-size: 1.2rem;
}

.homepage i{
    font-size: 1.2rem;
}

/*******************chat ****************************/
.header-chat{
    position: relative;
    height: 3rem;
    width: 12rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    text-align: center;
}

.header-chat h1{
    position: absolute;
    font-size: 1.5rem;
    color: white;
    margin-top: 0.1rem;
    margin-left: 2.5rem;
}

.header-chat .chat-line{
    position: absolute;
    background-color: white;
    width: 12rem;
    height: 0.5rem;
    left: 0;
    bottom: 0;
}
/***********typ message************/

.typing{
    position: relative;
    width: 12rem;
    height: 4.5rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    display: grid;
    grid-template-columns: 0fr 0fr 0fr;
    z-index: 0;
}

.profile{
    position: relative;
    margin: 0rem;
    width: 25px;
    height: 25px;
    border-radius: 5rem;
    left: 0.5rem;
    top: 0.5rem;
}

.profile img{
    position: absolute;
    object-fit: cover;
    width: 100%; height: 100%;
}

.nameuser {
    position: relative;
    top: 0rem;
    height: 1.6rem;
    padding-left:0.5rem;   
    padding-right:0.5rem;  
    left: 1rem;
    top: 0.5rem;
}

.nameuser p{  
    position: relative;
    font-size: 0.8rem;

}


.send-message{
    position: absolute;
    margin: 0em;
    margin-top: 0rem;
    width: 1.5rem;
    height: 1.3rem;
    text-align: center;
    top: 0.5rem;
    right: 0.5rem;
}

.send-message i{
    font-size: 1rem;
    position: relative;
    top: -0.75rem;
    color: black;
}



.typ-box-1{
    position: absolute ;
    top: 2.6rem;
    left: 0.5rem;
    width: 11rem;
    height: 1.2rem;
    font-size: 0.7rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}
.typ-box-1 p{
    position: absolute;
    top: 0rem;
    left: 0.5rem;
    width: 9rem;
    height: 1.2rem;
    font-size: 0.7rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}
.typ-box-1:focus{
    font-size: 0.7rem;
}


            .chat{
                background: #412465;
                width: 12em;
                height: 6.45rem;
                top: 0rem;
                left: 0;
                margin-left: 0.2rem;
                z-index: 2;
                padding-top: 1rem;
                padding-bottom: 0.6rem;
                padding-left: 0.2rem;
                position: relative;
            }

            .show-comment{
                display: flex;
                flex-direction: column;
                grid-gap: 1rem;
                width: 100%;
                position: relative;
                z-index: 2;
            }

            .comment{
                position: relative;
                box-sizing: border-box;
                background: #F8F2FF;
                padding: 0.5rem;
                padding-top: 0;
                padding-left: 0;
                width: 9rem;
                margin-left: 0.9rem;
                font-size: 1rem;
            }

            .user-acc{
                display: flex;
                flex-direction: row;
                padding: 0.5rem;
            }

            .profile-up{
                 position: relative;
                 margin: 0rem;
                 width: 25px;
                 height: 25px;
                 border-radius: 5rem;
                 left: 0rem;
                 top: -0.2rem;

            }

            .profile-up img{
                position: absolute;
                object-fit: cover;
                width: 100%; height: 100%;
            }

            .nameuser-up{
                font-size: 0.5rem;
                padding-left: 0.5rem;   
                padding-right: 0.5rem;
                margin-top: 0.25rem;
                border-radius: 1rem;
                font-family: Mitn;
                position: relative;
                height: 1.3rem;
                left: 0.4rem;
                top: -0.3rem;
            }

            .nameuser-up p{  
                position: relative;
                font-size: 0.7rem;
                top: -0.05rem;

            }

            .typ-box-up p{
                position: relative;
                width: 7rem; 
                left: 0.5rem;
                top: -0.5rem;
            }

            textarea{
                resize: none;
            }

            /**** show model pic *****/
            .catalog{
                top: 6.5rem;
                margin-left: 1.5rem;
                margin-right: 0rem;
                position:relative;
                padding:0rem;
                padding-top:0rem;
                padding-bottom: 0rem;
                width: 100%;
                min-height: auto;
                justify-content: start;
                justify-items: center;
            }

            .video-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 12rem;
            }
            .profile-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 12rem;
            }


            .item-main{
                display: grid;    
                grid-template-columns: 1fr;
                column-gap: 1rem;
                row-gap: 1rem;
            }

            .down i{
                
                font-size: 2rem;

            }

            #down-1{
                position: absolute;
                left: 10.5rem; 
            }
            #down-2{
                position: absolute;
                left: 10.5rem;
            }

            .character{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 0rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 10rem;
                height: 3.3rem;
                text-align: center;
                align-items: center;
            }

            .animation{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 0rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 10rem;
                height: 3.3rem;
                align-items: center;
            }

            .character p{
                position: relative;
                margin-top: 0rem;
                left: 1.1rem;
                color: #23024D;
                font-size: 1.5rem;
                font-family: Mustica;
            }

            .animation p{
                position: relative;
                margin-top: 0rem;
                left: 1rem;
                color: #23024D;
                font-size: 1.5rem;
                font-family: Mustica;
    
            }

            .item-on{
                position: relative;
                width: 12rem;  
                left: 0rem;    
            }

            .item-on-video{
                position: relative;
                width: 12rem;
                left: 0rem; 
            }

            .item-on-video:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #EBF4FB;
                border-radius: 2rem;
            }

            .item-on-video:hover .pic-item,  .item-on:hover .pic-item{
                outline: none;
                width: 10rem;
                height: 10rem;
                box-shadow: 0 0 10px 0 #23024D;
                transition: 0.5s ease-in;
            }

            .item-on p{
                position: relative;
            }

            .pic-item{
                position: relative;
                background-color: white;
                width: 10rem;
                height: 10rem;
                border-radius: 100%;
                outline: 0.5rem solid #23024D;
                cursor: pointer;
            }

            .pic-item img{
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 100%;
            }
            .name-item{
                width:7rem;
                padding: 0.5rem;                
                font-size: 1.3rem; 
                left:1.5rem; 
            }
            
            .name-item p{
                position: relative;
                width:6rem;
                word-wrap: break-word;   
            }

            .name-item-video{
                width:7rem;
                padding: 0.5rem;                
                font-size: 1.3rem; 
                left:1.5rem; 
            }

            .name-title p{
                position: relative;
                width:6rem;
                word-wrap: break-word;             
            }

            .item-on-video:hover .name-item-video{
                background: #E0F4FF;
                color: black;
                border: 0.1rem solid black;
                transition: 0.5s ease-in;
            }
            .item-on:hover  .name-item{
                background: #FFE0FE;
                color: black;
                border: 0.1rem solid black;
                transition: 0.5s ease-in;
            }


}

@media screen and (min-width:260px) and (max-width: 300px){
    
    #chat-talk.notchat{
       display: none;
    }

    .chat-talk {
        display: block;
        position: fixed;
        top: 25%;
        left: -0.3rem;
        width: 15rem;
        padding-left: 1.4rem;
    }

    .chat-popup{
        display: visible;
        position: fixed;
        top: 87%;
        background-color: #23024D;
        z-index: 5;
        right: 1rem;
        padding: 0.5rem;
        border-radius: 2rem;
        cursor: pointer;
    }
    .chat-popup i{
        display: block;
        position: relative;
        font-size: 2rem;
        color: white;

    }

    .background{
        display: grid;
        grid-template-columns: 0fr;
        grid-template-rows: 0fr 0fr;
        row-gap: 1rem;

}

    .header{
    width: 100%;
    height:7rem;
    position: fixed;

}

.background-header{
    width: 100%;
    height: 7rem;
    margin: 0;
    position: fixed;
}

.background-header img{
    width: 100%; height: 7rem;
}

.header .title-header{
    position: fixed;
    width: 18rem;
    height:2.8rem;
    top: 3.5%;
}

.icon-bar{
    position: fixed;
    width: 10rem;
    height: 1.4rem;
    top: 4.8rem;
    padding-left: 0rem;
    justify-items: center;
}

.youtube i{
    font-size: 1.2rem;
}

.back i{
    font-size: 1.2rem;
}

.homepage i{
    font-size: 1.2rem;
}

/*******************chat ****************************/
.header-chat{
    position: relative;
    height: 4rem;
    width: 15rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    text-align: center;
}

.header-chat h1{
    position: absolute;
    font-size: 1.5rem;
    color: white;
    margin-top: 0.6rem;
    margin-left: 4.1rem;
}

.header-chat .chat-line{
    position: absolute;
    background-color: white;
    width: 15rem;
    height: 0.5rem;
    left: 0;
    bottom: 0;
}
/***********typ message************/

.typing{
    position: relative;
    width: 15rem;
    height: 4.5rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    display: grid;
    grid-template-columns: 0fr 0fr 0fr;
    z-index: 0;
}

.profile{
    position: relative;
    margin: 0rem;
    width: 25px;
    height: 25px;
    border-radius: 5rem;
    left: 0.5rem;
    top: 0.5rem;
}

.profile img{
    position: absolute;
    object-fit: cover;
    width: 100%; height: 100%;
}

.nameuser {
    position: relative;
    top: 0rem;
    height: 1.6rem;
    padding-left:0.5rem;   
    padding-right:0.5rem;  
    left: 1rem;
    top: 0.5rem;
}

.nameuser p{  
    position: relative;
    font-size: 0.8rem;

}


.send-message{
    position: absolute;
    margin: 0em;
    margin-top: 0rem;
    width: 1.5rem;
    height: 1.3rem;
    text-align: center;
    top: 0.5rem;
    right: 0.5rem;
}

.send-message i{
    font-size: 1rem;
    position: relative;
    top: -0.75rem;
    color: black;
}



.typ-box-1{
    position: absolute ;
    top: 2.6rem;
    left: 0.5rem;
    width: 14rem;
    height: 1.2rem;
    font-size: 0.7rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}
.typ-box-1 p{
    position: absolute;
    top: 0rem;
    left: 0.5rem;
    width: 9rem;
    height: 1.2rem;
    font-size: 0.7rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}
.typ-box-1:focus{
    font-size: 0.7rem;
}


            .chat{
                background: #412465;
                width: 15em;
                height: 16rem;
                top: 0rem;
                left: 0;
                margin-left: 0.2rem;
                z-index: 2;
                padding-top: 1rem;
                padding-bottom: 0.6rem;
                padding-left: 0.2rem;
                position: relative;
            }

            .show-comment{
                display: flex;
                flex-direction: column;
                grid-gap: 1rem;
                width: 100%;
                position: relative;
                z-index: 2;
            }

            .comment{
                position: relative;
                box-sizing: border-box;
                background: #F8F2FF;
                padding: 0.5rem;
                padding-top: 0;
                padding-left: 0;
                width: 11rem;
                margin-left: 0.9rem;
                font-size: 1rem;
            }

            .user-acc{
                display: flex;
                flex-direction: row;
                padding: 0.5rem;
            }

            .profile-up{
                 position: relative;
                 margin: 0rem;
                 width: 25px;
                 height: 25px;
                 border-radius: 5rem;
                 left: 0rem;
                 top: -0.2rem;

            }

            .profile-up img{
                position: absolute;
                object-fit: cover;
                width: 100%; height: 100%;
            }

            .nameuser-up{
                font-size: 0.5rem;
                padding-left: 0.5rem;   
                padding-right: 0.5rem;
                margin-top: 0.25rem;
                border-radius: 1rem;
                font-family: Mitn;
                position: relative;
                height: 1.3rem;
                left: 0.4rem;
                top: -0.3rem;
            }

            .nameuser-up p{  
                position: relative;
                font-size: 0.7rem;
                top: -0.05rem;

            }

            .typ-box-up p{
                position: relative;
                width: 7rem; 
                left: 0.5rem;
                top: -0.5rem;
            }

            textarea{
                resize: none;
            }

            /**** show model pic *****/
            .catalog{
                top: 9rem;
                margin-left: 1.5rem;
                margin-right: 0rem;
                position:relative;
                padding:0rem;
                padding-top:0rem;
                padding-bottom: 0rem;
                width: 100%;
                min-height: auto;
                justify-content: center;
                justify-items: center;
            }

            .video-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0.5rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 12rem;
            }
            .profile-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0.5rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 12rem;
            }


            .item-main{
                display: grid;    
                grid-template-columns: 1fr;
                column-gap: 1rem;
                row-gap: 1rem;
            }

            #down-1:hover{
                background-color: #BEDEF0;
            }

            #down-2:hover{
                background-color: #F0BEEB;
            }

            .down i{
                
                font-size: 2rem;

            }

            #down-1{
                position: absolute;
                left: 10.5rem; 
            }
            #down-2{
                position: absolute;
                left: 10.5rem;
            }

            .character{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 0rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 10rem;
                height: 3.3rem;
                text-align: center;
                align-items: center;
                background-color: #F0BEEB;
            }

            .animation{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 0rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 10rem;
                height: 3.3rem;
                align-items: center;
                background-color: #BEDEF0;
            }

            .character p{
                position: relative;
                margin-top: 0rem;
                left: 1.1rem;
                color: #23024D;
                font-size: 1.5rem;
                font-family: Mustica;
            }

            .animation p{
                position: relative;
                margin-top: 0rem;
                left: 1rem;
                color: #23024D;
                font-size: 1.5rem;
                font-family: Mustica;
    
            }

            .item-on{
                position: relative;
                width: 14rem;  
                left: -1rem;  
            }

            .item-on-video{
                position: relative;
                width: 14em;
                left: -1rem; 
            }

            .item-on:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #F0BEEB;
                border-radius: 2rem;
            }

            .item-on-video:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #BEDEF0;
                border-radius: 2rem;
            }
            

            .item-on-video:hover .pic-item,  .item-on:hover .pic-item{
                outline: none;
                width: 10rem;
                height: 10rem;
                box-shadow: 0 0 10px 0 #23024D;
                transition: 0.5s ease-in;
            }

            .item-on p{
                position: relative;
            }

            .pic-item{
                position: relative;
                background-color: white;
                width: 10rem;
                height: 10rem;
                border-radius: 100%;
                outline: 0.5rem solid #23024D;
                cursor: pointer;
            }

            .pic-item img{
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 100%;
            }
            .name-item{
                width:7rem;
                padding: 0.5rem;                
                font-size: 1.3rem; 
                left:1.5rem; 
            }
            
            .name-item p{
                position: relative;
                width:6rem;
                word-wrap: break-word;   
            }

            .name-item-video{
                width:7rem;
                padding: 0.5rem;                
                font-size: 1.3rem; 
                left:1.5rem; 
            }

            .name-title p{
                position: relative;
                width:6rem;
                word-wrap: break-word;             
            }

            .item-on-video:hover .name-item-video{
                background: #E0F4FF;
                color: black;
                border: 0.1rem solid black;
                transition: 0.5s ease-in;
            }
            .item-on:hover  .name-item{
                background: #FFE0FE;
                color: black;
                border: 0.1rem solid black;
                transition: 0.5s ease-in;
            }


}


@media screen and (min-width:310px) and (max-width: 340px){

    #chat-talk.notchat{
       display: none;
    }

    .chat-talk {
        display: block;
        position: fixed;
        top: 25%;
        left: 0rem;
        width: 15rem;
        padding-left: 1.4rem;
    }

    .chat-popup{
        display: visible;
        position: fixed;
        top: 85%;
        background-color: #23024D;
        z-index: 5;
        right: 1.5rem;
        padding: 0.5rem;
        border-radius: 2rem;
        cursor: pointer;
    }
    .chat-popup i{
        display: block;
        position: relative;
        font-size: 2rem;
        color: white;

    }

    .background{
        display: grid;
        grid-template-columns: 0fr;
        grid-template-rows: 0fr 0fr;
        row-gap: 1rem;

}

    .header{
    width: 100%;
    height:7rem;
    position: fixed;

}

.background-header{
    width: 100%;
    height: 7rem;
    margin: 0;
    position: fixed;
}

.background-header img{
    width: 100%; height: 7rem;
}

.header .title-header{
    position: fixed;
    width: 18rem;
    height:2.8rem;
    top: 3.5%;
}

.icon-bar{
    position: fixed;
    width: 10rem;
    height: 1.4rem;
    top: 4.9rem;
    padding-left: 0rem;
    justify-items: center;
}

.youtube i{
    font-size: 1.2rem;
}

.back i{
    font-size: 1.2rem;
}

.homepage i{
    font-size: 1.2rem;
}

/*******************chat ****************************/
.header-chat{
    position: relative;
    height: 4rem;
    width: 17rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    text-align: center;
}

.header-chat h1{
    position: absolute;
    font-size: 1.5rem;
    color: white;
    margin-top: 0.6rem;
    margin-left: 5rem;
}

.header-chat .chat-line{
    position: absolute;
    background-color: white;
    width:17rem;
    height: 0.5rem;
    left: 0;
    bottom: 0;
}
/***********typ message************/

.typing{
    position: relative;
    width: 17rem;
    height: 4.5rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    display: grid;
    grid-template-columns: 0fr 0fr 0fr;
    z-index: 0;
}

.profile{
    position: relative;
    margin: 0rem;
    width: 25px;
    height: 25px;
    border-radius: 5rem;
    left: 0.5rem;
    top: 0.5rem;
}

.profile img{
    position: absolute;
    object-fit: cover;
    width: 100%; height: 100%;
}

.nameuser {
    position: relative;
    top: 0rem;
    height: 1.6rem;
    padding-left:0.5rem;   
    padding-right:0.5rem;  
    left: 1rem;
    top: 0.5rem;
}

.nameuser p{  
    position: relative;
    font-size: 0.8rem;

}


.send-message{
    position: absolute;
    margin: 0em;
    margin-top: 0rem;
    width: 1.7rem;
    height: 1.5rem;
    text-align: center;
    top: 0.5rem;
    right: 0.5rem;
}

.send-message i{
    font-size: 1rem;
    position: relative;
    top: -0.75rem;
    color: black;
}



.typ-box-1{
    position: absolute ;
    top: 2.6rem;
    left: 1rem;
    width: 15rem;
    height: 1.2rem;
    font-size: 0.7rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}
.typ-box-1 p{
    position: absolute;
    top: 0rem;
    left: 0.5rem;
    width: 9rem;
    height: 1.2rem;
    font-size: 0.7rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}
.typ-box-1:focus{
    font-size: 0.7rem;
}


            .chat{
                background: #412465;
                width: 17em;
                height: 12rem;
                top: 0rem;
                left: 0;
                margin-left: 0.2rem;
                z-index: 2;
                padding-top: 1rem;
                padding-bottom: 0.6rem;
                padding-left: 0.2rem;
                position: relative;
            }

            .show-comment{
                display: flex;
                flex-direction: column;
                grid-gap: 1rem;
                width: 100%;
                position: relative;
                z-index: 2;
            }

            .comment{
                position: relative;
                box-sizing: border-box;
                background: #F8F2FF;
                padding: 0.5rem;
                padding-top: 0;
                padding-left: 0;
                width: 14rem;
                margin-left: 0.9rem;
                font-size: 1rem;
            }

            .user-acc{
                display: flex;
                flex-direction: row;
                padding: 0.5rem;
            }

            .profile-up{
                 position: relative;
                 margin: 0rem;
                 width: 25px;
                 height: 25px;
                 border-radius: 5rem;
                 left: 0rem;
                 top: -0.2rem;

            }

            .profile-up img{
                position: absolute;
                object-fit: cover;
                width: 100%; height: 100%;
            }

            .nameuser-up{
                font-size: 0.5rem;
                padding-left: 0.5rem;   
                padding-right: 0.5rem;
                margin-top: 0.25rem;
                border-radius: 1rem;
                font-family: Mitn;
                position: relative;
                height: 1.3rem;
                left: 0.4rem;
                top: -0.3rem;
            }

            .nameuser-up p{  
                position: relative;
                font-size: 0.7rem;
                top: -0.05rem;

            }

            .typ-box-up p{
                position: relative;
                width: 10rem; 
                left: 0.5rem;
                top: -0.5rem;
            }

            textarea{
                resize: none;
            }

            /**** show model pic *****/
            .catalog{
                top: 9rem;
                margin-left: 2.4rem;
                margin-right: 0rem;
                position:relative;
                padding:0rem;
                padding-top:0rem;
                padding-bottom: 0rem;
                width: 100%;
                min-height: auto;
                justify-content: center;
                justify-items: center;
            }

            .video-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0.5rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 12rem;
            }
            .profile-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0.5rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 12rem;
            }


            .item-main{
                display: grid;    
                grid-template-columns: 1fr;
                column-gap: 1rem;
                row-gap: 1rem;
            }

            #down-1:hover{
                background-color: #BEDEF0;
            }

            #down-2:hover{
                background-color: #F0BEEB;
            }

            .down i{
                
                font-size: 2rem;

            }

            #down-1{
                position: absolute;
                left: 10.5rem; 
            }
            #down-2{
                position: absolute;
                left: 10.5rem;
            }

            .character{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 0rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 10rem;
                height: 3.3rem;
                text-align: center;
                align-items: center;
                background-color: #F0BEEB;
            }

            .animation{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 0rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 10rem;
                height: 3.3rem;
                align-items: center;
                background-color: #BEDEF0;
            }

            .character p{
                position: relative;
                margin-top: 0rem;
                left: 1.1rem;
                color: #23024D;
                font-size: 1.5rem;
                font-family: Mustica;
            }

            .animation p{
                position: relative;
                margin-top: 0rem;
                left: 1rem;
                color: #23024D;
                font-size: 1.5rem;
                font-family: Mustica;
    
            }

            .item-on{
                position: relative;
                width: 14rem;  
                left: -1.1rem;  
            }

            .item-on-video{
                position: relative;
                width: 14rem;
                left: -1.1rem; 
            }

            .item-on:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #F0BEEB;
                border-radius: 2rem;
            }

            .item-on-video:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #BEDEF0;
                border-radius: 2rem;
            }
            

            .item-on-video:hover .pic-item,  .item-on:hover .pic-item{
                outline: none;
                width: 10rem;
                height: 10rem;
                box-shadow: 0 0 10px 0 #23024D;
                transition: 0.5s ease-in;
            }

            .item-on p{
                position: relative;
            }

            .pic-item{
                position: relative;
                background-color: white;
                width: 10rem;
                height: 10rem;
                border-radius: 100%;
                outline: 0.5rem solid #23024D;
                cursor: pointer;
            }

            .pic-item img{
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 100%;
            }
            .name-item{
                width:7rem;
                padding: 0.5rem;                
                font-size: 1.3rem; 
                left:1.5rem; 
            }
            
            .name-item p{
                position: relative;
                width:6rem;
                word-wrap: break-word;   
            }

            .name-item-video{
                width:7rem;
                padding: 0.5rem;                
                font-size: 1.3rem; 
                left:1.5rem; 
            }

            .name-title p{
                position: relative;
                width:6rem;
                word-wrap: break-word;             
            }

            .item-on-video:hover .name-item-video{
                background: #E0F4FF;
                color: black;
                border: 0.1rem solid black;
                transition: 0.5s ease-in;
            }
            .item-on:hover  .name-item{
                background: #FFE0FE;
                color: black;
                border: 0.1rem solid black;
                transition: 0.5s ease-in;
            }

}

@media screen and (min-width:341px) and (max-width: 370px){

    #chat-talk.notchat{
       display: none;
    }

    .chat-talk {
        display: block;
        position: fixed;
        top: 25%;
        left: 0rem;
        width: 15rem;
        padding-left: 1.8rem;
    }

    .chat-popup{
        display: visible;
        position: fixed;
        top: 88%;
        background-color: #23024D;
        z-index: 5;
        right: 1.5rem;
        padding: 0.5rem;
        border-radius: 2rem;
        cursor: pointer;
    }
    .chat-popup i{
        display: block;
        position: relative;
        font-size: 2rem;
        color: white;

    }

    .background{
        display: grid;
        grid-template-columns: 0fr;
        grid-template-rows: 0fr 0fr;
        row-gap: 1rem;

}

    .header{
    width: 100%;
    height:7rem;
    position: fixed;

}

.background-header{
    width: 100%;
    height: 7rem;
    margin: 0;
    position: fixed;
}

.background-header img{
    width: 100%; height: 7rem;
}

.header .title-header{
    position: fixed;
    width: 18rem;
    height:2.8rem;
    top: 3.5%;
}

.icon-bar{
    position: fixed;
    width: 10rem;
    height: 1.4rem;
    top: 4.9rem;
    padding-left: 0rem;
    justify-items: center;
}

.youtube i{
    font-size: 1.2rem;
}

.back i{
    font-size: 1.2rem;
}

.homepage i{
    font-size: 1.2rem;
}

/*******************chat ****************************/
.header-chat{
    position: relative;
    height: 5rem;
    width: 18rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    text-align: center;
}

.header-chat h1{
    position: absolute;
    font-size: 2rem;
    color: white;
    margin-top: 0.6rem;
    margin-left: 4.2rem;
}

.header-chat .chat-line{
    position: absolute;
    background-color: white;
    width:18rem;
    height: 0.5rem;
    left: 0;
    bottom: 0;
}
/***********typ message************/

.typing{
    position: relative;
    width: 18rem;
    height: 6rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    display: grid;
    grid-template-columns: 0fr 0fr 0fr;
    z-index: 0;
}

.profile{
    position: relative;
    margin: 0rem;
    width: 30px;
    height: 30px;
    border-radius: 5rem;
    left: 0.8rem;
    top: 0.9rem;
}

.profile img{
    position: absolute;
    object-fit: cover;
    width: 100%; height: 100%;
}

.nameuser {
    position: relative;
    height: 2rem;
    padding-left:0.5rem;   
    padding-right:0.5rem;  
    left: 1.6rem;
    top: 0.8rem;
}

.nameuser p{  
    position: relative;
    font-size: 1rem;

}


.send-message{
    position: absolute;
    margin: 0em;
    margin-top: 0rem;
    width: 2rem;
    height: 2rem;
    text-align: center;
    top: 0.8rem;
    right: 0.8rem;
}

.send-message i{
    font-size: 1.5rem;
    position: relative;
    top: -0.2rem;
    color: black;
}



.typ-box-1{
    position: absolute ;
    top: 3.6rem;
    left: 1rem;
    width: 16rem;
    height: 1.5rem;
    font-size: 0.7rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}
.typ-box-1 p{
    position: absolute;
    top: 0rem;
    left: 0.5rem;
    width: 10rem;
    height: 1.2rem;
    font-size: 1rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}
.typ-box-1:focus{
    font-size: 0.7rem;
}


            .chat{
                background: #412465;
                width: 18em;
                height: 15rem;
                top: 0rem;
                left: 0;
                margin-left: 0.2rem;
                z-index: 2;
                padding-top: 1rem;
                padding-bottom: 1rem;
                padding-left: 0.2rem;
                position: relative;
            }

            .show-comment{
                display: flex;
                flex-direction: column;
                grid-gap: 1rem;
                width: 100%;
                position: relative;
                z-index: 2;
            }

            .comment{
                position: relative;
                box-sizing: border-box;
                background: #F8F2FF;
                padding: 0.5rem;
                padding-top: 0;
                padding-left: 0;
                width: 14rem;
                margin-left: 1.5rem;
                font-size: 1.3rem;
            }

            .user-acc{
                display: flex;
                flex-direction: row;
                padding: 0.5rem;
            }

            .profile-up{
                 position: relative;
                 margin: 0rem;
                 width: 25px;
                 height: 25px;
                 border-radius: 5rem;
                 left: 0rem;
                 top: -0.2rem;

            }

            .profile-up img{
                position: absolute;
                object-fit: cover;
                width: 100%; height: 100%;
            }

            .nameuser-up{
                font-size: 0.5rem;
                padding-left: 0.5rem;   
                padding-right: 0.5rem;
                margin-top: 0.25rem;
                border-radius: 1rem;
                font-family: Mitn;
                position: relative;
                height: 1.3rem;
                left: 0.4rem;
                top: -0.3rem;
            }

            .nameuser-up p{  
                position: relative;
                font-size: 0.7rem;
                top: -0.05rem;

            }

            .typ-box-up p{
                position: relative;
                width: 10rem; 
                left: 0.5rem;
                top: -0.5rem;
            }

            textarea{
                resize: none;
            }

            /**** show model pic *****/
            .catalog{
                top: 9rem;
                margin-left: 2.2rem;
                margin-right: 0rem;
                position:relative;
                padding:0rem;
                padding-top:0rem;
                padding-bottom: 0rem;
                width: 100%;
                min-height: auto;
                justify-content: center;
                justify-items: center;
            }

            .video-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0.5rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 12rem;
            }
            .profile-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0.5rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 12rem;
            }


            .item-main{
                display: grid;    
                grid-template-columns: 1fr;
                column-gap: 1rem;
                row-gap: 1rem;
            }

            #down-1:hover{
                background-color: #BEDEF0;
            }

            #down-2:hover{
                background-color: #F0BEEB;
            }

            .down i{
                
                font-size: 2rem;

            }

            #down-1{
                position: absolute;
                left: 13rem; 
            }
            #down-2{
                position: absolute;
                left: 13rem;
            }

            .character{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 0rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 11.5rem;
                height: 3.3rem;
                text-align: center;
                align-items: center;
                background-color: #F0BEEB;
            }

            .animation{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 0rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 12rem;
                height: 3.3rem;
                align-items: center;
                background-color: #BEDEF0;
            }

            .character p{
                position: relative;
                margin-top: -0.4rem;
                left: 0.6rem;
                color: #23024D;
                font-size: 2rem;
                font-family: Mustica;
            }

            .animation p{
                position: relative;
                margin-top: -0.4rem;
                left: 0.8rem;
                color: #23024D;
                font-size: 2rem;
                font-family: Mustica;
    
            }

            .item-on{
                position: relative;
                width: 14rem;  
                left: 0.2rem;  
            }

            .item-on-video{
                position: relative;
                width: 14rem;
                left: 0.2rem; 
            }

            .item-on:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #F0BEEB;
                border-radius: 2rem;
            }

            .item-on-video:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #BEDEF0;
                border-radius: 2rem;
            }
            

            .item-on-video:hover .pic-item,  .item-on:hover .pic-item{
                outline: none;
                width: 10rem;
                height: 10rem;
                box-shadow: 0 0 10px 0 #23024D;
                transition: 0.5s ease-in;
            }

            .item-on p{
                position: relative;
            }

            .pic-item{
                position: relative;
                background-color: white;
                width: 10rem;
                height: 10rem;
                border-radius: 100%;
                outline: 0.5rem solid #23024D;
                cursor: pointer;
            }

            .pic-item img{
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 100%;
            }
            .name-item{
                width:7rem;
                padding: 0.5rem;                
                font-size: 1.3rem; 
                left:1.5rem; 
            }
            
            .name-item p{
                position: relative;
                width:6rem;
                word-wrap: break-word;   
            }

            .name-item-video{
                width:7rem;
                padding: 0.5rem;                
                font-size: 1.3rem; 
                left:1.5rem; 
            }

            .name-title p{
                position: relative;
                width:6rem;
                word-wrap: break-word;             
            }

            .item-on-video:hover .name-item-video{
                background: #E0F4FF;
                color: black;
                border: 0.1rem solid black;
                transition: 0.5s ease-in;
            }
            .item-on:hover  .name-item{
                background: #FFE0FE;
                color: black;
                border: 0.1rem solid black;
                transition: 0.5s ease-in;
            }


}



@media screen and (min-width:371px) and (max-width: 389px){
    #chat-talk.notchat{
       display: none;
    }

    .chat-talk {
        display: block;
        position: fixed;
        top: 25%;
        left: 0rem;
        width: 15rem;
        padding-left: 2.6rem;
    }

    .chat-popup{
        display: visible;
        position: fixed;
        top: 88%;
        background-color: #23024D;
        z-index: 5;
        right: 1.5rem;
        padding: 0.5rem;
        border-radius: 2rem;
        cursor: pointer;
    }
    .chat-popup i{
        display: block;
        position: relative;
        font-size: 2rem;
        color: white;

    }

    .background{
        display: grid;
        grid-template-columns: 0fr;
        grid-template-rows: 0fr 0fr;
        row-gap: 1rem;

}

    .header{
    width: 100%;
    height:7rem;
    position: fixed;

}

.background-header{
    width: 100%;
    height: 7rem;
    margin: 0;
    position: fixed;
}

.background-header img{
    width: 100%; height: 7rem;
}

.header .title-header{
    position: fixed;
    width: 18rem;
    height:2.8rem;
    top: 3.5%;
}

.icon-bar{
    position: fixed;
    width: 10rem;
    height: 1.4rem;
    top: 4.9rem;
    padding-left: 0rem;
    justify-items: center;
}

.youtube i{
    font-size: 1.2rem;
}

.back i{
    font-size: 1.2rem;
}

.homepage i{
    font-size: 1.2rem;
}

/*******************chat ****************************/
.header-chat{
    position: relative;
    height: 5rem;
    width: 18rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    text-align: center;
}

.header-chat h1{
    position: absolute;
    font-size: 2rem;
    color: white;
    margin-top: 0.6rem;
    margin-left: 4.2rem;
}

.header-chat .chat-line{
    position: absolute;
    background-color: white;
    width:18rem;
    height: 0.5rem;
    left: 0;
    bottom: 0;
}
/***********typ message************/

.typing{
    position: relative;
    width: 18rem;
    height: 6rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    display: grid;
    grid-template-columns: 0fr 0fr 0fr;
    z-index: 0;
}

.profile{
    position: relative;
    margin: 0rem;
    width: 30px;
    height: 30px;
    border-radius: 5rem;
    left: 0.8rem;
    top: 0.9rem;
}

.profile img{
    position: absolute;
    object-fit: cover;
    width: 100%; height: 100%;
}

.nameuser {
    position: relative;
    height: 2rem;
    padding-left:0.5rem;   
    padding-right:0.5rem;  
    left: 1.6rem;
    top: 0.8rem;
}

.nameuser p{  
    position: relative;
    font-size: 1rem;

}


.send-message{
    position: absolute;
    margin: 0em;
    margin-top: 0rem;
    width: 2rem;
    height: 2rem;
    text-align: center;
    top: 0.8rem;
    right: 0.8rem;
}

.send-message i{
    font-size: 1.5rem;
    position: relative;
    top: -0.2rem;
    color: black;
}



.typ-box-1{
    position: absolute ;
    top: 3.6rem;
    left: 1rem;
    width: 16rem;
    height: 1.5rem;
    font-size: 0.7rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}
.typ-box-1 p{
    position: absolute;
    top: 0rem;
    left: 0.5rem;
    width: 10rem;
    height: 1.2rem;
    font-size: 1rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}
.typ-box-1:focus{
    font-size: 0.7rem;
}


            .chat{
                background: #412465;
                width: 18em;
                height: 15rem;
                top: 0rem;
                left: 0;
                margin-left: 0.2rem;
                z-index: 2;
                padding-top: 1rem;
                padding-bottom: 1rem;
                padding-left: 0.2rem;
                position: relative;
            }

            .show-comment{
                display: flex;
                flex-direction: column;
                grid-gap: 1rem;
                width: 100%;
                position: relative;
                z-index: 2;
            }

            .comment{
                position: relative;
                box-sizing: border-box;
                background: #F8F2FF;
                padding: 0.5rem;
                padding-top: 0;
                padding-left: 0;
                width: 14rem;
                margin-left: 1.5rem;
                font-size: 1.3rem;
            }

            .user-acc{
                display: flex;
                flex-direction: row;
                padding: 0.5rem;
            }

            .profile-up{
                 position: relative;
                 margin: 0rem;
                 width: 30px;
                 height: 30px;
                 border-radius: 5rem;
                 left: 0.2rem;
                 top: 0rem;

            }

            .profile-up img{
                position: absolute;
                object-fit: cover;
                width: 100%; height: 100%;
            }

            .nameuser-up{
                font-size: 0.5rem;
                padding-left: 0.5rem;   
                padding-right: 0.5rem;
                margin-top: 0.25rem;
                border-radius: 1rem;
                font-family: Mitn;
                position: relative;
                height:1.8rem;
                left: 0.8rem;
                top: -0.2rem;
            }

            .nameuser-up p{  
                position: relative;
                font-size: 1rem;
                top: -0.1rem;

            }

            .typ-box-up p{
                position: relative;
                width: 12rem; 
                left: 0.8rem;
                top: -0.5rem;
            }

            textarea{
                resize: none;
            }

            /**** show model pic *****/
            .catalog{
                top: 9rem;
                margin-left: 2.5rem;
                margin-right: 0rem;
                position:relative;
                padding:0rem;
                padding-top:0rem;
                padding-bottom: 0rem;
                width: 100%;
                min-height: auto;
                justify-content: center;
                justify-items: center;
            }

            .video-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0.5rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 12rem;
            }
            .profile-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0.5rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 12rem;
            }


            .item-main{
                display: grid;    
                grid-template-columns: 1fr;
                column-gap: 1rem;
                row-gap: 1rem;
            }

            #down-1:hover{
                background-color: #BEDEF0;
            }

            #down-2:hover{
                background-color: #F0BEEB;
            }

            .down i{
                
                font-size: 2rem;

            }

            #down-1{
                position: absolute;
                left: 13rem; 
            }
            #down-2{
                position: absolute;
                left: 13rem;
            }

            .character{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 0rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 12rem;
                height: 3.5rem;
                text-align: center;
                align-items: center;
                background-color: #F0BEEB;
            }

            .animation{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 0rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 12.5rem;
                height: 3.5rem;
                align-items: center;
                background-color: #BEDEF0;
            }

            .character p{
                position: relative;
                margin-top: -0.4rem;
                left: 0.6rem;
                color: #23024D;
                font-size: 2.2rem;
                font-family: Mustica;
            }

            .animation p{
                position: relative;
                margin-top: -0.4rem;
                left: 0.8rem;
                color: #23024D;
                font-size: 2rem;
                font-family: Mustica;
    
            }

            .item-on{
                position: relative;
                width: 14rem;  
                left: 0.5em;  
            }

            .item-on-video{
                position: relative;
                width: 14rem;
                left: 0.5rem; 
            }

            .item-on:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #F0BEEB;
                border-radius: 2rem;
            }

            .item-on-video:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #BEDEF0;
                border-radius: 2rem;
            }
            

            .item-on-video:hover .pic-item,  .item-on:hover .pic-item{
                outline: none;
                width: 10rem;
                height: 10rem;
                box-shadow: 0 0 10px 0 #23024D;
                transition: 0.5s ease-in;
            }

            .item-on p{
                position: relative;
            }

            .pic-item{
                position: relative;
                background-color: white;
                width: 10rem;
                height: 10rem;
                border-radius: 100%;
                outline: 0.5rem solid #23024D;
                cursor: pointer;
            }

            .pic-item img{
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 100%;
            }
            .name-item{
                width:7rem;
                padding: 0.5rem;                
                font-size: 1.3rem; 
                left:1.5rem; 
            }
            
            .name-item p{
                position: relative;
                width:6rem;
                word-wrap: break-word;   
            }

            .name-item-video{
                width:7rem;
                padding: 0.5rem;                
                font-size: 1.3rem; 
                left:1.5rem; 
            }

            .name-title p{
                position: relative;
                width:6rem;
                word-wrap: break-word;             
            }

            .item-on-video:hover .name-item-video{
                background: #E0F4FF;
                color: black;
                border: 0.1rem solid black;
                transition: 0.5s ease-in;
            }
            .item-on:hover  .name-item{
                background: #FFE0FE;
                color: black;
                border: 0.1rem solid black;
                transition: 0.5s ease-in;
            }

}

@media screen and (min-width:390px) and (max-width: 420px){
    #chat-talk.notchat{
       display: none;
    }

    .chat-talk {
        display: block;
        position: fixed;
        top: 25%;
        left: 0rem;
        width: 15rem;
        padding-left: 2.3rem;
    }

    .chat-popup{
        display: visible;
        position: fixed;
        top: 88%;
        background-color: #23024D;
        z-index: 5;
        right: 1.5rem;
        padding: 0.5rem;
        border-radius: 2rem;
        cursor: pointer;
    }
    .chat-popup i{
        display: block;
        position: relative;
        font-size: 2rem;
        color: white;

    }

    .background{
        display: grid;
        grid-template-columns: 0fr;
        grid-template-rows: 0fr 0fr;
        row-gap: 1rem;

}

    .header{
    width: 100%;
    height:9rem;
    position: fixed;

}

.background-header{
    width: 100%;
    height: 9rem;
    margin: 0;
    position: fixed;
}

.background-header img{
    width: 100%; height: 9rem;
}

.header .title-header{
    position: fixed;
    width: 20rem;
    height:3.2rem;
    top: 3.5%;
}

.icon-bar{
    position: fixed;
    width: 12rem;
    height: 1.9rem;
    top:6rem;
    padding-left: 0rem;
    justify-items: center;
}

.youtube i{
    font-size: 1.7rem;
}

.back i{
    font-size: 1.7rem;
}

.homepage i{
    font-size: 1.7rem;
}

/*******************chat ****************************/
.header-chat{
    position: relative;
    height: 5rem;
    width: 20rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    text-align: center;
}

.header-chat h1{
    position: absolute;
    font-size: 2.2rem;
    color: white;
    margin-top: 0.6rem;
    margin-left: 4.6rem;
}

.header-chat .chat-line{
    position: absolute;
    background-color: white;
    width:20rem;
    height: 0.5rem;
    left: 0;
    bottom: 0;
}
/***********typ message************/

.typing{
    position: relative;
    width: 20rem;
    height: 8rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    display: grid;
    grid-template-columns: 0fr 0fr 0fr;
    z-index: 0;
}

.profile{
    position: relative;
    margin: 0rem;
    width: 40px;
    height: 40px;
    border-radius: 5rem;
    left: 1rem;
    top: 0.8rem;
}

.profile img{
    position: absolute;
    object-fit: cover;
    width: 100%; height: 100%;
}

.nameuser {
    position: relative;
    height: 2.5rem;
    padding-left:0.5rem;   
    padding-right:0.5rem;  
    left: 1.9rem;
    top: 0.8rem;
}

.nameuser p{  
    position: relative;
    font-size: 1.2rem;

}


.send-message{
    position: absolute;
    margin: 0em;
    margin-top: 0rem;
    width: 2.6rem;
    height: 2.6rem;
    text-align: center;
    top: 0.8rem;
    right: 1rem;
}

.send-message i{
    font-size: 1.8rem;
    position: relative;
    top: 0rem;
    color: black;
}



.typ-box-1{
    position: absolute ;
    top: 4.2rem;
    left: 1rem;
    width: 18rem;
    height: 2rem;
    font-size: 0.7rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}
.typ-box-1 p{
    position: absolute;
    top: 0rem;
    left: 0.5rem;
    width: 10rem;
    height: 1.2rem;
    font-size: 1rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}
.typ-box-1:focus{
    font-size: 0.7rem;
}


            .chat{
                background: #412465;
                width: 20em;
                height: 15rem;
                top: 0rem;
                left: 0;
                margin-left: 0.2rem;
                z-index: 2;
                padding-top: 1rem;
                padding-bottom: 1rem;
                padding-left: 0.2rem;
                position: relative;
            }

            .show-comment{
                display: flex;
                flex-direction: column;
                grid-gap: 1rem;
                width: 100%;
                position: relative;
                z-index: 2;
            }

            .comment{
                position: relative;
                box-sizing: border-box;
                background: #F8F2FF;
                padding: 0.5rem;
                padding-top: 0;
                padding-left: 0;
                width: 15rem;
                margin-left: 2.1rem;
                font-size: 1.3rem;
            }

            .user-acc{
                display: flex;
                flex-direction: row;
                padding: 0.5rem;
            }

            .profile-up{
                 position: relative;
                 margin: 0rem;
                 width: 30px;
                 height: 30px;
                 border-radius: 5rem;
                 left: 0.2rem;
                 top: 0rem;

            }

            .profile-up img{
                position: absolute;
                object-fit: cover;
                width: 100%; height: 100%;
            }

            .nameuser-up{
                font-size: 0.5rem;
                padding-left: 0.5rem;   
                padding-right: 0.5rem;
                margin-top: 0.25rem;
                border-radius: 1rem;
                font-family: Mitn;
                position: relative;
                height:1.8rem;
                left: 0.8rem;
                top: -0.2rem;
            }

            .nameuser-up p{  
                position: relative;
                font-size: 1rem;
                top: -0.1rem;

            }

            .typ-box-up p{
                position: relative;
                width: 12rem; 
                left: 0.8rem;
                top: -0.5rem;
            }

            textarea{
                resize: none;
            }

            /**** show model pic *****/
            .catalog{
                top: 12rem;
                margin-left: 2.9rem;
                margin-right: 0rem;
                position:relative;
                padding:0rem;
                padding-top:0rem;
                padding-bottom: 0rem;
                width: 100%;
                min-height: auto;
                justify-content: center;
                justify-items: center;
            }

            .video-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0.5rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 12rem;
            }
            .profile-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0.5rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 12rem;
            }


            .item-main{
                display: grid;    
                grid-template-columns: 1fr;
                column-gap: 1rem;
                row-gap: 1rem;
            }

            #down-1:hover{
                background-color: #BEDEF0;
            }

            #down-2:hover{
                background-color: #F0BEEB;
            }

            .down i{
                
                font-size: 2rem;

            }

            #down-1{
                position: absolute;
                left: 13rem; 
            }
            #down-2{
                position: absolute;
                left: 13rem;
            }

            .character{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 0rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 12rem;
                height: 3.5rem;
                text-align: center;
                align-items: center;
                background-color: #F0BEEB;
            }

            .animation{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 0rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 12.5rem;
                height: 3.5rem;
                align-items: center;
                background-color: #BEDEF0;
            }

            .character p{
                position: relative;
                margin-top: -0.4rem;
                left: 0.6rem;
                color: #23024D;
                font-size: 2.2rem;
                font-family: Mustica;
            }

            .animation p{
                position: relative;
                margin-top: -0.4rem;
                left: 0.8rem;
                color: #23024D;
                font-size: 2rem;
                font-family: Mustica;
    
            }

            .item-on{
                position: relative;
                width: 14rem;  
                left: 0.5em;  
            }

            .item-on-video{
                position: relative;
                width: 14rem;
                left: 0.5rem; 
            }

            .item-on:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #F0BEEB;
                border-radius: 2rem;
            }

            .item-on-video:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #BEDEF0;
                border-radius: 2rem;
            }
            

            .item-on-video:hover .pic-item,  .item-on:hover .pic-item{
                outline: none;
                width: 10rem;
                height: 10rem;
                box-shadow: 0 0 10px 0 #23024D;
                transition: 0.5s ease-in;
            }

            .item-on p{
                position: relative;
            }

            .pic-item{
                position: relative;
                background-color: white;
                width: 10rem;
                height: 10rem;
                border-radius: 100%;
                outline: 0.5rem solid #23024D;
                cursor: pointer;
            }

            .pic-item img{
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 100%;
            }
            .name-item{
                width:7rem;
                padding: 0.5rem;                
                font-size: 1.3rem; 
                left:1.5rem; 
            }
            
            .name-item p{
                position: relative;
                width:6rem;
                word-wrap: break-word;   
            }

            .name-item-video{
                width:7rem;
                padding: 0.5rem;                
                font-size: 1.3rem; 
                left:1.5rem; 
            }

            .name-title p{
                position: relative;
                width:6rem;
                word-wrap: break-word;             
            }

            .item-on-video:hover .name-item-video{
                background: #E0F4FF;
                color: black;
                border: 0.1rem solid black;
                transition: 0.5s ease-in;
            }
            .item-on:hover  .name-item{
                background: #FFE0FE;
                color: black;
                border: 0.1rem solid black;
                transition: 0.5s ease-in;
            }


}

@media screen and (min-width:480px) and (max-width: 540px){
    #chat-talk.notchat{
       display: none;
    }

    .chat-talk {
        display: block;
        position: fixed;
        top: 25%;
        left: 0rem;
        width: 15rem;
        padding-left: 3.8rem;
    }

    .chat-popup{
        display: visible;
        position: fixed;
        top: 88%;
        background-color: #23024D;
        z-index: 5;
        right: 1.5rem;
        padding: 0.5rem;
        border-radius: 2rem;
        cursor: pointer;
    }
    .chat-popup i{
        display: block;
        position: relative;
        font-size: 2rem;
        color: white;

    }

    .background{
        display: grid;
        grid-template-columns: 0fr;
        grid-template-rows: 0fr 0fr;
        row-gap: 1rem;

}

    .header{
    width: 100%;
    height:9rem;
    position: fixed;

}

.background-header{
    width: 100%;
    height: 9rem;
    margin: 0;
    position: fixed;
}

.background-header img{
    width: 100%; height: 9rem;
}

.header .title-header{
    position: fixed;
    width: 20rem;
    height:3.2rem;
    top: 3.5%;
}

.icon-bar{
    position: fixed;
    width: 12rem;
    height: 1.9rem;
    top:6rem;
    padding-left: 0rem;
    justify-items: center;
}

.youtube i{
    font-size: 1.7rem;
}

.back i{
    font-size: 1.7rem;
}

.homepage i{
    font-size: 1.7rem;
}

/*******************chat ****************************/
.header-chat{
    position: relative;
    height: 5rem;
    width: 22rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    text-align: center;
}

.header-chat h1{
    position: absolute;
    font-size: 2.2rem;
    color: white;
    margin-top: 0.6rem;
    margin-left: 5.5rem;
}

.header-chat .chat-line{
    position: absolute;
    background-color: white;
    width:22rem;
    height: 0.5rem;
    left: 0;
    bottom: 0;
}
/***********typ message************/

.typing{
    position: relative;
    width: 22rem;
    height: 8rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    display: grid;
    grid-template-columns: 0fr 0fr 0fr;
    z-index: 0;
}

.profile{
    position: relative;
    margin: 0rem;
    width: 40px;
    height: 40px;
    border-radius: 5rem;
    left: 1rem;
    top: 0.8rem;
}

.profile img{
    position: absolute;
    object-fit: cover;
    width: 100%; height: 100%;
}

.nameuser {
    position: relative;
    height: 2.5rem;
    padding-left:0.5rem;   
    padding-right:0.5rem;  
    left: 1.9rem;
    top: 0.8rem;
}

.nameuser p{  
    position: relative;
    font-size: 1.2rem;

}


.send-message{
    position: absolute;
    margin: 0em;
    margin-top: 0rem;
    width: 2.6rem;
    height: 2.6rem;
    text-align: center;
    top: 0.8rem;
    right: 1rem;
}

.send-message i{
    font-size: 1.8rem;
    position: relative;
    top: 0rem;
    color: black;
}



.typ-box-1{
    position: absolute ;
    top: 4.2rem;
    left: 1rem;
    width: 19rem;
    height: 2rem;
    font-size: 0.7rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}
.typ-box-1 p{
    position: absolute;
    top: 0rem;
    left: 0.5rem;
    width: 10rem;
    height: 1.2rem;
    font-size: 1rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}
.typ-box-1:focus{
    font-size: 0.7rem;
}


            .chat{
                background: #412465;
                width: 22em;
                height: 18rem;
                top: 0rem;
                left: 0;
                margin-left: 0.2rem;
                z-index: 2;
                padding-top: 1rem;
                padding-bottom: 1rem;
                padding-left: 0.2rem;
                position: relative;
            }

            .show-comment{
                display: flex;
                flex-direction: column;
                grid-gap: 1rem;
                width: 100%;
                position: relative;
                z-index: 2;
            }

            .comment{
                position: relative;
                box-sizing: border-box;
                background: #F8F2FF;
                padding: 0.5rem;
                padding-top: 0;
                padding-left: 0;
                width: 15rem;
                margin-left: 2.1rem;
                font-size: 1.3rem;
            }

            .user-acc{
                display: flex;
                flex-direction: row;
                padding: 0.5rem;
            }

            .profile-up{
                 position: relative;
                 margin: 0rem;
                 width: 30px;
                 height: 30px;
                 border-radius: 5rem;
                 left: 0.2rem;
                 top: 0rem;

            }

            .profile-up img{
                position: absolute;
                object-fit: cover;
                width: 100%; height: 100%;
            }

            .nameuser-up{
                font-size: 0.5rem;
                padding-left: 0.5rem;   
                padding-right: 0.5rem;
                margin-top: 0.25rem;
                border-radius: 1rem;
                font-family: Mitn;
                position: relative;
                height:1.8rem;
                left: 0.8rem;
                top: -0.2rem;
            }

            .nameuser-up p{  
                position: relative;
                font-size: 1rem;
                top: -0.1rem;

            }

            .typ-box-up p{
                position: relative;
                width: 12rem; 
                left: 0.8rem;
                top: -0.5rem;
            }

            textarea{
                resize: none;
            }

            /**** show model pic *****/
            .catalog{
                top: 12rem;
                margin-left: 4rem;
                margin-right: 0rem;
                position:relative;
                padding:0rem;
                padding-top:0rem;
                padding-bottom: 0rem;
                width: 100%;
                min-height: auto;
                justify-content: center;
                justify-items: center;
            }

            .video-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0.5rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 12rem;
            }
            .profile-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0.5rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 12rem;
            }


            .item-main{
                display: grid;    
                grid-template-columns: 1fr;
                column-gap: 1rem;
                row-gap: 1rem;
            }

            #down-1:hover{
                background-color: #BEDEF0;
            }

            #down-2:hover{
                background-color: #F0BEEB;
            }

            .down i{
                
                font-size: 2.5rem;

            }

            #down-1{
                position: absolute;
                left: 16rem; 
            }
            #down-2{
                position: absolute;
                left: 15.8rem;
            }

            .character{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 0rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 14rem;
                height: 4rem;
                text-align: center;
                align-items: center;
                background-color: #F0BEEB;
            }

            .animation{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 0rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 14.5rem;
                height: 4rem;
                align-items: center;
                background-color: #BEDEF0;
            }

            .character p{
                position: relative;
                margin-top: -0.4rem;
                left: 0.6rem;
                color: #23024D;
                font-size: 2.5rem;
                font-family: Mustica;
            }

            .animation p{
                position: relative;
                margin-top: -0.5rem;
                left: 0.8rem;
                color: #23024D;
                font-size: 2.5rem;
                font-family: Mustica;
    
            }

            .item-on{
                position: relative;
                width: 14rem;  
                left: 1rem;  
            }

            .item-on-video{
                position: relative;
                width: 14rem;
                left: 1rem; 
            }

            .item-on:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #F0BEEB;
                border-radius: 2rem;
            }

            .item-on-video:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #BEDEF0;
                border-radius: 2rem;
            }
            

            .item-on-video:hover .pic-item,  .item-on:hover .pic-item{
                outline: none;
                width: 10rem;
                height: 10rem;
                box-shadow: 0 0 10px 0 #23024D;
                transition: 0.5s ease-in;
            }

            .item-on p{
                position: relative;
            }

            .pic-item{
                position: relative;
                background-color: white;
                width: 10rem;
                height: 10rem;
                border-radius: 100%;
                outline: 0.5rem solid #23024D;
                cursor: pointer;
            }

            .pic-item img{
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 100%;
            }
            .name-item{
                width:7rem;
                padding: 0.5rem;                
                font-size: 1.3rem; 
                left:1.5rem; 
            }
            
            .name-item p{
                position: relative;
                width:6rem;
                word-wrap: break-word;   
            }

            .name-item-video{
                width:7rem;
                padding: 0.5rem;                
                font-size: 1.3rem; 
                left:1.5rem; 
            }

            .name-title p{
                position: relative;
                width:6rem;
                word-wrap: break-word;             
            }

            .item-on-video:hover .name-item-video{
                background: #E0F4FF;
                color: black;
                border: 0.1rem solid black;
                transition: 0.5s ease-in;
            }
            .item-on:hover  .name-item{
                background: #FFE0FE;
                color: black;
                border: 0.1rem solid black;
                transition: 0.5s ease-in;
            }



}

@media screen and (min-width:600px) and (max-width: 660px){
    #chat-talk.notchat{
       display: none;
    }

    .chat-talk {
        display: block;
        position: fixed;
        top: 32%;
        left: 0rem;
        width: 15rem;
        padding-left: 7rem;
    }

    .chat-popup{
        display: visible;
        position: fixed;
        top: 90%;
        background-color: #23024D;
        z-index: 5;
        right: 2rem;
        padding: 0.5rem;
        border-radius: 2rem;
        cursor: pointer;
    }
    .chat-popup i{
        display: block;
        position: relative;
        font-size: 3rem;
        color: white;

    }

    .background{
        display: grid;
        grid-template-columns: 0fr;
        grid-template-rows: 0fr 0fr;
        row-gap: 1rem;

}

    .header{
    width: 100%;
    height:10rem;
    position: fixed;

}

.background-header{
    width: 100%;
    height: 10rem;
    margin: 0;
    position: fixed;
}

.background-header img{
    width: 100%; height: 10rem;
}

.header .title-header{
    position: fixed;
    width: 27rem;
    height:4rem;
    top: 3.1%;
}

.icon-bar{
    position: fixed;
    width: 12rem;
    height: 1.9rem;
    top:6.8rem;
    padding-left: 0rem;
    justify-items: center;
}

.youtube i{
    font-size: 1.7rem;
}

.back i{
    font-size: 1.7rem;
}

.homepage i{
    font-size: 1.7rem;
}

/*******************chat ****************************/
.header-chat{
    position: relative;
    height: 5rem;
    width: 22rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    text-align: center;
}

.header-chat h1{
    position: absolute;
    font-size: 2.2rem;
    color: white;
    margin-top: 0.6rem;
    margin-left: 5.5rem;
}

.header-chat .chat-line{
    position: absolute;
    background-color: white;
    width:22rem;
    height: 0.5rem;
    left: 0;
    bottom: 0;
}
/***********typ message************/

.typing{
    position: relative;
    width: 22rem;
    height: 8rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    display: grid;
    grid-template-columns: 0fr 0fr 0fr;
    z-index: 0;
}

.profile{
    position: relative;
    margin: 0rem;
    width: 40px;
    height: 40px;
    border-radius: 5rem;
    left: 1rem;
    top: 0.8rem;
}

.profile img{
    position: absolute;
    object-fit: cover;
    width: 100%; height: 100%;
}

.nameuser {
    position: relative;
    height: 2.5rem;
    padding-left:0.5rem;   
    padding-right:0.5rem;  
    left: 1.9rem;
    top: 0.8rem;
}

.nameuser p{  
    position: relative;
    font-size: 1.2rem;

}


.send-message{
    position: absolute;
    margin: 0em;
    margin-top: 0rem;
    width: 2.6rem;
    height: 2.6rem;
    text-align: center;
    top: 0.8rem;
    right: 1rem;
}

.send-message i{
    font-size: 1.8rem;
    position: relative;
    top: 0rem;
    color: black;
}



.typ-box-1{
    position: absolute ;
    top: 4.2rem;
    left: 1rem;
    width: 19rem;
    height: 2rem;
    font-size: 0.7rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}
.typ-box-1 p{
    position: absolute;
    top: 0rem;
    left: 0.5rem;
    width: 10rem;
    height: 1.2rem;
    font-size: 1rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}
.typ-box-1:focus{
    font-size: 0.7rem;
}


            .chat{
                background: #412465;
                width: 22em;
                height: 20rem;
                top: 0rem;
                left: 0;
                margin-left: 0.2rem;
                z-index: 2;
                padding-top: 1rem;
                padding-bottom: 1rem;
                padding-left: 0.2rem;
                position: relative;
            }

            .show-comment{
                display: flex;
                flex-direction: column;
                grid-gap: 1rem;
                width: 100%;
                position: relative;
                z-index: 2;
            }

            .comment{
                position: relative;
                box-sizing: border-box;
                background: #F8F2FF;
                padding: 0.5rem;
                padding-top: 0;
                padding-left: 0;
                width: 15rem;
                margin-left: 2.1rem;
                font-size: 1.3rem;
            }

            .user-acc{
                display: flex;
                flex-direction: row;
                padding: 0.5rem;
            }

            .profile-up{
                 position: relative;
                 margin: 0rem;
                 width: 30px;
                 height: 30px;
                 border-radius: 5rem;
                 left: 0.2rem;
                 top: 0rem;

            }

            .profile-up img{
                position: absolute;
                object-fit: cover;
                width: 100%; height: 100%;
            }

            .nameuser-up{
                font-size: 0.5rem;
                padding-left: 0.5rem;   
                padding-right: 0.5rem;
                margin-top: 0.25rem;
                border-radius: 1rem;
                font-family: Mitn;
                position: relative;
                height:1.8rem;
                left: 0.8rem;
                top: -0.2rem;
            }

            .nameuser-up p{  
                position: relative;
                font-size: 1rem;
                top: -0.1rem;

            }

            .typ-box-up p{
                position: relative;
                width: 12rem; 
                left: 0.8rem;
                top: -0.5rem;
            }

            textarea{
                resize: none;
            }

            /**** show model pic *****/
            .catalog{
                top: 14rem;
                margin-left: 6rem;
                margin-right: 0rem;
                position:relative;
                padding:0rem;
                padding-top:0rem;
                padding-bottom: 0rem;
                width: 100%;
                min-height: auto;
                justify-content: center;
                justify-items: center;
            }

            .video-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0.5rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 15rem;
            }
            .profile-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0.5rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 15rem;
            }


            .item-main{
                display: grid;    
                grid-template-columns: 1fr;
                column-gap: 1rem;
                row-gap: 1rem;
            }

            #down-1:hover{
                background-color: #BEDEF0;
            }

            #down-2:hover{
                background-color: #F0BEEB;
            }

            .down i{
                
                font-size: 2.5rem;

            }

            #down-1{
                position: absolute;
                left: 16rem; 
            }
            #down-2{
                position: absolute;
                left: 15.8rem;
            }

            .character{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 0rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 14rem;
                height: 4rem;
                text-align: center;
                align-items: center;
                background-color: #F0BEEB;
            }

            .animation{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 0rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 14.5rem;
                height: 4rem;
                align-items: center;
                background-color: #BEDEF0;
            }

            .character p{
                position: relative;
                margin-top: -0.4rem;
                left: 0.6rem;
                color: #23024D;
                font-size: 2.5rem;
                font-family: Mustica;
            }

            .animation p{
                position: relative;
                margin-top: -0.5rem;
                left: 0.8rem;
                color: #23024D;
                font-size: 2.5rem;
                font-family: Mustica;
    
            }

            .item-on{
                position: relative;
                width: 20rem;  
                left: -0.5rem;  
                top: 2rem;
            }

            .item-on-video{
                position: relative;
                width: 20rem;
                left: -0.5rem; 
                top: 2rem;
            }

            .item-on:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #F0BEEB;
                border-radius: 3rem;
            }

            .item-on-video:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #BEDEF0;
                border-radius: 3rem;
            }
            

            .item-on-video:hover .pic-item,  .item-on:hover .pic-item{
                outline: none;
                width: 15rem;
                height: 15rem;
                box-shadow: 0 0 10px 0 #23024D;
                transition: 0.5s ease-in;
            }

            .item-on p{
                position: relative;
            }

            .pic-item{
                position: relative;
                background-color: white;
                width: 15rem;
                height: 15rem;
                border-radius: 100%;
                outline: 0.5rem solid #23024D;
                cursor: pointer;
            }

            .pic-item img{
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 100%;
            }
            .name-item{
                width:7rem;
                padding: 0.5rem;                
                font-size: 2rem; 
                left:4rem; 
            }
            
            .name-item p{
                position: relative;
                width:6rem;
                word-wrap: break-word;   
            }

            .name-item-video{
                width:7rem;
                padding: 0.5rem;                
                font-size:2rem; 
                left:4rem; 
            }

            .name-title p{
                position: relative;
                width:6rem;
                word-wrap: break-word;             
            }

            .item-on-video:hover .name-item-video{
                background: #E0F4FF;
                color: black;
                border: 0.1rem solid black;
                transition: 0.5s ease-in;
            }
            .item-on:hover  .name-item{
                background: #FFE0FE;
                color: black;
                border: 0.1rem solid black;
                transition: 0.5s ease-in;
            }


}

@media screen and (min-width:600px) and (max-width: 660px) and (min-height: 300px) and (max-height: 400px){
    #chat-talk.notchat{
       display: none;
    }

    .chat-talk {
        position: fixed ;
        top: 0.5rem;
        left: 50%;
        width: 12rem;
        padding-left: 0;
        z-index: 12;
    }

    .chat-popup{
        display: visible;
        position: fixed;
        top: 80%;
        background-color: #23024D;
        z-index: 5;
        right: 1.4rem;
        padding: 0.5rem;
        border-radius: 2rem;
        cursor: pointer;
    }
    .chat-popup i{
        display: block;
        position: relative;
        font-size: 1.5rem;
        color: white;

    }


    .background{
        display: grid;
        grid-template-columns: 0fr;
        grid-template-rows: 0fr 0fr;
        row-gap: 1rem;

}

    .header{
    width: 100%;
    height:10rem;
    position: fixed;

}

.background-header{
    width: 100%;
    height: 10rem;
    margin: 0;
    position: fixed;
}

.background-header img{
    width: 100%; height: 10rem;
}

.header .title-header{
    position: fixed;
    width: 28rem;
    height:4.5rem;
    top: 6%;
}

.icon-bar{
    position: fixed;
    width: 12rem;
    height: 1.9rem;
    top:6.8rem;
    padding-left: 0rem;
    justify-items: center;
}

.youtube i{
    font-size: 1.7rem;
}

.back i{
    font-size: 1.7rem;
}

.homepage i{
    font-size: 1.7rem;
}

/*******************chat ****************************/
.header-chat{
    position: relative;
    height: 5rem;
    width: 15rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    text-align: center;
}

.header-chat h1{
    position: absolute;
    font-size: 2.2rem;
    color: white;
    margin-top: 0.6rem;
    margin-left: 5.5rem;
}

.header-chat .chat-line{
    position: absolute;
    background-color: white;
    width:15rem;
    height: 0.5rem;
    left: 0;
    bottom: 0;
}
/***********typ message************/

.typing{
    position: relative;
    width: 15rem;
    height: 6rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    display: grid;
    grid-template-columns: 0fr 0fr 0fr;
    z-index: 0;
}

.profile{
    position: relative;
    margin: 0rem;
    width: 30px;
    height: 30px;
    border-radius: 5rem;
    left: 1rem;
    top: 0.8rem;
}

.profile img{
    position: absolute;
    object-fit: cover;
    width: 100%; height: 100%;
}

.nameuser {
    position: relative;
    height: 2rem;
    padding-left:0.5rem;   
    padding-right:0.5rem;  
    left: 1.8rem;
    top: 0.6rem;
}

.nameuser p{  
    position: relative;
    font-size: 1rem;

}


.send-message{
    position: absolute;
    margin: 0em;
    margin-top: 0rem;
    width: 2rem;
    height: 2rem;
    text-align: center;
    top: 0.8rem;
    right: 1rem;
}

.send-message i{
    font-size: 1.5rem;
    position: relative;
    top: -0.15rem;
    color: black;
}



.typ-box-1{
    position: absolute ;
    top: 3.5rem;
    left: 1rem;
    width: 13rem;
    height: 1.5rem;
    font-size: 0.7rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}
.typ-box-1 p{
    position: absolute;
    top: 0rem;
    left: 0.5rem;
    width: 10rem;
    height: 1.2rem;
    font-size: 1rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}
.typ-box-1:focus{
    font-size: 0.7rem;
}


            .chat{
                background: #412465;
                width: 15em;
                height: 10rem;
                top: 0rem;
                left: 0;
                margin-left: 0.2rem;
                z-index: 2;
                padding-top: 1rem;
                padding-bottom: 1rem;
                padding-left: 0.2rem;
                position: relative;
            }

            .show-comment{
                display: flex;
                flex-direction: column;
                grid-gap: 1rem;
                width: 100%;
                position: relative;
                z-index: 2;
            }

            .comment{
                position: relative;
                box-sizing: border-box;
                background: #F8F2FF;
                padding: 0.2rem;
                padding-top: 0;
                padding-left: 0;
                width: 11rem;
                margin-left: 1rem;
                font-size: 1.3rem;
            }

            .user-acc{
                display: flex;
                flex-direction: row;
                padding: 0.5rem;
            }

            .profile-up{
                 position: relative;
                 margin: 0rem;
                 width: 30px;
                 height: 30px;
                 border-radius: 5rem;
                 left: 0.2rem;
                 top: 0rem;
            }

            .profile-up img{
                position: absolute;
                object-fit: cover;
                width: 100%; height: 100%;
            }

            .nameuser-up{
                font-size: 0.5rem;
                padding-left: 0.5rem;   
                padding-right: 0.5rem;
                margin-top: 0.25rem;
                border-radius: 1rem;
                font-family: Mitn;
                position: relative;
                height:1.8rem;
                left: 0.8rem;
                top: -0.2rem;
            }

            .nameuser-up p{  
                position: relative;
                font-size: 1rem;
                top: -0.1rem;

            }

            .typ-box-up p{
                position: relative;
                width: 12rem; 
                left: 0.8rem;
                top: -0.5rem;
            }

            textarea{
                resize: none;
            }

            /**** show model pic *****/
            .catalog{
                top: 14rem;
                margin-left: 2.2rem;
                margin-right: 0rem;
                position:relative;
                padding:0rem;
                padding-top:0rem;
                padding-bottom: 0rem;
                width: 100%;
                min-height: auto;
                justify-content: center;
                justify-items: center;
            }

            .video-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0.5rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 12rem;
            }
            .profile-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0.5rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 12rem;
            }

            .item-main{
                display: grid;    
                grid-template-columns: 0fr 1fr;
                column-gap: 3rem;
                row-gap: 1rem;
            }

            #down-1:hover{
                background-color: #BEDEF0;
            }

            #down-2:hover{
                background-color: #F0BEEB;
            }

            .down i{
                
                font-size: 2.5rem;

            }

            #down-1{
                position: absolute;
                left: 16rem; 
            }
            #down-2{
                position: absolute;
                left: 15.8rem;
            }
            
            .character{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 0rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 14rem;
                height: 4rem;
                text-align: center;
                align-items: center;
                background-color: #F0BEEB;
            }

            .animation{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 0rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 14.5rem;
                height: 4rem;
                align-items: center;
                background-color: #BEDEF0;
            }

            .character p{
                position: relative;
                margin-top: -0.4rem;
                left: 0.6rem;
                color: #23024D;
                font-size: 2.5rem;
                font-family: Mustica;
            }

            .animation p{
                position: relative;
                margin-top: -0.5rem;
                left: 0.8rem;
                color: #23024D;
                font-size: 2.5rem;
                font-family: Mustica;
    
            }

            .item-on{
                position: relative;
                width: 15rem;  
                left: -0.5rem;  
                top: 1.5rem;
                margin-bottom: 4rem;
            }

            .item-on-video{
                position: relative;
                width: 15rem;
                left: -0.5rem; 
                top: 1.5rem;
            }

            .item-on:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #F0BEEB;
                border-radius: 3rem;
            }

            .item-on-video:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #BEDEF0;
                border-radius: 3rem;
            }
            

            .item-on-video:hover .pic-item,  .item-on:hover .pic-item{
                outline: none;
                width: 10rem;
                height: 10rem;
                box-shadow: 0 0 10px 0 #23024D;
                transition: 0.5s ease-in;
            }

            .item-on p{
                position: relative;
            }

            .pic-item{
                position: relative;
                background-color: white;
                width: 10rem;
                height: 10rem;
                border-radius: 100%;
                outline: 0.5rem solid #23024D;
                cursor: pointer;
            }

            .pic-item img{
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 100%;
            }
            .name-item{
                width:7rem;
                padding: 0.5rem;  
                padding-left: 1rem;                
                font-size: 1.8rem; 
                left:1.6rem; 
            }
            
            .name-item p{
                position: relative;
                width:5rem;
                word-wrap: break-word;   
            }

            .name-item-video{
                width:7rem;
                padding: 0.5rem;  
                padding-left: 1rem;                 
                font-size:1.8rem; 
                left:1.6rem; 
            }

            .name-title p{
                position: relative;
                width:5rem;
                word-wrap: break-word;             
            }

         
}

@media screen and (min-width:710px) and (max-width: 770px){
    #chat-talk.notchat{
       display: none;
    }

    .chat-talk {
        position: fixed ;
        top: 30%;
        left: 35%;
        width: 12rem;
        padding-left: 0;
        z-index: 12;
    }

    .chat-popup{
        display: visible;
        position: fixed;
        top: 86%;
        background-color: #23024D;
        z-index: 5;
        right: 3rem;
        padding: 0.5rem;
        border-radius: 2rem;
        cursor: pointer;
    }
    .chat-popup i{
        display: block;
        position: relative;
        font-size: 3rem;
        color: white;

    }


    .background{
        display: grid;
        grid-template-columns: 0fr;
        grid-template-rows: 0fr 0fr;
        row-gap: 1rem;

}

    .header{
    width: 100%;
    height:10rem;
    position: fixed;

}

.background-header{
    width: 100%;
    height: 10rem;
    margin: 0;
    position: fixed;
}

.background-header img{
    width: 100%; height: 10rem;
}

.header .title-header{
    position: fixed;
    width: 26rem;
    height:4rem;
    top: 2.5%;
}

.icon-bar{
    position: fixed;
    width: 14rem;
    height: 2rem;
    top:6.8rem;
    padding-left: 0rem;
    justify-items: center;
}

.youtube i{
    font-size: 1.7rem;
}

.back i{
    font-size: 1.7rem;
}

.homepage i{
    font-size: 1.7rem;
}

/*******************chat ****************************/
.header-chat{
    position: relative;
    height: 5rem;
    width: 25rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    text-align: center;
}

.header-chat h1{
    position: absolute;
    font-size: 2.2rem;
    color: white;
    margin-top: 0.6rem;
    margin-left: 5.5rem;
}

.header-chat .chat-line{
    position: absolute;
    background-color: white;
    width:25rem;
    height: 0.5rem;
    left: 0;
    bottom: 0;
}
/***********typ message************/

.typing{
    position: relative;
    width: 25rem;
    height: 9rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    display: grid;
    grid-template-columns: 0fr 0fr 0fr;
    z-index: 0;
}

.profile{
    position: relative;
    margin: 0rem;
    width: 48px;
    height: 48px;
    border-radius: 5rem;
    left: 1.4rem;
    top: 1rem;
}

.profile img{
    position: absolute;
    object-fit: cover;
    width: 100%; height: 100%;
}

.nameuser {
    position: relative;
    height: 3rem;
    padding-left:0.5rem;   
    padding-right:0.5rem;  
    left: 2.5rem;
    top: 1rem;
}

.nameuser p{  
    position: relative;
    font-size: 1.5rem;

}


.send-message{
    position: absolute;
    margin: 0em;
    margin-top: 0rem;
    width: 3rem;
    height: 3rem;
    text-align: center;
    top: 1.1rem;
    right: 1.5rem;
}

.send-message i{
    font-size: 2rem;
    position: relative;
    top: 0.1rem;
    color: black;
}

.typ-box-1{
    position: absolute ;
    top: 5rem;
    left: 1rem;
    width: 23rem;
    height: 2.5rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}
.typ-box-1 p{
    position: absolute;
    top: 0rem;
    left: 0.5rem;
    width: 10rem;
    height: 1.2rem;
    font-size:4rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}

.typ-box-1:focus{
    font-size: 1.5rem;
}


            .chat{
                background: #412465;
                width: 25rem;
                height: 20rem;
                top: 0rem;
                left: 0;
                margin-left: 0.2rem;
                z-index: 2;
                padding-top: 1rem;
                padding-bottom: 1rem;
                padding-left: 0.2rem;
                position: relative;
            }

            .show-comment{
                display: flex;
                flex-direction: column;
                grid-gap: 1rem;
                width: 100%;
                position: relative;
                z-index: 2;
            }

            .comment{
                position: relative;
                box-sizing: border-box;
                background: #F8F2FF;
                padding: 0.2rem;
                padding-top: 0;
                padding-left: 0;
                width: 15rem;
                margin-left: 6rem;
                font-size: 1.3rem;
            }

            .user-acc{
                display: flex;
                flex-direction: row;
                padding: 0.5rem;
            }

            .profile-up{
                 position: relative;
                 margin: 0rem;
                 width: 30px;
                 height: 30px;
                 border-radius: 5rem;
                 left: 0.2rem;
                 top: 0rem;
            }

            .profile-up img{
                position: absolute;
                object-fit: cover;
                width: 100%; height: 100%;
            }

            .nameuser-up{
                font-size: 0.5rem;
                padding-left: 0.5rem;   
                padding-right: 0.5rem;
                margin-top: 0.25rem;
                border-radius: 1rem;
                font-family: Mitn;
                position: relative;
                height:1.8rem;
                left: 0.8rem;
                top: -0.2rem;
            }

            .nameuser-up p{  
                position: relative;
                font-size: 1rem;
                top: -0.1rem;

            }

            .typ-box-up p{
                position: relative;
                width: 12rem; 
                left: 0.8rem;
                top: -0.5rem;
            }

            textarea{
                resize: none;
            }

            /**** show model pic *****/
            .catalog{
                top: 14rem;
                margin-left: 2.2rem;
                margin-right: 0rem;
                position:relative;
                padding:0rem;
                padding-top:0rem;
                padding-bottom: 0rem;
                width: 100%;
                min-height: auto;
                justify-content: center;
                justify-items: center;
            }

            .video-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0.5rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 12rem;
            }
            .profile-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0.5rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 12rem;
            }

            .item-main{
                display: grid;    
                grid-template-columns: 0fr 1fr;
                column-gap: 4rem;
                row-gap: 1rem;
            }

            #down-1:hover{
                background-color: #BEDEF0;
            }

            #down-2:hover{
                background-color: #F0BEEB;
            }

            .down i{
                
                font-size: 2.5rem;

            }

            #down-1{
                position: absolute;
                left: 16rem; 
            }
            #down-2{
                position: absolute;
                left: 15.8rem;
            }
            
            .character{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 0rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 14rem;
                height: 4rem;
                text-align: center;
                align-items: center;
                background-color: #F0BEEB;
            }

            .animation{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 0rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 14.5rem;
                height: 4rem;
                align-items: center;
                background-color: #BEDEF0;
            }

            .character p{
                position: relative;
                margin-top: -0.4rem;
                left: 0.6rem;
                color: #23024D;
                font-size: 2.5rem;
                font-family: Mustica;
            }

            .animation p{
                position: relative;
                margin-top: -0.5rem;
                left: 0.8rem;
                color: #23024D;
                font-size: 2.5rem;
                font-family: Mustica;
    
            }

            .item-on{
                position: relative;
                width: 17rem;  
                left: -0.5rem;  
                top: 1.5rem;
                margin-bottom: 4rem;
            }

            .item-on-video{
                position: relative;
                width: 17rem;
                left: -0.5rem; 
                top: 1.5rem;
            }

            .item-on:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #F0BEEB;
                border-radius: 3rem;
            }

            .item-on-video:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #BEDEF0;
                border-radius: 3rem;
            }
            

            .item-on-video:hover .pic-item,  .item-on:hover .pic-item{
                outline: none;
                width: 12rem;
                height: 12rem;
                box-shadow: 0 0 10px 0 #23024D;
                transition: 0.5s ease-in;
            }

            .item-on p{
                position: relative;
            }

            .pic-item{
                position: relative;
                background-color: white;
                width: 12rem;
                height: 12rem;
                border-radius: 100%;
                outline: 0.5rem solid #23024D;
                cursor: pointer;
            }

            .pic-item img{
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 100%;
            }
            .name-item{
                width:7rem;
                padding: 0.5rem;  
                padding-left: 1rem;                
                font-size: 1.8rem; 
                left:2.5rem; 
            }
            
            .name-item p{
                position: relative;
                width:5rem;
                word-wrap: break-word;   
            }

            .name-item-video{
                width:7rem;
                padding: 0.5rem;  
                padding-left: 1rem;                 
                font-size:1.8rem; 
                left:2.5rem; 
            }

            .name-title p{
                position: relative;
                width:5rem;
                word-wrap: break-word;             
            }

}

@media screen and (min-width:800px) and (max-width: 850px){
    #chat-talk.notchat{
       display: none;
    }

    .chat-talk {
        position: fixed ;
        top: 33%;
        left: 42%;
        width: 12rem;
        padding-left: 0;
        z-index: 12;
    }

    .chat-popup{
        display: visible;
        position: fixed;
        top: 90%;
        background-color: #23024D;
        z-index: 5;
        right: 4rem;
        padding: 0.5rem;
        border-radius: 2rem;
        cursor: pointer;
    }
    .chat-popup i{
        display: block;
        position: relative;
        font-size: 3rem;
        color: white;

    }


    .background{
        display: grid;
        grid-template-columns: 0fr;
        grid-template-rows: 0fr 0fr;
        row-gap: 1rem;

}

    .header{
    width: 100%;
    height:10rem;
    position: fixed;

}

.background-header{
    width: 100%;
    height: 10rem;
    margin: 0;
    position: fixed;
}

.background-header img{
    width: 100%; height: 10rem;
}

.header .title-header{
    position: fixed;
    width: 26rem;
    height:4rem;
    top: 2.5%;
}

.icon-bar{
    position: fixed;
    width: 14rem;
    height: 2rem;
    top:6.8rem;
    padding-left: 0rem;
    justify-items: center;
}

.youtube i{
    font-size: 1.7rem;
}

.back i{
    font-size: 1.7rem;
}

.homepage i{
    font-size: 1.7rem;
}

/*******************chat ****************************/
.header-chat{
    position: relative;
    height: 5rem;
    width: 25rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    text-align: center;
}

.header-chat h1{
    position: absolute;
    font-size: 2.2rem;
    color: white;
    margin-top: 0.6rem;
    margin-left: 5.5rem;
}

.header-chat .chat-line{
    position: absolute;
    background-color: white;
    width:25rem;
    height: 0.5rem;
    left: 0;
    bottom: 0;
}
/***********typ message************/

.typing{
    position: relative;
    width: 25rem;
    height: 9rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    display: grid;
    grid-template-columns: 0fr 0fr 0fr;
    z-index: 0;
}

.profile{
    position: relative;
    margin: 0rem;
    width: 48px;
    height: 48px;
    border-radius: 5rem;
    left: 1.4rem;
    top: 1rem;
}

.profile img{
    position: absolute;
    object-fit: cover;
    width: 100%; height: 100%;
}

.nameuser {
    position: relative;
    height: 3rem;
    padding-left:0.5rem;   
    padding-right:0.5rem;  
    left: 2.5rem;
    top: 1rem;
}

.nameuser p{  
    position: relative;
    font-size: 1.5rem;

}


.send-message{
    position: absolute;
    margin: 0em;
    margin-top: 0rem;
    width: 3rem;
    height: 3rem;
    text-align: center;
    top: 1.1rem;
    right: 1.5rem;
}

.send-message i{
    font-size: 2rem;
    position: relative;
    top: 0.1rem;
    color: black;
}

.typ-box-1{
    position: absolute ;
    top: 5rem;
    left: 1rem;
    width: 23rem;
    height: 2.5rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}
.typ-box-1 p{
    position: absolute;
    top: 0rem;
    left: 0.5rem;
    width: 10rem;
    height: 1.2rem;
    font-size:4rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}

.typ-box-1:focus{
    font-size: 1.5rem;
}


            .chat{
                background: #412465;
                width: 25rem;
                height: 25rem;
                top: 0rem;
                left: 0;
                margin-left: 0.2rem;
                z-index: 2;
                padding-top: 1rem;
                padding-bottom: 1rem;
                padding-left: 0.2rem;
                position: relative;
            }

            .show-comment{
                display: flex;
                flex-direction: column;
                grid-gap: 1rem;
                width: 100%;
                position: relative;
                z-index: 2;
            }

            .comment{
                position: relative;
                box-sizing: border-box;
                background: #F8F2FF;
                padding: 0.2rem;
                padding-top: 0;
                padding-left: 0;
                width: 15rem;
                margin-left: 6rem;
                font-size: 1.3rem;
            }

            .user-acc{
                display: flex;
                flex-direction: row;
                padding: 0.5rem;
            }

            .profile-up{
                 position: relative;
                 margin: 0rem;
                 width: 30px;
                 height: 30px;
                 border-radius: 5rem;
                 left: 0.2rem;
                 top: 0rem;
            }

            .profile-up img{
                position: absolute;
                object-fit: cover;
                width: 100%; height: 100%;
            }

            .nameuser-up{
                font-size: 0.5rem;
                padding-left: 0.5rem;   
                padding-right: 0.5rem;
                margin-top: 0.25rem;
                border-radius: 1rem;
                font-family: Mitn;
                position: relative;
                height:1.8rem;
                left: 0.8rem;
                top: -0.2rem;
            }

            .nameuser-up p{  
                position: relative;
                font-size: 1rem;
                top: -0.1rem;

            }

            .typ-box-up p{
                position: relative;
                width: 12rem; 
                left: 0.8rem;
                top: -0.5rem;
            }

            textarea{
                resize: none;
            }

            /**** show model pic *****/
            .catalog{
                top: 14rem;
                margin-left: 2.2rem;
                margin-right: 0rem;
                position:relative;
                padding:0rem;
                padding-top:0rem;
                padding-bottom: 0rem;
                width: 100%;
                min-height: auto;
                justify-content: center;
                justify-items: center;
            }

            .video-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0.5rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 12rem;
            }
            .profile-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0.5rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 12rem;
            }

            .item-main{
                display: grid;    
                grid-template-columns: 0fr 1fr;
                column-gap: 5rem;
                row-gap: 1rem;
            }

            #down-1:hover{
                background-color: #BEDEF0;
            }

            #down-2:hover{
                background-color: #F0BEEB;
            }

            .down i{
                
                font-size: 4rem;

            }

            #down-1{
                position: absolute;
                left: 22rem; 
            }
            #down-2{
                position: absolute;
                left: 21.5rem;
            }
            
            .character{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 0rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 19.5rem;
                height: 5.5rem;
                text-align: center;
                align-items: center;
                background-color: #F0BEEB;
            }

            .animation{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 0rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 20rem;
                height: 5.2rem;
                align-items: center;
                background-color: #BEDEF0;
            }

            .character p{
                position: relative;
                margin-top: -0.4rem;
                left: 0.8rem;
                color: #23024D;
                font-size: 3.5rem;
                font-family: Mustica;
            }

            .animation p{
                position: relative;
                margin-top: -0.5rem;
                left: 0.8rem;
                color: #23024D;
                font-size: 3.5rem;
                font-family: Mustica;
    
            }

            .item-on{
                position: relative;
                width: 19rem;  
                left: 0rem;  
                top: 1.5rem;
                margin-bottom: 4rem;
            }

            .item-on-video{
                position: relative;
                width: 19rem;
                left: 0rem; 
                top: 1.5rem;
            }

            .item-on:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #F0BEEB;
                border-radius: 3rem;
            }

            .item-on-video:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #BEDEF0;
                border-radius: 3rem;
            }
            

            .item-on-video:hover .pic-item,  .item-on:hover .pic-item{
                outline: none;
                width: 15rem;
                height: 15rem;
                box-shadow: 0 0 10px 0 #23024D;
                transition: 0.5s ease-in;
            }

            .item-on p{
                position: relative;
            }

            .pic-item{
                position: relative;
                background-color: white;
                width: 15rem;
                height: 15rem;
                border-radius: 100%;
                outline: 0.5rem solid #23024D;
                cursor: pointer;
            }

            .pic-item img{
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 100%;
            }
            .name-item{
                width:7rem;
                padding: 0.5rem;  
                padding-left: 1rem;                
                font-size: 1.8rem; 
                left:4rem; 
            }
            
            .name-item p{
                position: relative;
                width:5rem;
                word-wrap: break-word;   
            }

            .name-item-video{
                width:7rem;
                padding: 0.5rem;  
                padding-left: 1rem;                 
                font-size:1.8rem; 
                left:4rem; 
            }

            .name-title p{
                position: relative;
                width:5rem;
                word-wrap: break-word;             
            }


}

@media screen and (min-width:900px) and (max-width: 960px){

    #chat-talk.notchat{
       display: none;
    }

    .chat-talk {
        position: fixed ;
        top: 33%;
        left: 48%;
        width: 12rem;
        padding-left: 0;
        z-index: 12;
    }

    .chat-popup{
        display: visible;
        position: fixed;
        top: 86%;
        background-color: #23024D;
        z-index: 5;
        right: 5rem;
        padding: 1rem;
        border-radius: 5rem;
        cursor: pointer;
    }
    .chat-popup i{
        display: block;
        position: relative;
        font-size: 4rem;
        color: white;

    }


    .background{
        display: grid;
        grid-template-columns: 0fr;
        grid-template-rows: 0fr 0fr;
        row-gap: 1rem;

}

    .header{
    width: 100%;
    height:15rem;
    position: fixed;

}

.background-header{
    width: 100%;
    height: 15rem;
    margin: 0;
    position: fixed;
}

.background-header img{
    width: 100%; height: 15rem;
}

.header .title-header{
    position: fixed;
    width: 40rem;
    height:6.5rem;
    top: 2.5%;
}

.icon-bar{
    position: fixed;
    width: 16rem;
    height: 3rem;
    top:10rem;
    padding-left: 0rem;
    justify-items: center;
}

.youtube i{
    font-size: 2.2rem;
}

.back i{
    font-size: 2.2rem;
}

.homepage i{
    font-size: 2.2rem;
}

/*******************chat ****************************/
.header-chat{
    position: relative;
    height: 5rem;
    width: 25rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    text-align: center;
}

.header-chat h1{
    position: absolute;
    font-size: 2.2rem;
    color: white;
    margin-top: 0.6rem;
    margin-left: 5.5rem;
}

.header-chat .chat-line{
    position: absolute;
    background-color: white;
    width:25rem;
    height: 0.5rem;
    left: 0;
    bottom: 0;
}
/***********typ message************/

.typing{
    position: relative;
    width: 25rem;
    height: 9rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    display: grid;
    grid-template-columns: 0fr 0fr 0fr;
    z-index: 0;
}

.profile{
    position: relative;
    margin: 0rem;
    width: 48px;
    height: 48px;
    border-radius: 5rem;
    left: 1.4rem;
    top: 1rem;
}

.profile img{
    position: absolute;
    object-fit: cover;
    width: 100%; height: 100%;
}

.nameuser {
    position: relative;
    height: 3rem;
    padding-left:0.5rem;   
    padding-right:0.5rem;  
    left: 2.5rem;
    top: 1rem;
}

.nameuser p{  
    position: relative;
    font-size: 1.5rem;

}


.send-message{
    position: absolute;
    margin: 0em;
    margin-top: 0rem;
    width: 3rem;
    height: 3rem;
    text-align: center;
    top: 1.1rem;
    right: 1.5rem;
}

.send-message i{
    font-size: 2rem;
    position: relative;
    top: 0.1rem;
    color: black;
}

.typ-box-1{
    position: absolute ;
    top: 5rem;
    left: 1rem;
    width: 23rem;
    height: 2.5rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}
.typ-box-1 p{
    position: absolute;
    top: 0rem;
    left: 0.5rem;
    width: 10rem;
    height: 1.2rem;
    font-size:4rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}

.typ-box-1:focus{
    font-size: 1.5rem;
}


            .chat{
                background: #412465;
                width: 25rem;
                height: 25rem;
                top: 0rem;
                left: 0;
                margin-left: 0.2rem;
                z-index: 2;
                padding-top: 1rem;
                padding-bottom: 1rem;
                padding-left: 0.2rem;
                position: relative;
            }

            .show-comment{
                display: flex;
                flex-direction: column;
                grid-gap: 1rem;
                width: 100%;
                position: relative;
                z-index: 2;
            }

            .comment{
                position: relative;
                box-sizing: border-box;
                background: #F8F2FF;
                padding: 0.2rem;
                padding-top: 0;
                padding-left: 0;
                width: 15rem;
                margin-left: 6rem;
                font-size: 1.3rem;
            }

            .user-acc{
                display: flex;
                flex-direction: row;
                padding: 0.5rem;
            }

            .profile-up{
                 position: relative;
                 margin: 0rem;
                 width: 30px;
                 height: 30px;
                 border-radius: 5rem;
                 left: 0.2rem;
                 top: 0rem;
            }

            .profile-up img{
                position: absolute;
                object-fit: cover;
                width: 100%; height: 100%;
            }

            .nameuser-up{
                font-size: 0.5rem;
                padding-left: 0.5rem;   
                padding-right: 0.5rem;
                margin-top: 0.25rem;
                border-radius: 1rem;
                font-family: Mitn;
                position: relative;
                height:1.8rem;
                left: 0.8rem;
                top: -0.2rem;
            }

            .nameuser-up p{  
                position: relative;
                font-size: 1rem;
                top: -0.1rem;

            }

            .typ-box-up p{
                position: relative;
                width: 12rem; 
                left: 0.8rem;
                top: -0.5rem;
            }

            textarea{
                resize: none;
            }

            /**** show model pic *****/
            .catalog{
                top: 18rem;
                margin-left: 2.2rem;
                margin-right: 0rem;
                position:relative;
                padding:0rem;
                padding-top:0rem;
                padding-bottom: 0rem;
                width: 100%;
                min-height: auto;
                justify-content: center;
                justify-items: center;
            }

            .video-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0.5rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 12rem;
            }
            .profile-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0.5rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 12rem;
            }

            .item-main{
                display: grid;    
                grid-template-columns: 0fr 1fr;
                column-gap: 5rem;
                row-gap: 1rem;
            }

            #down-1:hover{
                background-color: #BEDEF0;
            }

            #down-2:hover{
                background-color: #F0BEEB;
            }

            .down i{
                
                font-size: 4rem;

            }

            #down-1{
                position: absolute;
                left: 22rem; 
            }
            #down-2{
                position: absolute;
                left: 21.5rem;
            }
            
            .character{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 1rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 19.5rem;
                height: 5.5rem;
                text-align: center;
                align-items: center;
                background-color: #F0BEEB;
            }

            .animation{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 1rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 20rem;
                height: 5.2rem;
                align-items: center;
                background-color: #BEDEF0;
            }

            .character p{
                position: relative;
                margin-top: -0.4rem;
                left: 0.8rem;
                color: #23024D;
                font-size: 3.5rem;
                font-family: Mustica;
            }

            .animation p{
                position: relative;
                margin-top: -0.5rem;
                left: 0.8rem;
                color: #23024D;
                font-size: 3.5rem;
                font-family: Mustica;
    
            }

            .item-on{
                position: relative;
                width: 20rem;  
                left: 1rem;  
                top: 1.5rem;
                margin-bottom: 4rem;
            }

            .item-on-video{
                position: relative;
                width: 20rem;
                left: 1rem; 
                top: 1.5rem;
            }

            .item-on:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #F0BEEB;
                border-radius: 3rem;
            }

            .item-on-video:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #BEDEF0;
                border-radius: 3rem;
            }
            

            .item-on-video:hover .pic-item,  .item-on:hover .pic-item{
                outline: none;
                width: 15rem;
                height: 15rem;
                box-shadow: 0 0 10px 0 #23024D;
                transition: 0.5s ease-in;
            }

            .item-on p{
                position: relative;
            }

            .pic-item{
                position: relative;
                background-color: white;
                width: 15rem;
                height: 15rem;
                border-radius: 100%;
                outline: 0.5rem solid #23024D;
                cursor: pointer;
            }

            .pic-item img{
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 100%;
            }
            .name-item{
                width:7rem;
                padding: 0.5rem;  
                padding-left: 1rem;                
                font-size: 1.8rem; 
                left:4rem; 
            }
            
            .name-item p{
                position: relative;
                width:5rem;
                word-wrap: break-word;   
            }

            .name-item-video{
                width:7rem;
                padding: 0.5rem;  
                padding-left: 1rem;                 
                font-size:1.8rem; 
                left:4rem; 
            }

            .name-title p{
                position: relative;
                width:5rem;
                word-wrap: break-word;             
            }



}

@media screen and (min-width:1020px) and (max-width: 1080px){

    #chat-talk.notchat{
       display: none;
    }

    .chat-talk {
        position: fixed ;
        top: 20%;
        left: 20%;
        width: 12rem;
        padding-left: 0;
        z-index: 4;
    }

    .chat-popup{
        display: visible;
        position: fixed;
        top: 85%;
        background-color: #23024D;
        z-index: 5;
        right: 6rem;
        padding: 1rem;
        border-radius: 5rem;
        cursor: pointer;
    }
    .chat-popup i{
        display: block;
        position: relative;
        font-size: 5rem;
        color: white;

    }


    .background{
        display: grid;
        grid-template-columns: 0fr;
        grid-template-rows: 0fr 0fr;
        row-gap: 1rem;

}

    .header{
    width: 100%;
    height:15rem;
    position: fixed;

}

.background-header{
    width: 100%;
    height: 15rem;
    margin: 0;
    position: fixed;
}

.background-header img{
    width: 100%; height: 15rem;
}

.header .title-header{
    position: fixed;
    width: 40rem;
    height:6.3rem;
    top:2%;
}

.icon-bar{
    position: fixed;
    width: 16rem;
    height: 3rem;
    top:10.5rem;
    padding-left: 0rem;
    justify-items: center;
}

.youtube i{
    font-size: 2.2rem;
}

.back i{
    font-size: 2.2rem;
}

.homepage i{
    font-size: 2.2rem;
}

/*******************chat ****************************/
.header-chat{
    position: relative;
    height: 8rem;
    width: 40rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    text-align: center;
}

.header-chat h1{
    position: absolute;
    font-size: 3rem;
    color: white;
    margin-top: 1rem;
    margin-left: 6rem;
}

.header-chat .chat-line{
    position: absolute;
    background-color: white;
    width:40rem;
    height: 0.5rem;
    left: 0;
    bottom: 0;
}
/***********typ message************/

.typing{
    position: relative;
    width: 40rem;
    height: 15rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    display: grid;
    grid-template-columns: 0fr 0fr 0fr;
    z-index: 0;
}

.profile{
    position: relative;
    margin: 0rem;
    width: 70px;
    height: 70px;
    border-radius: 5rem;
    left: 1.8rem;
    top: 1.5rem;
}

.profile img{
    position: absolute;
    object-fit: cover;
    width: 100%; height: 100%;
}

.nameuser {
    position: relative;
    height: 4rem;
    padding-left:1rem;   
    padding-right:1rem;  
    left: 4rem;
    top: 1.5rem;
    border-radius: 5rem;
}

.nameuser p{  
    position: relative;
    font-size: 2rem;

}


.send-message{
    position: absolute;
    margin: 0em;
    margin-top: 0rem;
    width: 5rem;
    height: 5rem;
    text-align: center;
    top: 1.5rem;
    right: 1.5rem;
    border-radius: 2rem;
}

.send-message i{
    font-size: 3rem;
    position: relative;
    top: 0.1rem;
    color: black;
}

.typ-box-1{
    position: absolute ;
    top: 8.5rem;
    left: 2.5rem;
    width: 35rem;
    height: 4rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}
.typ-box-1 p{
    position: absolute;
    top: 0rem;
    left: 0.5rem;
    width: 10rem;
    height: 1.2rem;
    font-size:4rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}

.typ-box-1:focus{
    font-size: 1.5rem;
}


            .chat{
                background: #412465;
                width: 40rem;
                height: 35rem;
                top: 0rem;
                left: 0;
                margin-left: 0.2rem;
                z-index: 2;
                padding-top: 1rem;
                padding-bottom: 1rem;
                padding-left: 0.2rem;
                position: relative;
            }

            .show-comment{
                display: flex;
                flex-direction: column;
                grid-gap: 1rem;
                width: 100%;
                position: relative;
                z-index: 2;
            }

            .comment{
                position: relative;
                box-sizing: border-box;
                background: #F8F2FF;
                padding: 0.2rem;
                padding-top: 0;
                padding-left: 0;
                width: 25rem;
                margin-left: 5em;
                font-size:2rem;
            }

            .user-acc{
                display: flex;
                flex-direction: row;
                padding: 0.5rem;
            }

            .profile-up{
                 position: relative;
                 margin: 0rem;
                 width: 45px;
                 height: 45px;
                 border-radius: 5rem;
                 left: 0.2rem;
                 top: 0rem;
            }

            .nameuser-up{
                font-size: 0.5rem;
                padding-left: 0.5rem;   
                padding-right: 0.5rem;
                margin-top: 0.25rem;
                border-radius: 1rem;
                font-family: Mitn;
                position: relative;
                height:3rem;
                left: 1.5rem;
                top: -0.5em;
            }

            .nameuser-up p{  
                position: relative;
                font-size: 2rem;
                top: -0.5rem;

            }

            .typ-box-up p{
                position: relative;
                width: 12rem; 
                left: 0.8rem;
                top: -0.5rem;
            }

            textarea{
                resize: none;
            }

            /**** show model pic *****/
            .catalog{
                top: 18rem;
                margin-left: 2.2rem;
                margin-right: 0rem;
                position:relative;
                padding:0rem;
                padding-top:0rem;
                padding-bottom: 0rem;
                width: 100%;
                min-height: auto;
                justify-content: center;
                justify-items: center;
            }

            .video-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0.5rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 12rem;
            }
            .profile-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0.5rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 12rem;
            }

            .item-main{
                display: grid;    
                grid-template-columns: 0fr 1fr;
                column-gap: 5rem;
                row-gap: 3rem;
            }

            #down-1:hover{
                background-color: #BEDEF0;
            }

            #down-2:hover{
                background-color: #F0BEEB;
            }

            .down i{
                
                font-size: 4rem;

            }

            #down-1{
                position: absolute;
                left: 22rem; 
            }
            #down-2{
                position: absolute;
                left: 21.5rem;
            }
            
            .character{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 1rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 19.5rem;
                height: 5.5rem;
                text-align: center;
                align-items: center;
                background-color: #F0BEEB;
            }

            .animation{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 1rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 20rem;
                height: 5.2rem;
                align-items: center;
                background-color: #BEDEF0;
            }

            .character p{
                position: relative;
                margin-top: -0.4rem;
                left: 0.8rem;
                color: #23024D;
                font-size: 3.5rem;
                font-family: Mustica;
            }

            .animation p{
                position: relative;
                margin-top: -0.5rem;
                left: 0.8rem;
                color: #23024D;
                font-size: 3.5rem;
                font-family: Mustica;
    
            }

            .item-on{
                position: relative;
                width: 25rem;  
                left: 1rem;  
                top: 1.5rem;
                margin-bottom: 4rem;
            }

            .item-on-video{
                position: relative;
                width: 25rem;
                left: 1rem; 
                top: 1.5rem;
            }

            .item-on:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #F0BEEB;
                border-radius: 3rem;
            }

            .item-on-video:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #BEDEF0;
                border-radius: 3rem;
            }
            

            .item-on-video:hover .pic-item,  .item-on:hover .pic-item{
                outline: none;
                width: 20rem;
                height: 20rem;
                box-shadow: 0 0 10px 0 #23024D;
                transition: 0.5s ease-in;
            }

            .item-on p{
                position: relative;
            }

            .pic-item{
                position: relative;
                background-color: white;
                width: 20rem;
                height: 20rem;
                border-radius: 100%;
                outline: 0.5rem solid #23024D;
                cursor: pointer;
            }

            .pic-item img{
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 100%;
            }
            .name-item{
                width:10rem;
                padding: 0.5rem;  
                padding-left: 1.5rem;                
                font-size: 2.5rem; 
                left:5rem; 
            }
            
            .name-item p{
                position: relative;
                width:7rem;
                word-wrap: break-word;   
            }

            .name-item-video{
                width:10rem;
                padding: 0.5rem;  
                padding-left: 1rem;                 
                font-size:2.5rem; 
                left:5rem; 
                text-align: center;
            }

            .name-title p{
                position: relative;
                width:7rem;
                word-wrap: break-word;             
            }



}

@media screen and (min-width:1080px) and (max-width: 1100px) and (min-height:2300px) and (max-height:2350px){

    #chat-talk.notchat{
       display: none;
    }

    .chat-talk {
        position: fixed ;
        top: 30%;
        left: 20%;
        width: 12rem;
        padding-left: 0;
        z-index: 12;
    }

    .chat-popup{
        display: visible;
        position: fixed;
        top: 90%;
        background-color: #23024D;
        z-index: 5;
        right: 6rem;
        padding: 1rem;
        border-radius: 5rem;
        cursor: pointer;
    }
    .chat-popup i{
        display: block;
        position: relative;
        font-size: 5rem;
        color: white;

    }


    .background{
        display: grid;
        grid-template-columns: 0fr;
        grid-template-rows: 0fr 0fr;
        row-gap: 1rem;

}

    .header{
    width: 100%;
    height:15rem;
    position: fixed;

}

.background-header{
    width: 100%;
    height: 15rem;
    margin: 0;
    position: fixed;
}

.background-header img{
    width: 100%; height: 15rem;
}

.header .title-header{
    position: fixed;
    width: 40rem;
    height:6.3rem;
    top:2%;
}

.icon-bar{
    position: fixed;
    width: 16rem;
    height: 3rem;
    top:10.5rem;
    padding-left: 0rem;
    justify-items: center;
}

.youtube i{
    font-size: 2.2rem;
}

.back i{
    font-size: 2.2rem;
}

.homepage i{
    font-size: 2.2rem;
}

/*******************chat ****************************/
.header-chat{
    position: relative;
    height: 8rem;
    width: 40rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    text-align: center;
}

.header-chat h1{
    position: absolute;
    font-size: 5rem;
    color: white;
    margin-top: -0.1rem;
    margin-left: 9rem;
}

.header-chat .chat-line{
    position: absolute;
    background-color: white;
    width:40rem;
    height: 0.5rem;
    left: 0;
    bottom: 0;
}
/***********typ message************/

.typing{
    position: relative;
    width: 40rem;
    height: 15rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    display: grid;
    grid-template-columns: 0fr 0fr 0fr;
    z-index: 0;
}

.profile{
    position: relative;
    margin: 0rem;
    width: 70px;
    height: 70px;
    border-radius: 5rem;
    left: 1.8rem;
    top: 1.5rem;
}

.profile img{
    position: absolute;
    object-fit: cover;
    width: 100%; height: 100%;
}

.nameuser {
    position: relative;
    height: 4rem;
    padding-left:1rem;   
    padding-right:1rem;  
    left: 4rem;
    top: 1.5rem;
    border-radius: 5rem;
}

.nameuser p{  
    position: relative;
    font-size: 2rem;

}


.send-message{
    position: absolute;
    margin: 0em;
    margin-top: 0rem;
    width: 5rem;
    height: 5rem;
    text-align: center;
    top: 1.5rem;
    right: 1.5rem;
    border-radius: 2rem;
}

.send-message i{
    font-size: 3rem;
    position: relative;
    top: 0.1rem;
    color: black;
}

.typ-box-1{
    position: absolute ;
    top: 8.5rem;
    left: 2.5rem;
    width: 35rem;
    height: 4rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}
.typ-box-1 p{
    position: absolute;
    top: 0rem;
    left: 0.5rem;
    width: 10rem;
    height: 1.2rem;
    font-size:4rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}

.typ-box-1:focus{
    font-size: 1.5rem;
}


            .chat{
                background: #412465;
                width: 40rem;
                height: 45rem;
                top: 0rem;
                left: 0;
                margin-left: 0.2rem;
                z-index: 2;
                padding-top: 1rem;
                padding-bottom: 1rem;
                padding-left: 0.2rem;
                position: relative;
            }

            .show-comment{
                display: flex;
                flex-direction: column;
                grid-gap: 1rem;
                width: 100%;
                position: relative;
                z-index: 2;
            }

            .comment{
                position: relative;
                box-sizing: border-box;
                background: #F8F2FF;
                padding: 0.2rem;
                padding-top: 0;
                padding-left: 0;
                width: 25rem;
                margin-left: 5em;
                font-size:2rem;
            }

            .user-acc{
                display: flex;
                flex-direction: row;
                padding: 0.5rem;
            }

            .profile-up{
                 position: relative;
                 margin: 0rem;
                 width: 45px;
                 height: 45px;
                 border-radius: 5rem;
                 left: 0.2rem;
                 top: 0rem;
            }

            .nameuser-up{
                font-size: 0.5rem;
                padding-left: 0.5rem;   
                padding-right: 0.5rem;
                margin-top: 0.25rem;
                border-radius: 1rem;
                font-family: Mitn;
                position: relative;
                height:3rem;
                left: 1.5rem;
                top: -0.5em;
            }

            .nameuser-up p{  
                position: relative;
                font-size: 2rem;
                top: -0.5rem;

            }

            .typ-box-up p{
                position: relative;
                width: 12rem; 
                left: 0.8rem;
                top: -0.5rem;
            }

            textarea{
                resize: none;
            }

            /**** show model pic *****/
            .catalog{
                top: 18rem;
                margin-left: 2.2rem;
                margin-right: 0rem;
                position:relative;
                padding:0rem;
                padding-top:0rem;
                padding-bottom: 0rem;
                width: 100%;
                min-height: auto;
                justify-content: center;
                justify-items: center;
            }

            .video-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0.5rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 12rem;
            }
            .profile-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0.5rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 12rem;
            }

            .item-main{
                display: grid;    
                grid-template-columns: 0fr 1fr;
                column-gap: 5rem;
                row-gap: 3rem;
            }

            #down-1:hover{
                background-color: #BEDEF0;
            }

            #down-2:hover{
                background-color: #F0BEEB;
            }

            .down i{
                
                font-size: 4rem;

            }

            #down-1{
                position: absolute;
                left: 22rem; 
            }
            #down-2{
                position: absolute;
                left: 21.5rem;
            }
            
            .character{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 1rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 19.5rem;
                height: 5.5rem;
                text-align: center;
                align-items: center;
                background-color: #F0BEEB;
            }

            .animation{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 1rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 20rem;
                height: 5.2rem;
                align-items: center;
                background-color: #BEDEF0;
            }

            .character p{
                position: relative;
                margin-top: -0.4rem;
                left: 0.8rem;
                color: #23024D;
                font-size: 3.5rem;
                font-family: Mustica;
            }

            .animation p{
                position: relative;
                margin-top: -0.5rem;
                left: 0.8rem;
                color: #23024D;
                font-size: 3.5rem;
                font-family: Mustica;
    
            }

            .item-on{
                position: relative;
                width: 25rem;  
                left: 1rem;  
                top: 1.5rem;
                margin-bottom: 4rem;
            }

            .item-on-video{
                position: relative;
                width: 25rem;
                left: 1rem; 
                top: 1.5rem;
            }

            .item-on:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #F0BEEB;
                border-radius: 3rem;
            }

            .item-on-video:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #BEDEF0;
                border-radius: 3rem;
            }
            

            .item-on-video:hover .pic-item,  .item-on:hover .pic-item{
                outline: none;
                width: 20rem;
                height: 20rem;
                box-shadow: 0 0 10px 0 #23024D;
                transition: 0.5s ease-in;
            }

            .item-on p{
                position: relative;
            }

            .pic-item{
                position: relative;
                background-color: white;
                width: 20rem;
                height: 20rem;
                border-radius: 100%;
                outline: 0.5rem solid #23024D;
                cursor: pointer;
            }

            .pic-item img{
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 100%;
            }
            .name-item{
                width:10rem;
                padding: 0.5rem;  
                padding-left: 1.5rem;                
                font-size: 2.5rem; 
                left:5rem; 
            }
            
            .name-item p{
                position: relative;
                width:7rem;
                word-wrap: break-word;   
            }

            .name-item-video{
                width:10rem;
                padding: 0.5rem;  
                padding-left: 1rem;                 
                font-size:2.5rem; 
                left:5rem; 
                text-align: center;
            }

            .name-title p{
                position: relative;
                width:7rem;
                word-wrap: break-word;             
            }
}

@media screen and (min-width:1020px) and (max-width: 1080px) and (min-height: 600px) and (max-height: 1000px){

    #chat-talk.notchat{
       display: none;
    }

    .chat-talk {
        position: fixed ;
        top: 5%;
        left: 25%;
        width: 12rem;
        padding-left: 0;
        z-index: 10;
    }

    .chat-popup{
        display: visible;
        position: fixed;
        top: 80%;
        background-color: #23024D;
        z-index: 5;
        right: 4.5rem;
        padding: 1rem;
        border-radius: 5rem;
        cursor: pointer;
    }
    .chat-popup i{
        display: block;
        position: relative;
        font-size: 4rem;
        color: white;

    }


    .background{
        display: grid;
        grid-template-columns: 0fr;
        grid-template-rows: 0fr 0fr;
        row-gap: 1rem;

}

    .header{
    width: 100%;
    height:15rem;
    position: fixed;

}

.background-header{
    width: 100%;
    height: 15rem;
    margin: 0;
    position: fixed;
}

.background-header img{
    width: 100%; height: 15rem;
}

.header .title-header{
    position: fixed;
    width: 40rem;
    height:6.3rem;
    top:2%;
}

.icon-bar{
    position: fixed;
    width: 16rem;
    height: 3rem;
    top:10.5rem;
    padding-left: 0rem;
    justify-items: center;
}

.youtube i{
    font-size: 2.2rem;
}

.back i{
    font-size: 2.2rem;
}

.homepage i{
    font-size: 2.2rem;
}

/*******************chat ****************************/
.header-chat{
    position: relative;
    height: 8rem;
    width: 30rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    text-align: center;
}

.header-chat h1{
    position: absolute;
    font-size: 4rem;
    color: white;
    margin-top: 0.5rem;
    margin-left: 5.5rem;
}

.header-chat .chat-line{
    position: absolute;
    background-color: white;
    width:30rem;
    height: 0.5rem;
    left: 0;
    bottom: 0;
}
/***********typ message************/

.typing{
    position: relative;
    width: 30rem;
    height: 11rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    display: grid;
    grid-template-columns: 0fr 0fr 0fr;
    z-index: 0;
}

.profile{
    position: relative;
    margin: 0rem;
    width: 50px;
    height: 50px;
    border-radius: 5rem;
    left: 1.8rem;
    top: 1.5rem;
}

.profile img{
    position: absolute;
    object-fit: cover;
    width: 100%; height: 100%;
}

.nameuser {
    position: relative;
    height: 4rem;
    padding-left:1rem;   
    padding-right:1rem;  
    left: 4rem;
    top: 1.2rem;
    border-radius: 5rem;
}

.nameuser p{  
    position: relative;
    font-size: 2rem;

}


.send-message{
    position: absolute;
    margin: 0em;
    margin-top: 0rem;
    width: 4rem;
    height: 4rem;
    text-align: center;
    top: 1.2rem;
    right: 1.5rem;
    border-radius: 2rem;
}

.send-message i{
    font-size: 3rem;
    position: relative;
    top: 0.1rem;
    color: black;
}

.typ-box-1{
    position: absolute ;
    top: 6.5rem;
    left: 1.2rem;
    width: 28rem;
    height: 2.5rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}
.typ-box-1 p{
    position: absolute;
    top: 0rem;
    left: 0.5rem;
    width: 10rem;
    height: 1.2rem;
    font-size:4rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}

.typ-box-1:focus{
    font-size: 1.5rem;
}


            .chat{
                background: #412465;
                width: 30rem;
                height: 15rem;
                top: 0rem;
                left: 0;
                margin-left: 0.2rem;
                z-index: 2;
                padding-top: 1rem;
                padding-bottom: 1rem;
                padding-left: 0.2rem;
                position: relative;
            }

            .show-comment{
                display: flex;
                flex-direction: column;
                grid-gap: 1rem;
                width: 100%;
                position: relative;
                z-index: 2;
            }

            .comment{
                position: relative;
                box-sizing: border-box;
                background: #F8F2FF;
                padding: 0.2rem;
                padding-top: 0;
                padding-left: 0;
                width: 20rem;
                margin-left: 5rem;
                font-size:2rem;
            }

            .user-acc{
                display: flex;
                flex-direction: row;
                padding: 0.5rem;
            }

            .profile-up{
                 position: relative;
                 margin: 0rem;
                 width: 45px;
                 height: 45px;
                 border-radius: 5rem;
                 left: 0.2rem;
                 top: 0rem;
            }

            .nameuser-up{
                font-size: 0.5rem;
                padding-left: 0.5rem;   
                padding-right: 0.5rem;
                margin-top: 0.25rem;
                border-radius: 1rem;
                font-family: Mitn;
                position: relative;
                height:3rem;
                left: 1.5rem;
                top: -0.5em;
            }

            .nameuser-up p{  
                position: relative;
                font-size: 2rem;
                top: -0.5rem;

            }

            .typ-box-up p{
                position: relative;
                width: 12rem; 
                left: 0.8rem;
                top: -0.5rem;
            }

            textarea{
                resize: none;
            }

            /**** show model pic *****/
            .catalog{
                top: 18rem;
                margin-left: 2.2rem;
                margin-right: 0rem;
                position:relative;
                padding:0rem;
                padding-top:0rem;
                padding-bottom: 0rem;
                width: 100%;
                min-height: auto;
                justify-content: center;
                justify-items: center;
            }

            .video-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0.5rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 12rem;
            }
            .profile-pic{
                position: relative; 
                margin-top: 1rem;
                margin-left: 0.5rem;
                margin-right: 0rem;
                box-sizing: border-box;
                padding-bottom: 1rem;
                width: 12rem;
            }

            .item-main{
                display: grid;    
                grid-template-columns: 0fr 1fr;
                column-gap: 5rem;
                row-gap: 3rem;
            }

            #down-1:hover{
                background-color: #BEDEF0;
            }

            #down-2:hover{
                background-color: #F0BEEB;
            }

            .down i{
                
                font-size: 4rem;

            }

            #down-1{
                position: absolute;
                left: 22rem; 
            }
            #down-2{
                position: absolute;
                left: 21.5rem;
            }
            
            .character{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 1rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 19.5rem;
                height: 5.5rem;
                text-align: center;
                align-items: center;
                background-color: #F0BEEB;
            }

            .animation{
                column-gap: 1.5rem;
                position: relative;
                margin-left: 1rem;
                padding-left: 0rem;
                padding-right: 0rem;
                padding: 0.5rem;
                width: 20rem;
                height: 5.2rem;
                align-items: center;
                background-color: #BEDEF0;
            }

            .character p{
                position: relative;
                margin-top: -0.4rem;
                left: 0.8rem;
                color: #23024D;
                font-size: 3.5rem;
                font-family: Mustica;
            }

            .animation p{
                position: relative;
                margin-top: -0.5rem;
                left: 0.8rem;
                color: #23024D;
                font-size: 3.5rem;
                font-family: Mustica;
    
            }

            .item-on{
                position: relative;
                width: 25rem;  
                left: 1rem;  
                top: 1.5rem;
                margin-bottom: 4rem;
            }

            .item-on-video{
                position: relative;
                width: 25rem;
                left: 1rem; 
                top: 1.5rem;
            }

            .item-on:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #F0BEEB;
                border-radius: 3rem;
            }

            .item-on-video:hover{
                transition: 2s ease-out;
                position: relative;
                background-color: #BEDEF0;
                border-radius: 3rem;
            }
            

            .item-on-video:hover .pic-item,  .item-on:hover .pic-item{
                outline: none;
                width: 20rem;
                height: 20rem;
                box-shadow: 0 0 10px 0 #23024D;
                transition: 0.5s ease-in;
            }

            .item-on p{
                position: relative;
            }

            .pic-item{
                position: relative;
                background-color: white;
                width: 20rem;
                height: 20rem;
                border-radius: 100%;
                outline: 0.5rem solid #23024D;
                cursor: pointer;
            }

            .pic-item img{
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 100%;
            }
            .name-item{
                width:10rem;
                padding: 0.5rem;  
                padding-left: 1.5rem;                
                font-size: 2.5rem; 
                left:5rem; 
            }
            
            .name-item p{
                position: relative;
                width:7rem;
                word-wrap: break-word;   
            }

            .name-item-video{
                width:10rem;
                padding: 0.5rem;  
                padding-left: 1rem;                 
                font-size:2.5rem; 
                left:5rem; 
                text-align: center;
            }

            .name-title p{
                position: relative;
                width:7rem;
                word-wrap: break-word;             
            }

}

@media screen and (min-width:1230px) and (max-width: 1280px) and (min-height:800px){
    
    .background-header img{
    width: 100%; height: 15rem;
}

.header .title-header{
    position: fixed;
    width: 45rem;
    height:7rem;
    top:4%;
}

.icon-bar{
    position: fixed;
    width: 18rem;
    height: 3rem;
    top:10rem;
    padding-left: 0rem;
    justify-items: center;
}

.youtube i{
    font-size: 2.5rem;
}

.back i{
    font-size: 2.5rem;
}

.homepage i{
    font-size: 2.5rem;
}
    
    .chat-talk{
        position: fixed;
        left: 62.05%;
    }
    
    .header-chat{
    position: relative;
    height: 8rem;
    width: 30rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    text-align: center;
}

.header-chat h1{
    position: absolute;
    font-size: 4rem;
    color: white;
    margin-top: 0.5rem;
    margin-left: 5.5rem;
}

.header-chat .chat-line{
    position: absolute;
    background-color: white;
    width:30rem;
    height: 0.5rem;
    left: 0;
    bottom: 0;
}
/***********typ message************/

.typing{
    position: relative;
    width: 30rem;
    height: 11rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    display: grid;
    grid-template-columns: 0fr 0fr 0fr;
    z-index: 0;
}

.profile{
    position: relative;
    margin: 0rem;
    width: 50px;
    height: 50px;
    border-radius: 5rem;
    left: 1.8rem;
    top: 1.5rem;
}

.profile img{
    position: absolute;
    object-fit: cover;
    width: 100%; height: 100%;
}

.nameuser {
    position: relative;
    height: 4rem;
    padding-left:1rem;   
    padding-right:1rem;  
    left: 4rem;
    top: 1.2rem;
    border-radius: 5rem;
}

.nameuser p{  
    position: relative;
    font-size: 2rem;

}


.send-message{
    position: absolute;
    margin: 0em;
    margin-top: 0rem;
    width: 4rem;
    height: 4rem;
    text-align: center;
    top: 1.2rem;
    right: 1.5rem;
    border-radius: 2rem;
}

.send-message i{
    font-size: 3rem;
    position: relative;
    top: 0.1rem;
    color: black;
}

.typ-box-1{
    position: absolute ;
    top: 6.5rem;
    left: 1.2rem;
    width: 27.5rem;
    height: 2.5rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}
.typ-box-1 p{
    position: absolute;
    top: 0rem;
    left: 0.5rem;
    width: 10rem;
    height: 1.2rem;
    font-size:4rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}

.typ-box-1:focus{
    font-size: 1.5rem;
}


            .chat{
                background: #412465;
                width: 30rem;
                height: 18.2rem;
                top: 0rem;
                left: 0;
                margin-left: 0.2rem;
                z-index: 2;
                padding-top: 1rem;
                padding-bottom: 1rem;
                padding-left: 0.2rem;
                position: relative;
            }
            .comment{
                position: relative;
                box-sizing: border-box;
                background: #F8F2FF;
                padding: 0.2rem;
                padding-top: 0;
                padding-left: 1rem;
                width: 18rem;
                margin-left: 7rem;
                font-size:2rem;
            }

            .item-main{
                display: grid;    
                grid-template-columns: 0fr 1fr;
                column-gap: 5rem;
                row-gap: 3rem;
            }

            .catalog{
                top: 15rem;
                margin-left: 2rem;
            }

}



@media screen and (min-width:1900px) and (min-height: 1080px) {

    .background-header img{
    width: 100%; height: 15rem;
}

.header .title-header{
    position: fixed;
    width: 45rem;
    height:7rem;
    top:4%;
}

.icon-bar{
    position: fixed;
    width: 18rem;
    height: 3rem;
    top:10.5rem;
    padding-left: 0rem;
    justify-items: center;
}

.youtube i{
    font-size: 2.5rem;
}

.back i{
    font-size: 2.5rem;
}

.homepage i{
    font-size: 2.5rem;
}
    
    .chat-talk{
        position: fixed;
        left: 74.8%;
        top: 15rem;
    }
    
    .header-chat{
    position: relative;
    height: 8rem;
    width: 30rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    text-align: center;
}

.header-chat h1{
    position: absolute;
    font-size: 4rem;
    color: white;
    margin-top: 0.5rem;
    margin-left: 5.5rem;
}

.header-chat .chat-line{
    position: absolute;
    background-color: white;
    width:30rem;
    height: 0.5rem;
    left: 0;
    bottom: 0;
}
/***********typ message************/

.typing{
    position: relative;
    width: 30rem;
    height: 11rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    display: grid;
    grid-template-columns: 0fr 0fr 0fr;
    z-index: 0;
}

.profile{
    position: relative;
    margin: 0rem;
    width: 50px;
    height: 50px;
    border-radius: 5rem;
    left: 1.8rem;
    top: 1.5rem;
}

.profile img{
    position: absolute;
    object-fit: cover;
    width: 100%; height: 100%;
}

.nameuser {
    position: relative;
    height: 4rem;
    padding-left:1rem;   
    padding-right:1rem;  
    left: 4rem;
    top: 1.2rem;
    border-radius: 5rem;
}

.nameuser p{  
    position: relative;
    font-size: 2rem;

}


.send-message{
    position: absolute;
    margin: 0em;
    margin-top: 0rem;
    width: 4rem;
    height: 4rem;
    text-align: center;
    top: 1.2rem;
    right: 1.5rem;
    border-radius: 2rem;
}

.send-message i{
    font-size: 3rem;
    position: relative;
    top: 0.1rem;
    color: black;
}

.typ-box-1{
    position: absolute ;
    top: 6.5rem;
    left: 1.2rem;
    width: 27.5rem;
    height: 2.5rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}
.typ-box-1 p{
    position: absolute;
    top: 0rem;
    left: 0.5rem;
    width: 10rem;
    height: 1.2rem;
    font-size:4rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}

.typ-box-1:focus{
    font-size: 1.5rem;
}


            .chat{
                background: #412465;
                width: 30rem;
                height: 33.5rem;
                top: 0rem;
                left: 0;
                margin-left: 0.2rem;
                z-index: 2;
                padding-top: 1rem;
                padding-bottom: 1rem;
                padding-left: 0.2rem;
                position: relative;
            }
            .comment{
                position: relative;
                box-sizing: border-box;
                background: #F8F2FF;
                padding: 0.2rem;
                padding-top: 0;
                padding-left: 1rem;
                width: 20rem;
                margin-left: 7.5rem;
                font-size:2rem;
            }
            .catalog{
                top: 15rem;
                margin-left: 3rem;
            }

            .item-main{
                display: grid;
                grid-template-columns: 0fr 0fr 0fr;
                column-gap: 7rem;
            }



}

@media screen and (min-width:1440px) and (max-width:1900px) and (min-height: 900px){

    .background-header img{
    width: 100%; height: 15rem;
}

.header .title-header{
    position: fixed;
    width: 45rem;
    height:7rem;
    top:4%;
}

.icon-bar{
    position: fixed;
    width: 18rem;
    height: 3rem;
    top:10.5rem;
    padding-left: 0rem;
    justify-items: center;
}

.youtube i{
    font-size: 2.5rem;
}

.back i{
    font-size: 2.5rem;
}

.homepage i{
    font-size: 2.5rem;
}
    
.chat-talk{
        position: fixed;
        left: 70%;
        top: 15rem;
    }
    
    .header-chat{
    position: relative;
    height: 8rem;
    width: 27rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    text-align: center;
}

.header-chat h1{
    position: absolute;
    font-size: 4rem;
    color: white;
    margin-top: 0.5rem;
    margin-left: 5.5rem;
}

.header-chat .chat-line{
    position: absolute;
    background-color: white;
    width:27rem;
    height: 0.5rem;
    left: 0;
    bottom: 0;
}
/***********typ message************/

.typing{
    position: relative;
    width: 27rem;
    height: 11rem;
    left: 0;
    margin-left: 0.2rem;
    top: 0rem;
    display: grid;
    grid-template-columns: 0fr 0fr 0fr;
    z-index: 0;
}

.profile{
    position: relative;
    margin: 0rem;
    width: 50px;
    height: 50px;
    border-radius: 5rem;
    left: 1.8rem;
    top: 1.5rem;
}

.profile img{
    position: absolute;
    object-fit: cover;
    width: 100%; height: 100%;
}

.nameuser {
    position: relative;
    height: 4rem;
    padding-left:1rem;   
    padding-right:1rem;  
    left: 4rem;
    top: 1.2rem;
    border-radius: 5rem;
}

.nameuser p{  
    position: relative;
    font-size: 2rem;

}


.send-message{
    position: absolute;
    margin: 0em;
    margin-top: 0rem;
    width: 4rem;
    height: 4rem;
    text-align: center;
    top: 1.2rem;
    right: 1.5rem;
    border-radius: 2rem;
}

.send-message i{
    font-size: 3rem;
    position: relative;
    top: 0.1rem;
    color: black;
}

.typ-box-1{
    position: absolute ;
    top: 6.5rem;
    left:2rem;
    width: 23rem;
    height: 2.5rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}
.typ-box-1 p{
    position: absolute;
    top: 0rem;
    left: 0.5rem;
    width: 10rem;
    height: 1.2rem;
    font-size:4rem;
    padding: 0rem;
    padding-left: 0.2rem;
    padding-right: 0.1rem;
}

.typ-box-1:focus{
    font-size: 1.5rem;
}


            .chat{
                background: #412465;
                width: 27rem;
                height: 23rem;
                top: 0rem;
                left: 0;
                margin-left: 0.2rem;
                z-index: 2;
                padding-top: 1rem;
                padding-bottom: 1rem;
                padding-left: 0.2rem;
                position: relative;
            }
            .comment{
                position: relative;
                box-sizing: border-box;
                background: #F8F2FF;
                padding: 0.2rem;
                padding-top: 0;
                padding-left: 1rem;
                width: 18rem;
                margin-left: 7rem;
                font-size:2rem;
            }
            .catalog{
                top: 15rem;
                margin-left: 3rem;
            }

            .item-main{
                display: grid;
                grid-template-columns: 0fr 0fr;
                column-gap:10rem;
                left: 1.5rem;
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
         <div class="header">
                <img class="title-header" src="title.png">
                <div class="icon-bar">
                    <form class="back" method="post" >
                    <a href="index.php? logout='1'"><i class='bx bxs-door-open'></i></a>
                    </form>
                    <div class="homepage" name="homepage">
                        <i class='bx bxs-home' ></i>
                    </div>
                    <div class="youtube">
                        <a href="https://www.youtube.com/channel/UCx7mF0j6vV025dI43FqL-YA"><i class='bx bxl-youtube'></i></a>
                    </div>
                </div>
                <div class="background-header"><img src="header.png"></div>
            </div>
            
        <div class="background">
            
        <div class="catalog">    
                        
                
                <div class="video-pic">
                    <div class="animation">
                        <p>Animation</p>
                        <div class="down" id="down-1" onclick="down_1()">
                             <i class='bx bx-chevrons-down'></i>
                        </div>
                    </div>
        
                    <div class="item-main" id="animation">
                    <?php
                    while($row = mysqli_fetch_assoc($selectAni_query)){ 
                        $animation_name = $row['animation_name'];
                        $animation_img = $row['animation_img'];
                    ?>
                        <div class="item-on-video">
                            <a href="animation.php? AnimationID=<?php echo $row['id'];?>"><div class="pic-item">
                                <img src="<?php echo $animation_img;?>" width="100%">
                            </div></a>
                            <div class="name-item-video">
                                <div class="name-title">
                                    <p><?php echo $animation_name;?></p>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                    </div>
                </div>

                
                <div class="profile-pic">
                    <div class="character">
                        <p>Character</p>
                        <div class="down" id="down-2">
                            <i class='bx bx-chevrons-down'></i>
                        </div>
                    </div>
                    <div class="item-main" id="character">
                    <?php
                    while($row = mysqli_fetch_assoc($selectChar_query)){ 
                        $charactor_img = $row['charactor_img'];
                        $charactor_name = $row['charactor_name'];
                    ?>
                        <div class="item-on">
                            <a href="model.php? ModelID=<?php echo $row['id']; ?> "><div class="pic-item">
                                <img src="<?php echo $charactor_img ;?>">
                            </div></a>
                            <div class="name-item">
                                <p><?php echo $charactor_name;?></p>
                            </div>
                        </div>
                    <?php }?>
                    </div>   
                </div>
            </div>
        </div>
        
        <div class="chat-popup" id="chat-popup">
                 <i class='bx bxs-conversation'></i>
        </div>
        <div class="chat-talk" id="chat-talk">
                <div class="header-chat">
                                <div class="chat-title">
                                    <h1>comment</h1>
                                </div>
                                <div class="chat-line"></div>
                    </div>
                <div class="chat scroll">
                       <div class="show-comment">
                                <?php
                                while($row = mysqli_fetch_assoc($show_comment_run)) {
                                ?>
                                     
                                    <div class="comment">
                                                <div class="user-acc">
                                                    <div class="profile-up">
                                                                <img src="user.png">
                                                    </div>
                                                    <div class="nameuser-up">
                                                                <p><?php echo $row['nameuser'];
                                                                ?></p>
                                                    </div>
                                                </div>
                                    
                                                <div class="typ-box-up">
                                                    <p><?php echo $row['comment'];
                                                                ?>
                                                    </p>
                                                </div>
                                    </div>  
                                <?php } ?> 
                                </div>
                     </div>
                <div class="typing">
                                <div class="profile">
                                    <img src="user.png">
                                </div>
                                <div class="nameuser">
                                    <p><?php

                                    echo $_SESSION['joiner'];
                                                
                                    ?></p>
                                </div>
                                <form class="typ-box" method="post">
                                    <textarea type="text" class="typ-box-1" name="comments" rows="1" cols="200"></textarea>
                                    <button class="send-message" type="submit" name="sendmsg"><i class='bx bx-send' id="bx-send" ></i></button>
                                </form>
                    </div>
            </div> 
         
    
            
         <script>


            //down animation section

            let animation = document.querySelector('#animation'),
            down = document.querySelector('#down-1');

            let close = localStorage.getItem("closed_1");
            if (close === "close"){
                animation.classList.toggle("close");
            }

            down.addEventListener("click", () => {
                animation.classList.toggle("close");
                if(!animation.classList.contains("close")){
                    return localStorage.setItem("closed_1", "")
                }
                localStorage.setItem("closed_1", "close")
            })

            //down character section

            let character = document.querySelector('#character'),
            down_1 = document.querySelector('#down-2');

            let close_1 = localStorage.getItem("closed_2");
            if (close_1 === "close"){
                character .classList.toggle("close");
            }

            down_1.addEventListener("click", () => {
                character.classList.toggle("close");
                if(!character.classList.contains("close")){
                    return localStorage.setItem("closed_2", "")
                }
                localStorage.setItem("closed_2", "close")
            })

            //chat display

            let chat = document.querySelector('#chat-talk'),
            notchat = document.querySelector('#chat-popup');

            let dont_talk = localStorage.getItem("notalk");
            if (dont_talk === "notchat"){
                chat.classList.toggle("notchat");
            }

            notchat.addEventListener("click", () => {
                chat.classList.toggle("notchat");
                if(!chat.classList.contains("notchat")){
                    return localStorage.setItem("notalk", "")
                }
                localStorage.setItem("notalk", "notchat")
            })


           

        </script>
        
    </body>
</html>