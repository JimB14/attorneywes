<?php

// this class is a parent to many classes; it has many children
class Controller
{
    /**
     * Open the database connection with the credentials from app/init.php
     */
    public function getDb()
    {
        // set the (optional) options of the PDO connection. in this case, we set the fetch mode to
        // "objects", which means all results will be objects, like this: $result->user_name !
        // For example, fetch mode FETCH_ASSOC would return results like this: $result["user_name] !
        // @see http://www.php.net/manual/en/pdostatement.fetch.php
        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
        // generate a database connection, using the PDO connector
        // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
        return new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS, $options);
    }


    public function model($model)
    {
        if(file_exists('../app/models/' . $model . '.php'))
        {
            require_once '../app/models/' . $model . '.php';

            // return to controller a new instance of model
            // & db connection via getDb method
            return new $model($this->getDb());
        }
    }


    public function view($viewName, $data)
    {
        // Controller has access to View object b/c View object is available if
        // View is called b/c the View object is built in the constructor,which
        // means it is built when the class is called (like instance of App
        // object created @public/index.php)
        $view = new View($viewName, $data);

        // object being echoed (won't work unless magic method __toString
        // is used @View.php)
        echo $view;
    }
}
