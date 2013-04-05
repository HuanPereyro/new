// try to pull from github

<a href="http://www.unako.org/corporateclients">df</a>
<?php
	# MySQL через PDO_MYSQL  
	$DBH = new PDO("mysql:host=localhost;dbname=unako", "root", "");  
	$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	
	
	
	# чтение файлов
	function echoTxt($directory){
		$dir = opendir($directory);
		while($file = readdir($dir)) {
			if(is_file($directory . "/" . $file)) { 
				$list[] = $file;
			}
		}
		closedir ($dir);
		return $list;
	};
	
	
	
	$STH = $DBH->query('SELECT title,id FROM pages');
	# устанавливаем режим выборки
	$STH->setFetchMode(PDO::FETCH_ASSOC); 
	$pages = $STH->fetchAll();
	$STH = $DBH->query('SELECT id,str FROM middle_titles');
	# устанавливаем режим выборки
	$STH->setFetchMode(PDO::FETCH_ASSOC); 
	$cat_menu = $STH->fetchAll();
	
	//echo "<pre>";
	//print_r($cat_menu);
	//echo "</pre>";
	
?>

<h2>add new page</h2>
<form method="post" action="index.php">
	<input type="text" name="title" 	/><label> -> title</label><br/>
	<select name="icon">
		<?php
			$list = echoTxt('img/');
			foreach($list as $key){
				echo "<option value='".$key."'>".$key."</option>";
			}
		?>
	</select><label> -> icon</label><br/>
	<select name="category">
		<option value="P">P</option>
		<option value="S">S</option>
		<option value=""></option>
	</select><label> -> icategory</label><br/>
	<input type="text" name="lat_name" 	/><label> -> lat_name</label><br/>
	<input type="submit" name="send" />
</form>

<h2>create section of menu at page</h2>
<form method="post" action="index.php">
	<input type="text" name="text" 	/><label> -> title</label><br/>
	<select name="page">
		<?php
		foreach ($pages as $line) {
			echo "<option value='".$line['id']."'>".$line['title']."</option>";
		}
		?>
	</select><label> -> in the page</label><br/>
	<input type="submit" name="send1" />
</form>

<h2>create block at page</h2>
<form method="post" action="index.php">
	<input type="text" name="title_of_block" 	/><label> -> title</label><br/>
	<select name="id_page">
		<?php
		foreach ($pages as $line) {
			echo "<option value='".$line['id']."'>".$line['title']."</option>";
		}
		?>
	</select><label> -> in the page</label><br/>
	<select name="img">
		<?php
			$list = echoTxt('img/');
			foreach($list as $key){
				echo "<option value='".$key."'>".$key."</option>";
			}
		?>
	</select>
	<select name="align">
		<option value="LEFT">LEFT</option>
		<option value="RIGHT">RIGHT</option>
		<option value=""></option>
	</select><label> -> img</label><br/>
	<select name="category_of_menu">
		<?php
		foreach ($cat_menu as $line) {
			echo "<option value='".$line['id']."'>".$line['str']."</option>";
		}
		?>
	</select><label> -> img</label><br/>
	<textarea name="text"></textarea><label> -> text</label><br/>
	<input type="submit" name="send2" />
</form>

<?php

	if(isset($_POST['send'])) {

		// Данные, которые надо вставить  
		$data = array(
			'title' => $_POST['title'],
			'icon' => $_POST['icon'],
			'category' => $_POST['category'],
			'lat_name' => $_POST['lat_name']
		);
		  
		// Сокращение  
		$STH = $DBH->prepare("INSERT INTO pages (title, icon, category, lat_name) 
								value (:title, :icon, :category, :lat_name)");  
		$STH->execute($data);
	}
	
	if(isset($_POST['send1'])) {

		// Данные, которые надо вставить  
		$data = array(
			'id_page' => $_POST['page'],
			'str' => $_POST['text']
		);
		  
		// Сокращение  
		$STH = $DBH->prepare("INSERT INTO middle_titles (id_page, str) 
								value (:id_page, :str)");  
		$STH->execute($data);
	}
	
	if(isset($_POST['send2'])) {

		// Данные, которые надо вставить  
		$data = array(
			'id_page' 		   => $_POST['id_page'],
			'title_of_block'   => $_POST['title_of_block'],
			'text' 			   => $_POST['text'],
			'img' 			   => $_POST['img'],
			'align' 		   => $_POST['align'],
			'category_of_menu' => $_POST['category_of_menu']
		);
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		// Сокращение  
		$STH = $DBH->prepare("INSERT INTO blocks (id_page, title_of_block, text, img, align, category_of_menu) 
								value (:id_page, :title_of_block, :text, :img, :align, :category_of_menu)");  
		$STH->execute($data);
	}

	# поскольку это обычный запрос без placeholder’ов,
	# можно сразу использовать метод query()  
	$STH = $DBH->query('SELECT * FROM pages');  
	  
	# устанавливаем режим выборки
	$STH->setFetchMode(PDO::FETCH_ASSOC); 
	
	$row = $STH->fetchAll();		

?>
