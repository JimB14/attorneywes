<?php

class Home extends Controller
{
    // if provided, 1st argument = $url[2]; otherwise = null
    public function index()
    {

      // call view method of Controller class/object & pass location of view
      // view method arguments: $view, $data, so array data (key = 'user') is
      // being passed in $data variable (see in view method @Controller.php)
      $this->view('home/index', []);
   }

}
