<?php
	session_start();
	echo 'в house session_id = '.session_id().'<br />';	
	$no_plan = $_SESSION['no_plan'];
	//echo ('$_SESSION["no_plan"] = '.$_SESSION["no_plan"].'  <br />');
	header("Content-Type: text/html; charset=utf-8");

	//echo ($_SESSION['fias_val'].' n <br />');
?>
<html>
<head>
	<title> Страница дома </title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" href="modal.css">
	<link rel="stylesheet" href="../menu.css">
	<link rel="stylesheet" href="../house.css">
	<link rel="stylesheet" href="../css/style.css">  
	<link rel="stylesheet" href="../css/bootstrap.min.css" >
	<link rel="stylesheet" href="../css/bootstrap-theme.min.css" >
	<link rel="stylesheet" href="../fancybox/jquery.fancybox.css" media="all">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/suggestions-jquery@17.10.0/dist/css/suggestions.min.css"  />
<!-- ----------------------------------------------------------------------------------  -->
	<style>
		#d1,#d1_1,#d1_2, #d2, #d3,#d3_1,#d3_2, #d4,#d4_1,#d4_2, #d5,#d5_1,#d5_2, #d6,#d6_1,#d6_2, #d7,#d7_1,#d7_2, #d9,#d9_1,#d9_2
			{ display : none;}
		#d8 { display : block;}
	</style>
<!-- ----------------------------------------------------------------------------------  -->
	<style>
		#map1 {
			width: 600px;
			height: 350px;
			margin-left: -70px;
			margin-top: 20px;
		}
		#direction header{
		/*	font-size: 17px;*/
		}
		.headline{
			font-size: 20px;	
		}
		.menu_main_block{
			font-size: 15px;
			/*color: #f00;*/
		}
		#menu li a{
			font-size: 17px;
		}
	</style>
<!-- ----------------------------------------------------------------------------------  -->

	<script src="interpreterJQ/jquery-3.2.1.js"></script>
	<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=272a6e33-f500-40b4-8efb-c093c8ce6ca6"></script>
	<script src="direct_geocode.js"></script>
	<script>
		address= "<?php echo $_SESSION['fias_val'];?>";
		//alert ('адрес ='+ address );
		sessionStorage['detailPage'] =  address ;
	</script>

<!--  --------------------------------------------------------------------------------------- -->
 	<script>
