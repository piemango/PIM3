<?php
session_start();

include('server.php');

if (!isset($_COOKIE['addmin'])){
    header("location: log_in.php");
    die();
}

if(isset($_GET['logout'])){
    session_destroy();
    setcookie('addmin', $_SESSION['addmin'], 60);
    unset($_SESSION['name_addmin']);
    header("location: log_in.php");
}

if(isset($_GET['logout_2'])){
    session_destroy();
    header("location: login.php");
}

// ------------------ upload file --------------------------- //

$error=0;

if(isset($_POST['upload-ani']) ){

    //animation
    $animation_name = $_POST['title-animation'];
    $animation_file	 = basename($_FILES["video-file"]["name"]);
    $animation_img = basename($_FILES['img-file']["name"]);
    $story	= $_POST['story'];

     //folder
     $anifolder = "animation/" . $animation_file;
     $aniFloder_path = $_FILES["video-file"]['tmp_name'];
     move_uploaded_file($aniFloder_path, $anifolder);
     
     

     $aniImgFolder = "ani-img/" . $animation_img;
     $aniImg_path = $_FILES['img-file']['tmp_name'];
     move_uploaded_file($aniImg_path, $aniImgFolder);
    

    if($error==0){
       
        $insert_animation = "INSERT into animation(animation_name, animation_file, animation_img, story) 
        VALUES('$animation_name', '$anifolder', '$aniImgFolder', '$story')";
        $query_animation = mysqli_query($conn, $insert_animation);
        header('location: post.php');
    }
}

if(isset($_POST['upload-char']) ){
    
//charactor
$charactor_name = $_POST['name-char'];
$charactor_file = basename($_FILES['model-file']["name"]);
$charactor_img	= basename($_FILES['picture-file']["name"]);
$charactor_describe	= $_POST['describe'];

 //folder
 $charFolder = "model/" . $charactor_file;
 $char_path = $_FILES['model-file']['tmp_name'];
 move_uploaded_file($char_path, $charFolder);

 $charImgFolder = "char-img/" . $charactor_img;
 $charImg_path = $_FILES['picture-file']['tmp_name'];
 move_uploaded_file($charImg_path, $charImgFolder);

 if($error==0){

    $insert_charactor = "INSERT into charactor(charactor_name, charactor_file, charactor_img, charactor_describe) 
    VALUES('$charactor_name', '$charFolder', '$charImgFolder', '$charactor_describe')";
    $query_charactor = mysqli_query($conn, $insert_charactor);
    header('location: post.php');
}

}

$_SESSION['addmin'] = $_COOKIE['addmin'];

?>

