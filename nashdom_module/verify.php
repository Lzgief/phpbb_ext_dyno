<?php
	session_start();
	$password = $_POST['password'];
	$login = $_POST['login'];
		
	//  ============================  Соединение с БД   =================================
	$link = mysqli_connect();
	//  if(!$link) echo ('Соединиться с БД НЕ удалось <br />');
	//  else {echo ('Соединение с БД реализовано. <br />');	}
	//  ================================================================================== 

	//  ======================= Определение наличия введенного логина в БД  ==============
	$rezult = mysqli_query($link, "SELECT id_user, login FROM user  WHERE login = '$login' ");
	//   echo 'В базе ' . mysqli_num_rows($rezult) . ' записей <br />';
	$number = mysqli_num_rows($rezult);
	if($number == 1){
		//  ======================= Определяем идентификатор пользователя  =============== 

		$par_user=mysqli_fetch_array($rezult);
		
		$id_user= $par_user[0];          // Идентификатор пользователя проходящего аутентификацию
		$_SESSION['id_user'] = $id_user;
		//echo ('Идентификатор пользователя = '.$id_user.'<br />');
		//die('end');
		
		
		//  ======================= Определение пароля хранящегося в БД   ================
		$query = "SELECT  password  FROM   user  WHERE  login = '$login'";
		$query_password = mysqli_query($link, $query);
		
		$result=mysqli_fetch_array($query_password);
		//echo $result['password'];
		$hash = $result['password'];          // Хеш пароля полученная из БД
		//  ==============================================================================

		//  ======================= Верификация пароля   =================================
		$verify = password_verify ( $password ,  $hash );
		if( $verify) {
			//echo ( 'В БД есть такая пара логина и пароля!<br />');
			$_SESSION['authentication']= 1;
			setcookie('my_cookie', $hash);    	// Запись хеш пароля в cookie
			//echo ("Куки my_cookie = ".$_COOKIE['my_cookie']."<br />");
			 //die("<br > Остановка после записи cookie!");
			 //print_r($_COOKIE);
			echo ("
				<script>
					address = sessionStorage['url_house'] ;
					//alert (address);
					adres='http://nashdom.club/'+address;
					window.open(adres, '_self');         // Переход на страницу дома 
				</script>
				");
			}
			else {
				//echo ( 'Ошибка ввода пароля!');
				$_SESSION['authentication']= 0;
				include '../authentication_error.php';
				} 
		//  ==============================================================================
	}
	
	else
		{
			//echo ( 'Ошибка ввода !');
			include '../authentication_error.php';
			
		} 
	
	//  ==================================== Инклюды для phpbb =====================
	define('IN_PHPBB', true);
	define('PHPBB_ROOT_PATH', './../phpbb/');
	$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
	$phpEx = substr(strrchr(__FILE__, '.'), 1);
	include($phpbb_root_path . 'common.' . $phpEx);
	include($phpbb_root_path . 'includes/functions_user.' . $phpEx);
//  ==================================== Аутентификация на форуме =====================
	$user->session_begin();
	$auth->acl($user->data);
	$user->setup('ucp');
	$login = $auth->login($login, $password);
	
?>
