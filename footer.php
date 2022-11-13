</div>
<div class="container">
  <div class="footer">
    <div class="row">
      <div class="col-lg-7">
        <ul class="list-group list-group-horizontal-md copyright">
          <li class="list-group-item">© 2019-2020 Millatemp</li>
          <li class="list-group-item">Made with &hearts;, Python, PHP, JavaScript and HTML</li>
        </ul>
      </div>
      <div class="col-lg-5">
        <ul class="list-group list-group-horizontal-md links">
          <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){ ?>
            <li class="list-group-item"><a href="https://<?php echo $_SERVER['SERVER_NAME']?>/admin/profile.php">Min side</a></li>
          <?php } else{?>
            <li class="list-group-item"><a href="https://<?php echo $_SERVER['SERVER_NAME']?>/admin/login.php">Logg inn</a></li>
          <?php } ?>
          <li class="list-group-item"><a href="https://<?php echo $_SERVER['SERVER_NAME']?>/admin/register.php">Registrering</a></li>
          <li class="list-group-item"><a href=#>Kontakt</a></li>
          <li class="list-group-item"><a href=#>Terms</a></li>
          <li class="list-group-item"><a href=#>Privacy</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>

</body>
</html>
