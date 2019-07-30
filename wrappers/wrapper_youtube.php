<?php
    $url_encoded = "https://www.youtube.com/results?search_query=".urlencode($steam_game_name)."+gameplay";
    
    $curl = curl_init($url_encoded);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($curl);
    if(curl_errno($curl)){
        header("wrapper_youtube, Scraper error: " . curl_error($curl), true, 500);
        // echo "<script>console.log( 'wrapper_youtube ERROR' );</script>";
        // echo "<script>console.log( 'Scraper error: " . curl_error($curl) . "' );</script>";
        exit;
    }
    curl_close($curl);

    $html = new simple_html_dom();
    $html -> load($response);

    $youtube_video_gameplay = array();
    
    // seleziona solo i primi {$count} video gameplay
    $count = 5;
    foreach($html->find('div') as $video){
            if($video->class == "yt-lockup-content"){
                foreach($video->find('a') as $a){
                    array_push($youtube_video_gameplay, "https://www.youtube.com/".$a->href);
                    $count--;
                    break;
                }
            }
            if($count<1){
                break;
            }
    }

    $toReturn['videoGameplay'] = $youtube_video_gameplay;
?>