<?php
    /*
        # App Core Class
        # Creates URL & Loads core controller
        # URL FORMAT - /controller/method/parameters
    */

    class Core {
        protected $currentController = 'Pages';
        protected $currentMethod = 'index';
        protected $params = [];

        public function __construct(){
            // print_r($this->getUrl());

            $url = $this->getUrl();

            /*
               * 1. Look if given URL is not empty and look in controllers for the file

               * 2. Require the currentController

               * 3. Instantiate controller class

               * 4. Check for second part of url

               * 5. Get parameters

               * 6. Call a callback with array of parameters

            */

            // * 1 *
            if(isset($url[0]) && file_exists('../app/controllers/'.ucwords($url[0]).'.php')){
                 
                // if exist set as current controller
                $this->currentController = ucwords($url[0]);

                // Unset 0 Index
                unset($url[0]);
                
            }

            // * 2 *
            require_once '../app/controllers/'.$this->currentController.'.php';

            // * 3 *
            $this->currentController = new $this->currentController;

            // * 4 *
            if(isset($url[1])) {

                // check if controller has a this method
                if(method_exists($this->currentController, $url[1])) {
                    $this->currentMethod = $url[1];

                    // Unset 1 Index
                    unset($url[1]);
                }
            }

            // * 5 *
            $this->params = $url ? array_values($url) : [];

            // * 6 *
            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        }

        public function getUrl() {
            // Mapping the url and return as an array
            if(isset($_GET['url'])) {
                $url = rtrim($_GET['url'], '/');
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/', $url);
                return $url;
            } else {
                return [];
            }
        }
    }


?>