<!DOCTYPE html>
<!-- Xin Li -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Document</title>
</head>

<body>

    <?php
    session_start();
    ?>
    <h2>Login</h2>

    <form action="controller.php" method="post" class="container form">
        <input type="text" name="loginUsername" placeholder="Username" required />
        <br><br>
        <input type="password" name="loginPassword" placeholder="Password" required />
        <br><br>
        <input type="submit" value="Login" />
        <br><br>
        <b>
            <?php
            if (isset($_SESSION['loginError'])) {
                echo $_SESSION['loginError'];
                unset($_SESSION['loginError']);
            }
            ?>
        </b>
    </form>

    <div></div>


</body>

</html>