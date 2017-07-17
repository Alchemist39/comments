<?php
	require_once('/config.php');
?>
<html>
	<head>
		<title>Comments</title>
		<meta charset="utf-8">
		<link href="/css/bootstrap.min.css" rel="stylesheet">
		<link href="/css/main.css" rel="stylesheet">
	</head>
	<body>
		<div class="container">
		<?php
			$stmt = $pdo->prepare("
				SELECT *
				FROM comments
				LIMIT 10
				OFFSET :offset
			");
			$query = $pdo->prepare("SELECT COUNT(*) as total FROM `comments`");
			$query->execute();
			$count = $query->fetch();
			$pageCount = ceil($count['total'] / 10);

			if($pageCount >= (int) $_GET['page'] && (int) $_GET['page'] > 0) {
				$page = (int) $_GET['page'];
			} else {
				$page = 1;
			}
			
			$stmt->bindValue('offset', ($page - 1) * 10, PDO::PARAM_INT);
			$stmt->execute();
			foreach($stmt as $row) {
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
			} if($error) { ?> 
				<div class="error"><?=$error ?></div>
		<?php 
			} 
			if(!isset($_SESSION['login'])) { 
		?>
			<h2>Регистрация</h2>
			<form action="register_user.php" method="post">
			<p>
			<label>Ваш логин:<br></label>
			<input name="login" type="text" size="32" maxlength="32">
			</p>
			<p>
			<label>Ваш пароль:<br></label>
			<input name="pass" type="password" size="32" maxlength="32">
			</p>
			<p>
			<input type="submit" name="submit" value="Зарегистрироваться/войти">
			</p>

		<?php } ?>
			</form>
			<form class="form-inline" method="POST" action="/post.php">
				<div class="form-group">
					<label for="exampleInputName2">Name</label>
					<input type="text" name="name" class="form-control" id="exampleInputName2" placeholder="Jane Doe" value="<?= $_SESSION['login'] ?>">
				</div>
				<div class="form-group">
					<label for="exampleInputEmail2">Email</label>
					<input type="email" name="email" class="form-control" id="exampleInputEmail2" placeholder="jane.doe@example.com" value="<?= $_SESSION['email'] ?>">
				</div>
				<button type="submit" class="btn btn-default">Send invitation</button></br>
				<p><a href="exit.php">выход</a></p>
				<textarea class="text_input" name="comment" rows="3"></textarea>
			</form>
			<?php
				for($i = 1; $i <= $pageCount; $i++) { 
					if($page == $i) {
						echo($i);
					} else {
					?>

					<a href="index.php?page=<?= $i ?>"><?= $i ?></a>
				<?php
					}
				}
			?>
		</div>
	</body>
</html>