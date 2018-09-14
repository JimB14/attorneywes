<?php
/**
 *  parses the url
 *
 */
class App
{
    // protected: visible in all classes that extend this class including parent class
    protected $controller = 'home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        if(file_exists('../app/controllers/' . $url[0] . '.php')) // relative to app/core/
        {
            $this->controller = $url[0];
            unset($url[0]); // does not reindex array
        }
        
        // $url[0] value or default value (viz. 'home')
        require_once '../app/controllers/' . $this->controller . '.php';

        // create new instance of class (); $url[0] value or default value (viz. 'home')
        $this->controller = new $this->controller;


        // check if method set
        if(isset($url[1]))
        {
            // check if method exists in this class
            if(method_exists($this->controller, $url[1]))
            {
                // assign value
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // array_values — Return all the values of an array (also re-indexes array)
        $this->params = $url ? array_values($url): [];

        // calls method on object and passes an array of values to the method
        // 1st param = array (object, method); 2nd param = array of values
        // being passed to the method (allows passing values to method in controller)
        call_user_func_array([$this->controller, $this->method], $this->params);

    }


    protected function parseUrl()
    {
        if(isset($_GET['url']))
        {
            // trim (off) final slash, filter, then explode on slash into array
            return explode('/', (filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_STRING)));
        }
    }


}
