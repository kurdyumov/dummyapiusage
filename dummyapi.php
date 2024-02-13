<?php
class DummyApi {
	const JSON_FILE = 'products.json';

	public function getProducts() {
		$data = file_get_contents('https://dummyjson.com/products?limit=0');
		$obj = json_decode($data);
		return array_merge($obj->products, $this->getProdJson());
	}

	public function getProduct($title) {
		if ($title == '')
			return self::getProducts();
		$data = file_get_contents('https://dummyjson.com/products/search?limit=0&q='.$title);
		$obj = json_decode($data, true);
		return $obj;
	}

	public function addProduct($attr) {
		$curl = curl_init('https://dummyjson.com/products/add');
		curl_setopt($curl, CURLOPT_POST, 1);

		$args = [];
		foreach ($attr as $k=>$a)
			$args[$k] = $a;
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($args));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json'
		]);
		$response = curl_exec($curl);
		$this->appendProdToJson($response);
		curl_close($curl);
		return $response;
	}

	private function appendProdToJson($obj) {
		$json = $this->getProdJson();
		$obj = json_decode($obj);
		$ids = array_column($json, 'id');
		if (!empty($ids)) {
			$max_id = max($ids);
			$obj->id = $max_id+1;
		}
		$json[] = $obj;
		file_put_contents(self::JSON_FILE, json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
	}

	private function getProdJson() {
		return file_exists(self::JSON_FILE)?json_decode(file_get_contents(self::JSON_FILE), true):[];
	}
}