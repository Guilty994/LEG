<?php

	//change name into Kinguin's searching format
	function changeName($name) {

	  $name = preg_replace( array('/[^ \w]+/', '/\s+/'), '+', strtolower($name) ); // Remove Special Characters and extra spaces -or- convert to LowerCase
	  return $name;

	}
	

	$tempnam = changeName($steam_game_name);
	//base game
	$gametype = "content_type%5B%5D=1";
	//order min + asc
	$orderprice = "order=min_price&dir=asc";
	//region europe ------- free region =3 /europe = 1
	$region = "region_limit=3";
	//platform steam 
	$platform = "platform=2";
	
	$curl = curl_init("https://www.kinguin.net/catalogsearch/result/index/?p=1&q=".$tempnam."&".$orderprice."&".$gametype."&hide_outstock=1&".$platform."&".$region);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($curl);
    if(curl_errno($curl)){
        echo 'Scraper error: ' . curl_error($curl);
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
	echo "<b>BEST PRICE FROM KINGUIN.IT: </b><br>";
	echo "<b>Game URL: </b>".$gameurl." <br>";
	echo "<b>Game price: </b>".$gameprice." <br>";
	}else {
		echo "<b>No price available from Kinguin.it: </b> <br>";	
	}

?>