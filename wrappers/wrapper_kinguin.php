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
		$region = "region_limit=1";
		//PLATFORM ------- steam = 2
		$platform = "platform=2";
		
		$curl = curl_init("https://www.kinguin.net/catalogsearch/result/index/?p=1&q=".$gamenameinput."&".$orderprice."&".$gametype."&hide_outstock=1&".$platform."&".$region);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($curl);
		if(curl_errno($curl)){
			echo "<script>console.log( 'Scraper error: " . curl_error($curl) . "' );</script>";
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
				$gameurl = $link;
				break;
			}
	 
			foreach($bestprice->find('div') as $price){
				if($price->class == 'actual-price'){
					$gameprice = $price->first_child()->attr['data-no-tax-price'];
				}
			}
			$toReturn['kinguinGameURL'] = $gameurl;
			$toReturn['kinguinGamePrice'] = $gameprice;
		}else {
			$toReturn['kinguinGameURL'] = "NO GAME AVALAIBLE";	
			$toReturn['kinguinGamePrice'] = "NO GAME AVALAIBLE";
		}
	

	}else{
		$toReturn['kinguinGameURL'] = "";	
		$toReturn['kinguinGamePrice'] = "";
	}

?>