/*  ============   Вставка  =========================================*/
		// -------- 1 Объявления и новости  -------	
		function off_menu(){
		$( "#menu1_vertical" ).css("color","#1f729a").css("font-size", "17px");
	    	$( "#menu2_vertical" ).css("color","#1f729a");
	    	$( "#menu3_vertical" ).css("color","#1f729a");
	    	$( "#menu4_vertical" ).css("color","#1f729a");
	    	$( "#menu5_vertical" ).css("color","#1f729a");
	    	$( "#menu6_vertical" ).css("color","#1f729a");
	    	$( "#menu7_vertical" ).css("color","#1f729a");
	    	$( "#menu8_vertical" ).css("color","#1f729a");
	    	$( "#menu9_vertical" ).css("color","#1f729a");
	    	$( "#menu10_vertical" ).css("color","#1f729a");
		}
 		function call_1(){
			$('#d1')  .css({'display':'block'});
			$('#d1_1,#d1_2,#d2,#d2_1,#d2_2, #d3,#d3_1,#d3_2, #d4,#d4_1,#d4_2 ,#d5,#d5_1,#d5_2,#d6,#d6_1,#d6_2,#d7,#d7_1,#d7_2 ,#d8,#d8_1,#d8_2')  .css({'display':'none'});
			off_menu();
			$('#menu1_vertical').css('color','#f00');
			}
  		function call_1_1(){
			$('#d1')  .css({'display':'none' });
			$('#d1_1').css({'display':'block'});
			}
 		function call_1_2(){
			$('#d1')  .css({'display':'none' });
			$('#d1_2').css({'display':'block'});
			}
		// -------------- 2 ФОРУМ  -------------	
 		function call_2(){
			$('#d2')  .css({'display':'block'});
			$('#d1,#d1_1,#d1_2,#d2_1,#d2_2, #d3,#d3_1,#d3_2, #d4,#d4_1,#d4_2 ,#d5,#d5_1,#d5_2,#d6,#d6_1,#d6_2,#d7,#d7_1,#d7_2 ,#d8,#d8_1,#d8_2')  .css({'display':'none'});
			off_menu();
			$('#menu2_vertical').css('color','#f00');
			}			
  		function call_2_1(){
			$('#d2')  .css({'display':'none' });
			$('#d2_1').css({'display':'block'});
			}
 		function call_2_2(){
			$('#d2')  .css({'display':'none' });
			$('#d2_2').css({'display':'block'});
			}
		// ------- 3 Кто и как обслуживает наш дом ------	
 		function call_3(){
			$('#d3')  .css({'display':'block'});
			$('#d1,#d1_1,#d1_2, #d2,#d2_1,#d2_2, #d3_1,#d3_2, #d4,#d4_1,#d4_2 ,#d5,#d5_1,#d5_2,#d6,#d6_1,#d6_2,#d7,#d7_1,#d7_2 ,#d8,#d8_1,#d8_2')  .css({'display':'none'});
			off_menu();
			$('#menu3_vertical').css('color','#f00');			
			}			
  		function call_3_1(){
			$('#d3')  .css({'display':'none' });
			$('#d3_1').css({'display':'block'});
			}
 		function call_3_2(){
			$('#d3')  .css({'display':'none' });
			$('#d3_2').css({'display':'block'});
			}
		// ------- 4 План работы на год  ------	
 		function call_4(){
			$('#d4')  .css({'display':'block'});
			$('#d1,#d1_1,#d1_2, #d2,#d2_1,#d2_2, #d3,#d3_1,#d3_2, #d4_1,#d4_2 ,#d5,#d5_1,#d5_2,#d6,#d6_1,#d6_2,#d7,#d7_1,#d7_2 ,#d8,#d8_1,#d8_2')  .css({'display':'none'});
			off_menu();
			$('#menu4_vertical').css('color','#f00');			
			}			
  		function call_4_1(){
			$('#d4')  .css({'display':'none' });
			$('#d4_1').css({'display':'block'});
			}
 		function call_4_2(){
			$('#d4')  .css({'display':'none' });
			$('#d4_2').css({'display':'block'});
			}
		// ------- 5 Протоколы общих собраний ------	
 		function call_5(){
			$('#d5')  .css({'display':'block'});
			$('#d1,#d1_1,#d1_2, #d2,#d2_1,#d2_2, #d3,#d3_1,#d3_2, #d4,#d4_1,#d4_2 ,#d5_1,#d5_2,#d6,#d6_1,#d6_2,#d7,#d7_1,#d7_2 ,#d8,#d8_1,#d8_2')  .css({'display':'none'});
			off_menu();
			$('#menu5_vertical').css('color','#f00');			
			}			
  		function call_5_1(){
			$('#d5')  .css({'display':'none' });
			$('#d5_1').css({'display':'block'});
			}
 		function call_5_2(){
			$('#d5')  .css({'display':'none' });
			$('#d5_2').css({'display':'block'});
			}
		// ------- 6 Технический паспорт дома ------	
 		function call_6(){
			$('#d6')  .css({'display':'block'});
			$('#d1,#d1_1,#d1_2, #d2,#d2_1,#d2_2, #d3,#d3_1,#d3_2, #d4,#d4_1,#d4_2, #d5,#d5_1,#d5_2,#d6_1,#d6_2,#d7,#d7_1,#d7_2 ,#d8,#d8_1,#d8_2')  .css({'display':'none'});
			off_menu();
			$('#menu6_vertical').css('color','#f00');
			}			
  		function call_6_1(){
			$('#d6')  .css({'display':'none' });
			$('#d6_1').css({'display':'block'});
			}
 		function call_6_2(){
			$('#d6')  .css({'display':'none' });
			$('#d6_2').css({'display':'block'});
			}
		// -------------- 7 Кому жаловаться  --------	
 		function call_7(){
			$('#d7')  .css({'display':'block'});
			$('#d1,#d1_1,#d1_2, #d2,#d2_1,#d2_2, #d3,#d3_1,#d3_2, #d4,#d4_1,#d4_2, #d5,#d5_1,#d5_2, #d6,#d6_1,#d6_2,#d7_1,#d7_2 ,#d8,#d8_1,#d8_2')  .css({'display':'none'});
			off_menu();
			$('#menu7_vertical').css('color','#f00');			
			}			
  		function call_7_1(){
			$('#d7')  .css({'display':'none' });
			$('#d7_1').css({'display':'block'});
			}
 		function call_7_2(){
			$('#d7')  .css({'display':'none' });
			$('#d7_2').css({'display':'block'});
			}
		// -------------- 8 Дом на карте  --------	
 		function call_8(){
			$('#d8')  .css({'display':'block'});
			$('#d1,#d1_1,#d1_2, #d2,#d2_1,#d2_2, #d3,#d3_1,#d3_2, #d4,#d4_1,#d4_2, #d5,#d5_1,#d5_2, #d6,#d6_1,#d6_2, #d7,#d7_1,#d7_2 ,#d8_1,#d8_2')  .css({'display':'none'});
			off_menu();
			$('#menu8_vertical').css('color','#f00');			
			}			
  		function call_8_1(){
			$('#d8')  .css({'display':'none' });
			$('#d8_1').css({'display':'block'});
			}
 		function call_8_2(){
			$('#d8')  .css({'display':'none' });
			$('#d8_2').css({'display':'block'});
			}
