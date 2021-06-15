<?php
require_once 'logique.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/solar/bootstrap.css">

</head>
<body>
    <?php require_once dirname(__FILE__)."/../navbar.php" ?>

<div class="container">
<h1>Modification de votre profil</h1>
<p>Bien arrivé edit profil</p>

  <?php  foreach($resultatRequeteProfil as $value){ ?>

<!-- Modification du displayname et du mail -->
    <form action="" method="POST">
    
    <input type="hidden" name="userIdAModifier" value="<?php echo $value['id'] ?>">
    <input type="text" class="form-control" name="displayName" id="" value="<?php echo $value['displayname']?>" placeholder="Votre pseudo">
    <input type="text" name="email" class="form-control" value="<?php echo $value['email']?>" placeholder="Votre adresse mail">
    <input class="form-control btn btn-success" type="submit" value="Enregistrer les modifications">
    </form>

<!-- Modification/upload photo profil -->
    <h2>Télécharger une photo de profil</h2>
    <form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="pictureToUpload">
    <input type="hidden" name="profilePic" value="upload">
    <input type="hidden" name="userId" value="<?php echo $value['id']?>">
    <button type="submit" class="btn btn-info" value="">Envoyer</button>
    </form>

  <?php } ?>

</div>
</body>
</html>