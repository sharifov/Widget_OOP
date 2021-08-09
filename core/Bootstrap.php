<?php

class Bootstrap {

	private static $routes = [];

	private static $action = 'index';
	
	private static $plugin;

	private static $defaults = ['NotFound', 'plugin' => 'SenderService']; 
	
	private static function setRoutes() {
		self::$routes = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
	}

	public static function start(){

		self::setRoutes();

		if( !empty(self::$routes[0]) )
			$pluginName = str_replace(' ', '', ucwords( str_replace('_', ' ', self::$routes[0]) ) );
		else 
			$pluginName = self::$defaults['plugin'];

		$pluginPath = (in_array($pluginName, self::$defaults) ? CORE : PLUGINS) . $pluginName . '.php';

		if(!file_exists($pluginPath))
			self::error();

		require_once($pluginPath);

		ob_start();

		self::$plugin = new $pluginName(self::view());
	}

	public static function view() {

		return function($page = 'error', $data = [], $layout = true) {
		
			if($data) extract($data);

			$page = VIEW.$page.'.php';

			if( file_exists($page) )
				include_once($page);

			$content = ob_get_contents();

			ob_end_clean();

			if($layout) {

				$layout = VIEW.'layout.php';
				
				if(file_exists($layout))
					include_once($layout);				
			}
			else
				print $content;
			
			exit;
		};

	}

	public static function asset($url = ''){
		return PROJECT_URL.'static/'.$url;
	}

	public static function error() {
        header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		header("Location: ".PROJECT_URL."not_found");
		exit;
    }
}