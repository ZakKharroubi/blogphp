<?php 
require_once "logique.php";

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
<?php
if($isAdmin){?>

<p>Salut admin</p>

<h2>Gestion des articles </h2>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Titre</th>
      <th scope="col">Auteur</th>
      <th scope="col">Lien vers l'article</th>
      <th scope="col">Statut publication</th>
      <th scope="col">Suppression</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($resultatPostsAdmin as $value) {?>
    <tr>
      <th scope="row"><?php echo $value['id']?></th>
      <td><?php echo $value['title']?></td>
      <td><?php echo $value['username']?></td>
      <td><a href="postUnique.php?postId=<?php echo $value["id"]?>" class="btn btn-primary">Voir l'article</a></td>
      <td><?php if($value['published']){ ?>
      <!-- Formulaire Dépubli admin -->
      <form method="POST">

    
      <input type="hidden" name="unpublishAdmin" value="<?php echo $value['id']?>">
      <button type="submit" class="btn btn-warning">Dé-publier</button>

      </form>
      <?php } else {?>
      <!-- Formulaire Publi admin -->
      <form method="POST">

      <input type="hidden" name="publishAdmin" value="<?php echo $value['id']?>">
      <button type="submit" class="btn btn-primary">Publier</button>

      </form>
      <?php }?>
      </td>
      <td>
      <!-- Formulaire Suppr admin -->
      <form method="POST">      
      
      <input type="hidden" name="deleteAdmin" value="<?php echo $value['id']?>">
      <button type="submit" class="btn btn-danger">Supprimer</button>

      </form>
      </td>
    </tr>
    <?php }?>

  </tbody>
</table>

<h2>Gestion des utilisateurs</h2>

<table class="table">
<thead>
<th>#</th>
<th>username</th>
<th>display name</th>
<th>Suppression</th>
</thead>
<tbody>
<?php foreach($resultatUsersAdmin as $value){ ?>
<tr>
<td><?php echo $value['id']?></td>
<td><?php echo $value['username']?></td>
<td><?php echo $value['displayname']?></td>
<td>
<form method="POST">      
<input type="hidden" name="deleteAccountAdmin" value="<?php echo $value['id']?>">
<button type="submit" class="btn btn-danger">Supprimer</button>
</form>
</td>
</tr>
<?php } ?>
</tbody>
</table>




<?php } else {?>
<p>Salut pas admin</p>


<?php } ?>
</body>

</html>







