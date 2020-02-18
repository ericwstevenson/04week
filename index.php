<?php
require_once('database.php');

$itemNum = filter_input(INPUT_POST, 'itemNum', FILTER_VALIDATE_INT);

if (!isset($itemNum)) {
    $itemNum = filter_input(INPUT_GET, 'itemNum', 
            FILTER_VALIDATE_INT);
    if ($itemNum == NULL || $itemNum == FALSE) {
        $itemNum = 1;
		echo "No to do list items exist yet.";
    }
}
$query = 'SELECT * FROM toDoItems
          ORDER BY itemNum';
$statement = $db->prepare($query);
$statement->bindValue(':itemNum', $itemNum);
$statement->execute();
$item = $statement->fetch();
$items = $statement->fetchAll();
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
    <section>
        <table>
            <tr>
                <th>ItemNum</th>
                <th>Title</th>
                <th>Description</th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach ($items as $item) : ?>
            <tr>
                <td><?php echo $item['itemNum']; ?></td>
                <td><?php echo $item['title']; ?></td>
                <td><?php echo $item['description']; ?></td>
                <td><form action= <?php 
				                  if ($itemNum != false) {
                                      $query = 'DELETE FROM toDoItems
                                      WHERE itemNum = :itemNum';
                                      $statement = $db->prepare($query);
                                      $statement->bindValue(':itemNum', $itemNum);
                                      $success = $statement->execute();
                                      $statement->closeCursor();    
                                      } ?> method="post">
                    <input type="hidden" name="itemNum"
                           value="<?php echo $item['itemNum']; ?>">
                    <input type="submit" value="Remove">
                </form></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <p><a href="additem.php">Click Here to add a new item to the list.</a></p>      
    </section>
</main>
</body>
</html>