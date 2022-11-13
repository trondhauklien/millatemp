
<?php
  //require_once "config.php";
  $selected = $_POST['items'];
  $action = $_POST['actionSelect'];


  if(isset($action) && (empty($selected)))
  {
    $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Velg noe, din løk!</strong> For å gjøre en handling må du velge én eller flere brukere ved hjelp av avkrysningsboksene.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    if($action == nod){
      $sql = sprintf("UPDATE Memes SET Aktiv=0 ");
      mysqli_query($link,$sql);
      $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Nødslett iverksatt!</strong> Alle memes er nå deaktivert.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    }
  }
  else
  {
    //echo($action);
    $N = count($selected);

    if($action == delete){
      for($i=0; $i < $N; $i++)
      {
        $sql = sprintf(" DELETE FROM users WHERE id='%s'",$selected[$i]);
        mysqli_query($link,$sql);
        $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sletting gjort!</strong> Du har slettet  '.$N.' bruker(e).<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
      }
    }

    elseif($action == admin){
      for($i=0; $i < $N; $i++)
      {
        $sql = sprintf("UPDATE users SET level=1 WHERE id='%s'",$selected[$i]);
        mysqli_query($link,$sql);
        $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Suksess!</strong> Du har gitt  '.$N.' bruker(e) administratorrettigheter.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
      }
    }

    elseif($action == notadmin){
      for($i=0; $i < $N; $i++)
      {
        $sql = sprintf("UPDATE users SET level=0 WHERE id='%s'",$selected[$i]);
        mysqli_query($link,$sql);
        $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Suksess!</strong> Du har fjernet administratorrettighetene til '.$N.' bruker(e).<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
      }
    }

    elseif($action == nod){
      $sql = sprintf("UPDATE Memes SET Aktiv=0 ");
      mysqli_query($link,$sql);
      $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Nødslett iverksatt!</strong> Alle memes er nå deaktivert.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    }
  }
?>
