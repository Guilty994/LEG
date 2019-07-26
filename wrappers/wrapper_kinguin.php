<?php
	if(isset($steam_game_name)){
		$gamesteam = $steam_game_name;
	
		$badwords = array('DLC','DCL','ASIA','RU','RUSSIA','TURKEY','CIS','PACK','PASS');
		$gamenameinput = preg_replace("/[^a-zA-Z0-9]/", " ", strtolower($gamesteam));
		$gamenameinput = preg_replace("!\s+!"," ",$gamenameinput);
		
		//LINK PARAMETERS
		//name with the right encode
		$gamenameinput = urlencode($gamenameinput);
		// echo $gamenameinput;
		//ONLY BASE GAME
		$gametype = "content_type%5B%5D=1";
		//ORDER MIN + ASC
		$orderprice = "order=min_price&dir=asc";
		//GAME REGION  ------- free region =3 /europe = 1
		$region = "region_limit=1";
		//PLATFORM ------- steam = 2
		$platform = "platform=2";
		
		$curl = curl_init("https://www.kinguin.net/catalogsearch/result/index/?p=1&q=".$gamenameinput."&".$orderprice."&".$gametype."&hide_outstock=1&".$platform."&".$region);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($curl);
		if(curl_errno($curl)){
			header($_SERVER['SERVER_PROTOCOL'] . "wrapper_kinguin, Scraper error: " . curl_error($curl), true, 500);
			exit;
		}
		curl_close($curl);

		$html = new simple_html_dom();
		$html -> load($response);
		
		$gameurl = NULL;
		$gameprice = NULL;
		foreach($html->find("div[class][id][itemtype] div div.info")as $div){
			$gamename = $div->first_child()->first_child()->innertext;
			$gamename = preg_replace("/[^a-zA-Z0-9]/", " ", strtolower($gamename));
			if (preg_match('/\b('.implode($badwords,"|").')\b/i',$gamename)){
				continue;
			}else{
				$gameurl = $div->first_child()->first_child()->first_child()->attr['href'];
				$pricetag = $div->first_child()->next_sibling()->find("div[class=actual-price] span[data-no-tax-price]");
				$gameprice = $pricetag[0]->attr['data-no-tax-price'];
				break;	
			}
		
		}
		
		
			
		if($gameurl == NULL){
			header($_SERVER['SERVER_PROTOCOL'] . "", true, 404);
			exit;
		}else{
			$toReturn['kinguinGameURL'] = $gameurl;
			$toReturn['kinguinGamePrice'] = $gameprice;
		}
	

	}else{
		header($_SERVER['SERVER_PROTOCOL'] . "", true, 400);
		exit;
	}
?>