<?php 
require_once 'logique.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/solar/bootstrap.css">

</head>
<body>
<?php require_once dirname(__FILE__)."/../navbar.php" ?>

<?php if(isset($_GET['info']) && $_GET['info']== "edited"){ ?>

<div class="alert alert-success" role="alert">
Your profile was successfully edited !
</div>


<?php }?>


<?php 
    foreach($resultatRequeteProfil as $value){
?>
<h2>Profil de <?php  
if ($value['displayname'] == "") { echo $value['username'];} else {echo $value['displayname'];}
?>
</h2>
<ul>
    <li><img src="../images/profiles/<?php echo $value['image']?>"> </li>
    <li>Nom de l'utilisateur : 
    <?php if ($value['displayname'] == "") 
    {
        echo $value['username'];
    } else { 
        echo $value['displayname'];
        }?></li>
    <li> Email : <?php if ($value['email'] == ""){
        echo "Adresse mail non renseignée";
    }else{ 
        echo $value['email'];
    } ?></li>
</ul>
<?php } ?>

<?php if($isLoggedIn && $isUser){?>
            <form action="profileEdit.php" method="post">
                        <div class="text-center">
                        <button name='profileEdit' value="<?php echo $_SESSION['userId'] ?>" type="submit" class="btn btn-warning">Modifier mon profil</button>
                     </div>
                    
                    
                    </form>
                
     <?php } ?>


<div class="text-center">
    
            <a href="/blogv2" class="btn btn-danger">Retour a l'accueil</a>
    </div>
</body>
</html>