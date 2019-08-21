<?php
    $offset = 0;
    $count = 0;
    $gamesFound = array();
    while($offset < 10){
        $url_encoded = "https://api.twitch.tv/kraken/games/top?limit=5&offset=".$offset;

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
            exit;
        }
        curl_close($curl);

        $response_json = json_decode($response, TRUE);

        
        foreach($response_json['top'] as $top){
            $gamesFound[$count] = $top['game']['name'];
            $count++;
        }
        $offset = $offset + 5;
    }
    if(empty($gamesFound)){
        header("No games found", true, 404);
        exit;
    }

    $toReturn['topGames'] = $gamesFound;

    // // Check game avability on Steam
    // class Game{
    //     public function __construct($name, $icon) {
    //         $this->name = $name;
    //         $this->icon = $icon;
    //     }
    // }

    // $toReturn['topFive'] = array();
    // foreach($gamesFound as $twitchGame){
    //     include "wrappers/wrapper_steam_checkgameavaibility.php";
    // }

    // if(empty($toReturn['topFive'])){
    //     header("No matching found", true, 404);
    //     exit;
    // }
?>