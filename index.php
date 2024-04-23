<?php
session_start();

if(isset($_GET['logout'])){    
    $logout_message = "<div class='msgln'><span class='left-info'>User <b class='user-name-left'>" . htmlspecialchars($_SESSION['name']) . "</b> has left the chat session.</span><br></div>";
    file_put_contents("log.html", $logout_message, FILE_APPEND | LOCK_EX);
    session_destroy();
    header("Location: index.php");
    exit();
}

if(isset($_POST['enter'])){
    if($_POST['name'] != ""){
        $_SESSION['name'] = htmlspecialchars($_POST['name']);
    }
    else{
        echo '<script>alert("Please type in a name");</script>';
    }
}

function loginForm(){
    echo 
    '<div id="loginform"> 
        <p>Please enter your name to continue!</p> 
        <form action="index.php" method="post"> 
            <label for="name">Name:</label> 
            <input type="text" name="name" id="name" /> 
            <input type="submit" name="enter" id="enter" value="Enter" /> 
        </form> 
    </div>';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Chat Application</title>
    <meta name="description" content="Tuts+ Chat Application" />
    <link rel="stylesheet" href="style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
</head>
<body>
    <?php if(!isset($_SESSION['name'])) { 
        loginForm();
    } else { ?>
<div id="wrapper">
    <div id="menu">
            <p class="welcome">Welcome, <b><?php echo htmlspecialchars($_SESSION['name']); ?></b></p>
            <p class="actions">
                <a id="delete" href="#">Delete Chats</a> | 
                <a id="exit" href="#">Exit Chat</a>
            </p>
        <?php } ?>
    </div>
    <?php
    if(isset($_SESSION['name'])){
    ?>
    <div id="chatbox">
        <?php
        if(file_exists("log.html") && filesize("log.html") > 0){
            $contents = file_get_contents("log.html");          
            echo htmlspecialchars($contents);
        }
        ?>
    </div>
    <form name="message" action="" onsubmit="return validateForm()">
        <input name="usermsg" type="text" id="usermsg" />
        <input name="submitmsg" type="submit" id="submitmsg" value="Send" />
    </form>
    <?php } ?>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="script.js"></script>
</body>
</html>
