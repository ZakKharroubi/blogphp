<?php 

session_start();
if(isset($_POST['logOut'])){
   session_unset();
} 

$racineSite = "http://localhost/blogv2";


require_once dirname(__FILE__)."/../authentification/auth.php";
require_once dirname(__FILE__)."/../access/db.php";



// Affichage users admin

if ( $isAdmin && $_SESSION['role'] == 'admin' ){
   $maRequeteUsersAdmin = "SELECT users.id, users.username, users.displayname FROM users";
   $resultatUsersAdmin = mysqli_query($maConnection, $maRequeteUsersAdmin);

}

// Suppression users admin

if ($isAdmin && isset($_POST['deleteAccountAdmin'])){
   $idASupprimer = $_POST['deleteAccountAdmin'];
      
   $maRequeteDeSuppression = "DELETE FROM users WHERE id=$idASupprimer";

   $maSuppression= mysqli_query($maConnection, $maRequeteDeSuppression);

   header("Location: admin.php");
}


// Affichage posts admin 

if( $isAdmin && $_SESSION['role'] == 'admin'){
   $maRequetePostsAdmin = "SELECT posts.id, posts.authorid, posts.title, posts.published, users.username, users.displayname FROM posts INNER JOIN users ON posts.authorid = users.id";
   $resultatPostsAdmin = mysqli_query($maConnection, $maRequetePostsAdmin);
}

// Publication admin


if(   isset($_POST['publishAdmin']) && $_POST['publishAdmin']!=""){

   $postId = $_POST['publishAdmin'];
   $maRequetePublication = "UPDATE posts SET published = 1 WHERE id ='$postId'";
   $resultatPublication = mysqli_query($maConnection, $maRequetePublication);
   header("Location: admin.php");
} else if (isset($_POST['unpublishAdmin']) && $_POST['unpublishAdmin']!="") {

   $postId = $_POST['unpublishAdmin'];
   $maRequetePublication = "UPDATE posts SET published = 0 WHERE id ='$postId'";
   $resultatPublication = mysqli_query($maConnection, $maRequetePublication);
   header("Location: admin.php");
}

// Suppression admin 

if(isset($_POST['deleteAdmin'])){

      $idASupprimer = $_POST['deleteAdmin'];
      
      $maRequeteDeSuppression = "DELETE FROM posts WHERE id=$idASupprimer";

      $maSuppression= mysqli_query($maConnection, $maRequeteDeSuppression);

      header("Location: admin.php");
      

    }


// Publication

if(   isset($_POST['publish']) && $_POST['publish']!=""){

   $postId = $_POST['publish'];
   $maRequetePublication = "UPDATE posts SET published = 1 WHERE id ='$postId'";
   $resultatPublication = mysqli_query($maConnection, $maRequetePublication);
   if($resultatPublication){
      header("Location: postUnique.php?postId=$postId&info=published");
   }else {
      header("Location: postUnique.php?postId=$postId&info=notPublished");
   }
} else if (isset($_POST['unPublish']) && $_POST['unPublish']!="") {

   $postId = $_POST['unPublish'];
   $maRequetePublication = "UPDATE posts SET published = 0 WHERE id ='$postId'";
   $resultatPublication = mysqli_query($maConnection, $maRequetePublication);
   if($resultatPublication){
      header("Location: postUnique.php?postId=$postId&info=unpublished");
   }else {
      header("Location: postUnique.php?postId=$postId&info=unpublishedError");
   }
}





// Ajout d'un commentaire 