/*  ============   Окончание вставки  =========================================*/
        function color_off(){
			$('.menu_vertical').css('color','#1f729a');
		}
	</script>
</head>

<body>
<!--	http://www.programmersforum.ru/showthread.php?t=141902  -->
<?php
	// Запоминаем URL этой страницы в переменной $parent
	$_SESSION['host'] = $_SERVER['HTTP_HOST'] ;
	$_SESSION['name'] = $_SERVER['SCRIPT_NAME'] ;
	$host = $_SESSION['host'] ;
	$name = $_SESSION['name'] ;
	$parent=$host.$name ;
	//echo $parent.'<br />';
	$parent = substr( $parent,  4) ;
	//echo $parent.'<br />';
	$parent ='http://'.$parent ;
	//echo $parent.'<br />';
	$_SESSION['parent']  = $parent;
	//echo "parent = ".$parent."<br />" ;
	
	
		print_r ($_SESSION);
		
?>

<div id ="glob">
<div id="shadow">
	<div id ="top">
		<div id ="title_1"> Наш дом  </div> 
		<p id="tit_11">   <?php echo $_SESSION['fias_val'];?> </p>
		<!--<form  action="../registration/index.php" method="POST" name="search">  -->
		<form  action="../authentication.php" method="POST" name="search">

			<div id="button"> <input type="submit" value="&nbspВход&nbsp" /> </div>
		</form>

	</div>



	<div id ="menu_hor">
		<a href="../index.php">				Главная				</a> &nbsp / &nbsp 
		<a href="info-page.php">			Полезная информация	</a> &nbsp /&nbsp 
		<a href="#">						ЖКХ					</a> &nbsp /&nbsp
		<a <?php echo "href=\"../phpbb/viewforum.php?f=".$_SESSION['forum_id']."\""?>>Форум</a> &nbsp /&nbsp 
		<a href="#">						О проете			</a>
	</div>
	
	<div id="div_main">
		<div id="div1">
			<div id ="menu">
				<ul>
					<li> <a href="# " onclick = "call_1()" id="menu1_vertical"> Объявления и новости			</a> </li>
					<li> <a href="../phpbb/index.php"  onclick = "call_2()" id="menu2_vertical"> Общение с соседями (форум)   	</a> </li>  
				<!--	<li> <a href="#"  onclick = "call_2()" id="menu2_vertical"> Общение с соседями (форум)   	</a> </li>  -->
					<li> <a href="#"  onclick = "call_3()" id="menu3_vertical"> Кто и как обслуживает наш дом </a> </li>
					<li> <a href="#"  onclick = "call_4()" id="menu4_vertical"> Планы работ по обслуживанию дома</a> </li>
					<li> <a href="#"  onclick = "call_5()" id="menu5_vertical"> Протоколы общих собраний		</a> </li>
					<li> <a href="#"  onclick = "call_6()" id="menu6_vertical"> Технический паспорт дома		</a> </li>
					<li> <a href="#"  onclick = "call_7()" id="menu7_vertical"> Кому жаловаться         		</a> </li>
					<li> <a href="#"  onclick = "call_8()" id="menu8_vertical"> Дом на карте        			</a> </li>
					<li> <a href="../abc/abc_contents.php"    id="menu9_vertical"> Азбука потребителей услуг ЖКХ </a> </li>
					<li> <a href="#"  onclick = "call_9()" id="menu10_vertical"> Интернет в нашем доме      	</a> </li>

				</ul>
			</div>
		</div>
		<div id= "main">
			<div id="d8">
				<div class="info_block" >
					<p class="title"> Дом на карте </p> 
					<input type="hidden" id="suggest" value="<?php echo $_SESSION['fias_val'];?>">		 
			<!--		<p id="notice">Поиск карты</p>
					<div class="map" id="map"></div>   -->
					<div  id="map1"></div>					
				</div>
				<div id="text_my_house" >
					В этом разделе сайта можно общаться с соседями вашего дома и обсуждать общие проблемы,
					а также можно прочитать информацию о доме или самому что то ввести, что может заинтересовать ваших соседей. 
				</div>
			</div>
