<?php
session_start();
include '18_database-connection.php';

global $db;

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id !== null && $id !== false) {
    $query = $db->prepare("SELECT * FROM fietsen WHERE categorie_id = :id");
    $query->bindParam('id', $id);
    $query->execute();

    $bikes = $query->fetchAll(PDO::FETCH_ASSOC);

    $queryCategory = $db->prepare("SELECT * FROM categorie WHERE id = :id");
    $queryCategory->bindParam('id', $id);
    $queryCategory->execute();

    $category = $queryCategory->fetch(PDO::FETCH_ASSOC);
} else {
    var_dump("test");
    die();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
if (isset($_SESSION['message'])){
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}
?>
<h1><?= $category['naam'] ?></h1>
<table>
    <?php foreach ($bikes as $bike): ?>
        <tr>
            <td>
                <?= $bike['type'] ?>
            </td>
            <td><a href="update.php?id=<?= $bike['id'] ?>"> update</a></td>
            <td><a href="delete.php?id=<?= $bike['id'] ?>"> delete</a></td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
