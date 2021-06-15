<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/hb/blog">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-tarPOST="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a href="<?php echo $racineSite ?>" class="nav-link active" href="#">Home
            <span class="visually-hidden">(current)</span>
          </a>
        </li>
        <?php if($isLoggedIn){?>

        <li class="nav-item">
          <a class="nav-link" href="<?php echo $racineSite ?>/blog/creation.php">Nouveau post</a>
        </li>
        <li>
        
        <form action="<?php echo $racineSite ?>/index.php" method="POST" class="d-flex">
 
  <button type="submit" name="myPosts" class="btn btn-secondary my-2 my-sm-0" >Mes Posts</button>
</form>

        
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $racineSite ?>/blog/profile.php?profile=<?php echo $_SESSION['userId']?>">Mon Profil</a>
        </li>
        <li>
                <?php } ?>
      
      </ul>
      <?php if(!$isLoggedIn && !$modeInscription){ ?>
        <form method="POST" class="d-flex align-items-center">

            <div class="form-group">
                <label for="username">Username</label>

                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="form-group">
            <label for="password">password</label>

                <input type="password" class="form-control" name="password" required>
            </div>        
        
                <div class="form-group">
                 <input type="submit" value="Log in" class="btn btn-success">
                </div>
        </form>
      

<hr>
        <?php }?>

        <?php if($isLoggedIn){?>

            <h2>Bonjour  <?php 
                

                if($_SESSION['displayName'] == ""){
                    echo $_SESSION['username'] ;

                }else{
                   echo $_SESSION['displayName'];
                }
                
                
                
                
                
                ?></h2>

<form method="POST" class="d-flex">
 
  <button type="submit" name="logOut" class="btn btn-secondary my-2 my-sm-0" >Deconnexion</button>
</form>

<?php }?>


      <?php if(!$modeInscription && !$isLoggedIn){?>



      <form method="POST" class="d-flex">
       
        <button type="submit" name="modeInscription" value="on" class="btn btn-secondary my-2 my-sm-0" type="submit">Inscription</button>
      </form>
      <?php }?>
    </div>
  </div>
</nav>