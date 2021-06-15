<?php include "logique.php"?>

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

<?php if( isset($_GET['info']) && $_GET['info'] == 'forbidden' ){?>

<div class="alert alert-dismissible alert-danger">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <strong>Nope ! </strong> You need to be logged in in order to comment a post.
</div>
<?php } ?>

<?php if( isset($_GET['info']) && $_GET['info'] == 'unpublishedError' ){?>

<div class="alert alert-dismissible alert-danger">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <strong>ERROR !  </strong> Your post couldn't be unpublished. 
</div>
<?php } ?>
<?php if( isset($_GET['info']) && $_GET['info'] == 'notPublished' ){?>

<div class="alert alert-dismissible alert-danger">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <strong>ERROR !  </strong> Your post couldn't be published. 
</div>
<?php } ?>



<?php if( isset($_GET['info']) && $_GET['info'] == 'published' ){?>

<div class="alert alert-dismissible alert-success">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <strong>Well done!</strong> You successfully published <a href="#" class="alert-link">this article</a>.
</div>
<?php } ?>
<?php if( isset($_GET['info']) && $_GET['info'] == 'unpublished' ){?>

<div class="alert alert-dismissible alert-success">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <strong>Well done!</strong> You successfully unpublished <a href="#" class="alert-link">this article</a>.
</div>
<?php } ?>


<?php if( isset($_GET['info']) && $_GET['info'] == 'edited' ){?>

<div class="alert alert-dismissible alert-success">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <strong>Well done!</strong> You successfully edited <a href="#" class="alert-link">this article</a>.
</div>
<?php } ?>


<?php if( isset($_GET['info']) && $_GET['info'] == 'pasLeDroit' ){?>

<div class="alert alert-dismissible alert-danger">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <strong>Well done!</strong> Vous n'avez pas le droit de modifier cet article <a href="#" class="alert-link">this article</a>.
</div>
<?php } ?>
    <div class="container mt-5">



   
  <div class="container">
  
  
  

<?php
    foreach($leResultatDeMaRequeteArticleUnique as $value){?>
                  
                  <div class="row text-center">
                  
                    <h2><?php echo $value["title"];?></h2>
                  
                  </div>
                  <div class="row text-center">
                  <img src="../images/posts/<?php echo $value['image'] ?>" alt="">

                  </div>
                  <div class="text-center">
                      <p><?php echo $value['content'];?></p>
                  </div>
                  
                    
                   
                   
            
    </div>
    </div>
<?php if($isLoggedIn && $isOwner){?>
            <div class="row">
              <form action="edition.php" method="post">
                <div class="text-center">
                  <button type="submit" name="postId" value="<?php echo $value['id']?>" class="btn btn-primary">Modifier</button>
                </div>
              </form>
            </div>

    <form action="" method="post">
    
    <?php if($value['published']){?>

    <button type="submit" class="btn btn-danger" name="unPublish" value="<?php echo $value['id']?>">Dé-publier</button>

    <?php }else{?>

    <button type="submit" name ="publish" value="<?php echo $value['id']?>" class="btn btn-success">Publier</button>
      <?php }?>

    </form>



     <?php } ?>




    <div class="text-center">
    
            <a href="/blogv2" class="btn btn-danger">Retour a l'accueil</a>
    </div>
    
    <?php if($isLoggedIn){ ?>

      <form action="" method="post">
      <div class="form-group">
        <input type="text" name="comment" class="form-control" id="" placeholder="Votre commentaire">
        <input type="hidden" name="postIdComment" value="<?php echo $value['id']?>">
        <input type="hidden" name="authorId" value="<?php echo $_SESSION['userId']?>">
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-success">Poster le commentaire</button>
      </div>
      </form>
   <?php }?>

   <?php } ?>
    
    <?php foreach($mesCommentaires as $comment){ ?>

    <div class="row">
    <p><strong> <?php if($comment['displayname'] != ""){echo $comment['displayname'];}else {echo $comment['username'];}?>  </strong></p>
    <p> <?php echo $comment['content'];?></p>
    
    </div>
    <hr>

    <?php }?>
    
    
    
    
</body>
</html>