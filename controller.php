<?php
    include "simple_html_dom.php";

    if(isset($_GET["game"])){
        if($_GET["game"]==""){
            echo "No game searched.";
        }else{
            $game = $_GET["game"];

            echo "<h2>Source Steam... </h2>";
            require "wrappers/wrapper_steam.php";
            echo "<h2>Source Steamcharts... </h2>";
            include "wrappers/wrapper_steamcharts.php";
			echo "<h2>Kinguin price..</h2>";
			include "wrappers/wrapper_kinguin.php";
			echo "<h2> Greenman Gaming price..</h2>";
			include "wrappers/wrapper_greenman.php";
			echo "<h2> G2A price..</h2>";
			include "wrappers/wrapper_g2a.php";
			
			
        }       
    }else{
        echo "Error in the GET request.";
    }
?>