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

				$host = 'localhost';
				$db   = 'comments';
				$user = 'root';
				$pass = '';
				$charset = 'utf8';
				$dsn = 'mysql:host=' . $host . ';dbname=' . $db . ';charset=' . $charset;
				$pdo = new PDO($dsn, $user, $pass);

			if($_POST['name']) {
				$nameError = checkName();
				$emailError = checkEmail();
				$commentError = checkComment();

				if(!$nameError && !$emailError && !$commentError) {
					$queryTemplate = $pdo->prepare("
						INSERT INTO `comments` (
							`name` ,
							`email` ,
							`comment` ,
							`date`
						)
						VALUES (
							:name,  
							:email,  
							:comment, 
							NOW()
						);
					");
					$queryTemplate->execute(array(
						'name' => $_POST['name'],
						'email' => $_POST['email'],
						'comment' => $_POST['comment']
					));
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
		?>
		<div class="container">
		<?php
			$stmt = $pdo->query("
				SELECT *
				FROM comments
				");
			while ($row = $stmt->fetch())
			{
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