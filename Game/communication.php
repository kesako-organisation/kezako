<script type="text/javascript">
	var wsUri = "ws://localhost:9000/demo/server.php"; 	
	websocket = new WebSocket(wsUri); 
	var pseudo = "<?php echo $_SESSION['login'] ?>";
	
	$("#btnMessage").on('click', function() {
		var mess = $("#message").val();
		$("#message").val("");
		sendMessage(mess);
	});
	
	var startParty = {
		name: pseudo,
		action : 'start',
		salle : idRoom
	}
	
	var quitParty = {
		name: pseudo,
		action : 'quit',
		salle : idRoom
	}
	
	var changed = {
		name: pseudo,
		action : 'changed',
		salle : idRoom
	}
	
	$("#sortir").on('click', function(){
		websocket.send(JSON.stringify(quitParty));
	});
	
	websocket.onopen = function(ev) {  
		$.ajax({
			/*MISE A JOUR DE LA LISTE DES JOUEURS */
			type: "POST",
			data: {'idRoom': idRoom},
			url: "players_list_update.php",
			async: true,
			success: function( data ){
				$("#players_list").html(data);
			}
		}).fail(function() {
			alert( "Une erreur s'est produite" );
		})	
	}

	websocket.onmessage = function(ev) {
		var msg = JSON.parse(ev.data); //PHP sends Json data
		var type = msg.type; //message type
		var message = msg.message;
		var uname = msg.name; //user name
		var action = msg.action; //action
		var room = msg.salle;
		var next = msg.next;
		
		if (room==undefined || idRoom==room ) {
		
			if (type != 'system' && action == 'newHost' ) {
				if (next == pseudo) {
					//On rafraichit la page lorsque le nouveau hôte est définie
					location.reload();
				}
			}
			
			if (type != 'system' && action == 'quit' ) {
				$( "#players-list" ).ready(removePlayerFromList(uname));
			}
			
			if (type != 'system' && action == 'chat' ) {
				receiveMessage(uname, message);
			}
			
			if (action == 'connection' || action == 'changed' ) {
				$.ajax({
					/*MISE A JOUR DE LA LISTE DES JOUEURS */
					type: "POST",
					data:{'idRoom': idRoom},
					url: "players_list_update.php",
					async: true,
					success: function( data ){
						$("#players_list").html(data);
					}
				}).fail(function() {
					alert( "Une erreur s'est produite" );
				})	
			}
			
			<?php if (!$isHost) { ?>
			if (type != 'system' && action == 'start' ) {
				startPlay();
			}
			<?php } ?>
		
		}
	};
	
	function removePlayerFromList(pseudo) {
		$('#players-list #'+pseudo).parent().remove()
	}
	
	function newHostPlayer(pseudoNewHost) {
		var newHost = {
			name: pseudo,
			action : 'newHost',
			salle : idRoom,
			next : pseudoNewHost
		}
		websocket.send(JSON.stringify(newHost));
	}
	
	function sendMessage(mess) {
		var sendMessage = {
			name: pseudo,
			message : mess,
			action: 'chat',
			salle : idRoom
		}
		websocket.send(JSON.stringify(sendMessage));
	}
	
	function receiveMessage(author, message) {
		$("#profil-img").attr('src', '../img/joueurs/'+author+'.jpg');
		$("#messages").css('visibility','visible');
		$("#author").text(author+"");
		$("#income-message").text(message+"");
	}
	
</script>