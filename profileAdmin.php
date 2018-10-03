<?php
	session_start();
	require("navbar.php");
	require_once("utilizador.php");
	$utilizador = new utilizador();
	
	
	if($utilizador->checkSession() == FALSE)
	{
		header('location: login.php');
		exit();
	}
	
	$listOfUsers = $utilizador->getAllUsers();	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
		<style>
			.navbar {
			color:white;
			}
		</style>
	</head>
	<body>
		Welcome Admin <?php $utilizador->findUser(); ?> 
		<button class="pull-right"><a href="logout.php">LOG OUT</a></button>
		<a href="uploadPicture.php" class="pull-right">Upload Picture</a>
		<a href="changePass.php" class="pull-right">Change password</a>
		<h2>User Information</h2>
		<table class="table table-condensed table-hover table-stripped">
			<thead>
				<tr>
					<th></th>
					<th>ID</th>
					<th>Name</th>
					<th>Email</th>
					<th>Status</th>
					<th>Admin</th>
					<th>Date signup</th>
					<th class="text-right">Options</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($listOfUsers as $user) { ?>
					<tr>
						<td><img src="<?php echo ($user['photo_path'] == null ? 'uploads/unknown.jpg' : $user['photo_path']); ?>" width="35px" height="35px" class="img-responsive"/></td>
						<td><?php echo $user['id']; ?></td>
						<td><?php echo $user['name']; ?></td>
						<td><?php echo $user['email']; ?></td>
						<td class="td-status"><?php echo $user['status']; ?></td>
						<td class="td-admin"><?php echo $user['admin']; ?></td>
						<td><?php echo $user['date_signup']; ?></td>
						
						<?php if($user['admin'] == FALSE) { ?>
							<td class="text-right">
								<button class="btn btn-warning btn-sm btn-edit">Edit</button>
								<button class="btn btn-danger btn-sm btn-delete">Delete</button>
							</td>
							<?php } else { ?>
							<td class="text-right"></td>
						<?php } ?>
						
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		
		<script>
			$(document).on('click', '.btn-edit', function()
			{
				// Ao clicar, se o texto do status ou admin for 1 transforma numa checkbox checked
				// Tira a classe edit e mete a class save
				var tr 				= $(this).parent().parent();
				var td_status 		= $(tr).find('.td-status');
				var td_admin 		= $(tr).find('.td-admin');
				
				var value_status 	= $(td_status).text();
				var value_admin 	= $(td_admin).text();
				
				var html_status     = '<input type="checkbox" ' + (value_status == '1' ? 'checked' : '') + '>';
				var html_admin     	= '<input type="checkbox" ' + (value_admin == '1' ? 'checked' : '') + '>';
				
				$(td_status).html(html_status);   
				$(td_admin).html(html_admin);
				
				$(this).removeClass('btn-edit')
				.removeClass('btn-warning')
				.addClass('btn-success')
				.addClass('btn-save')
				.text('Save');
			});
			
			$(document).on('click', '.btn-save', function()
			{
				var t 				= $(this);
				var tr 				= $(t).parent().parent();
				var td_status 		= $(tr).find('.td-status');
				var td_admin 		= $(tr).find('.td-admin');
				var td_id 			= $(tr).find('td').eq(1);
				
				var value_status 	= $(td_status).find('input').is(':checked');
				var value_admin 	= $(td_admin).find('input').is(':checked');
				var value_id 		= $(td_id).text();
				
				$.post('ajax_comment.php', { 'type': 'edit', 'id': value_id, 'status': value_status, 'admin': value_admin }, function(response)
				{
					var json = JSON.parse(response);
					
					if(json.status == false)
					{
						alert(json.msg);
						return;
					}
					
					$(td_status).text(value_status == true ? '1' : '0');
					$(td_admin).text(value_admin == true ? '1' : '0');
					$(t).removeClass('btn-save')
					.removeClass('btn-success')
					.addClass('btn-warning')
					.addClass('btn-edit')
					.text('Edit');
				});
			});
			$(document).on('click', '.btn-delete', function()
			{
				var t			= $(this);
				var tr			= $(t).parent().parent();
				var td_id		= $(tr).find('td').eq(1);
				
				var value_id	= $(td_id).text();
				
				if(confirm('Tem a certeza que deseja prosseguir?') == true)
				{
					$.post('ajax_admin.php', { 'type': 'delete', 'id': value_id}, function(response)
					{
						var json = JSON.parse(response);
						
						if(json.status == false)
						{
							alert(json.msg);
							return;
						}
						$(tr).remove();
					});
				}
			});
		</script>
	</body>
</html>			