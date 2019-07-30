<?php
	
	
	
	if(isset($steam_game_name)){
		$gamesteam = $steam_game_name;
		
		$gamenameinput = preg_replace("/[^a-zA-Z0-9]/", " ", strtolower($gamesteam));
		$badwords = array('DLC','DCL','ASIA','RU','RUSSIA','TURKEY','CIS');
		//LINK PARAMETERS
		//name with the right encode
		$gamenameinput = rawurlencode($gamenameinput);
		$curl = curl_init("https://www.g2a.com/search?query=".$gamenameinput."&sort=price-lowest-first&category_id=games-c189&region%5B1%5D=8355&region%5B0%5D=878&drm%5B5%5D=1");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		// curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');// specifica locazione dei cookie da leggere
		// curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie_read.txt');// specifica locazione in cui sono scritti i cookie che erano presenti
		
		curl_setopt($curl, CURLOPT_ENCODING, 'gzip, deflate');
		
		$headers = array();
		$headers[] = 'Authority: www.g2a.com';
		$headers[] = 'Upgrade-Insecure-Requests: 1';
		$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36 OPR/58.0.3135.132';
		$headers[] = 'Dnt: 1';
		$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8';
		$headers[] = 'Accept-Encoding: gzip, deflate, br';
		$headers[] = 'Accept-Language: en-US,en;q=0.9';
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);
		
		$response = curl_exec($curl);
		if(curl_errno($curl)){
			header("Qualcosa" . "wrapper_g2a, Scraper error: " . curl_error($curl), true, 500);
			exit;
		}
		curl_close($curl);
		
		$html = new simple_html_dom();
		$html -> load($response);
	
	
		$gameURL = NULL;
		$gamePrice = NULL;
		foreach($html->find("li[class=products-grid__item]") as $li){
			foreach($li->find('div') as $internaldiv){
				$gameinstance = $internaldiv->first_child()->first_child();
				if($internaldiv->class =='Card__headings'){
					// echo $gameinstance->innertext;
					if (preg_match('/\b('.implode($badwords,"|").')\b/i',$gameinstance->innertext)){
						break;
					}else{
						$gameURL = $gameinstance->attr['href'];
					}
				}
				if($internaldiv->class =='Card__price'){
					$gamePrice =$internaldiv->first_child()->next_sibling()->innertext;
				}
			}
			if($gameURL != NULL)
				break;
		}
		if($gameURL == NULL){
			header("Qualcosa" . "wrapper_g2a, gioco non disponibile in catalogo: " . curl_error($curl), true, 404);
			exit;
		}else {
			$toReturn['G2AGameURL'] = "https://www.g2a.com".$gameURL;
			$toReturn['G2AGamePrice'] = $gamePrice;
		}
		
	}else{
			header("Qualcosa" . "wrapper_g2a, steam non definito: " . curl_error($curl), true, 400);
			exit;
	
	}
	
		
?>