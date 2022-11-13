<!DOCTYPE html>
<html>
<!--header-->
<?php include("head.php"); ?>

<?php
//Connect to DB
  require_once "config.php";
//BOOM you are connected
?>
  <body>
    <h1 id="header">Millatemp</h1>

    <!---scrolling quotes-->
    <div class="marquee"></div>
    <br>
    <script>
    var oldresult = '';
    var $mq = $('.marquee');
    $mq.bind('finished', change)
    function change(){
      $mq.marquee('pause');
      $.ajax({url: "getQuote.php", success: function(result){
          //Checking for the same result as last time
          if (result == oldresult){
              change();
          }
          else{
        $mq
          .html(result)
          .marquee({speed:100})
          .marquee('resume');
          oldresult = result;
          }
      },error: function(){
          setTimeout(function(){
          change();
          console.log("hei");},4000);


      }

      });
    };
    change();

    </script>
    <?php
    //Temp last 5 hours
    $sql = sprintf("SELECT * FROM Data order by Id desc limit 20");
    //Temp right now
    $sqlNow = sprintf("SELECT * FROM Data order by Id desc limit 1");
    //Lowest temp last 24
  	$sqlLow = sprintf("SELECT Temp FROM (SELECT * FROM `Data` order by Id DESC LIMIT 96) As dataa ORDER BY Temp LIMIT 1");
  	//Highest temp last 34
  	$sqlHigh= sprintf("SELECT Temp FROM (SELECT * FROM `Data` order by Id DESC LIMIT 96) As dataa ORDER BY Temp desc LIMIT 1");
  	//humidity
  	//$sqlHum = sprintf("SELECT Hum FROM (SELECT * FROM `Data` order by Id DESC LIMIT 96) As dataa ORDER BY Hum LIMIT 1");
    //Chart
    $chartsql = sprintf('SELECT Date,Temp FROM Data order by Id desc limit 192');
    //Memes
    $sqlimg = sprintf('SELECT * FROM Memes WHERE Aktiv = 1');
    //Chart data from Yr (past)
    date_default_timezone_set("Europe/Oslo");
    $nowdate = new DateTime();
    $yesterdayDT = $nowdate->sub(new DateInterval('P2D'));
    $yesterday = $yesterdayDT->format("Y-m-d H:i:s");
    //echo $nowdate;
    $chartyrsql = sprintf("SELECT date,temp FROM yr WHERE date>='$yesterday'");

    $datasett = mysqli_query($conn,$sql);
    $datasettNow = mysqli_query($conn,$sqlNow);
    $datasettNow2 = mysqli_query($conn,$sqlNow);
    $datasettLow = mysqli_query($conn,$sqlLow);
    $datasettHigh = mysqli_query($conn,$sqlHigh);
    //$datasettHum = mysqli_query($conn,$sqlHum);
    $chartDatasett = mysqli_query($conn,$chartsql);
    $chartYrDatasett = mysqli_query($conn,$chartyrsql);
    $datasettimg = mysqli_query($conn,$sqlimg);
    //echo $nowdate;
    ?>

    <div class="container">
      <div class="jumbotron stats">
        <div class="row">
          <div class="col-sm-4">
            <?php  while ($row3 = mysqli_fetch_array($datasettNow)){
              echo "<h1 id='now'>".$row3["Temp"]."°</h1>";
            }
            ?>
            <p>temperatur nå</p>
          </div>
  	      <div class="col-sm-4">
            <?php  while ($row420 = mysqli_fetch_array($datasettLow)){
              echo "<h1 id='low'>".$row420[0]."°</h1>";
            }
            ?>
            <p>laveste temperatur siste 24</p>
          </div>

          <div class="col-sm-4">
            <?php  while ($row69 = mysqli_fetch_array($datasettHigh)){
              echo "<h1 id='high'>".$row69[0]."°</h1>";
            }
            ?>
  		      <p>høyeste temperatur siste 24</p>
          </div>
        </div>
      </div>

      <p id='counter'>Laster inn...</p>
      <a id="refresh" href="#">Refresh</a>

    </div>

    <div class="container">
      <h2 class="section">Været som var</h2>

      <!-- Nav tabs -->
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" id="nav-chart" data-toggle="tab" href="#chart" role="tab" aria-controls="nav-chart" aria-selected="true">Graf</a>
          <a class="nav-item nav-link" id="nav-table" data-toggle="tab" href="#table" role="tab" aria-controls="nav-table" aria-selected="false">Tabell</a>
        </div>
      </nav>

      <!-- Tab panes -->
      <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="chart" role="tabpanel" aria-labelledby="nav-chart">
          <h4 class="nav-header">Temperatur</h4>
          <div class="legend">
            <svg height="1em" width="26">
              <line x1="0" y1="50%" x2="100%" y2="50%" stroke-dasharray="6,4" style="stroke:#bbbbbb;stroke-width:3"></line>
            </svg>
            <p class="inline"> Meldt Yr </p>
            <svg height="1em" width="26">
              <line x1="0" y1="30%" x2="100%" y2="30%" style="stroke:#FF3333;stroke-width:3"></line>
              <line x1="0" y1="70%" x2="100%" y2="70%" style="stroke:#33DDFF;stroke-width:3"></line>
            </svg>
            <p class="inline">Målinger</p>
            <svg height="1em" width="26">
              <line x1="0" y1="30%" x2="100%" y2="30%" stroke-dasharray="6,4" style="stroke:#FF3333;stroke-width:3"></line>
              <line x1="0" y1="70%" x2="100%" y2="70%" stroke-dasharray="6,4" style="stroke:#33DDFF;stroke-width:3"></line>
            </svg>
            <p class="inline">Yr-varsel</p>
          </div>
          <div id="chartWrapper">
            <div id="scrollContainer">
              <div id="chartContainer">
                <canvas id="tempChart"></canvas>
              </div>
            </div>
            <canvas id="yChart">
          </div>
        </div>
        <div class="tab-pane fade" id="table" role="tabpanel" aria-labelledby="nav-chart">
          <h4 class="nav-header">Temperatur siste fem timer</h4>
          <?php
            echo '<table id="temp_table" class="table table-hover"><thead><th>ID</th><th>Date</th><th>Temp</th></thead>';
            while($row = mysqli_fetch_assoc($datasett))
            {
              echo "<tbody><tr><td>".$row["Id"]."</td><td>".$row["Date"]."</td><td>".$row["Temp"]."°</td></tr></tbody>";
            }
            echo "</table>";
          ?>
        </div>
      </div>
      <br>
      <p><a href="https://www.yr.no/sted/Norge/Innlandet/%c3%85mot/Rena_leir/">Værvarsel </a>fra Yr levert av Meteorologisk institutt og NRK</p>
    </div>



    <div class="container">
      <h2 class="section">Registrer et sitat</h2>
      <div id="regQuote">
        <div id="alert"></div>
        <form id="quoteRegistration" method="post" action="sendQuote.php">
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="quote" name="quote" placeholder="Bidra med ditt sitat!" aria-label="Bidra med ditt sitat!" aria-describedby="button-addon2">
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" type="submit" name="submit" id="sendQuote">Send inn</button>
            </div>
          </div>
        </form>
      </div>

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
              $("#alert").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Gratulerer!</strong> Du har registrert et sitat. Hvis det blir godkjent, synliggjøres det i toppen av denne siden.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
              $("#sendQuote").html('Send inn');
            }
          });
        });
      });
      </script>

      <h2 class="section">Meme-bibliotek</h2>
      <script src="https://cdn.rawgit.com/tuupola/jquery_lazyload/0a5e0785a90eb41a6411d67a2f2e56d55bbecbd3/lazyload.js"></script>
      <div class="row">
      <?php
      //$directory = "img/";
      //$images = glob("$dir/*.{jpg,png,bmp}", GLOB_BRACE);

      //foreach(glob($directory.'*') as $filename){
      while ($rowimg = mysqli_fetch_array($datasettimg)){
        echo "<div class='col-md-4'><img class='lazyload meme' data-src='img/" . $rowimg['Filnavn'] . "' width='100%' height='auto'></div> \r\n";
      }
      ?>
      </div>
      <script type="text/javascript">
        window.addEventListener("load",
        function(event) {
          lazyload();
        });
      </script>
    </div>

    <?php include("footer.php"); ?>
