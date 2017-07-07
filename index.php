<html>
	<head>
		<title>Comments</title>
		<meta charset="utf-8">
		<link href="/css/bootstrap.min.css" rel="stylesheet">
		<link href="/css/main.css" rel="stylesheet">
	</head>
	<body>
		<?php 

			function checkName() {
				$nameLength = strlen($_POST['name']);
				$error = '';
				if($nameLength > 32) {
					$error .= ' имя слишком длинное ';
				} if($nameLength < 5) {
					$error .= ' имя слишком короткое ';
				} else {
					return false;
				}
				return $error;
			}
			function checkEmail() {
				$emailLength = strlen($_POST['email']);
				$error = '';
				if($emailLength > 32) {
					$error .= ' почта слишком длинная ';
				} if($emailLength < 5) {
					$error .= ' почта слишком короткая ';
				} else {
					return false;
				}
				return $emailError;
			}
			function checkComment() {
				$commentLength = strlen($_POST['comment']);
				$error = '';
				if($commentLength == 0) {
					$error .= ' Введите комментарий ';
				} if( !(preg_match("/привет/", $_POST['comment'])) ) {
					$error .= ' поздоровайтесь ';
				} else {
					return false;
				}
				return $error;
			}

			$link = mysql_connect('localhost', 'root', '');
			if (!$link) {
				die('Ошибка соединения: ' . mysql_error());
			}

			$db_selected = mysql_select_db('comments', $link);
			if (!$db_selected) {
				die ('Can\'t use foo : ' . mysql_error());
			}
			if($_POST['name']) {
				$nameError = checkName();
				$emailError = checkEmail();
				$commentError = checkComment();

				if(!$nameError && !$emailError && !$commentError) {
					mysql_query("
						INSERT INTO `comments` (
							`name` ,
							`email` ,
							`comment` ,
							`date`
						)
						VALUES (
							'" . mysql_real_escape_string($_POST["name"]) . "',  
							'" . mysql_real_escape_string($_POST["email"]) . "',  
							'" . mysql_real_escape_string($_POST["comment"]) . "', 
							NOW( )
						);
					");
				} else {
					$totalError = $nameError . ' ' . $emailError . ' ' . $commentError . ' ' . $privietError;
					if($nameError) {
						$error = 'Ошибка насяльника' . ' ' . $totalError;
					} else if($emailError) {
						$error = 'Ошибка насяльника' . ' ' . $totalError;
					} else if($commentError) {
						$error = 'Ошибка насяльника' . ' ' . $totalError;
					}
				}
			}

			$result = mysql_query("
				SELECT * 
				FROM  `comments`
			");
			if (!$result) {
				die('Неверный запрос: ' . mysql_error());
			}
		?>
		<div class="container">
		<?php
			while ($row = mysql_fetch_assoc($result)) {
		?>	
			<span class="right">
				<?=$row['id'] ?>
			</span>
			
			<p class="name">
				<?=$row['name'] ?>
			</p>
			<p class="text">
				<?=$row['comment'] ?>
			</p>

		<?php
			}
			mysql_close($link);
		?>
		<?php if($error) { ?> 
			<div class="error"><?=$error ?></div>
		<?php } ?>
			<form class="form-inline" method="POST" action="/">
				<div class="form-group">
					<label for="exampleInputName2">Name</label>
					<input type="text" name="name" class="form-control" id="exampleInputName2" placeholder="Jane Doe">
				</div>
				<div class="form-group">
					<label for="exampleInputEmail2">Email</label>
					<input type="email" name="email" class="form-control" id="exampleInputEmail2" placeholder="jane.doe@example.com">
				</div>
				<button type="submit" class="btn btn-default">Send invitation</button></br>
				<textarea class="text_input" name="comment" rows="3"></textarea>
			</form>
		</div>
	</body>
</html>