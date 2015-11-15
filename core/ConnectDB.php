<?php
class ConnectDB {
	private static $conn;
	
	private function __construct() {}
	
	public static function open() {
		self::$conn = new PDO('pgsql:dbname=testes;user=postgres;password=123456;host=localhost');
	}
	
	public static function close() {
		self::$conn = null;
	}
	
	public static function getConn() {
		return self::$conn;
	}
}