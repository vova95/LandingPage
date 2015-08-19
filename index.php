<?php

	require_once "auth.php";
	$vkApi = new vkApi();

	if(isset($_COOKIE['session_id'])) {
		
		session_id($_COOKIE['session_id']);

		session_start();

		$vkApi->setTokenUserId($_SESSION['user_id']);
		$vkApi->setAccessToken($_SESSION['token_access']);
		// var_dump($_SESSION['token_access']);
	}
	elseif(isset($_GET['code'])) {

		$url = 'Location: http://LandingPage/';

		$vkApi->generateToken();

		session_start();

		setcookie('session_id', session_id(), time()+3600);
		// setcookie('adress', $url, time()+3600);

		$_COOKIE['session_id'] = session_id();
		// $_COOKIE['adress'] = $url;

		// setcookie('user_id', $authentication->getTokenUserId(), time()+3600);
		$_SESSION['token_access'] = $vkApi->getAccessToken();
		$_SESSION['user_id'] = $vkApi->getTokenUserId();
		// var_dump($_COOKIE);
		header($url);
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Landing Page</title>
	<meta charset="utf-8">
	<script type="text/javascript" src="//vk.com/js/api/openapi.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=PT+Sans" />
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/media.css">
	
</head>
<body>

<script language="javascript">
				
			    VK.init({
			        apiId: 5028342 
			    });
</script>
<?php
	// $authentication->createPhotoAttachment();

?>

	<div class="wrapper">
		<div class="header">
			<img class="logo" src="img/logo.png"></img>
			<p class="title">Денежная стена Вконтакте</p>
			<p class="description">Рекомендуйте шаблоны друзьям и зарабатывайте 1.000.000</p>
			<img class="mouse" src="img/mouse.png"></img>
		</div>
		<div class="content">
			<div class="advertisement">
				<h3 align="center" class="heading">Привет!</h3>
				<p>Зарабатывать с <span style="color: #2573b5; font-weight: bold;">Template</span><span style="color: #de101a; font-weight: bold;">Monster</span> – мировым производителем шаблонов сайтов не только весело и увлекательно, но еще и очень просто.</p>

				<p class="indent">Представляем вашему вниманию инструмент, который позволит мгновенно разослать сообщения с вашей аффилиатской ссылкой по всем вашим друзьям вконтакте.</p>

				<p class="indent">Вам останется только проверять статистику и смотреть на то, как растет доход.</p> 
			</div>
			<div class="main_content">
				<h3 class="heading">Поехали!</h3>
				<label>
					Ваш логин в партнерской программе TemplateMonster:
					<a href="http://www.templatemonster.com/ru/sign-up/" target="_blank" class="no_login">Нет логина?</a>
					<input type = "text" class="login"></input>
				</label>
				<label>
					Про какой продукт хотите рассказать:
					<select type = "text" class="products">

						<option value="0">Wordpress шаблоны</option>
						<option value="1">Monstroid</option>
						<option value="2">Joomla шаблоны</option>
						<option value="3">MotoCMS шаблоны</option>
						<option value="4">PrestaShop шаблоны</option>
						<option value="5">OpenCart шаблоны</option>
						<option value="6">Magento шаблоны</option>
						<option value="7">Woocommerce шаблоны</option>
						<option value="8">Drupal шаблоны</option>
						<option value="9">HTML шаблоны</option>
					</select>
				</label>
				
				
				<div class="friends_wrapper">
				<div class="all_friends">
				<input type="checkbox" class="all_friends_checked" >
				<span>Отправить всем друзьям</span>
				</div>
					<ul class="friends">
						<?php $vkApi->getFriends(); ?>
					</ul>
				</div>
			</div>
			<div class="example">
			<img class="example_img" src=""></img>
				</div>
			<div class="example_button button">
				<span>Посмотреть пример</span>
			</div>
			<div class="send_button button">
				<span>Разместить на стене у друзей</span>
			</div>
			<!-- <div onclick="sendwallpost('Hello!');">отправить</div> -->
			
		</div>
		<div class="pop_up_wrapper">
			<div class="pop_up">
				<div class="close">
				</div>
				<div class="pop_up_text">
					<h3 align="center" class="pop_up_title">Подведем итоги</h3>
					<p>Удалось опубликовать <span class="selected_friends_number"></span> на стенах ваших друзей.</p>
					<p class="discount">Каждая покупка принесет вам <span class="discount_number">30%</span> от чека.</p>
					<p>Рекомендуем не сидеть сложа руки и отправить письмо по списку ваших контактов в почте.</p>
					<div class="send_mail button"><span>Отправить письмо</span></div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>