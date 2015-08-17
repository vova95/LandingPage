<?php
class Authentication {

	private $client_id = '5030222'; // ID приложения
	private $client_secret = 'QQMwD2ICHbKJHKBxi7zY'; // Защищённый ключ
	private $redirect_uri = 'http://localhost/LandingPage/'; // Адрес сайта
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
	    // curl_setopt($ch, CURLOPT_PROXY, '192.168.5.111:3128');
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
	        'scope'         => 'notify,friends,photos,notes,wall,offline',
	        'redirect_uri'  => $this->redirect_uri,
	        'response_type' => 'code'
    	);

    	echo $link = '<a class="auth" href="' . $this->url . '?' . urldecode(http_build_query($params)) . '"><div class="auth_button"></div></a>';
    }

    public function generateToken() {
    	
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
		    $this->access_token = $token['access_token'];
		    $this->token_user_id = $token['user_id'];
		    // var_dump($token['access_token']);
    		return $this->access_token;
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
				        </div>
			        </li>
			        <?php
		    	}
		        
		    } else {

					$this->set_authentication_button();					
				
		    }
    	
	}

	public function createPhotoAttachment()
    {
    	$params = array(
		        'uid' => $this->token_user_id,
		        'access_token' => $this->access_token
		    );
        $result = json_decode($this->url_get_contents('https://api.vk.com/method/photos.getWallUploadServer' . '?' . urldecode(http_build_query($params))), true);

        var_dump($result);


        $post_params = array (
        	'photo' => '@' .dirname(__FILE__)."/img/example1.png"
        	);
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $result["response"]["upload_url"]);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_params);
		$upload = curl_exec($ch);   
        curl_close($ch);
        
        $upload = json_decode($upload);
		var_dump($upload);
        $params2 = array(
            'server' => $upload->server,
            'photo' => $upload->photo,
            'hash' => $upload->hash,
            'uid' => $this->token_user_id,
            );

        $result = json_decode($this->url_get_contents('https://api.vk.com/method/photos.saveWallPhoto' . '?' . urldecode(http_build_query($params))), true);
        var_dump($result);
        // return $result["response"][0]["id"];
    }
}
?>