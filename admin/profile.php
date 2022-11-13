<?php
  require_once "session.php";

  $err = ['access' => '<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Sorry!</strong> You have no access to that page.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'];
?>

<!DOCTYPE html>
<html lang="en">
<?php include("../head.php"); ?>
<body>
  <?php include("nav.php");?>
  <br/>
  <div class="container">
    <h2>Hei, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Velkommen til millatemp.no.</h2>
    <?php echo $err[$_GET["e"]]; ?>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Tilbakestill passord</a>
        <a href="logout.php" class="btn btn-danger">Logg ut</a>
    </p>
  </div>
  <?php include("../footer.php"); ?>
</body>
</html>
