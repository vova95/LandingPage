

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
			            message: message,
			            attachments : 'photo114682098_312885815'
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
	function viewExample() {
		$('.example').fadeIn('fast');
		if ($('.products').val() == 'Magento') {
			$('.example .example_img').attr({
				src: 'img/example1.png'
			});
		} else if($('.products').val() == 'PrestaShop') {
			$('.example .example_img').attr({
				src: 'img/example2.png'
			});
		} else if($('.products').val() == 'PrestaShop') {
			$('.example .example_img').attr({
				src: 'img/example3.png'
			});
		}
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
			if($('.login').val() !== '' && selected.length !== 0) {
				sendWallPost(selected, "hello", 0);
			}
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