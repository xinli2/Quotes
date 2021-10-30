<?php
// This file contains a bridge between the view and the model and redirects back to the proper page
// with after processing whatever form this code absorbs. This is the C in MVC, the Controller.
//
// Authors: Rick Mercer and Xin Li
//  
session_start();

require_once './DatabaseAdaptor.php';

$theDBA = new DatabaseAdaptor();

if (isset($_GET['todo']) && $_GET['todo'] === 'getQuotes') {
    $arr = $theDBA->getAllQuotations();
    unset($_GET['todo']);
    echo getQuotesAsHTML($arr);
}

if (isset($_POST['update'])) {
    $update = $_POST['update'];
    if ($update === 'increase') {
        $theDBA->increaseRating($_POST['ID']);
    } else if ($update === 'decrease') {
        $theDBA->decreaseRating($_POST['ID']);
    } else if ($update === 'delete') {
        $theDBA->deleteQuote($_POST['ID']);
    }
    header("Location: view.php");
}

if (isset($_POST['newQuote']) && isset($_POST['author'])) {
    // protect by sanitize input from user. 
    $newQuote = htmlspecialchars($_POST['newQuote']);
    $author = htmlspecialchars($_POST['author']);

    $theDBA->addQuote($newQuote, $author);
    header("Location: view.php");
}

// the registering 
if (isset($_POST['registerUsername']) && isset($_POST['registerPassword'])) {

    $registerUsername = htmlspecialchars($_POST['registerUsername']);
    $registerPassword = htmlspecialchars($_POST['registerPassword']);

    if ($theDBA->accountExists($registerUsername)) {
        $_SESSION["registerError"] = "Acount name already taken.";
        header("Location: register.php");
    } else {
        $theDBA->addUser($registerUsername, $registerPassword);
        header("Location: view.php");
    }
}

if (isset($_POST['loginUsername']) && isset($_POST['loginPassword'])) {

    $loginUsername = htmlspecialchars($_POST['loginUsername']);
    $loginPassword = htmlspecialchars($_POST['loginPassword']);

    if ($theDBA->verifyCredentials($loginUsername, $loginPassword)) {
        $_SESSION["username"] = $loginUsername;
        header("Location: view.php");
    } else {
        $_SESSION["loginError"] = "Invalid Account/Password";
        header("Location: login.php");
    }
}

if (isset($_POST['logout'])) {
    unset($_SESSION['username']);
    header("Location: view.php");
}

function getQuotesAsHTML($arr)
{
    $result = '';
    // $result .= '<link rel="stylesheet" type="text/css" href="styles.css">';
    foreach ($arr as $quote) {
        $result .= '<div class="container">';
        $result .= '"' . $quote['quote'] . '" <br>';
        $result .= '<p class="author"> &nbsp;&nbsp; -- ' . $quote['author'] . '<br></p>';
        $result .= ' <form action="controller.php" method="post">';
        $result .= '<input type="hidden" name="ID" value="' . $quote['id'] . '">&nbsp;&nbsp;&nbsp;';
        $result .= ' <button name="update" value="increase">+</button>';
        $result .= '&nbsp;<span id="rating"> ' . $quote['rating'] . '</span>&nbsp;&nbsp;';
        $result .= '<button name="update" value="decrease">-</button>&nbsp;&nbsp;';
        if (isset($_SESSION["username"])) {
            $result .= '<button name="update" value="delete">Delete</button>';
        }
        $result .= ' </form></div>';
    }

    return $result;
}
