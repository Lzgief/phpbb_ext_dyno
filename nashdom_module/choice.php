<?php
	session_start() ;
	echo 'в choice session_id = '.session_id().'<br />';
	ob_clean();
	$addressh=$_POST['fias_val'];
	setcookie("Address",$addressh, time()+3600, '/');
	echo $_COOKIE['Address'];
	header('Content-Type: text/html; charset = utf-8');
	$city					= $_POST['city'];
	$street					= $_POST['street'];
	$street_kladr_id		= (int)$_POST['street_kladr_id'];
 	$house					= (string)$_POST['house'];
	$block					= (string)$_POST['block'];
	$street_type_full		= $_POST['street_type_full'];
	$_SESSION['fias_val']	= $_POST['fias_val'];
	$_SESSION['no_plan']	= 0;
	
	//  ================   Подключение к БД   ====================================== 	
	$link = mysqli_connect();
	if (!$link) {
		echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
		echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
		exit;
		}
	//echo "Соединение с MySQL установлено!" . PHP_EOL.' <br />';
	//echo "Информация о сервере: " . mysqli_get_host_info($link) . PHP_EOL.' <br />';
	//  ============================================================================= 

	if(empty($block)) $block = 0 ;   // $block - номер корпуса у дома 

	//  ============  Определение идентификатора МКД    =============================

	$query = "SELECT id_mkd FROM house  WHERE kod_street = '$street_kladr_id'  AND n_house = '$house' AND  n_block = '$block' ";
	
	if ($result1 = mysqli_query($link, $query)) {
		$row = mysqli_fetch_row($result1) ; 
		$id_mkd = $row[0] ;
 		mysqli_free_result($result1);
		$_SESSION['id_mkd'] = $id_mkd ;
		}
	// ==========================================================================
	//echo 'city = '            .$city	        	.'<br />'  ;
	//echo 'street = '          .$street				.'<br />'  ;
	//echo 'street_kladr_id = ' .$street_kladr_id		.'<br />'  ;
	//echo 'house = '           .$house 				.'<br />'  ;
	//echo 'block = '           .$block 				.'<br />'  ;
	//echo 'street_type_full = '.$street_type_full  	.'<br />'  ;

	if (empty($id_mkd)) {
			//echo '$NN или 0, или пусто, или вообще не определена. <br />';
		$query_2 = "INSERT INTO house ( city_mkd ,  street_mkd ,  kod_street        ,  n_house  ,  n_block,  street_type_full   , date_creation     )
                               	VALUES ('$city'  , '$street'   , '$street_kladr_id' , '$house'  , '$block', '$street_type_full' , CURRENT_TIMESTAMP )";
		$test = mysqli_query($link, $query_2 );
		if(!$test) {echo 'Запись в БД НЕ прошла! <br /> ';}
		else {/*echo 'Запись в БД  прошла успешно! <br /> ';*/}
		
		/* Здесь надо содать файл для введенного адреса, а затем его загрузить! */
		// ------------------------------------------------------------------- 
		$query_3 = " SELECT * FROM house ORDER BY  id_mkd DESC limit 1" ;
		$sql=mysqli_query($link, $query_3);
		if(!$sql) {echo 'Выборка из БД НЕ прошла! <br /> ';}
		else {/*echo 'Выборка из БД  прошла успешно! <br /> ';*/}
		
		$sql_row = mysqli_fetch_array($sql) or die("Не могу получить последнее значение".mysqli_error());
		$id_mkd=$sql_row[0];
		$_SESSION['id_mkd'] = $id_mkd ;
	
		//  ------------------------------------------------------------------ 
		
		$file    = 'Home/house.php';				/* === Имя файла шаблона  === */
		$mkd_new = $id_mkd ;
		$name_file_house = 'Home/house_'.$mkd_new.'.php';	/* === Имя шаблона для нового адреса (дома)  === */
		if (!copy($file, $name_file_house)) {
			echo "не удалось скопировать \n";
			}
		}
	else {
		$name_file_house = "Home/house_".$id_mkd.".php"; // Название файла для МКД
		//echo 'Такой дом уже есть в БД <br /> ';
		//Здесь надо загрузить файл выбранного дома! //
		//echo $name_file_house;
		}
	
	//======================POST-запрос в файл на добавление форума======================================
	$url = 'http://nashdom.club/phpbb/add_forum.php';
	$data = http_build_query(array("fias_val" => $_POST['fias_val']));
	$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded".PHP_EOL,
        'method'  => 'POST',
        'content' => $data,
    ));
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	$bb_link = mysqli_connect();
	$bb_query = "SELECT forum_id FROM phpbb_forums WHERE forum_name = '" . $_SESSION['fias_val'] ."'";
	$bb_result = mysqli_query($bb_link, $bb_query);
	$bb_id = mysqli_fetch_row($bb_result);
	$_SESSION['forum_id'] = $bb_id[0];
	
?>

<html>
<head>
</head>
<body onload= "start()">

<script>
	function start(){
		var url_house =  '<?php echo ($name_file_house); ?> ';    
		sessionStorage['url_house'] = url_house;
		//alert ('В файле choice.php переменная url_house = '+url_house); 
		}
</script>

<?php
	$_SESSION['name_file_house'] = $name_file_house;
	include $name_file_house;	// Загрузка файла МКД
	mysqli_close();
?>
</body>
</html>