<!-- ===================  БЛОК 1  Объявление и новости  ===============================  -->
		<div id="d1">
			<br />
			<p class = "headline"> Объявления, новости и информация</p>
			<ul>
			   <li onclick = "call_1_1()"> Новость 1           </li>	
			   <li onclick = "call_1_2()"> Срочное объявление  </li>	
			</ul>
		</div>
		<div id="d1_1">
			<p>Новость номер 1. Тарифы на услуги ЖКХ снижены на 0,5%. </p>
			<button  onclick = "call_1()"> Назад </button><br />		   
		</div>
		<div id="d1_2">
			<p >Собрание жильцов нашего дома состоится 23.08.2019 г.  </p>
			<button  onclick = "call_1()"> Назад </button><br />		   
		</div>

<!-- ====================  БЛОК 2   ФОРУМ ===========================================  -->
	
		<div id="d2">
			<br />
			<p class = "headline"> Переход на ФОРУМ дома</p>
			<!--
			<ul>
			   <li onclick = "call_2_1()">            </li>	
			   <li onclick = "call_2_2()">   </li>	
			</ul>
			-->
		</div>
		
<!-- ===================== БЛОК 3 Кто и как обслуживает наш дом   ===================  -->		
		<div id="d3">
			<br />
			<p class = "headline"> Кто и как обслуживает наш дом</p>
			<ul>
			   <li onclick = "call_3_1()"> Общая информация   </li>	
			   <li onclick = "call_3_2()"> Адреса и контакты  </li>	
			</ul>			
		</div>
			<!--  ---- Далее идут блоки с текстом  --------------------- -->

		<div id="d3_1">
			<p>По договору № ... от ... нас обслуживает Управляющая компания ....</p>
			<button  onclick = "call_3()"> Назад </button><br />		   
		</div>
		<div id="d3_2">
			<p >Ниже приведены важные адреса и телефоны организация, которые предаставляют нам услуги.</p>
			<button  onclick = "call_3()"> Назад </button><br />		   
		</div>

<!-- ===================   БЛОК 4 План работы на год  ===============================  -->
		<div id="d4">
			<br />
			<p class = "headline" id= "direction_header"> Планы работ по обслуживанию дома</p>

			<!--  =======================================================================  -->
			
			<div id="dropdown1">
				<button class="dropbtn">- План работ на текущий год</button>
				<div id="dropdown-content1">
					<a href="#">Проект плана</a>
					<a href="#">Утвержденный план</a>
				</div>
			</div>
			<div id="dropdown2">
				<button class="dropbtn">- Архив планов работ за прошлые года</button>
				<div id="dropdown-content2">
					<a href="../paperwork/archive_2019.php">2019 г.</a>
					<a href="../paperwork/archive_2018.php">2018 г.</a>
					<a href="../paperwork/archive_2017.php">2017 г.</a>
				</div>
			</div>
			<div id="dropdown3">
				<button class="dropbtn">- Ввод данных с использованием шаблона</button>
				<div id="dropdown-content3">
					<a href="../paperwork/plan_2019.php">2019 г.</a>
					<a href="../paperwork/plan_2020.php">2020 г.</a>
					<a href="../paperwork/plan_2021.php">2021 г.</a>
				</div>
			</div>

			<div id="dropdown4">
				<button class="dropbtn">- Загрузка файла с планом работ</button>
				<div id="dropdown-content4">
					<a href="#">Вариант 1</a>
					<a href="#">Вариант 2</a>
					<a href="#">Вариант 3</a>
				</div>
			</div>

			<div id="dropdown5">
				<button class="dropbtn">- Справка (о Планах работ по обслуживанию дома)</button>
				<div id="dropdown-content5">
					<a href="#">Общая информация о Плане работ</a>
					<a href="#">Обязательный перечень работ</a>
				</div>
			</div>			
			
			
			
			<!--  ====================================================================== -->
		</div>
			<!--  ---- Далее идут блоки с текстом  --------------------- -->
		<div id="d4_1">
			<p>План работы на текущий (2020 год) год. </p>
			<button  onclick = "call_4()"> Назад </button><br />		   
		</div>
		<div id="d4_2">
			<p >План работы на 2019 год.<br />
			План работы на 2018 год.  </p>
			<button  onclick = "call_4()"> Назад </button><br />		   
		</div>

