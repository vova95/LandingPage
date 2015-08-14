<?php
class Authentication {

	private $client_id = '5028342'; // ID приложения
	private $client_secret = 'oMoX2PVkI216bQSWVEVw'; // Защищённый ключ
	private $redirect_uri = 'http://LandingPage/'; // Адрес сайта
	private $access_token;
	private $token_user_id;
    private $url = 'http://oauth.vk.com/authorize';

    public function getTokenUserId() {
    	return $this->token_user_id;
    }

    public function getAccessToken() {
    	return $this->access_token;
    }

    public function setTokenUserId($user_id) {
    	$this->token_user_id = $user_id;
    }

    public function setAccessToken($token) {
    	$this->access_token = $token;
    }

	public function url_get_contents ($Url) {
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

	public function set_authentication_button() {
		$params = array(
	        'client_id'     => $this->client_id,
	        // 'scope'         => 'notify,friends,photos,notes,wall,offline',
	        'redirect_uri'  => $this->redirect_uri,
	        'response_type' => 'code'
    	);

    	echo $link = '<a class="auth" href="' . $this->url . '?' . urldecode(http_build_query($params)) . '"><div class="auth_button"></div></a>';
    }

    public function generateToken() {
    	
    		$params = array(
		        'client_id' => $this->client_id,
		        // 'scope'         => 'notify,friends,photos,notes,wall,offline',
		        'client_secret' => $this->client_secret,
		        'code' => $_GET['code'],
		        'redirect_uri' => $this->redirect_uri
		    );
		// var_dump(url_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))));

		    $token = json_decode($this->url_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);
		    // var_dump($token);
		    $this->access_token = $token['access_token'];
		    $this->token_user_id = $token['user_id'];
		    // var_dump($token['access_token']);
    		return $this->access_token;
    }

    public function setAuthCookie() {
    	// var_dump($this->access_token);
    	setcookie('token_access', $this->access_token, time()+3600);
		setcookie('user_id', $this->token_user_id, time()+3600);
		$_COOKIE['token_access'] = $this->access_token;
		$_COOKIE['user_id'] = $this->token_user_id;
    }

    public function run() {
    	
		    $result = false;
		    
		    if (isset($this->access_token)) {
		        $params = array(
		            'uids'         => $this->token_user_id,
		            'fields'       => 'uid,first_name,last_name,photo',
		            'access_token' => $this->access_token
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
		        
		    } else {

					$this->set_authentication_button();					
				
		    }
    	
	}
	public function echoing() {
		if (isset($_POST['user_id'])){
					$asd = $_POST['user_id'];
					// var_dump($asd);
					return $asd;
		}
	}
}
?>