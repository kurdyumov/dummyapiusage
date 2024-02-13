<?php
	require_once 'dummyapi.php';
	$api = new DummyApi();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	<form action="" method="post">
		<legend>Найти продукт</legend>
		<div>
			<label for="">Продукт</label>
			<input type="text" name="productGet[product]">
		</div>
		<button type="submit">Поиск</button>
	</form>
	<form action="" method="post">
		<legend>Регистрация продукта</legend>
		<div>
			<label for="">Продукт</label>
			<input type="text" name="productAdd[title]" required>
		</div>
		<div>
			<label for="">Описание</label>
			<input type="text" name="productAdd[description]" required>
		</div>
		<div>
			<label for="">Цена</label>
			<input type="number" min="0" name="productAdd[price]" required>
		</div>
		<div>
			<label for="">Скидка (%)</label>
			<input type="number" min="0" max="100" step="0.01" name="productAdd[discountPercentage]">
		</div>
		<div>
			<label for="">Бренд</label>
			<input type="text" name="productAdd[brand]" required>
		</div>
		<div>
			<label for="">В наличии</label>
			<input type="number" min="0" name="productAdd[stock]" required>
		</div>
		<div>
			<label for="">Рейтинг</label>
			<input type="number" min="0" max="5" name="productAdd[rating]" step="0.01" required>
		</div>
		<div>
			<label for="">Категория</label>
			<input type="text" name="productAdd[category]" required>
		</div>
		<button type="submit">Запись</button>
	</form>
	<?php
		if (isset($_REQUEST['productGet'])) {
			$data = $api->getProduct($_REQUEST['productGet']['product']);
			echo '<pre>'.json_encode($data, JSON_PRETTY_PRINT).'</pre>';
		}
		if (isset($_REQUEST['productAdd'])) {
			$api->addProduct($_REQUEST['productAdd']);
		}
	?>
</body>
</html>