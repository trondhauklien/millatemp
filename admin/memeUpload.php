<?php
require_once "session.php";
require_once "config.php";
require_once "multi-select-meme.php";
?>

<!DOCTYPE html>
<html>

<?php include("../head.php"); ?>

<body>


<?php include("nav.php"); ?>
<br/>
<?php

$target_dir = "../img/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image

    if(isset($_POST["submit"]))

    {

      //Dato
      date_default_timezone_set("Europe/Oslo");
      $date = date("Y-m-d H:i:s");

      //Bildefil
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
          $uploadOk = 1;
      } else {
          echo "File is not an image.";
          $uploadOk = 0;
      }

  // Check if file already exists
  if (file_exists($target_file)) {
      echo '<div class="alert alert-info"><strong>Info! </strong>Denne filen finnes fra før!</div>';
      $uploadOk = 0;
  }
  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 2000000)
  {
      echo '<div class="alert alert-info"><strong>Info! </strong>Denne filen er for stor!</div>';
      $uploadOk = 0;
  }
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
      echo '<div class="alert alert-info"><strong>Info! </strong>Bare JPG, JPEG, PNG & GIF filer er lov!</div>';
      $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

             $sql = sprintf("INSERT INTO Memes (Filnavn, Dato, Aktiv) VALUES ('%s','%s','0')",$_FILES["fileToUpload"]["name"], $date);

             if (!mysqli_query($link,$sql)) {

                    echo "Errormessage:".mysqli_error($link);
                    }

                    else {
                          $sql = sprintf("SELECT * FROM Memes WHERE Dato = '%s'",$date);
               $datasett323 = mysqli_query($link,$sql);




                        echo '<div class="alert alert-success"><strong>Nice!</strong> Memen er lastet opp!</div>';

                }
      }
                else {
                    echo '<div class="alert alert-danger"><strong>hmm! </strong>Din fil ble ikke lastet opp!</div>';
                }
            }

    }
?>
<div  class="container">
  <form method="post" enctype="multipart/form-data">
    <div class="form-row">
        <label for="fileToUpload" class="col-auto col-form-label">Last opp meme her: </label>
        <div class="form-group col-sm-6">
          <div class="custom-file">
            <input type="file" class="custom-file-input" name="fileToUpload" id="fileToUpload">
            <label class="custom-file-label" for="customFile">Velg fil</label>
          </div>
        </div>
      <div class="col-auto">
        <button type="submit" name="submit" class="btn btn-success">Last opp</button>
      </div>
    </div>
  </form>
</div>

<div class="container">
  <?php echo $alert; ?>

  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <?php
      $sql = sprintf("SELECT * FROM Memes");
      $datasett = mysqli_query($link,$sql);

      echo '<table class="table table-hover"><thead><th><input id="selectAll" type="checkbox"></th><th>ID</th><th>Filnavn</th><th>Dato</th><th>Aktiv</th></thead>';

      while($row = mysqli_fetch_assoc($datasett)){
        echo "<tbody><tr><td><input type='checkbox' name='items[]' value='".$row["Memeid"]."'></td><td>".$row["Memeid"]."</td><td>".$row["Filnavn"]."</td><td>".$row["Dato"]."</td><td>".$row["Aktiv"]."</td></tr></tbody>";
      }
      echo "</table>";
    ?>
    <div class="form-row">
      <div class="col">
        <select class="form-control" name="actionSelect">
          <option value="active">Aktiver</option>
          <option value="inactive">Deaktiver</option>
          <option value="delete" disabled>Slett</option>
          <option value="nod">Nødslett</option>
        </select>
      </div>
      <div class="col">
        <button type="submit" class="btn btn-primary">Fullfør</button>
      </div>
    </div>
  </form>
</div>

<br/>

<?php include("../footer.php"); ?>

<script>

$('#selectAll').click(function(e){
  var table= $(e.target).closest('table');
  $('td input:checkbox',table).prop('checked',this.checked);
});
$('.table>tbody>tr>td:not(:first-child)').css('cursor', 'pointer').click(function(e) {
  var checkBoxes = $(this).parent('tr').find('input:checkbox');
  checkBoxes.prop("checked", !checkBoxes.prop("checked"));
});

$(document).ready(function () {
  bsCustomFileInput.init()
})

</script>

</body>
</html>
