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
              <p>Nessuna ricerca recente</p>
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
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img id="copertina" class="img-responsive" alt="Immagine di copertina">
              </div>

              <h3 class="profile-username text-center" id="labelNomeGioco"></h3>

              <p class="text-muted text-center">Software Engineer</p>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Followers</b> <a class="float-right">1,322</a>
                </li>
                <li class="list-group-item">
                  <b>Following</b> <a class="float-right">543</a>
                </li>
                <li class="list-group-item">
                  <b>Friends</b> <a class="float-right">13,287</a>
                </li>
              </ul>

              <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <!-- About Me Box -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">About Me</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <strong><i class="fa fa-book mr-1"></i> Education</strong>

              <p class="text-muted">
                B.S. in Computer Science from the University of Tennessee at Knoxville
              </p>

              <hr>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card">
            <div class="card-header p-2">

            </div><!-- /.card-header -->
            <div class="card-body">

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

  <!-- Import JQUERY -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!-- import Bootstrap -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <!-- script index -->
  <script src="./js/index.js"></script>
</body>

</html>