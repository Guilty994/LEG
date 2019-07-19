<?php

if(isset($steam_game_name)){
	$gamesteam = $steam_game_name;
	
	$gamenameinput = preg_replace("/[^a-zA-Z0-9]/", " ", strtolower($gamesteam));
	
	//LINK PARAMETERS
	//name with the right encode
	$gamenameinput = urlencode($gamenameinput);
	//ONLY BASE GAME
	$gametype = "content_type%5B%5D=1";
	//ORDER MIN + ASC
	$orderprice = "order=min_price&dir=asc";
	//GAME REGION  ------- free region =3 /europe = 1
	$region = "region_limit=3";
	//PLATFORM ------- steam = 2
	$platform = "platform=2";
	
	$curl = curl_init("https://www.g2play.net/catalogsearch/result/index/?q=".$gamenameinput."&".$orderprice."&".$gametype."&hide_outstock=1&".$platform."&".$region);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);	
    $response = curl_exec($curl);
    if(curl_errno($curl)){
        header($_SERVER['SERVER_PROTOCOL'] . "wrapper_g2play, Scraper error: " . curl_error($curl), true, 400);
		exit;
    }
    curl_close($curl);

    $html = new simple_html_dom();
    $html -> load($response);
	//information about the game with the best price
	foreach($html->find('div') as $div){
		if($div->id == 'offerDetails'){
			foreach($div->find('div') as $gameinfo) {
				if($gameinfo->class == 'info'){
				$bestprice = $gameinfo;
				break;
				}
			}
		}
	}
	
	if(isset($bestprice)){
	
		//catch url and best price
		foreach($bestprice->find('a') as $link){
			$gameurl = $link->attr['href'];;
			break;
		}
	 
		foreach($bestprice->find('div') as $price){
			if($price->class == 'actual-price'){
				$gameprice = $price->first_child()->attr['data-no-tax-price'];
			}
		}
		$toReturn['g2playGameURL'] = $gameurl;
		$toReturn['g2playGamePrice'] = $gameprice;
		}else {
			$toReturn['g2playGameURL'] = "NO GAME AVALAIBLE";	
			$toReturn['g2playGamePrice'] = "NO GAME AVALAIBLE";
		}
	}else{
		$toReturn['g2playGameURL'] = "";	
		$toReturn['g2playGamePrice'] = "";
	}
	
	
	
	
?>