<?php
	$gamesteam = $steam_game_name;
	
	$badwords = array('DLC','DCL','ASIA','RU','RUSSIA','TURKEY','CIS','PACK','PASS');
	$gamenameinput = preg_replace("/[^a-zA-Z0-9]/", " ", strtolower($gamesteam));
	$gamenameinput = preg_replace("!\s+!"," ",$gamenameinput);
	$later = $gamenameinput;
	
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
        header("wrapper_g2play, Scraper error: " . curl_error($curl), true, 500);
		exit;
    }
	curl_close($curl);
	
    $html = new simple_html_dom();
	$html -> load($response);
	//information about the game with the best price
	$gameurl = NULL;
	$gameprice = NULL;
	foreach($html->find("div[class][id][itemtype] div div.info")as $div){
		$gamename = $div->first_child()->first_child()->innertext;
		$gamename = preg_replace("/[^a-zA-Z0-9]/", " ", strtolower($gamename));
		if (preg_match('/\b('.implode($badwords,"|").')\b/i',$gamename))
			continue;
		/////////////
		$explodedgame = explode(" ",$later);
		$rightgame = true;
		foreach($explodedgame as $word){
			if (!preg_match('/\b('.$word.')\b/i',$gamename)){
				$rightgame = false;
				break;
			}			
		}
		if ($rightgame == false){
			continue;
		}else{
			$gameurl = $div->first_child()->first_child()->first_child()->attr['href'];
			$pricetag = $div->first_child()->next_sibling()->find("div[class=actual-price] span[data-no-tax-price]");
			$gameprice = $pricetag[0]->attr['data-no-tax-price'];
			break;	
		}
		
	}
	
	if($gameurl == NULL){
			// Gioco non trovato
			header("Game not found", true, 404);
			exit;
		}else{
			$toReturn['g2playGameURL'] = $gameurl;
			$toReturn['g2playGamePrice'] = $gameprice;
		}
?>