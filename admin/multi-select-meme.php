
<?php
  //require_once "config.php";
  $selected = $_POST['items'];
  $action = $_POST['actionSelect'];


  if(isset($action) && (empty($selected)))
  {
    $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Velg noe, din løk!</strong> For å gjøre en handling må du velge én eller flere memes ved hjelp av avkrysningsboksene.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
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
        $sql = sprintf(" DELETE FROM Quotes WHERE Sitatid='%s'",$selected[$i]);
        mysqli_query($link,$sql);
        $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sletting gjort!</strong> Du har slettet  '.$N.' sitat(er).<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
      }
    }

    elseif($action == active){
      for($i=0; $i < $N; $i++)
      {
        $sql = sprintf("UPDATE Memes SET Aktiv=1 WHERE Memeid='%s'",$selected[$i]);
        mysqli_query($link,$sql);
        $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Aktivert!</strong> Du har aktivert  '.$N.' meme(s).<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
      }
    }

    elseif($action == inactive){
      for($i=0; $i < $N; $i++)
      {
        $sql = sprintf("UPDATE Memes SET Aktiv=0 WHERE Memeid='%s'",$selected[$i]);
        mysqli_query($link,$sql);
        $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Deaktivert!</strong> Du har deaktivert  '.$N.' meme(s).<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
      }
    }

    elseif($action == nod){
      $sql = sprintf("UPDATE Memes SET Aktiv=0 ");
      mysqli_query($link,$sql);
      $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Nødslett iverksatt!</strong> Alle memes er nå deaktivert.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    }
  }
?>
