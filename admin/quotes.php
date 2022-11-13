<?php
require_once "session.php";
require_once "config.php";
require_once "multi-select.php";
?>
<!DOCTYPE html>
<html>

<?php include("../head.php"); ?>

<body>

<?php include("nav.php"); ?>

<br/>
<div class="container">
  <?php echo $alert; ?>

  <div id="regQuote">
    <div id="alert"></div>
    <form id="quoteRegistration" method="post" action="../sendQuote.php">
      <div class="input-group mb-3">
        <input type="text" class="form-control" id="quote" name="quote" placeholder="Registrer et sitat." aria-label="Registrer et sitat." aria-describedby="button-addon2">
        <div class="input-group-append">
          <button class="btn btn-outline-secondary" type="submit" name="submit" id="sendQuote">Send inn</button>
        </div>
      </div>
    </form>
  </div>

  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <?php
      $sql = sprintf("SELECT * FROM Quotes");
      $datasett = mysqli_query($link,$sql);

      echo '<table class="table table-hover"><thead><th><input id="selectAll" type="checkbox"></th><th>ID</th><th>Sitat</th><th>Dato</th><th>Aktiv</th></thead>';

      while($row = mysqli_fetch_assoc($datasett)){
        echo "<tbody><tr><td><input type='checkbox' name='items[]' value='".$row["Sitatid"]."'></td><td>".$row["Sitatid"]."</td><td>".$row["Sitat"]."</td><td>".$row["Dato"]."</td><td>".$row["Aktiv"]."</td></tr></tbody>";
      }
      echo "</table>";
    ?>
    <div class="form-row">
      <div class="col">
        <select class="form-control" name="actionSelect">
          <option value="active">Aktiver</option>
          <option value="inactive">Deaktiver</option>
          <option value="delete">Slett</option>
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

</script>
<script>
$(document).ready(function(){
  $("#quoteRegistration").submit(function(e) {
    e.preventDefault();

    $("#sendQuote").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Laster...');
    $("#alert").html("");

    var form = $(this);
    var url = form.attr('action');
    //
    $.ajax({
      type: "POST",
      url: url,
      data: form.serialize(), // serializes the form's elements.
      success: function(data)
      {
        $("#quote").val("");
        $("#alert").html('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Suksess!</strong> Du har registrert et sitat. Alt som gjenstår nå er å refreshe siden og aktivere sitatet.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        $("#sendQuote").html('Send inn');
      }
    });
  });
});
</script>

</body>
</html>
