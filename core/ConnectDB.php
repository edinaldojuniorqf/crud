<?php
class ConnectDB {
	private static $conn;
	
	private function __construct() {}
	
	public static function open() {
		self::$conn = new PDO('pgsql:dbname=testes;user=postgres;password=123456;host=localhost');
		self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	
	public static function close() {
		self::$conn = null;
	}
	
	public static function getConn() {
		return self::$conn;
	}
	
	public static function beginTransaction() {
		self::$conn->beginTransaction();
	}
	
	public static function commit() {
		self::$conn->commit();
	}
	
	public static function rollBack() {
		self::$conn->rollBack();
	}
}