if($isLoggedIn){
if(   isset($_POST['comment']) && $_POST['comment']!=""){
  $postId = $_POST['postIdComment'];
  $commentContent = $_POST['comment'];
  $authorId = $_SESSION['userId'];

  if($_SESSION['userId'] == $authorId && $commentContent != ""){
  $maRequetePostCommentaire = "INSERT INTO comments (content, author_id, post_id) VALUES ('$commentContent', '$authorId', '$postId')";
  $resultatRequeteCommentaire = mysqli_query($maConnection, $maRequetePostCommentaire);
  
  if($resultatRequeteCommentaire){
     header("Location: postUnique.php?postId=$postId&info=commentPosted");
} else {
   header("Location: postUnique.php?postId=$postId&info=errorComment");
}
} else {
   header("Location: postUnique.php?postId=$postId&info=forbidden");
}
}
}
// Modification image post

  if( isset($_POST['postPic']) && $_POST['postPic'] == 'upload'){

            if (    isset($_FILES['postPictureToUpload']['name']   )        ){
                  if($_SESSION['userId']== $_POST['authorId']){
                     $postId = $_POST['postId']; 
                     $extensionsAutorisees = array("jpeg", "jpg", "png");

                     $hauteurMax = 720;
                     $largeurMax = 900;
                 
                     $tailleMax = 3000000;
                              
                     $repertoireUpload = "../images/posts/";
                  
                  $nomTemporaireFichier = $_FILES['postPictureToUpload']['tmp_name'];
                  var_dump($nomTemporaireFichier);
      
                 $mesInfos = getimagesize($_FILES['postPictureToUpload']['tmp_name']);
      
                 $monTableauExtensions = explode("/",$mesInfos['mime']); 
                  $extensionUploadee = $monTableauExtensions[1];
      
                $unTableau =    explode("\\", $nomTemporaireFichier);
      
                  $nomTemporaireSansChemin =  end($unTableau);
                                                         
                  $nomFinalDuFichier = $nomTemporaireSansChemin.".".$extensionUploadee;
                  
                  $destinationFinale = $repertoireUpload.$nomFinalDuFichier;
      
                   $maLargeur = $mesInfos[0];
                  $maHauteur = $mesInfos[1];
                  
                  $maTaille = $_FILES['postPictureToUpload']['size'];
      
      
                  if( in_array($extensionUploadee, $extensionsAutorisees) ){
      
                      if($maTaille <= $tailleMax){
      
                          if($maLargeur <= $largeurMax && $maHauteur <= $hauteurMax){
      
                                      if(move_uploaded_file($nomTemporaireFichier, $destinationFinale)){
      
                                              echo "UPLOAD SUCCESSFUL";

                                              $requeteUploadPhotoProfile = "UPDATE posts SET image = '$nomFinalDuFichier' WHERE id = '$postId'";
                                                $resultatRequete = mysqli_query($maConnection, $requeteUploadPhotoProfile);
                                             if($resultatRequete){
                                                header("Location: postUnique.php?postId=$postId&info=picUploaded");

                                             }else{
                                                die(mysqli_error($maConnection) );
                                             }


                                          }else{
      
                                             header("Location: postUnique.php?postId=$postId&info=uploadFailed");
                                          }
      
                                          //
                          }else{
      
                           header("Location: postUnique.php?postId=$postId&info=resolution");
                          }
      
                      }else{
      
                        header("Location: postUnique.php?postId=$postId&info=oversized");
                      }
      
      
                  }else{
      
                     header("Location: postUnique.php?postId=$postId&info=extension");
                  }
      

                  }else{

                     echo "ce n'est pas VOTRE profil, bas les pattes";
                  }


            }
}





   // Upload photo profil


  if( isset($_POST['profilePic']) && $_POST['profilePic'] == 'upload'){

            if (    isset($_FILES['pictureToUpload']['name']   )        ){
                  if($_SESSION['userId']== $_POST['userId']){
                     $userId = $_POST['userId']; 
                     $extensionsAutorisees = array("jpeg", "jpg", "png");

                     $hauteurMax = 720;
                     $largeurMax = 900;
                 
                     $tailleMax = 3000000;
                              
                     $repertoireUpload = "../images/profiles/";
                  
                  $nomTemporaireFichier = $_FILES['pictureToUpload']['tmp_name'];
                  var_dump($nomTemporaireFichier);
      
                 $mesInfos = getimagesize($_FILES['pictureToUpload']['tmp_name']);
      
                 $monTableauExtensions = explode("/",$mesInfos['mime']); 
                  $extensionUploadee = $monTableauExtensions[1];
      
                $unTableau =    explode("\\", $nomTemporaireFichier);
      
                  $nomTemporaireSansChemin =  end($unTableau);
                                                         
                  $nomFinalDuFichier = $nomTemporaireSansChemin.".".$extensionUploadee;
                  
                  $destinationFinale = $repertoireUpload.$nomFinalDuFichier;
      
                   $maLargeur = $mesInfos[0];
                  $maHauteur = $mesInfos[1];
                  
                  $maTaille = $_FILES['pictureToUpload']['size'];
      
      
                  if( in_array($extensionUploadee, $extensionsAutorisees) ){
      
                      if($maTaille <= $tailleMax){
      
                          if($maLargeur <= $largeurMax && $maHauteur <= $hauteurMax){
      
                                      if(move_uploaded_file($nomTemporaireFichier, $destinationFinale)){
      
                                              echo "UPLOAD SUCCESSFUL";

                                              $requeteUploadPhotoProfile = "UPDATE users SET image = '$nomFinalDuFichier' WHERE id = '$userId'";
                                                $resultatRequete = mysqli_query($maConnection, $requeteUploadPhotoProfile);
                                             if($resultatRequete){
                                                header("Location: profile.php?profile=$userId&info=picUploaded");

                                             }else{
                                                die(mysqli_error($maConnection) );
                                             }


                                          }else{
      
                                             header("Location: profile.php?profile=$userId&info=uploadFailed");
                                          }
      
                                          //
                          }else{
      
                           header("Location: profile.php?profile=$userId&info=resolution");
                          }
      
                      }else{
      
                        header("Location: profile.php?profile=$userId&info=oversized");
                      }
      
      
                  }else{
      
                     header("Location: profile.php?profile=$userId&info=extension");
                  }
      

                  }else{

                     echo "ce n'est pas VOTRE profil, bas les pattes";
                  }


            }
}

                     

                  





    //Suppression d'un article


