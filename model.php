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

// model show //
$model = "SELECT * FROM charactor WHERE id='$_GET[ModelID]'";
$model_query = mysqli_query($conn, $model);

?>

<!DOCTYPE html>
<html lang="eng">
    <head>
        <title> PIMY 3 </title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link rel="icon" type="x-icon" href="kaprikorn.png">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
        <script type="module" src="https://unpkg.com/@google/model-viewer@3.1.0/dist/model-viewer.min.js"></script>
        <script type="text/javascript">
            function preventBack(){window.history.forward()};
            setTimeout("preventBack()", 0);
               window.onunload=function(){null;}
        </script>
        <style>
            /*****************************************model*****************************************/
        @font-face{
            font-family: Mitn;
            src: url(font/MiTNThin.ttf);
        }

        @font-face{
            font-family: Mustica;
            src: url(font/MusticaPro-SemiBold.otf);
        }

        @font-face{
            font-family: Dinomilk;
            src: url(font/Dinomik.otf);
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

        .story-cont{
            margin: 2rem;
            margin-left: 3rem;
            display: grid;
            grid-template-columns: 0fr 1fr;
            box-sizing: border-box;
            position: relative;
            padding-top: 1rem;
            padding-bottom: 1rem;  
            padding-left: 3rem;
            padding-right: 0;
            width: 86rem;
        }

        /*************model***********/
        .model{
            width: 26rem;
            position: relative;
            justify-items: left;
            padding: 1rem 0.5rem;
            display: grid;
            grid-template-rows: 0fr 0fr;
            row-gap: 0;
            left: 2.5rem;

        }

        .item{
            left: 1rem;
            z-index: 5;
            position: relative;
            top: 1.8rem;
        }

        .item:hover{
            transform: translateY(-0.5rem);
            transition: 1s ease-in;
        }

        .item model-viewer{
            width: 360px;
            height: 480px;
        }

        /*************stage*****************/

        .stage{
            bottom: 2rem;
            position: relative;
            justify-items: center;
            left: 2.5rem;
        }

        .low-stage{
            position: relative;
            background-image: linear-gradient(60deg, #f6f6f6,#c7cacd,#b9c0c5,#e5e6e7);
            width: 19rem;
            height: 5.8rem;
            border-radius: 2.5rem;
            box-shadow: 0 2px 10px 0 black;
        }

        .middle-stage{
            position: relative;
            background-image: linear-gradient(60deg, #f5e143, #936303,#c1970c);
            width: 19rem;
            height: 3.5rem;
            padding-bottom: 0.2rem;
            border-radius: 5rem;
        }

        .top-stage{
            position: relative;
            background-color: #c8cbce;
            width: 19rem;
            height: 3rem;
            border-radius: 5rem 5rem 7rem 7rem;
            padding-bottom: 0.2rem;
            z-index: 1;
        }

        .top1-stage{
            position: relative;
            background-image: linear-gradient(180deg,#f5f5f5,#e7eaec,#f4f4f5,#d6d6d7);
            width: 19rem;
            height: 3rem;
            left: 0rem;
            top:-0.42rem;
            border-radius: 3rem;
            z-index: 2;
        }

        /********************story****************************/
        .story-1{
                position: relative;
                background-color: white;
                width: 40rem;
                height: 36rem;
                border-radius: 2rem;
                opacity: 92%;
                display: grid;
                grid-template-rows: 2fr 0fr;
                row-gap: 1rem;
                justify-items: center;
                right: -12.5rem;
                top: 1rem;
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
                width: 18rem;
                background-color: white;
                box-shadow: 0 2px 10px 0 black;
            }
            .text-title p{
                width: 15rem;
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
            
            /********************* responsive *******************************/
@media screen and (min-width:210px) and (max-width: 250px){

}

@media screen and (min-width:260px) and (max-width: 300px){

}

@media screen and (min-width:310px) and (max-width: 340px){
    
}

@media screen and (min-width:341px) and (max-width: 370px){

}



@media screen and (min-width:371px) and (max-width: 389px){

}

@media screen and (min-width:390px) and (max-width: 420px){

}

@media screen and (min-width:480px) and (max-width: 540px){

}

@media screen and (min-width:600px) and (max-width: 660px){

}

@media screen and (min-width:600px) and (max-width: 660px) and (min-height: 300px) and (max-height: 400px){

}

@media screen and (min-width:710px) and (max-width: 770px){

}

@media screen and (min-width:800px) and (max-width: 850px){

}

@media screen and (min-width:900px) and (max-width: 960px){

}

@media screen and (min-width:1020px) and (max-width: 1080px){

}

@media screen and (min-width:1080px) and (max-width: 1100px) and (min-height:2300px) and (max-height:2350px){

}

@media screen and (min-width:1020px) and (max-width: 1080px) and (min-height: 600px) and (max-height: 1000px){

}

@media screen and (min-width:1230px) and (max-width: 1280px) and (min-height:800px){

}



@media screen and (min-width:1900px) and (min-height: 1080px) {

}

@media screen and (min-width:1440px) and (max-width:1900px) and (min-height: 900px){

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
        <section class="story-cont">    
            <?php
                while($row = mysqli_fetch_assoc($model_query)){
                    $model = $row['charactor_file'];
                    $name = $row['charactor_name'];
                    $describe = $row['charactor_describe'];
                    $img = $row['charactor_img'];
            ?>
            <div class="model">
                <div class="item" id="item">
                    <model-viewer  
                    src="<?php echo $model ?>" 
                    camera-controls 
                    shadow-intensity="1"
                    disable-zoom>
                    </model-viewer>
                </div>

                <div class="stage">
                    <div class="low-stage">
                        <div class="middle-stage">
                            <div class="top-stage">
                                <div class="top1-stage"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>             
            <div class="story-1">
                <div class="story-tell scroll">
                    <div class="text-story">
                        <div class="title">
                            <div class="text-title">
                                <p><?php echo $name?></p>
                            </div>
                            <div class="img-title">
                                <img src="<?php echo $img?>">
                            </div>
                        </div>
                        <div class="describe">
                            <p> <?php echo $describe ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="icon-bar">
                    <form class="back" method="get" >
                    <a href="model.php? logout='1'"><i class='bx bxs-door-open'></i></a>
                    </form>
                    <form class="homepage" method="get">
                        <a href="model.php? backhome='1'"><i class='bx bxs-home' ></i></a>
                    </form>
                    <div class="youtube">
                        <a href="https://www.youtube.com/channel/UCx7mF0j6vV025dI43FqL-YA"><i class='bx bxl-youtube'></i></a>
                    </div>
                </div>
            </div>
        </section>
        
    </body>
</html>