<?php
	if(isset($steam_game_name)){
		
		$gamesteam = $steam_game_name;
		$gamenameinput = preg_replace("/[^a-zA-Z0-9]/", " ", strtolower($gamesteam));
	
	
		//LINK PARAMETERS
		//name with the right encode
		$gamenameinput = rawurlencode($gamenameinput);

		$curl = curl_init("https://www.greenmangaming.com/search/".$gamenameinput."?platforms=73&comingSoon=false&released=true&prePurchased=false&bestSelling=false&pageSize=10");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($curl);
		if(curl_errno($curl)){
			header($_SERVER['SERVER_PROTOCOL'] . "wrapper_greenman, Scraper error: " . curl_error($curl), true, 500);
			exit;
		}
		curl_close($curl);

		$html = new simple_html_dom();
		$html -> load($response);
		$gameurl = NULL;
		
		
		$liroot = $html->find("ul.table-search-listings")[0]->children(0);
		$inforoot = $liroot->first_child()->next_sibling()->next_sibling()->find("div.media-body")[0]->first_child()->first_child();
	
	
		$gamenamewords = explode(" ",$gamesteam);
		$gamename = $inforoot->innertext;
		$rightgame = true;
		foreach($gamenamewords as $word){
			if (!preg_match('/\b('.$word.')\b/i',$gamename)){
				$rightgame = false;
				break;
			}			
		}	
	
	
		if ($rightgame){
			// echo $liroot;
			$gameurl = "https://www.greenmangaming.com".$inforoot->attr['href'];
			$gameprice = $liroot->first_child()->next_sibling()->next_sibling()->find("p.listing-price strong")[0]->innertext;
		}
		
		
		
		if ($gameurl == NULL){
			header($_SERVER['SERVER_PROTOCOL'] . "", true, 404);
			exit;
		}else{
			$toReturn['greenManGameURL'] = $gameurl;
			$toReturn['greenManPrice'] = $gameprice;
		}

	}else{
			header($_SERVER['SERVER_PROTOCOL'] . "", true, 400);
			exit;
	}
	
?>

