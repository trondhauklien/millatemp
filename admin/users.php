<?php
require_once "session.php";
require_once "config.php";
require_once "multi-select-user.php";
?>

<!DOCTYPE html>
<html>

<?php include("../head.php"); ?>

<body>


<?php include("nav.php"); ?>
<br/>
<div  class="container">
  <p><a href="register.php">Klikk her</a> for å registrere en ny bruker.</p>
</div>

<div class="container">
  <?php echo $alert; ?>

  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <?php
      $sql = sprintf("SELECT * FROM users");
      $datasett = mysqli_query($link,$sql);

      echo '<table class="table table-hover"><thead><th><input id="selectAll" type="checkbox"></th><th>ID</th><th>Brukernavn</th><th>Dato</th><th>Admin</th></thead>';

      while($row = mysqli_fetch_assoc($datasett)){
        echo "<tbody><tr><td><input type='checkbox' name='items[]' value='".$row["id"]."'></td><td>".$row["id"]."</td><td>".$row["username"]."</td><td>".$row["created_at"]."</td><td>".$row["level"]."</td></tr></tbody>";
      }
      echo "</table>";
    ?>
    <div class="form-row">
      <div class="col">
        <select class="form-control" name="actionSelect">
          <option value="admin">Gjør admin</option>
          <option value="notadmin">Fjern admin</option>
          <option value="delete">Slett</option>
          <option value="nod" disabled>Nødslett</option>
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
$('.table>tbody>tr>td:not(:first-child)').css('cursor', 'pointer').click(function() {
  var checkBoxes = $(this).parent('tr').find('input:checkbox');
  checkBoxes.prop("checked", !checkBoxes.prop("checked"));
});

$(document).ready(function () {
  bsCustomFileInput.init()
})

</script>

</body>
</html>
