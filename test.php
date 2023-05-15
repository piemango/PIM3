<?php
 include('server.php');

 if(isset($_POST['sendmsg'])){
    $nameuser = $_SESSION['joiner'];
    $comments = $_POST['comments'];
    $insert = "INSERT into commented(nameuser, comment) VALUES('$nameuser', '$comments')";
    $insert_run = mysqli_query($conn, $insert);
    unset($comments);
    header('location: test.php');
}

$show_comment = "SELECT * FROM commented";
$show_comment_run = $conn->query($show_comment);
?>



<style>
    /*******************chat ****************************/
.header-chat{
    position: relative;
    height: 2.5rem;
    width: 10rem;
    left: 45%;
    top: 6.5rem;
}

.header-chat h1{
    position: absolute;
    font-size: 1.5rem;
    color: white;
    margin-top:-0.2rem;
    margin-left: 1.65rem;
}

.header-chat .chat-line{
    position: absolute;
    background-color: white;
    width: 10rem;
    height: 0.5rem;
    left: 0;
    bottom: 0;
}
/***********typ message************/

.typing{
    position: relative;
    width: 10rem;
    height: 4.5rem;
    left: 45%;
    top: 1.3rem;
    display: grid;
    grid-template-columns: 0fr 0fr 0fr;
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
    position: relative;
    margin: 0em;
    margin-top: 0rem;
    right: 1rem;
    width: 1.5rem;
    height: 1.3rem;
    text-align: center;
    top: 0.5rem;
    left: 2.4rem;
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
    width: 9rem;
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
                width: 10rem;
                height: 15rem;
                top: 4rem;
                left: 45%;
                z-index: 2;
                padding-top: 3rem;
                padding-bottom: 1rem;
                padding-left: 0.5rem;
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
                position: absolute;
                box-sizing: border-box;
                background: #F8F2FF;
                padding: 0.5rem;
                padding-top: 0;
                padding-left: 0;
                width: 8rem;
                margin-left: 0.4rem;
                font-size: 0.8rem;
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
                width: 7rem; 
                left: 0.5rem;
                top: -0.5rem;
            }

            textarea{
                resize: none;
            }

</style>

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
