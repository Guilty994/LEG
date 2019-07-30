<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>LEG</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <!-- CSS della pagina -->
  <link rel="stylesheet" href="./index.css">
  <!-- CSS charts -->
  <link rel="stylesheet" href="./Chart.css">

  <!-- Import JQUERY -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!-- import Bootstrap -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <!-- js charts -->
  <script src="./js/Chart.js"></script>
</head>

<body class="hold-transition sidebar-mini">
  <!-- Barra di ricerca -->
  <div class="row" style="margin-top:1%">
    <div class="col-md-4"></div>
    <div class="col-md-4">
      <div class="search-form">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" name="search" id="nomeGioco" placeholder="Cerca gioco"
            onkeypress="handle(event)">
          <span class="glyphicon glyphicon-search form-control-feedback"></span>
        </div>
      </div>
    </div>
    <div class="col-md-4"></div>
  </div>

  <!-- Ricerche recenti -->
  <div class="row" id="ricercheRecenti">
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">History</h3>
        </div>
        <div class="card-body" id="recenti">

        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <div class="col-md-2"></div>
  </div>

  <!-- Main content -->
  <section class="content" id="risultatiRicerca" style="display:none">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Short bio</h3>
            </div>
            <div class="card-body box-profile">
              <div class="text-center">
                <img id="copertina" class="img-responsive" alt="Immagine di copertina">
              </div>

              <h3 class="profile-username text-center" id="labelNomeGioco"></h3>
              <p class="text-muted" id="gameDescription"></p>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Genre</b> <a class="float-right" id="labelGenere"></a>
                </li>
                <li class="list-group-item">
                  <b>Developers</b> <a class="float-right" id="labelSviluppatori"></a>
                </li>
                <li class="list-group-item">
                  <b>Publishers</b> <a class="float-right" id="labelPublicatori"></a>
                </li>
                <li class="list-group-item">
                  <b>Release date</b> <a class="float-right" id="labelReleaseDate"></a>
                </li>
              </ul>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <!-- About Me Box -->
          <div class="card card-primary" id="cardCharts">
            <div class="card-header">
              <h3 class="card-title">Charts</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <canvas id="myChart" width="400" height="400"></canvas>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <div class="card card-primary" id="cardTrend">
            <div class="card-header">
              <h3 class="card-title">Trend</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <p class="text-muted" id="gameTrend"></p>
              <!-- <hr> -->
              <p class="text-muted" id="twitchViewers"></p>
              <p class="text-muted" id="steamCharts"></p>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Prices</h3>
            </div>
            <div class="card-body" id="cardPrezzi"></div>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="col-md-12"></div>
          <div class="card card-primary col-md-12">
            <div class="card-body">
              <div class="col-md-12" id="rowSlideshow" style="margin-bottom:10px"></div>
              <div class="col-md-6" id="gameplayYoutube0"></div>
              <div class="col-md-6" id="gameplayYoutube1"></div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->

  <!-- Modal per il caricamento -->
  <div class="modal"></div>
  <!-- script index -->
  <!-- <script src="./js/scriptModal.js"></script> -->
  <!-- Script che gestisce la pagina -->
  <script src="./js/index.js"></script>
  <script src="./js/toastr.js"></script>
</body>

</html>