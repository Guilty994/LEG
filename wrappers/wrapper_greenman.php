<?php

	function checkString($arr, $str) {

	  $str = preg_replace( array('/[^ \w]+/', '/\s+/'), ' ', strtolower($str) ); // Remove Special Characters and extra spaces -or- convert to LowerCase
	  $arr = preg_replace( array('/[^ \w]+/', '/\s+/'), ' ', strtolower($arr) ); // Remove Special Characters and extra spaces -or- convert to LowerCase
	  
	  $matchedString = array_intersect( explode(' ', $str), explode(' ',$arr));

	  if ( count($matchedString) >= sizeof(explode(' ',$arr))) {
		return true;
	  }
	  return false;
	}
	
	//change name into Kinguin's searching format
	function changeNameWithSymbol($name,$simbol) {

	  $name = preg_replace( array('/[^ \w]+/', '/\s+/'), $simbol, strtolower($name) ); // Remove Special Characters and extra spaces -or- convert to LowerCase
	  return $name;

	}
	
	$tempnam = changeNameWithSymbol($steam_game_name,'%20');
	$curl = curl_init("https://www.greenmangaming.com/search/".$tempnam."?platforms=73&comingSoon=false&released=true&prePurchased=false&bestSelling=true&pageSize=10");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($curl);
    if(curl_errno($curl)){
        echo 'Scraper error: ' . curl_error($curl);
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
		if(checkString($steam_game_name,$gamename)){
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
	//echo sizeof($checkbestprice);
	//echo $checkbestprice[0];
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
				}else{
					echo "false";
				}
			}
		}	
	}
	if(isset($finalResult)){
		
		echo "<b>BEST PRICE FROM GREENMANGAMING.com: </b><br>";
		echo "<b>Game URL: </b>".$finalResult['GameUrl'][0]." <br>";
		echo "<b>Game price: </b>".$finalResult['GamePrice'][0]." <br>";
	}else{
		
	}
	
	
	
	
	
?>

