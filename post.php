<?php 
	require_once('/config.php');
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
			header("refresh:2;url=index.php");
			?>
				<p>Сообщение отправлено</p>
				<a href='index.php'>Если перенаправление не сработало нажмите здесь</a>
			<?php
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
