<?php
	if(isset($steam_game_name)){
		
		$gamesteam = $steam_game_name;
		$gamesteam = preg_replace("/[^a-zA-Z0-9]/", " ", strtolower($gamesteam));
		
		
		//LINK PARAMETERS
		//name with the right encode
		$gamenameinput = rawurlencode($gamesteam);
		$gamenameinput = preg_replace("/(%20%20)$/","",$gamenameinput);
		$curl = curl_init("https://www.greenmangaming.com/search/".$gamenameinput."?platforms=73&comingSoon=false&released=true&prePurchased=false&bestSelling=false&pageSize=10");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($curl);
		if(curl_errno($curl)){
			header("Qualcosa" . "wrapper_greenman, Scraper error: " . curl_error($curl), true, 500);
			exit;
		}
		curl_close($curl);
		$html = new simple_html_dom();
		$html -> load($response);

		$gameurl = NULL;
		$gameprice = NULL;
		
		$root = $html->find("ul.table-search-listings,0");
		foreach($root[0]->children(0)->find("div.media-body") as $div){
			$gameroot = $div->first_child()->first_child();
			$explodedgame = explode(" ",$gamesteam);
			$gamename = $gameroot->innertext;
			$rightgame = true;
			foreach($explodedgame as $word){
				if (!preg_match('/\b('.$word.')\b/i',$gamename)){
					$rightgame = false;
					break;
				}			
			}
			if($rightgame){
				$gameurl = "https://www.greenmangaming.com".$gameroot->attr['href'];
				$gameprice = $div->find("div.row strong")[0]->innertext;
			}
			break;
		}
		
		if($gameurl == NULL){
			header("Qualcosa" . "", true, 404);
			exit;
		}else{
			$toReturn['greenManGameURL'] = $gameurl;
			$toReturn['greenManPrice'] = $gameprice;
		}
	}else{
		header("Qualcosa" . "", true, 400);
		exit;
	}
	
?>

