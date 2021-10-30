<!DOCTYPE html>
<!-- Xin Li -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Add a Quote</title>
</head>

<body>
    <h1>Add a Quote</h1>
    <form action="controller.php" method="post" class="container form">
        <textarea name="newQuote" rows="5" cols="50" placeholder="Enter a new quote"></textarea>
        <br>
        <input type="text" name="author" placeholder="Author" />
        <br><br>
        <input type="submit" value="Add Quote" />
    </form>

</body>

</html>