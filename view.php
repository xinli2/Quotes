<!-- 
This is the home page for Final Project, Quotation Service. 
It is a PHP file because later on you will add PHP code to this file.

File name quotes.php 
    
Authors: Rick Mercer and Xin Li
-->

<!DOCTYPE html>
<html>

<head>
	<title>Quotation Service</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body onload="showQuotes()">

	<?php
	session_start();
	?>

	<h1>Quotation Service</h1>

	<?php
	if (isset($_SESSION["username"])) {
		echo "<a href='./addQuote.php'><button>Add Quote</button></a>";
		echo "<form action='controller.php' method='post' class='logout'><input type='hidden' name='logout' value='logout'><input type='submit' value='Logout'></form>";
		echo "<b>&nbsp; Hello " . $_SESSION["username"] . "!</b>";
	} else {
		echo "<a href='./register.php'><button>Register</button></a>";
		echo "<br>";
		echo "<a href='./login.php'><button>Login</button></a>";
	}
	?>

	<div id="quotes"></div>

	<script>
		var element = document.getElementById("quotes");

		function showQuotes() {
			var ajax = new XMLHttpRequest();
			ajax.open("GET", "controller.php?todo=getQuotes", true);
			ajax.send();
			ajax.onreadystatechange = function() {
				if (ajax.readyState == 4 && ajax.status == 200) {
					var theDiv = document.getElementById("quotes");
					theDiv.innerHTML = ajax.responseText;
				}
			}

		} // End function showQuotes
	</script>

</body>

</html>