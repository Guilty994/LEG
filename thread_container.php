<?php
    
    $steam_charts_thread = new class extends Thread {
    
        public function run()
        {
            // Steamcharts
            include "wrappers/wrapper_steamcharts.php";
            echo "<script>console.log( 'wrapper_steamcharts EXECUTED' );</script>";
        }
    };


?>