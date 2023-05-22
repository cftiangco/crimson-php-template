<?php

require_once './models/UserModel.php';

$model = new UserModel();


if(isset($_POST['submit'])) {
    $data = ['username' => $_POST['username'], 'pword' => $_POST['pword']];
    $insertedId = $model->insert($data);
    echo $insertedId;
}

$conditions = ['username' => 'lebron'];
$columns = '*';
$results = $model->select($conditions, $columns);

print_r($results);

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
        <input type="text" name="username" id="username">
        <input type="password" name="pword" id="pword">
        <input type="submit" value="submit" name="submit">
    </form>
</body>
</html>