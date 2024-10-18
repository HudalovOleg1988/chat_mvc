<?php

	class Db {

		static $pdo;

		static function db() {

			try {
				self::$pdo = new PDO('mysql:host=localhost;dbname=chat','root','root');
				self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				self::$pdo->exec('SET NAMES "utf8"');
			}
			catch (PDOException $e) {
				echo "невозможно подключиться к базе данных".$e->getMessage();
				exit();
			}

		}

		static function query($sql,$values=null,$select=null) {
			// self::Db();
			try {
				$s = self::$pdo->prepare($sql);

				if ($values) {
					foreach ($values as $key => $value) {
						$s->bindValue("$key",$value);
					}
				}
				$s->execute();
			} catch (PDOException $e) {
		  		// header("Location: /error/");

				echo $e->getMessage();
			  	exit;
			}

			if ($select) {
				if ($select == "fetch") {
					return $s->fetch();
				}
				else {
					return $s->fetchAll();
				}
			}

		}

	}

?>