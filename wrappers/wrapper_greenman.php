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
	
	

		$controllarenome = array();
		foreach($html->find('ul') as $ul){
			if($ul->class == 'table-search-listings'){
				foreach($ul->find('li') as $li){
					//scorro i risultati
					
					foreach($li->find('div') as $div){
						if($div->class== 'media-body'){
							array_push($controllarenome, $div);
							// echo $controllarenome[$i];
							
						}
						
					}
				}
			}
		}
		
		$checkbestprice = array();
		foreach($controllarenome as $x){
			$gameurl = $x->first_child()->first_child()->attr['href'];
			$gamename = $x->first_child()->first_child()->innertext;
			// echo $gameurl;
			// echo $gamename;
			if(checkString($gamesteam,$gamename)){
				foreach($x->find('span') as $platform){
					if($platform->class == 'prod-platform'){
						if($platform->first_child()->innertext == 'PC'){
							array_push($checkbestprice,$x);
							break;
						}
					}
				}
			}
		}
		
		$bestprice = 1000;
		$finalResult= array(array("GameUrl","GamePrice"),array());
		foreach($checkbestprice as $x){
			foreach($x->find('span') as $game){
				if($game->class == 'current-price'){
					$price = $game->children(2)->innertext;
					if($price < $bestprice){
						$bestprice = $price ;
						$finalResult['GameUrl'][0] = "https://www.greenmangaming.com".$x->first_child()->first_child()->attr['href'];
						$finalResult['GamePrice'][0] = $bestprice;
					}
				}
			}	
		}
		if(isset($finalResult['GameUrl'][0]) && isset($finalResult['GamePrice'][0])){
			$toReturn['greenManGameURL'] = $finalResult['GameUrl'][0];
			$toReturn['greenManPrice'] = $finalResult['GamePrice'][0];
		}else{
			header($_SERVER['SERVER_PROTOCOL'] . "wrapper_greenman, gioco non disponibile in catalogo: " . curl_error($curl), true, 404);
			exit;
		}

	}else{
			header($_SERVER['SERVER_PROTOCOL'] . "wrapper_greenman, steam non definito: " . curl_error($curl), true, 400);
			exit;
	}
	
?>

