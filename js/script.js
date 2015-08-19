

$(document).ready(function(){
	$(".example_button").bind('click');
		var sendedPosts = 0;
		function sendWallPost(selectedIds, message, currentId) {

					if (currentId == selectedIds.length) {
						setTimeout(function() {
							$('.selected_friends_number').text(sendedPosts+" сообщения");
							$('.pop_up_wrapper').fadeIn('fast');
						}, 200);
						return;
					}
					// console.log(sendedPosts);
			    		VK.api("wall.post", {
			            owner_id: selectedIds[currentId],
			            message: message.message,
			            attachments : message.attachment
			        }, function (data) {
			        	if (data.response) {
			        		sendedPosts++;
			        		currentId++;
			        		sendWallPost(selectedIds, message, currentId);
			        	} else {
			        		// console.log('');
			        	};
			        });
			    	
};
	function loadJSON(callback) {   

	    var xobj = new XMLHttpRequest();
	        xobj.overrideMimeType("application/json");
	    xobj.open('GET', 'messages/messages.json', true); // Replace 'my_data' with the path to your file
	    xobj.onreadystatechange = function () {
	          if (xobj.readyState == 4 && xobj.status == "200") {
	            // Required use of an anonymous callback as .open will NOT return a value but simply returns undefined in asynchronous mode
	            callback(xobj.responseText);
	          }
	    };
	    xobj.send(null);  
	    
 }

	function viewExample() {
		var messageIndex = $('.products').val();
		$('.example').fadeIn('fast');
		loadJSON(function(response) {
			var actual_JSON = JSON.parse(response);
			$('.example .example_img').attr({
				src: actual_JSON.messages[messageIndex].example
			});
		});
		$('.example_button').css({
			display: 'none'
		});
		$('.send_button').css({
			display: 'table'
		});
	}
		if($('.auth').parents('.friends').length !== 1) {
			$('.example_button').css('display', 'table');
			$('.all_friends').css('display', 'block');
			$('.friends').css('height', '280px');
		}

		$('.example_button').on('click', function(event) {
			viewExample();
		});


		$('.send_button').on('click', function() {

			var selected = [];
			$('input[name="user_id"]:checked').each(function() {
			    selected.push(this.value);
			});

			loadJSON(function(response) {
			var messageIndex = $('.products').val();
		    var actual_JSON = JSON.parse(response);
		    console.log(actual_JSON);
		    if($('.login').val() !== '' && selected.length !== 0) {
				sendWallPost(selected, actual_JSON.messages[messageIndex], 0);
			}
		 });
		});

		$('.products').change(function() {
			$('.example').css({
				display: 'none'
			});
			$('.send_button').css({
				display: 'none'
			});
			$('.example_button').css({
				display: 'table'
			});
		});

		$('.pop_up_wrapper .pop_up .close').on('click', function(event) {
			$('.example').css({
				display: 'none'
			});
			$('.send_button').css({
				display: 'none'
			});
			$('.example_button').css({
				display: 'table'
			});
			$('input[name="user_id"]:checked').prop({
				checked: false
			});
			$('.pop_up_wrapper').fadeOut('fast');
		});
		$('.all_friends_checked').on('click', function(event) {
			if(($(this).is(':checked'))) {
				$('input[name="user_id"]').prop({
					checked: true
				});
			} else {
				$('input[name="user_id"]').prop({
					checked: false
				});
			}
		});
});