$isOwner = false;
$isUser = false;


    if(isset($_POST['idSuppression'])){

      $idASupprimer = $_POST['idSuppression'];
      
      if($isLoggedIn && verifyOwnership($_SESSION['userId'], $idASupprimer, $maConnection)){

      $maRequeteDeSuppression = "DELETE FROM posts WHERE id=$idASupprimer";

      $maSuppression= mysqli_query($maConnection, $maRequeteDeSuppression);

      header("Location: ../index.php");
      }

    }
   // modification de profil

     if(isset($_POST['userIdAModifier']) && $_POST['userIdAModifier'] !=""){

         $userId = $_POST['userIdAModifier'];
         if($_SESSION['userId'] == $userId){

               $newDisplayName = $_POST['displayName'];
               $newEmail = $_POST['email'];

               $maRequete = "UPDATE users SET displayname = '$newDisplayName', email = '$newEmail' WHERE id = $userId";
                     $resultatRequeteUpdateProfil = mysqli_query($maConnection, $maRequete);
                  if(!$resultatRequeteUpdateProfil){
                     die(mysqli_error($maConnection));
                  }else{
                     header("Location: profile.php?profile=$userId&info=edited");

                  }

         }else{
            die("vous n'avez pas le droit de modifier ce profil");
         }


   }



    // modification d'un article

      if(isset($_POST['titreEdite']) && isset($_POST['texteEdite'])){
         
            $titreEdite = $_POST['titreEdite'];
      
            $texteEdite = $_POST['texteEdite'];


      //on doit refaire passer l'ID par le biais d'un input supplémentaire dans le
            $idArticleAModifier = $_POST['idAModifier'];

          //  if($isLoggedIn && verifyOwnership($userId, $postId) ){
           if($isLoggedIn && verifyOwnership($_SESSION['userId'], $idArticleAModifier, $maConnection) ){


            

               $maRequeteUpdate = "UPDATE posts SET title  = '$titreEdite', content = '$texteEdite' WHERE id = $idArticleAModifier";

               $monResultat = mysqli_query($maConnection, $maRequeteUpdate);

               header("Location: postUnique.php?postId=$idArticleAModifier&info=edited");

           } else{
            header("Location: postUnique.php?postId=$idArticleAModifier&info=pasLeDroit");

           }


         }






    //creation d'article

   if( isset($_POST['nouveauTitre']) && isset($_POST['nouveauTexte']) ){
            if( $_POST['nouveauTitre'] !== "" && $_POST['nouveauTexte'] !== "" ){
                    $nouveauTitre = $_POST['nouveauTitre'];
                    $nouveauTexte = $_POST['nouveauTexte'];
                    $authorId = $_SESSION['userId'];
                    $maRequete = "INSERT INTO posts(title, content, authorid, image, published) VALUES ('$nouveauTitre', '$nouveauTexte', '$authorId', 'default.jpeg', 0)";

                    $statusUpload = "default";
            // si il y a upload de photo
                    if (    isset($_FILES['uploadPostPic']['name']   )   && $_FILES['uploadPostPic']['name'] != ""     ){
                  
                     
                        $extensionsAutorisees = array("jpeg", "jpg", "png");
   
                        $hauteurMax = 720;
                        $largeurMax = 900;
                    
                        $tailleMax = 3000000;
                                 
                        $repertoireUpload = "../images/posts/";
                     
                     $nomTemporaireFichier = $_FILES['uploadPostPic']['tmp_name'];         
                    $mesInfos = getimagesize($_FILES['uploadPostPic']['tmp_name']);
         
                    $monTableauExtensions = explode("/",$mesInfos['mime']); 
                     $extensionUploadee = $monTableauExtensions[1];
         
                   $unTableau =    explode("\\", $nomTemporaireFichier);
         
                     $nomTemporaireSansChemin =  end($unTableau);
                                                            
                     $nomFinalDuFichier = $nomTemporaireSansChemin.".".$extensionUploadee;
                     
                     $destinationFinale = $repertoireUpload.$nomFinalDuFichier;
         
                      $maLargeur = $mesInfos[0];
                     $maHauteur = $mesInfos[1];
                     
                     $maTaille = $_FILES['uploadPostPic']['size'];
                     
         
                     if( in_array($extensionUploadee, $extensionsAutorisees) ){
         
                         if($maTaille <= $tailleMax){
         
                             if($maLargeur <= $largeurMax && $maHauteur <= $hauteurMax){
         
                                         if(move_uploaded_file($nomTemporaireFichier, $destinationFinale)){
         
                                                 echo "UPLOAD SUCCESSFUL";
                                                $statusUpload = "added";
                                                 $maRequete = "INSERT INTO posts(title, content, authorid, image, published) VALUES ('$nouveauTitre', '$nouveauTexte', '$authorId', '$nomFinalDuFichier', 0)";
                                                   
   
                                             }else{
         
                                                $statusUpload = "failed";
                                             }
         
                                             //
                             }else{
         
                              $statusUpload = "resolution";
                             }
         
                         }else{
         
                           $statusUpload = "oversized";
                         }
         
         
                     }else{
         
                        $statusUpload = "extension";
                     }
         
         
         
         
         
   
                     
   
   
               }

                     
                  


                     
                     $leResultatDeMonAjoutArticle = mysqli_query($maConnection, $maRequete);
                   
                   
                     // TEST qu ne doit pas etre visible pour les uilisateurs
                     if(!$leResultatDeMonAjoutArticle){
                        die("RAPPORT ERREUR ".mysqli_error($maConnection));
                        
                     } 
                 //    die($statusUpload);
                    header("Location: ../index.php?info=$statusUpload");
                  }
         else{
            echo "remplis ton formulaire en entier";
         }
           
    }
    
    //effectuer une requete pour un article spécifique:
     if(  isset($_GET['postId']) || isset($_POST['postId']) ){

           if(isset($_GET['postId'])){
              $postId = $_GET['postId'];
           }else{
            $postId = $_POST['postId'];
           }
              
           if(verifyOwnership($_SESSION['userId'], $postId, $maConnection)){

            $isOwner = true;
           }
           
            

             $maRequeteArticleUnique = "SELECT posts.id, posts.title, posts.content, posts.image, posts.authorid, posts.published FROM posts WHERE id='$postId'";

             $leResultatDeMaRequeteArticleUnique = mysqli_query($maConnection, $maRequeteArticleUnique);
     
             $mesCommentaires = getCommentsByPostId($postId, $maConnection);
     
            }else if(isset($_POST['myPosts']) && $isLoggedIn  ){


            $userId = $_SESSION['userId'];

            echo "on est bien dans le cas MES POSTS";
        $maRequete = "SELECT posts.title, posts.content, posts.id, posts.authorid, users.displayname, users.username, posts.image, posts.published FROM posts 
        INNER JOIN users ON posts.authorid = users.id WHERE authorid = '$userId'";

        $leResultatDeMaRequete = mysqli_query($maConnection, $maRequete);
      






     }else{    //effectuer une requete SQL pour récupérer TOUS les posts

        $maRequete = "SELECT posts.title, posts.content, posts.id, posts.authorid, users.displayname, users.username, posts.image FROM posts 
       INNER JOIN users ON posts.authorid = users.id WHERE posts.published = 1";

        $leResultatDeMaRequete = mysqli_query($maConnection, $maRequete);





     }

   //   Affichage du profil 
     if(

       (isset($_GET['profile']) && $_GET['profile'] !="")   
       ||
       (isset($_POST['profileEdit']) && $_POST['profileEdit'] !="")  
       
       
       ){

         if(isset($_POST['profileEdit'])){
            $userId = $_POST['profileEdit'];
            $maRequeteProfile = "SELECT id, username, displayname, email, image FROM users WHERE id = '$userId'";

         }else{
         $userId = $_GET['profile'];
            $maRequeteProfile = "SELECT username, displayname, email, image FROM users WHERE id = '$userId'";
         }
        

         

            $resultatRequeteProfil = mysqli_query($maConnection, $maRequeteProfile);

            if($isLoggedIn && $_SESSION['userId'] == $userId){

               $isUser = true;
            }
            

   }



   //   Methode pour vérifier le propriétaire de l'article

      function verifyOwnership($userId, $postId, $maConnection){

      
         //on veut comparer l'userId au author_id

         //a partir du postId faire une requete SQL pour récurérer l'author_id
         //et comparer l'userId de la session à cet author_id récupéré directement depuis la BDD
         //et regler $ownerVerified sur true ou false en fonction de cela


            $maRequeteDeVerification = "SELECT * FROM posts WHERE id = '$postId'";
               $resultatRequeteVerification = mysqli_query($maConnection, $maRequeteDeVerification);

               foreach($resultatRequeteVerification as $value){
                  $authorId = $value['authorid'];

               }

               $ownerVerified = false;

               if($userId == $authorId){

                  $ownerVerified = true;
               }
            
            if($ownerVerified){

               return true;
            }else{

               return false;
            }
         
      }


      function getCommentsByPostId($postId, $maConnection){


         $maRequeteComments = "SELECT comments.content, users.displayname, users.username
                               FROM comments INNER JOIN users 
                               ON comments.author_id = users.id
                               WHERE  comments.post_id = $postId";
         
         $resultatRequeteComments = mysqli_query($maConnection, $maRequeteComments);

         return $resultatRequeteComments;

      }


    







?>