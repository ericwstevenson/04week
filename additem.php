<?php
require('database.php');
$itemNum = filter_input(INPUT_POST, 'itemNum', FILTER_VALIDATE_INT);
$title = filter_input(INPUT_POST, 'title');
$description = filter_input(INPUT_POST, 'description');

$query = 'SELECT *
          FROM toDoItems
          ORDER BY itemNum';
$statement = $db->prepare($query);
$statement->execute();
$categories = $statement->fetchAll();
$statement->closeCursor();
?>
<!DOCTYPE html>
<html>
<head>
    <title>To Do List</title>
</head>
<body>
    <header><h1>To Do List</h1></header>
    <main>
        <h1>Add Item</h1>
        <form action= <?php
                           require_once('database.php');
                           $query = 'INSERT INTO toDoItems
                                    (itemNum, title, description)
                                        VALUES
                                    (:itemNum, :title, :description)';
                                    $statement = $db->prepare($query);
                                    $statement->bindValue(':itemNum', $itemNum);
                                    $statement->bindValue(':title', $title);
                                    $statement->bindValue(':description', $description);
                                    $statement->execute();
                                    $statement->closeCursor();
							?> method="post" >
            <label>itemNum:</label>
            <input type="text" name="itemNum"><br>

            <label>title:</label>
            <input type="text" name="title"><br>

            <label>Description:</label>
            <input type="text" name="description"><br>

            <label>&nbsp;</label>
            <input type="submit" value="Add Item"><br>
        </form>
        <p><a href="index.php">View Product List</a></p>
    </main>
</body>
</html>