<script>
$(document).ready(function(){
  var tempChart;
  var tempData;

  function updateTable(id, date, temp) {
    var cell = $('#temp_table>tbody>tr:first>td:first').html();
    //console.log(cell);
    if(id !== $("#temp_table>tbody>tr:first>td:first").html()){
      $('#temp_table tbody')
        .prepend('<tr />')
        .children('tr:first')
        .append('<td>'+id+'</td><td>'+date+'</td><td>'+temp+'</td>')
    }
  }
  var fetchDate;
  var countDownDate;
  var refreshInt = 915000;
  function refreshTemp() {
    $("#refresh").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Laster...');
    $.ajax({url: "getTemp.php", success: function(output)
      {
        var result = $.parseJSON(output);
        $("#now").html(result[0] + "°");
        $("#low").html(result[1] + "°");
        $("#high").html(result[2] + "°");
        $("#refresh").html("Oppfrisk")
        fetchDate = result[3];
        countDownDate = new Date(Date.parse(fetchDate.replace(" ", "T") + ".000+02:00"));
        updateChart(tempChart, result[3], result[0]);
        updateTable(result[4], result[3], result[0]);
        //console.log(tempData);
        refreshInt = 915000;
      }
    });
  }
  $("#refresh").click(function(e){
    e.preventDefault();
    refreshTemp();
  });

  Chart.defaults.global.legend.display = false;
  <?php
  $chartArray = array();
  $index = 0;
  while($row = mysqli_fetch_assoc($chartDatasett)){
    $chartArray[$index] = array(x => $row["Date"], y => $row["Temp"]);
    $index++;
  }
  $chartjsArray = json_encode($chartArray);
  echo "var tempData = " . $chartjsArray . ";\n";

  $chartArray = array();
  $index = 0;
  while($row = mysqli_fetch_assoc($chartYrDatasett)){
    $chartArray[$index] = array(x=> $row["date"], y=> $row["temp"]);
    $index++;
  }
  $chartjsYrArray = json_encode($chartArray);
  echo "var tempYrData = " . $chartjsYrArray . ";\n";
  ?>

  console.log(tempYrData);

  var yrData = [];
  $.ajax({
    url: "getYr.php",
    async: false,
    success: function(response){
      var result = JSON.parse(response);
      //console.log(result[0]);
      $(result[0]).find("time").each(function(){
        xVal = $(this).attr('from');
        yVal = $(this).find("temperature").attr("value");
        if (yVal) {
          yrData.unshift({x: xVal, y: yVal});
        }
      });
      //tempChart.update();
    }
  });
  //console.log(yrData);
  //console.log(tempData);
    var rectangleSet = false;
    var ctx = document.getElementById('tempChart').getContext("2d");

    var height = document.getElementById("chartContainer").clientHeight - 37;

    var virtualArray = tempData.concat(yrData);
    console.log(virtualArray);
    var yArray = virtualArray.map(function(item) { return item["y"]; });
    var max = Math.ceil(Math.max(...yArray) + 1);
    var min = Math.floor(Math.min(...yArray) - 1);
    if(max>0 && min<0) {
      var diff = max - min;
      var zero = (- min) / diff;
      var gradientStroke = ctx.createLinearGradient(0, height, 0, 11);
      gradientStroke.addColorStop(0, "#33DDFF");
      gradientStroke.addColorStop(zero - 0.01, "#33DDFF");
      gradientStroke.addColorStop(zero, "#7C7C7C");
      gradientStroke.addColorStop(zero + 0.01, "#FF3333");
      gradientStroke.addColorStop(1, "#FF3333");
    }

    var tempChart = new Chart(ctx, {
      type: 'line',
      data: {
        datasets: [{
          label: 'Temperatur',
          data: tempData,
          borderColor: gradientStroke,
          //pointBorderWidth: 0,
          fill: false
        },{
          label: 'Varsel',
          data: yrData,
          borderColor: gradientStroke,
          borderDash: [6, 4],
          fill: false,
        },{
          label: 'Tidligere varsel',
          data: tempYrData,
          borderColor: "#bbbbbb",
          borderDash: [6, 4],
          fill: false,
        }]
      },
      options: {
        ledgend: {
          display: false,
          //pointStyle: 'line'
        },

        elements: {
          point: {
            radius: 0
          }
        },
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          xAxes: [{
            type: 'time',
            time: {
              displayFormats: {
                minute: 'H:mm',
                hour: 'dddd H:mm',
                day: 'dddd H:mm'
              }
            },
            distribution: 'linear',
            bounds: 'data',
            ticks: {
              //source: 'auto',
              maxRotation: 0
            }
          }],
          yAxes: [{
            ticks: {
              min: min,
              max: max,
              // Include degree sign
              callback: function(value, index, values) {
                return value + '°';
              }
            }
          }]
        },
        animation: {
          onComplete: function () {
            if (!rectangleSet) {
              var scale = window.devicePixelRatio;

              var sourceCanvas = tempChart.chart.canvas;
              var copyWidth = tempChart.scales['y-axis-0'].width - 10;
              var copyHeight = tempChart.scales['y-axis-0'].height + tempChart.scales['y-axis-0'].top + 10;

              var targetCtx = document.getElementById("yChart").getContext("2d");

              targetCtx.scale(scale, scale);
              targetCtx.canvas.width = copyWidth * scale;
              targetCtx.canvas.height = copyHeight * scale;

              targetCtx.canvas.style.width = `${copyWidth}px`;
              targetCtx.canvas.style.height = `${copyHeight}px`;
              targetCtx.drawImage(sourceCanvas, 0, 0, copyWidth * scale, copyHeight * scale, 0, 0, copyWidth * scale, copyHeight * scale);

              var sourceCtx = sourceCanvas.getContext('2d');

              // Normalize coordinate system to use css pixels.

              //sourceCtx.clearRect(0, 0, copyWidth * scale, copyHeight * scale);
              rectangleSet = true;
            }
          // },
          // onProgress: function () {
          //   if (rectangleSet === true) {
          //     var copyWidth = tempChart.scales['y-axis-0'].width;
          //     var copyHeight = tempChart.scales['y-axis-0'].height + tempChart.scales['y-axis-0'].top + 10;
          //
          //     var sourceCtx = tempChart.chart.canvas.getContext('2d');
          //     sourceCtx.clearRect(0, 0, copyWidth, copyHeight);
          //   }
          }
        }
      }
    });


  function updateChart(chart, xVal, yVal) {
    console.log(xVal);
    console.log(tempData);
    if(xVal !== tempData[0].x){
      //console.log("notEqual");
      tempData.pop();
      tempData.unshift({x: xVal, y: yVal});
      tempChart.update();
    }
  }

  // Set the date we're counting down to
  var fetchDate = "<?php
                    while($row333 = mysqli_fetch_array($datasettNow2)){
                        echo $row333['Date'];} ?>";
  //console.log(fetchDate);
  var countDownDate = new Date(Date.parse(fetchDate.replace(" ", "T") + ".000+02:00"));
  //console.log(countDownDate);

  var i = 1;

  // Update the count down every 1 second
  var x = setInterval(function() {

    // Get today's date and time
    var now = new Date().getTime();
    //console.log(now);

    // Find the distance between now and the count down date
    var distance = -(countDownDate - now);
    //console.log(distance);

    // If there is more than 15 m 15 sec since last update, refresh
    if (distance >= refreshInt && i <= 5) {
      refreshTemp();
      console.log("Refreshed");
      i += 1;
      setTimeout(function(){
        //change();
        console.log("Trying to refresh temperature data again.");},4000);
    }
    else if (i == 6) {
      console.log("Gave up, trying again in 15 minutes")
      refreshInt += 915000;
      console.log(refreshInt);
      i = 1;
    }
    //console.log(distance);

    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);


    var strminutes = "";
    var strhours = "";
    if (minutes >= 1) {
      strminutes = minutes + " m ";
    }
    if (hours >= 1) {
      strhours = hours + " t ";
    }

    // Output the result in an element with id="counter"
    document.getElementById("counter").innerHTML =
    "Siste måling for " + strhours + minutes + " m " + seconds + " s siden.";

    // If the count down is over, write some text

  }, 1000);
});
</script>

</body>

</html>
