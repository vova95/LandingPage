<?php
class Authentication {

	private $client_id = '5030222'; // ID приложения
	private $client_secret = 'QQMwD2ICHbKJHKBxi7zY'; // Защищённый ключ
	private $redirect_uri = 'http://localhost/LandingPage/'; // Адрес сайта
	// private $access_token;

    private $url = 'http://oauth.vk.com/authorize';

	function url_get_contents ($Url) {
	    if (!function_exists('curl_init')){ 
	        die('CURL is not installed!');
	    }
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $Url);
	    // curl_setopt($ch, CURLOPT_PROXY, '192.168.5.111:3128');
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $output = curl_exec($ch);
	    curl_close($ch);
	    return $output;
	}

	function set_authentication_button() {
		$params = array(
	        'client_id'     => $this->client_id,
	        'scope'         => 'notify,friends,photos,notes,wall,offline',
	        'redirect_uri'  => $this->redirect_uri,
	        'response_type' => 'code'
    	);

    	echo $link = '<a class="auth_button" href="' . $this->url . '?' . urldecode(http_build_query($params)) . '">Аутентификация через ВКонтакте</a>';
    }

    function run() {
    	if (isset($_GET['code'])) {
		    $result = false;
		    $params = array(
		        'client_id' => $this->client_id,
		        'scope'         => 'notify,friends,photos,notes,wall,offline',
		        'client_secret' => $this->client_secret,
		        'code' => $_GET['code'],
		        'redirect_uri' => $this->redirect_uri
		    );
		// var_dump(url_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))));

		    $token = json_decode($this->url_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);
		    // var_dump($token);
		    // $this->access_token = $token['access_token'];
		    $id = '5888733';
		    $text = "Hello!";
					// var_dump($this->access_token);
					// $sRequest = "https://api.vkontakte.ru/method/wall.post?owner_id=$id&message=$text&access_token=$this->access_token";
					// $oResponce = json_decode($this->url_get_contents($sRequest));
		    		// var_dump($this->PostToVK());
					// var_dump($oResponce);
		    if (isset($token['access_token'])) {
		        $params = array(
		            'uids'         => $token['user_id'],
		            'fields'       => 'uid,first_name,last_name,photo',
		            'access_token' => $token['access_token']
		        );
		        $userInfo = json_decode($this->url_get_contents('https://api.vk.com/method/friends.get' . '?' . urldecode(http_build_query($params))), true);
		        if (isset($userInfo['response'][0]['uid'])) {
		            //$userInfo = $userInfo['response'][0];
		            $result = true;
		        }
		    }


		    if ($result) {
		    	foreach ($userInfo['response'] as $key => $value) {
		    		?>
		    		<li class="friend">
		    			<div class="friend_wrapper">
			    			<div class="selected_user"><input name="user_id" id="user_id" type="checkbox" value="<?php echo $value['uid']; ?>"></div>
			    			<img class="photo" src="<?php echo $value['photo']; ?>"></img>
			    			<div class="name"><?php echo $value['first_name'];?> <br> <?php echo $value['last_name']; ?></div>
					    	<!-- echo "Социальный ID пользователя: " . $value['uid'] . '<br />';
					        echo "Имя пользователя: " . $value['first_name'] . '<br />';
					        //echo "Ссылка на профиль пользователя: " . $userInfo['screen_name'] . '<br />';
					        //echo "Пол пользователя: " . $userInfo['sex'] . '<br />';
					        //echo "День Рождения: " . $userInfo['bdate'] . '<br />';
					        echo '<img src="' . $value['photo_big'] . '" />'; echo "<br />"; -->
				        </div>
			        </li>
			        <?php
		    	}
		        
		    }
    	}
	}
	function echoing() {
		if (isset($_POST['user_id'])){
					$asd = $_POST['user_id'];
					// var_dump($asd);
					return $asd;
		}
	}
}
?>