<!DOCTYPE html>
<html lang="eng">
    <head>
        <title> PIMY 3 - post </title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="x-icon" href="kaprikorn.png">
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
                background-size: cover;
            }

            section{
                position: relative;
                margin: 0;
                width: 100%; height: 100%;
            }
            
            header{
                position: relative;
                width: auto; height: 9.5rem;
                padding: 1rem;
                padding-left: 3rem;
                background-color: #AB9DFF;
                display: grid;
                grid-template-columns: 0fr 0fr 0fr;
                column-gap: 18.5em;
                align-items: center;
                font-family: Kanit;
            }
            header a{
                font-size: 1.5rem;
                color: #AB9DFF;
                background-color: white;
                width: 12rem;
                position: relative;
                left: 0rem;
                text-decoration: none;
                text-align: center;
                border-radius: 2rem;
            }
            header a:hover{
                background-color: #8276CD;
                color: #AB9DFF;
                transition: 0.5s ease-in;

            }
            header h1{
                font-size: 3rem;
                background-color: white;
                width: 24rem;
                position: relative;
                color: white;
                background-color: #AB9DFF;
            }

            header #logout-2{
                position: relative;
            }

            /******************** add works *********************/
            .add{
                position: relative;
                width: auto; height: 100%;
                padding: 5rem;
                background-color: #D1CAFF;
                display: grid;
                grid-template-columns: 0fr;
                justify-content: center;
            }

            form{
                position: relative;
                display: grid;
                grid-template-columns: 0fr;
                grid-template-rows: 0fr 0fr;
                row-gap: 5rem;
                justify-items: center;
            }
            
            .form{
                position: relative;
                display: grid;
                grid-template-columns: 0fr 0fr;
                column-gap: 10rem;
                align-items: center;
                justify-items: center;
            }

            p{
                font-size: 2rem;
                font-family: Kanit;
                color: #8276CD;

            }

            input{
                font-size: 1.5rem;
                font-family: Kanit;
                padding: 0.5rem;
                border: none;
                outline: none;
                color: #8276CD;
                border-radius: 2rem;
                padding-left: 1rem;
                padding-right: 1rem;
                box-sizing: border-box;
            }
            input:focus{
                background-color: #AB9DFF;
            }


            button{
                position: relative;
                font-size: 1.5rem;
                font-family: Kanit;
                margin-top: 1rem;
                width: 12rem;
                background-color: #8276CD;
                color: white;
                border: none;
                border-radius: 2rem;
                box-shadow: 0 0 10px 0 #8276CD;
                cursor: pointer;
            }

            button:hover{
                background: #AB9DFF;
                color: #8276CD;
                box-shadow: 0 0 10px 0 #AB9DFF;
                transition: 0.5s ease-in;
            }


            input[type="file"]::file-selector-button{
                position: relative;
                font-size: 1.5rem;
                font-family: Kanit;
                border-radius: 2rem;
                background: #8276CD;
                color: white;
                margin-right: 1rem;
                border: none;
                padding: 0.5rem;
                box-shadow: 0 0 10px 0 #8276CD;
                cursor: pointer;
            }

            input[type="file"]::file-selector-button:hover{
                background: #AB9DFF;
                color: #8276CD;
                box-shadow: 0 0 10px 0 #AB9DFF;
                transition: 0.5s ease-in;
            }

            .file-up{
                background-color: #C1B7FC;
            }

            textarea{
                font-size: 1.5rem;
                font-family: Kanit;
                padding: 0.5rem;
                border-radius: 2rem;
                box-sizing: border-box;
                padding-left: 1rem;
                padding-right: 1rem;
                resize: none;
                border: none;
                outline: none;
                color: #8276CD;
            }

            textarea:focus{
                background-color: #AB9DFF;
            }

            

            div .animation{
                display: grid;
                grid-template-columns: 0fr;
                row-gap: 1rem;
                justify-content: center;
                align-items: center;
            }

            div .charactor{
                display: grid;
                grid-template-columns: 0fr;
                row-gap: 1rem;
                justify-content: center;
                align-items: center;
            }

            ::-webkit-scrollbar{
                display: none;
            }



        </style>
    </head>
    <body>

        <section class="post-works">
            <header>
                <a href="post.php? logout='1'" class="header-logout">กลับสู่หน้าแรก</a>
                <h1>
                     ยินดีต้อนรับ <?php echo $_SESSION['addmin']; ?>
                </h1>
                <a href="post.php? logout_2='1'" class="header-logout" id="logout-2">ออกจากแอดมิน</a>
            </header>
            <div class="add">
                <form class="upload" method="post" enctype="multipart/form-data">
                  <div class="form">
                    <div class="animation">
                          <p>ชื่อเรื่อง</p>
                          <input type="text" name="title-animation">
                           <p>อัพโหลดแอนิเมชัน</p>
                          <input type="file" name="video-file" class="file-up" id="file-up">
                          <p>ภาพแอนิเมชัน</p>
                          <input type="file" name="img-file" class="file-up" id="file-up">
                          <p>เนื้อเรื่อง</p>
                          <textarea type="text" name="story" rows="5" cols="10"></textarea>
                          <button type="submit" name="upload-ani">อัพโหลด</button>
                    </div>
                    <div class="charactor">
                          <p>ชื่อตัวละคร</p>
                          <input type="text" name="name-char">
                          <p>อัพโหลดตัวละคร</p>
                          <input type="file" name="model-file" class="file-up" id="file-up">
                          <p>ภาพตัวละคร</p>
                          <input type="file" name="picture-file" class="file-up" id="file-up">
                          <p>คำอธิบาย</p>
                          <textarea type="text" name="describe" rows="5" cols="10"></textarea>
                          <button type="submit" name="upload-char">อัพโหลด</button>
                    </div>
                   </div>
                </form>

                
            </div>

        </section>





    </body>
</html>