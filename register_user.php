<?php 
	require_once('/config.php');
	// обработка запроса в базу, если логин уже есть и пароль совпадает с введенным
	// то делаем логин
	// если логин есть и пароль не совпадает, выводим ошибку (имя занято/неверный пароль)
	// если логина нет, то регистрируем нового пользователя в бд и делаем логин
	if($_POST['login']) {
		$loginQueue = $pdo->prepare("
			SELECT *
			FROM users
			WHERE login = :login
		");

		$userInsertQuery = $pdo->prepare("
			INSERT INTO `users` (
				`login` ,
				`pass` 
			)
			VALUES (
				:login,  
				:pass
			);
		");
		
		$loginQueue -> execute(array(
			'login' => $_POST['login']
		));
		$loginRow = $loginQueue->fetch();	
		
		//header("refresh:1;url=index.php");
		
		$pass_hash = substr(crypt(
			$_POST['pass'], 
			$globalSalt
		), strlen($globalSalt));

		if($loginRow) {
			if($loginRow['pass'] == $pass_hash) {
				?>
				<p> С возвращением, 
					<?php 
						echo($loginRow['login'])
					?> 
				</p>
				<a href='index.php'>Если перенаправление не сработало нажмите здесь</a>
				<?php
				
				$_SESSION['login'] = $_POST['login'];

			} else {
				
				?>
				<p> Неправильный пароль/Имя пользователя занято </p>
				<a href='index.php'>Если перенаправление не сработало нажмите здесь</a>
				<?php
			}
		} else {
			$userInsertQuery->execute(array(
				'login' => $_POST['login'],
				'pass' => $pass_hash,
			));
			setcookie('name', $loginRow['name'], time()+86400);
			?>
				<p>Вы зарегистрированы</p>
				<a href='index.php'>Если перенаправление не сработало нажмите здесь</a>
			<?php
		}
	}
?>