<!-- ====================    БЛОК 5  Протоколы оющих собраний  =======================  -->
		<div id="d5">
			<br />
			<p class = "headline"> Протоколы общих собраний</p>
			<ul>
			   <li onclick = "call_5_1()"> Протоколы за 2019 год.           </li>	
			   <li onclick = "call_5_2()"> Архив протоколов за прошлые года. </li>	
			</ul>		
		</div>		

			<!--  ---- Далее идут блоки с текстом  --------------------- -->

		<div id="d5_1">
			<p>Протоколы за 2019 год.<br /> Расходы за квартплату увеличились на 5%.			</p>
			<button  onclick = "call_5()"> Назад </button><br />		   
		</div>
		<div id="d5_2">
			<p >Протоколы за 2018 год <br />Протоколы за 2017 год   </p>
			<button  onclick = "call_5()"> Назад </button><br />		   
		</div>

		
<!-- ====================== БЛОК 6 Технический паспорт дома  =======================  -->		
		<div id="d6">
			<br />
			<p class = "headline"> Технический паспорт дома (ТПД)</p>
			<ul>
			   <li onclick = "call_6_1()"> Что такое ТПД           </li>	
			   <li onclick = "call_6_2()"> ТПД нашего дома  </li>	
			</ul>			
		</div>
		
			<!--  ---- Далее идут блоки с текстом  --------------------- -->
		
		<div id="d6_1">
			<p>Информация о том, что такое Технический паспорт дома </p>
			<button  onclick = "call_6()"> Назад </button><br />		   
		</div>
		
		<div id="d6_2">
			<p >Введенные данные о ТПД нашего дома </p>
			<button  onclick = "call_6()"> Назад </button><br />		   
		</div>
		
<!-- ======================  БЛОК 7 Кому жаловаться  ================================  -->
		<div id="d7">
			<br />
			<p class = "headline"> Кому жаловаться</p>
			<ul>
			   <li onclick = "call_7_1()"> Важные  адреса и телефоны  </li>	
			   <li onclick = "call_7_2()"> Порядок оформления жалобы  </li>	
			</ul>			
		 	
			<!--  ---- Далее идут блоки с текстом  --------------------- -->
			
		</div>
		
		<div id="d7_2">
			<p>Примеры оформления жалоб и предложений в разные инстанции приведены ниже.</p>
			<button  onclick = "call_7()"> Назад </button><br />		   
		</div>
		
		<div id="d7_1">
			<p >Адреса и телефоны контролирующих организаций.</p>
			<button  onclick = "call_7()"> Назад </button><br />		   
		</div>

	

		
<!-- =====================   БЛОК 8 Наш дом на карте   ================================  -->


		
<!-- ======================  БЛОК 9 Азбука потребителей услуг  ЖКХ ===================  -->

<!-- ======================  ==================================== ===================  -->






		</div>  <!--  --------------  Окончание блока div id="main"  ----------------  -->
	</div>
	<div id ="foter">
		<p id="copy"> &copy  2020 г. СПбГУТ</p>
	</div>
</div>

</div>

	<div id="myModal" class="modal"> 
		<div class="modal-content">
			<div class="modal-header">
				<span class="close">&times;</span>
				<h3>План на <span> <?php echo $_SESSION['plan_year']; ?> </span> год в архиве отсутствует</h3>
			</div>
			<div class="modal-body">
				<p></p>
				<p>Если у вас есть данные о плане на этод год то вы можете их ввести используя пункт меню<br /> 
					"Ввод данных с использованием шаблона,<br />или<br />"Загрузка файл с планом работ".
				</p>
			</div>
			<div class="modal-footer">
				<h6>Для ввода данных необходимо быть зарегистрированным пользователем.</h6>
			</div>
		</div>
	</div>
	<?php
	//echo ('no_plan6 = '.$no_plan.'<br />');
	include 'modal.php';  // Файл в текущем каталоге!
	?>






</body>
</html>