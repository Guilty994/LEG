<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | User Profile</title>
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

  <!-- Import JQUERY -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!-- import Bootstrap -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <!-- Script che gestisce la pagina -->
  <script src="./js/index.js"></script>
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
    <div class="col-md-12">
      <h3>Ricerche recenti:</h3>
      <div class="row">
        <div class="col-md-1"></div>
        <!-- TODO: Usare offset invece della colonna vuota -->
        <div class="col-md-10">
          <table>
            <thead></thead>
            <tbody id="tbodyRicercheRecenti">
              <p>No recent search</p>
            </tbody>
          </table>
        </div>
        <!-- TODO: Usare offset invece della colonna vuota -->
        <div class="col-md-1"></div>
      </div>
    </div>
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
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Trend</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <p class="text-muted" id="gameTrend"></p>
              <!-- <hr> -->
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Screenshots</h3>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div id="carouselScreenshots" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators" id="carouselIndicatorsScreenshots"></ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" id="carouselInnerScreenshots" style="text-align: center"></div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#carouselScreenshots" data-slide="prev">
                  <span class="glyphicon glyphicon-chevron-left"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#carouselScreenshots" data-slide="next">
                  <span class="glyphicon glyphicon-chevron-right"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
            </div><!-- /.card-body -->
          </div>
          <!-- /.nav-tabs-custom -->
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
  <script src="./js/scriptModal.js"></script>

</body>

</html>