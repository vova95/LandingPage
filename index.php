<!DOCTYPE html>
<html>
<head>
	<title>Landing Page</title>
	<meta charset="utf-8">
	<script type="text/javascript" src="http://userapi.com/js/api/openapi.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>

	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=PT+Sans" />
</head>
<body>
<?php
require_once "auth.php";
$authentication = new Authentication();

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
					<a href="" class="no_login">Нет логина?</a>
					<input type = "text" class="login"></input>
				</label>
				<label>
					Про какой продукт хотите рассказать:
					<select type = "text" class="products">
						<option>Magento</option>
						<option>PrestaShop</option>
						<option>Opencart</option>
					</select>
				</label>
				<?php
					$authentication->set_authentication_button();					
				?>
				<form method="POST">
				<input type="checkbox" value="1" name="user_id">
				<div class="friends_wrapper">
					<ul class="friends">
						<?php $authentication->run(); ?>
					</ul>
				</div>
				<button type="submit" class="send_button"><span>Посмотреть пример</span></button>
				
				</form>
				<?php 
				$authentication->echoing(); ?>
			</div>
			<div onclick="sendwallpost('Hello!');">отправить</div>
			<script language="javascript">
				
			    VK.init({
			        apiId: 5031578 // id созданного вами приложения вконтакте 
			    });
			    

			    function sendwallpost(mydata) {
			    	var selected = [];
			    	$('input[name="user_id"]:checked').each(function() {
			    		selected.push(this.value);
				});
			    	// console.log(selected);
			    	$.each(selected, function(index, value) {
			    		console.log(value);
			    		VK.api("wall.post", {
			            owner_id: value,
			            message: mydata
			        }, function (data) {});
			    	});
			    }
			</script>
		</div>
	</div>
</body>
</html>