<?php
class Connexion{
	public function connect(){
		
        $dsn = 'mysql:host='.hostname.';dbname='.database.';charset=utf8';
        $ma_connexion_mysql = new PDO($dsn, username, password);
        $ma_connexion_mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $ma_connexion_mysql->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
				return $ma_connexion_mysql;
		
		/*
				$dbopts = parse_url(getenv('DATABASE_URL'));
				$app->register(new Csanquer\Silex\PdoServiceProvider\Provider\PDOServiceProvider('pdo'),
											 array(
												'pdo.server' => array(
													 'driver'   => 'pgsql',
													 'user' => $dbopts["user"],
													 'password' => $dbopts["pass"],
													 'host' => $dbopts["host"],
													 'port' => $dbopts["port"],
													 'dbname' => ltrim($dbopts["path"],'/')
													 )
											 )
				);
				return $app;
			*/
    }
}
