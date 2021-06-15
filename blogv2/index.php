<?php 

require "blog/logique.php";
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
   
<?php require_once "navbar.php" ?>

<?php if(isset($_GET['info']) && $_GET['info']== "registered"){ ?>

<div class="alert alert-success" role="alert">
Successfully registered !
</div>


<?php }?>
<?php if( isset($_GET['info']) && $_GET['info'] == 'added' ){?>

<div class="alert alert-dismissible alert-success">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <strong>Well done!</strong> You successfully created <a href="#" class="alert-link">a new article</a>.
    You must publish it so it can be viewed by other users. 

</div>
<?php } ?>

<?php if( isset($_GET['info']) && $_GET['info'] == 'default' ){?>

<div class="alert alert-dismissible alert-success">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <strong>Well done!</strong> You successfully created<a href="#" class="alert-link">a new article with no picture</a>.
  You must publish it so it can be viewed by other users. 
</div>
<?php } ?>



<?php if( isset($_GET['info']) && $_GET['info'] == 'deleted' ){?>

<div class="alert alert-dismissible alert-danger">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <strong>Well done!</strong> You successfully deleted <a href="#" class="alert-link">this article</a>.
</div>
<?php } ?>


    <div class="container">
    
    
        <div class="row mt-5">
        <?php if($modeInscription){ ?>
<form method="post">

<div class="form-group">
    <label for="username">Username</label>

    <input type="text" class="form-control" name="usernameSignUp">
</div>
<div class="form-group">
<label for="password">password</label>

    <input type="password" class="form-control" name="passwordSignUp">
</div>  
<div class="form-group">
<label for="passwordRetype">Re-type password</label>

    <input type="password" class="form-control" name="passwordRetypeSignUp">
</div>      

    <div class="form-group">
    <input type="hidden" name="modeInscription" value="on">
     <input type="submit" value="Sign up" class="btn btn-success">
    </div>

</form>
<form method="POST">
<button class="btn btn-primary" name="modeInscription" value="off">Se connecter</button>
</form>
<hr>
<?php }else{ ?>


            <?php //debut de la boucle   
                    foreach($leResultatDeMaRequete as $post){
            ?>
                    
                    <div class="col-4">
                    
                            <div class="card text-white bg-success mb-3" style="max-width: 20rem;">
                            <img src="images/posts/<?php echo $post['image']?>">
                            <div class="card-header"><?php echo $post["title"]; ?></div>
                            <div class="card-body">
                                <?php if(isset($_POST['myPosts']) && $post['published']){?>
                                <span class="badge rounded-pill bg-primary">Publié</span>

                                <?php } else if(isset($_POST['myPosts']) && !$post['published']) {?>
                                    
                                <span class="badge rounded-pill bg-danger">Non publié</span>


                                 <?php } ?>   
                                <h4 class="card-title"> <a href="blog/profile.php?profile=<?php echo $post['authorid']?>" class="text-white text-decoration-none"> Auteur : <?php if($post['displayname'] == ""){echo $post["username"];} else {echo $post["displayname"]; }?></a></h4>
                                <p class="card-text"><?php echo $post["content"]; ?></p>
                            </div>
                            
                                 <a href ="blog/postUnique.php?postId=<?php echo $post['id']?>" class="btn btn-light">Voir l'article</a>
        
                            </div>
                    
                    
                    </div>
                    
            <?php //fin de la boucle
                         } ?>


<?php } ?>
        
        </div>
    
    
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

</body>
</html>