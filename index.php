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
  <!-- Chart -->
  <link rel="stylesheet" href="./css/Chart.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="./css/toastr.css">
  <!-- Multiple select tags -->
  <link rel="stylesheet" href="./css/multiple-select.min.css">

  <!-- favicon -->
  <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
  <link rel="icon" href="img/favicon.png" type="image/x-icon">
  
</head>

<body class="hold-transition sidebar-mini">
  <!-- Barra di ricerca -->
  <div class="row searchBar" style="margin-top:1%; margin-bottom:2%">
    <!-- <div class="col-md-1"></div> -->
    <div class="col-md-3">
      <img class="img-responsive pointer" src="logo_wide.png" onclick="home()" style="width:50%; padding-left:5%"
        align="right" />
    </div>
    <div class="col-md-3">
      <div class="search-form" style="margin-top:10%;">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" name="search" id="nomeGioco" placeholder="Search by name"
            onkeypress="handle(event)">
          <span class="glyphicon glyphicon-search form-control-feedback"></span>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <select id="selectTags">
        <option value="492">Indie</option>
        <option value="19">Action</option>
        <option value="21">Adventure</option>
        <option value="597">Casual</option>
        <option value="9">Strategy</option>
        <option value="599">Simulation</option>
        <option value="122">RPG</option>
        <option value="493">Early Access</option>
        <option value="113">Free to Play</option>
        <option value="4182">Singleplayer</option>
        <option value="4667">Violent</option>
        <option value="701">Sports</option>
        <option value="128">Massively Multiplayer</option>
        <option value="4345">Gore</option>
        <option value="699">Racing</option>
        <option value="1756">Great Soundtrack</option>
        <option value="6650">Nudity</option>
        <option value="4166">Atmospheric</option>
        <option value="3871">2D</option>
        <option value="3859">Multiplayer</option>
        <option value="1664">Puzzle</option>
        <option value="12095">Sexual Content</option>
        <option value="1742">Story Rich</option>
        <option value="4026">Difficult</option>
        <option value="4085">Anime</option>
        <option value="21978">VR</option>
        <option value="1684">Fantasy</option>
        <option value="1667">Horror</option>
        <option value="4136">Funny</option>
        <option value="3942">Sci-fi</option>
        <option value="3964">Pixel Graphics</option>
        <option value="1695">Open World</option>
        <option value="1774">Shooter</option>
        <option value="7208">Female Protagonist</option>
        <option value="1625">Platformer</option>
        <option value="3839">First-Person</option>
        <option value="87">Utilities</option>
        <option value="1685">Co-op</option>
        <option value="5350">Family Friendly</option>
        <option value="1662">Survival</option>
        <option value="1663">FPS</option>
        <option value="4004">Retro</option>
        <option value="84">Design &amp; Illustration</option>
        <option value="1677">Turn-Based</option>
        <option value="1773">Arcade</option>
        <option value="1719">Comedy</option>
        <option value="3810">Sandbox</option>
        <option value="4700">Movie</option>
        <option value="3843">Online Co-Op</option>
        <option value="3834">Exploration</option>
        <option value="3799">Visual Novel</option>
        <option value="4726">Cute</option>
        <option value="4711">Replay Value</option>
        <option value="1693">Classic</option>
        <option value="1698">Point &amp; Click</option>
        <option value="5144">Masterpiece</option>
        <option value="7481">Controller</option>
        <option value="1721">Psychological Horror</option>
        <option value="1654">Relaxing</option>
        <option value="1697">Third Person</option>
        <option value="4305">Colorful</option>
        <option value="1755">Space</option>
        <option value="1659">Zombies</option>
        <option value="872">Animation &amp; Modeling</option>
        <option value="1036">Education</option>
        <option value="1734">Fast-Paced</option>
        <option value="10397">Memes</option>
        <option value="1027">Audio Production</option>
        <option value="1708">Tactical</option>
        <option value="7368">Local Multiplayer</option>
        <option value="4342">Dark</option>
        <option value="3968">Physics</option>
        <option value="5716">Mystery</option>
        <option value="8013">Software</option>
        <option value="4234">Short</option>
        <option value="4175">Realistic</option>
        <option value="1038">Web Publishing</option>
        <option value="1643">Building</option>
        <option value="4255">Shoot 'Em Up</option>
        <option value="5611">Mature</option>
        <option value="3978">Survival Horror</option>
        <option value="12472">Management</option>
        <option value="3841">Local Co-Op</option>
        <option value="10695">Party-Based RPG</option>
        <option value="5577">RPGMaker</option>
        <option value="1716">Rogue-like</option>
        <option value="4231">Action RPG</option>
        <option value="4106">Action-Adventure</option>
        <option value="3798">Side Scroller</option>
        <option value="6426">Choices Matter</option>
        <option value="1678">War</option>
        <option value="784">Video Production</option>
        <option value="1702">Crafting</option>
        <option value="5900">Walking Simulator</option>
        <option value="1741">Turn-Based Strategy</option>
        <option value="5537">Puzzle-Platformer</option>
        <option value="3987">Historical</option>
        <option value="1676">RTS</option>
        <option value="4791">Top-Down</option>
        <option value="1621">Music</option>
        <option value="3878">Competitive</option>
        <option value="4885">Bullet Hell</option>
        <option value="4747">Character Customization</option>
        <option value="1775">PvP</option>
        <option value="1738">Hidden Object</option>
        <option value="1687">Stealth</option>
        <option value="4604">Dark Fantasy</option>
        <option value="1646">Hack and Slash</option>
        <option value="3959">Rogue-lite</option>
        <option value="4434">JRPG</option>
        <option value="4094">Minimalist</option>
        <option value="1743">Fighting</option>
        <option value="9551">Dating Sim</option>
        <option value="3835">Post-apocalyptic</option>
        <option value="5125">Procedural Generation</option>
        <option value="3814">Third-Person Shooter</option>
        <option value="3916">Old School</option>
        <option value="1645">Tower Defense</option>
        <option value="1720">Dungeon Crawler</option>
        <option value="1669">Moddable</option>
        <option value="4840">4 Player Local</option>
        <option value="5984">Drama</option>
        <option value="4172">Medieval</option>
        <option value="4295">Futuristic</option>
        <option value="4947">Romance</option>
        <option value="4190">Addictive</option>
        <option value="5411">Beautiful</option>
        <option value="4252">Stylized</option>
        <option value="6971">Multiple Endings</option>
        <option value="4195">Cartoony</option>
        <option value="7332">Base Building</option>
        <option value="4325">Turn-Based Combat</option>
        <option value="1710">Surreal</option>
        <option value="4242">Episodic</option>
        <option value="4057">Magic</option>
        <option value="8945">Resource Management</option>
        <option value="5851">Isometric</option>
        <option value="4637">Top-Down Shooter</option>
        <option value="4150">World War II</option>
        <option value="1666">Card Game</option>
        <option value="1754">MMORPG</option>
        <option value="5923">Dark Humor</option>
        <option value="4168">Military</option>
        <option value="5228">Blood</option>
        <option value="1445">Software Training</option>
        <option value="4115">Cyberpunk</option>
        <option value="7478">Illuminati</option>
        <option value="5752">Robots</option>
        <option value="5711">Team-Based</option>
        <option value="4158">Beat 'em up</option>
        <option value="4695">Economy</option>
        <option value="1644">Driving</option>
        <option value="4064">Thriller</option>
        <option value="3965">Epic</option>
        <option value="1628">Metroidvania</option>
        <option value="13782">Experimental</option>
        <option value="14139">Turn-Based Tactics</option>
        <option value="4486">Choose Your Own Adventure</option>
        <option value="5395">3D Platformer</option>
        <option value="7948">Soundtrack</option>
        <option value="1759">Perma Death</option>
        <option value="4328">City Builder</option>
        <option value="6815">Hand-drawn</option>
        <option value="1673">Aliens</option>
        <option value="7782">Cult Classic</option>
        <option value="13906">Game Development</option>
        <option value="4758">Twin Stick Shooter</option>
        <option value="1770">Board Game</option>
        <option value="11014">Interactive Fiction</option>
        <option value="4036">Parkour</option>
        <option value="6378">Crime</option>
        <option value="31275">Text-Based</option>
        <option value="5363">Destruction</option>
        <option value="15045">Flight</option>
        <option value="4191">3D</option>
        <option value="4562">Cartoon</option>
        <option value="4236">Loot</option>
        <option value="6691">1990's</option>
        <option value="8122">Level Editor</option>
        <option value="5547">Arena Shooter</option>
        <option value="5613">Detective</option>
        <option value="6730">PvE</option>
        <option value="5186">Psychological</option>
        <option value="4161">Real-Time</option>
        <option value="4400">Abstract</option>
        <option value="11123">Mouse only</option>
        <option value="4364">Grand Strategy</option>
        <option value="5153">Kickstarter</option>
        <option value="7743">1980s</option>
        <option value="4975">2.5D</option>
        <option value="1718">MOBA</option>
        <option value="1777">Steampunk</option>
        <option value="5030">Dystopian </option>
        <option value="7432">Lovecraftian</option>
        <option value="7107">Real-Time with Pause</option>
        <option value="6129">Logic</option>
        <option value="1665">Match 3</option>
        <option value="809">Photo Editing</option>
        <option value="9541">Demons</option>
        <option value="4598">Alternate History</option>
        <option value="44868">LGBTQ+</option>
        <option value="19995">Dark Comedy</option>
        <option value="15339">Documentary</option>
        <option value="379975">Clicker</option>
        <option value="4736">2D Fighter</option>
        <option value="10816">Split Screen</option>
        <option value="16598">Space Sim</option>
        <option value="1616">Trains</option>
        <option value="1752">Rhythm</option>
        <option value="17305">Strategy RPG</option>
        <option value="1649">GameMaker</option>
        <option value="5154">Score Attack</option>
        <option value="29363">3D Vision</option>
        <option value="21725">Tactical RPG</option>
        <option value="7250">Linear</option>
        <option value="1670">4X</option>
        <option value="5708">Remake</option>
        <option value="5348">Mod</option>
        <option value="3813">Real Time Tactics</option>
        <option value="25085">Touch-Friendly</option>
        <option value="5794">Science</option>
        <option value="4684">Wargame</option>
        <option value="4821">Mechs</option>
        <option value="1714">Psychedelic</option>
        <option value="176981">Battle Royale</option>
        <option value="13276">Tanks</option>
        <option value="12057">Tutorial</option>
        <option value="1681">Pirates</option>
        <option value="1688">Ninja</option>
        <option value="5094">Narration</option>
        <option value="5055">eSports</option>
        <option value="4046">Dragons</option>
        <option value="4853">Political</option>
        <option value="5160">Dinosaurs</option>
        <option value="3854">Lore-Rich</option>
        <option value="1732">Voxel</option>
        <option value="4508">Co-op Campaign</option>
        <option value="4608">Swordplay</option>
        <option value="14153">Dungeons &amp; Dragons</option>
        <option value="31579">Otome</option>
        <option value="16689">Time Management</option>
        <option value="24904">NSFW</option>
        <option value="9271">Trading Card Game</option>
        <option value="5310">Games Workshop</option>
        <option value="1751">Comic Book</option>
        <option value="1671">Superhero</option>
        <option value="5179">Cold War</option>
        <option value="4474">CRPG</option>
        <option value="3955">Character Action Game</option>
        <option value="8666">Runner</option>
        <option value="10808">Supernatural</option>
        <option value="5502">Hacking</option>
        <option value="1647">Western</option>
        <option value="7113">Crowdfunded</option>
        <option value="6052">Noir</option>
        <option value="5300">God Game</option>
        <option value="4754">Politics</option>
        <option value="29482">Souls-like</option>
        <option value="1717">Hex Grid</option>
        <option value="8075">TrackIR</option>
        <option value="5765">Gun Customization</option>
        <option value="4376">Assassin</option>
        <option value="4878">Parody </option>
        <option value="5608">Emotional</option>
        <option value="1651">Satire</option>
        <option value="4145">Cinematic</option>
        <option value="6910">Naval</option>
        <option value="15954">Silent Protagonist</option>
        <option value="150626">Gaming</option>
        <option value="9994">Experience</option>
        <option value="7569">Grid-Based Movement</option>
        <option value="6869">Nonlinear</option>
        <option value="5673">Modern</option>
        <option value="22602">Agriculture</option>
        <option value="11333">Villain Protagonist</option>
        <option value="6276">Inventory Management</option>
        <option value="9564">Hunting</option>
        <option value="3952">Gothic</option>
        <option value="16094">Mythology</option>
        <option value="10679">Time Travel</option>
        <option value="13190">America</option>
        <option value="1638">Dog</option>
        <option value="1680">Heist</option>
        <option value="5796">Bullet Time</option>
        <option value="8093">Minigames</option>
        <option value="4559">Quick-Time Events</option>
        <option value="134316">Philisophical</option>
        <option value="4202">Trading</option>
        <option value="9157">Underwater</option>
        <option value="7226">Football</option>
        <option value="5390">Time Attack</option>
        <option value="4155">Class-Based</option>
        <option value="30358">Nature</option>
        <option value="17894">Cats</option>
        <option value="4018">Vampire</option>
        <option value="5382">World War I</option>
        <option value="6915">Martial Arts</option>
        <option value="1679">Soccer</option>
        <option value="15564">Fishing</option>
        <option value="18594">FMV</option>
        <option value="4777">Spectacle fighter</option>
        <option value="3796">Based On A Novel</option>
        <option value="5372">Conspiracy</option>
        <option value="6625">Time Manipulation</option>
        <option value="7423">Sniper</option>
        <option value="5432">Programming</option>
        <option value="12286">Warhammer 40K</option>
        <option value="8369">Investigation</option>
        <option value="24003">Word Game</option>
        <option value="1736">LEGO</option>
        <option value="5981">Mining</option>
        <option value="5230">Sequel</option>
        <option value="4845">Capitalism</option>
        <option value="776177">360 Video</option>
        <option value="198631">Mystery Dungeon</option>
        <option value="7622">Offroad</option>
        <option value="7926">Artificial Intelligence</option>
        <option value="17770">Asynchronous Multiplayer</option>
        <option value="8253">Music-Based Procedural Generation</option>
        <option value="9592">Dynamic Narration</option>
        <option value="13577">Sailing</option>
        <option value="6041">Horses</option>
        <option value="6621">Pinball</option>
        <option value="180368">Faith</option>
        <option value="4835">6DOF</option>
        <option value="4184">Chess</option>
        <option value="1735">Star Wars</option>
        <option value="6702">Mars</option>
        <option value="16250">Gambling</option>
        <option value="6310">Diplomacy</option>
        <option value="1733">Unforgiving</option>
        <option value="348922">Steam Machine</option>
        <option value="1674">Typing</option>
        <option value="56690">On-Rails Shooter</option>
        <option value="15172">Conversation</option>
        <option value="6948">Rome</option>
        <option value="17015">Werewolves</option>
        <option value="21006">Underground</option>
        <option value="9204">Immersive Sim</option>
        <option value="1694">Batman</option>
        <option value="5407">Benchmark</option>
        <option value="1730">Sokoban</option>
        <option value="1746">Basketball</option>
        <option value="7038">Golf</option>
        <option value="14906">Intentionally Awkward Controls</option>
        <option value="603297">Hardware</option>
        <option value="4137">Transhumanism</option>
        <option value="13070">Solitaire</option>
        <option value="123332">Bikes</option>
        <option value="22955">Mini Golf</option>
        <option value="198913">Motorbike</option>
        <option value="233824">Feature Film</option>
        <option value="19780">Submarine</option>
        <option value="51306">Foreign</option>
        <option value="5727">Baseball</option>
        <option value="47827">Wrestling</option>
        <option value="7328">Bowling</option>
        <option value="5914">Tennis</option>
        <option value="21722">Lara Croft</option>
        <option value="19568">Cycling</option>
        <option value="17927">Pool</option>
        <option value="255534">Automation</option>
        <option value="324176">Hockey</option>
        <option value="9803">Snow</option>
        <option value="17337">Lemmings</option>
        <option value="27758">Voice Control</option>
        <option value="71389">Spelling</option>
        <option value="1753">Skateboarding</option>
        <option value="15868">Motocross</option>
        <option value="92092">Jet</option>
        <option value="10383">Transportation</option>
        <option value="96359">Skating</option>
        <option value="252854">BMX</option>
        <option value="28444">Snowboarding</option>
        <option value="7309">Skiing</option>
        <option value="129761">ATV</option>
        <option value="856791">Asymmetric VR</option>
        <option value="745697">Social Deduction</option>
      </select>
      <span class="btn btn-sm glyphicon glyphicon-search" onclick="cercaTags()" style="background-color:white;margin-top:10%; border-radius:50%"></span>
    </div>
    <div class="col-md-1">
      <!-- Top 3 -->
      <img class="img-responsive pointer" src="./toppetre.png" onclick="top5()" />
      <!-- <button type="button" class="btn btn-success" onclick="top5()">TOP 3</button> -->
    </div>
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
              <label id="gameDescription"></label>

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
          <div class="card card-primary" id="cardTrend">
            <div class="card-header">
              <h3 class="card-title">Trend</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="col-md-6" style="text-align:center" id="divChartPositiveReviewsLastMonth">
                <div class="circle" id="chartPositiveReviewsLastMonth"></div>
                <label>Monthly positive review</label>
              </div>
              <div class="col-md-6" style="text-align:center" id="divChartPositiveReviews">
                <div class="circle" id="chartPositiveReviews"></div>
                <label>Global positive reviews</label>
              </div>
              <div class="col-md-6 circle" style="text-align:center" id="divChartMetacritic">
                <div class="circle" id="chartMetacritic"></div>
                <label>Score Metacritic</label>
              </div>
              <div class="col-md-6" style="text-align:center" id="divChartSteamCharts">
                <div class="circle" id="chartSteamCharts"></div>
                <label>Monthly AVG players</label>
              </div>
              <div class="col-md-12" style="margin-top:7px">
                <label id="twitchViewers"></label>
              </div>
              <!-- <hr> -->

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <div class="card card-primary" id="cardPrezziPrincipale">
            <div class="card-header">
              <h3 class="card-title">Prices</h3>
            </div>
            <div class="card-body" id="cardPrezzi"></div>
          </div>
          <div class="card card-primary" id="cardSystemRequirements">
            <div class="card-header">
              <h3 class="card-title">System Requirement</h3>
            </div>
            <div class="card-body" id="cardTableSystemRequirements"></div>
          </div>

        </div>

        <!-- /.col -->
        <div class="col-md-9">
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
  <div class="modal" id="modalCaricamento"></div>

  <!-- Modal per i top 3 -->
  <div class="modal fade" id="modalTop3">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Top 3 games</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body" id="contenutoModalTop3"></div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>

  <!-- Modal per la ricerca via tag -->
  <div class="modal fade" id="modalTags">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Risultati della ricerca</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body" id="contenutoModalTags"></div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>

  <!-- Script da importare -->
  <!-- Import JQUERY -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!-- import Bootstrap -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <!-- Chart -->
  <script src="./js/Chart.js"></script>
  <!-- Circles -->
  <script src="./js/circles.js"></script>
  <!-- Multiple select tags -->
  <script src="./js/multiple-select.min.js"></script>

  <script src="./js/index.js"></script>
  <script src="./js/toastr.js"></script>
</body>

</html>