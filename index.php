<?php
require 'connect.php';
function cleanInput(string $value): string
{
    $value = trim($value);
    $value = htmlspecialchars($value);
    $value = ucfirst($value);
    return $value;
}
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = cleanInput($_POST['name']);

    if (empty($name)) {
        $errors[] = 'Le champ ne peut être vide';
    }
    if (empty($errors)) {
        $pdo = new PDO(DSN, USER, PASS);
        $query = 'INSERT INTO membres (name) VALUES (:name)';
        $statement = $pdo->prepare($query);
        $statement->bindValue(':name', $name, PDO::PARAM_STR);
        $statement->execute();
        $id = $pdo->lastInsertId();
        header('Location: /index.php?id=' . $id);
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<header>
    <h1>Les Argonautes</h1>
    <img src="https://www.wildcodeschool.com/assets/logo_main-e4f3f744c8e717f1b7df3858dce55a86c63d4766d5d9a7f454250145f097c2fe.png" alt="Wild Code School logo" />
</header>
<main class="mt-4">
    <h2>Ajouter un(e) Argonaute</h2>
    <form action="" method="post" class="new-member-form">
        <label for="name">Nom de l'Argonaute</label>
        <?php foreach ($errors as $error): ?>
            <p><?= $error ?></p>
        <?php endforeach; ?>
        <input class="form-control" id="name" name="name" type="text" placeholder="Charalampos" />
        <button class="btn btn-dark rounded-pill mt-4" type="submit">Ajouter</button>
    </form>
    <?php
        $pdo = new PDO(DSN,USER,PASS);
        $query = 'SELECT * FROM membres';
        $statement = $pdo->query($query);
        $membres = $statement->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <h2>Membres de l'équipage</h2>
    <section class="member-list d-flex flex-wrap mt-3 fs-4">
        <?php foreach ($membres as $membre) :?>
            <div class="col-4 mt-3"><?= $membre['name'];?></div>
        <?php endforeach; ?>
    </section>
</main>

<footer>
    <p>Réalisé par Jason en Anthestérion de l'an 515 avant JC</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>
