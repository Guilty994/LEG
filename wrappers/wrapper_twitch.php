<?php
    // search game _id
    $mod_steam_game_name = preg_replace("/[^a-zA-Z0-9\s\:\,\']/", "", $steam_game_name);
    // $mod_steam_game_name = preg_split('/[\s,]+/', $mod_steam_game_name, 3)
    // echo urlencode($mod_steam_game_name);
    
    $url_encoded = "https://api.twitch.tv/kraken/search/games?query=".rawurlencode($mod_steam_game_name);
    
    // echo $url_encoded."<br>";
    $curlHeader = array('Client-ID: j05qnqaf7a16tjffl9n11seij9j6v9', 'Accept: application/vnd.twitchtv.v5+json');
    $curl = curl_init($url_encoded);
    curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $curlHeader);
    $response = curl_exec($curl);
    if(curl_errno($curl)){
        header("wrapper_twitch, Scraper error: " . curl_error($curl), true, 500);
        // echo "<script>console.log( 'wrapper_twitch ERROR' );</script>";
        // echo "<script>console.log( 'Scraper error: " . curl_error($curl) . "' );</script>";
        exit;
    }
    curl_close($curl);

    $response_json = json_decode($response, TRUE);

    // print_r($response_json);

    $_id = $response_json['games'][0]['_id'];

    //search steamers for that game and count views

    $url_encoded = "https://api.twitch.tv/helix/streams?game_id=".$_id."&first=100";
    
    $curlHeader = array('Client-ID: j05qnqaf7a16tjffl9n11seij9j6v9', 'Accept: application/vnd.twitchtv.v5+json');
    $curl = curl_init($url_encoded);
    curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $curlHeader);
    $response = curl_exec($curl);
    if(curl_errno($curl)){
        header("wrapper_twitch, Scraper error: " . curl_error($curl), true, 500);
        // echo "<script>console.log( 'wrapper_twitch ERROR' );</script>";
        // echo "<script>console.log( 'Scraper error: " . curl_error($curl) . "' );</script>";
        exit;
    }
    curl_close($curl);

    $response_json = json_decode($response, TRUE);
    
    $viewers = 0;
    $streamers_count = 0;

    if(isset($response_json['data'])){
        foreach($response_json['data'] as $streamer){
            $viewers = $viewers + $streamer['viewer_count'];
            $streamers_count++;
        }
    }
    


    while($streamers_count>99){
        $pagination = $response_json['pagination']['cursor'];

        $url_encoded = "https://api.twitch.tv/helix/streams?game_id=".$_id."&first=100&after=".$pagination;
    
        $curlHeader = array('Client-ID: j05qnqaf7a16tjffl9n11seij9j6v9', 'Accept: application/vnd.twitchtv.v5+json');
        $curl = curl_init($url_encoded);
        curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $curlHeader);
        $response = curl_exec($curl);
        if(curl_errno($curl)){
            header("wrapper_twitch, Scraper error: " . curl_error($curl), true, 500);
            // echo "<script>console.log( 'wrapper_twitch ERROR' );</script>";
            // echo "<script>console.log( 'Scraper error: " . curl_error($curl) . "' );</script>";
            exit;
        }
        curl_close($curl);

        $response_json = json_decode($response, TRUE);

        $streamers_count = 0;

        foreach($response_json['data'] as $streamer){
            $viewers = $viewers + $streamer['viewer_count'];
            $streamers_count++;
        }
    }

    $toReturn['twitchViewers'] = $viewers;
    
?>