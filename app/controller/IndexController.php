<?php
class IndexController {
	
	public function index() {
		require_once('app/view/head.php');
		require_once('app/view/index.php');
		require_once('app/view/footer.php');
	}
}