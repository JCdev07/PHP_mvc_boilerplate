<?php
    /*
        * Base Controller
        * Loads models & Views
    */

    class Controller {
        // Load Model
        public function model($model){
            // Require Model File
            require_once '../app/models/'.$model.'.php';

            // Instantiate the model
            return new $model();
        }

        // Load View
        public function view($view, $data = []) {
            // Check for the view file
            if(file_exists('../app/views/'.$view.'.php')) {
                // If it exist require it
                require_once '../app/views/'.$view.'.php';
            } else {
                // view does not exist
                die($view.' doesnt exist');
            }
        }
    }