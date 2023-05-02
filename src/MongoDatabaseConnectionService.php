<?php

abstract class MongoDatabaseConnectionService
{
	protected static $connection = null;

	/**
	 * @return MongoDB\Database
	 */
	public static function get()
	{
		if (!self::$connection) {
			try {
				self::$connection = self::createConnection();
			} catch (PDOException $e) {
				// Log db error message
				// $e->getMessage()
				throw new Exception('Database ERROR');
			}
		}

		return self::$connection;
	}

	/**
	 * @return MongoDB\Database
	 */
	protected static function createConnection()
	{
		$host = 'localhost';
		$port = 27017;
		$database = 'db_books';
		// $user = 'root';
		// $password = '';

		//mongodb://mongodb-deployment:27017'

		$dsn = "mongodb://{$host}:{$port}";

		return (new MongoDB\Client($dsn))->selectDatabase($database);
	}
}