<?php 
/* 
 *Core app class
 *Create URL & loads core controller
 *URL FORMAT - /controller/method/params
*/
class Core {
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->getUrl();
        
        // Look in 'controllers' for first value ucwords will capitalize first letter
        if($url == NULL)
               {
			$url = [$this->currentController];
		}

        if(file_exists('../app/controllers/' . ucwords($url[0]). '.php')){
            // If exists, set as controller
            $this->currentController = ucwords($url[0]);
            // Unset 0 Index
            unset($url[0]);
        }

        // Require the controller
        require_once '../app/controllers/' . $this->currentController. '.php';
        $this->currentController = new $this->currentController;

        // check for second part of the URL
        if (isset($url[1])) {
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }

        // GET parameters
        $this->params = $url ? array_values($url) : [];

        // call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl() {
        if(isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            // Allows you to filter variable as string/number
            $url = filter_var($url, FILTER_SANITIZE_URL);
            // Breaking it into an array
            $url = explode('/', $url);
            return $url;
        }
    }
}
