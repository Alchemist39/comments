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
			require_once('/config.php');
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
			<form class="form-inline" method="POST" action="/post.php">
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