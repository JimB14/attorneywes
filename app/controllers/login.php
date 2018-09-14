<?php

class Login extends Controller
{
    public function index()
    {
      $this->view('login/index', []);
    }

    public function postLogin()
    {
        //echo "Connected!"; exit();

        // quick validation then send to User model
        $email = ( isset($_REQUEST['email'])  ) ?  filter_var($_REQUEST['email'], FILTER_SANITIZE_EMAIL) : '';
        $password = ( isset($_REQUEST['password'])  ) ?  filter_var($_REQUEST['password'], FILTER_SANITIZE_EMAIL) : '';

        // call model method of Controller class & pass model name (User) &
        // receive back new instance of User class & db connection
        $isUserInDatabase = $this->model('User');

        // call validateLoginCredentials method of User class instance ($isUserInDatabase)
        // and send clean, validated user input data
        $isUserInDatabase->validateLoginCredentials($email, $password);
    }


    public function loginGranted($first_name, $last_name, $user_id, $access_level)
    {
        // store full name, user_id & access_level in SESSION variables
        $_SESSION['full_name'] = $first_name  . ' ' . $last_name;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['access_level'] = $access_level;

        //echo $_SESSION['access_level']; exit();

        // ASSET_ROOT defined @app/init.php ~ #24
        $asset_root = ASSET_ROOT;

        header("Location: $asset_root/home/");
        exit();
    }
}
