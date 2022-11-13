<nav class="navbar navbar-expand-sm navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="https://millatemp.no/">
      <img src="millatemp-icon.svg" width="30" height="30" class="d-inline-block align-top" alt="">
      Millatemp
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <?php if($_SESSION["level"] >= 1){ ?>
          <li class="nav-item" id="quotes.php">
            <a class="nav-link" href="quotes.php">Sitater</a>
          </li>
          <li class="nav-item" id="memeUpload.php">
            <a class="nav-link" href="memeUpload.php">Memes</a>
          </li>
          <li class="nav-item" id="users.php">
            <a class="nav-link" href="users.php">Brukere</a>
          </li>
          <?php } ?>
          <li class="nav-item" id="profile.php">
            <a class="nav-link" href="profile.php">Min Side</a>
          </li>
        </ul>
      </div>
  </div>
</nav>

<script>
  function jq( myid ) {
    return "#" + myid.replace( /(:|\.|\[|\]|,|=|@)/g, "\\$1" );
  };

  $(document).ready(function() {
    //console.log("excecuting...");
    var pathname = window.location.pathname;
    //console.log(pathname)
    var file = /[^/]*$/.exec(pathname)[0];
    //console.log(file);
    $(jq(file)).addClass("active");
  });
</script>
