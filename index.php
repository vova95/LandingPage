<!DOCTYPE html>
<html>
<head>
	<title>Landing Page</title>
	<meta charset="utf-8">
	<script type="text/javascript" src="http://userapi.com/js/api/openapi.js?34"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=PT+Sans" />
</head>
<body>
<?php
function url_get_contents ($Url) {
    if (!function_exists('curl_init')){ 
        die('CURL is not installed!');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_PROXY, '192.168.5.111:3128');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}
    $client_id = '5028342'; // ID приложения
	$client_secret = 'oMoX2PVkI216bQSWVEVw'; // Защищённый ключ
	$redirect_uri = 'http://LandingPage/'; // Адрес сайта

    $url = 'http://oauth.vk.com/authorize';

    $params = array(
        'client_id'     => $client_id,
        'redirect_uri'  => $redirect_uri,
        'response_type' => 'code'
    );

    echo $link = '<p><a href="' . $url . '?' . urldecode(http_build_query($params)) . '">Аутентификация через ВКонтакте</a></p>';

if (isset($_GET['code'])) {
    $result = false;
    $params = array(
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'code' => $_GET['code'],
        'redirect_uri' => $redirect_uri
    );
// var_dump(url_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))));

    $token = json_decode(url_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);
    var_dump($token);
    if (isset($token['access_token'])) {
        $params = array(
            'uids'         => $token['user_id'],
            'fields'       => 'uid,first_name,last_name,screen_name,sex,bdate,photo_big',
            'access_token' => $token['access_token']
        );
        $userInfo = json_decode(url_get_contents('https://api.vk.com/method/friends.get' . '?' . urldecode(http_build_query($params))), true);
        if (isset($userInfo['response'][0]['uid'])) {
            $userInfo = $userInfo['response'][0];
            $result = true;
        }
    }

    if ($result) {
        echo "Социальный ID пользователя: " . $userInfo['uid'] . '<br />';
        echo "Имя пользователя: " . $userInfo['first_name'] . '<br />';
        echo "Ссылка на профиль пользователя: " . $userInfo['screen_name'] . '<br />';
        echo "Пол пользователя: " . $userInfo['sex'] . '<br />';
        echo "День Рождения: " . $userInfo['bdate'] . '<br />';
        echo '<img src="' . $userInfo['photo_big'] . '" />'; echo "<br />";
    }
}
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
			</div>
		</div>
	</div>
</body>
</html>