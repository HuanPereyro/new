// this is my chenge

<?php

	function parseString( $str ) {
		$str = trim( $str );
		$str = preg_replace("/[^A-Za-z0-9\-\_]/","",@strval($str));
		$str = strip_tags( $str );
		$str = htmlspecialchars( $str, ENT_QUOTES );
		return $str;
	}

	# MySQL через PDO_MYSQL  
	$DBH = new PDO("mysql:host=localhost;dbname=unako", "root", "");  
	$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	
	if(!isset($_GET['page_name'])) exit("slomalos");
	$name = parseString($_GET['page_name']);
	echo $name.'<br/>';
	
	
	$STH = $DBH->query("SELECT * FROM pages WHERE lat_name = '".$name."'");
	# устанавливаем режим выборки
	$STH->setFetchMode(PDO::FETCH_ASSOC); 
	$page = $STH->fetchAll();
	
	//echo "<pre>";
	//print_r($page);
	//echo "</pre>";
	
	$STH = $DBH->query("SELECT * FROM middle_titles WHERE id_page = '".$page[0]['id']."'");
	# устанавливаем режим выборки
	$STH->setFetchMode(PDO::FETCH_ASSOC); 
	$link = $STH->fetchAll();
	
	#echo "<pre>";
	#print_r($link);
	#echo "</pre>";
	
	
	$STH = $DBH->query("SELECT * FROM blocks WHERE id_page = '".$page[0]['id']."'");
	# устанавливаем режим выборки
	$STH->setFetchMode(PDO::FETCH_ASSOC); 
	$blocks = $STH->fetchAll();
	
	#echo "<pre>";
	#print_r($blocks);
	#echo "</pre>";
	
	echo '#@!<br/>';	
	#=============================================================
	# $page,$link,$blocks;
	
	echo "title = ".$page[0]['title']."<br/>";
	echo "img = ".$page[0]['icon']."<br/>";
	echo "Menu:<br/>";
	
	foreach($link as $temp){
		echo $temp['str']."<br/>";
		foreach($blocks as $temp2){
            if ($temp2['category_of_menu'] == $temp['id']) {
				echo $temp2[title_of_block]."<br/>";
				echo $temp2[text]."<br/>";
				echo $temp2[img]."<br/>";
				echo $temp2[align]."<br/>";
			}
		}
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

