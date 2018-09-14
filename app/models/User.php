<?php

// User model
class User
{
    protected $errors = [];

    // holds database connectivity; called in model method of base Controller
    protected $db;

    // pass PDO object method
    // adding 'PDO' before the variable is 'type hinting', e.g construct(PDO $db)
    // my tests show that it works with or without type hinting
    public function __construct(PDO $db)
    {
        //var_dump($db);  // check to see if PDO object exists

        // set $db object to protected $db (see above) so it can be used in
        // any method in User class
        $this->db = $db;
    }


    public function getUser($id)
    {
        // type cast variable; type casting forces a variable to be evaluated as a certain type
        $id = (int)$id;

        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = [':id' => $id];
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetch();
    }


    public function getAllUsers()
    {
        $sql = "SELECT * FROM users";
        $query = $this->db->prepare($sql);
        $query->execute();
        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // core/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetchAll();
    }


    public function addUser()
    {
        //echo "Connected to addUser method of User class"; exit();
        // unset SESSION variable
        unset($_SESSION['registererror']);

        // store CONSTANT value in variable for use in header()
        // ASSET_ROOT defined @app/init.php ~ #24
        $asset_root = ASSET_ROOT;

        // create gatekeeper variable
        $okay = true;

        // retrieve post data from form
        $first_name = isset($_REQUEST['first_name']) ? filter_var($_REQUEST['first_name'], FILTER_SANITIZE_STRING) : '';
        $last_name = isset($_REQUEST['last_name']) ? filter_var($_REQUEST['last_name'], FILTER_SANITIZE_STRING) : '';
        $email = isset($_REQUEST['email']) ? filter_var($_REQUEST['email'], FILTER_SANITIZE_EMAIL) : '';

        if($first_name === '' || $last_name === '' || $email === '')
        {
            $_SESSION['registererror'] = '*All fields are required.';
            $okay = false;
            header("Location: $asset_root/register");
            exit();
        }

        // check if data passing
        // echo '<pre>';
        // print_r($_REQUEST);
        // echo '</pre>';
        // exit();

        // validate email
        if(filter_var($email, FILTER_SANITIZE_EMAIL === false))
        {
            $_SESSION['registererror'] = '*Please enter a valid email address.';
            $okay = false;
            header("Location: $asset_root/register");
            exit();
        }

        $verify_email = isset($_REQUEST['verify_email']) ? filter_var($_REQUEST['verify_email'], FILTER_SANITIZE_EMAIL) : '';

         // check if emails match
         if($verify_email != $email)
         {
             $okay = false;
             $_SESSION['registererror'] = '*Emails do not match.';
             $okay = false;
             header("Location: $asset_root/register");
             exit();
         }

        $password = isset($_REQUEST['password']) ? filter_var($_REQUEST['password'], FILTER_SANITIZE_STRING) : '';
        $verify_password = isset($_REQUEST['verify_password']) ? filter_var($_REQUEST['verify_password'], FILTER_SANITIZE_STRING) : '';

        // check if passwords match
        if($verify_password != $password)
        {
            $_SESSION['registererror'] = '*Passwords do not match';
            $okay = false;
            header("Location: $asset_root/register");
            exit();
        }

        // hash password
        $pass = password_hash($password, PASSWORD_DEFAULT);

        // echo $first_name . '<br>';
        // echo $last_name . '<br>';
        // echo $email . '<br>';
        // echo $pass . '<br>';
        // echo $okay . '<br>';
        // exit();


        if($okay == true)
        {
            // insert user data into users table
            try {
                $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)";
                $query = $this->db->prepare($sql);
                $parameters = [
                  ':first_name' => $first_name,
                  ':last_name'  => $last_name,
                  ':email'      => $email,
                  ':password'   => $pass
                ];
                $query->execute($parameters);

                // get new user's user_id
                $user_id = $this->db->lastInsertId();

                // create token for validation email
                $token = md5(uniqid(rand(), true)) . md5(uniqid(rand(), true));

                // echo $token . '<br>';
                // echo $user_id . '<br>';
                // echo $email . '<br>';
                // echo $first_name . '<br>';
                // echo $last_name . '<br><br>';
                // exit();

                // create new instance of Register class
                $register = new Register();

                // call addToUserPending method of new instance of Register class
                $register->addToUsersPending($token, $user_id, $email, $first_name);
                exit();
            }
            catch (PDOException $e)
            {
                $_SESSION['registererror'] = "Error adding user to database " . $e->getMessage();
                header("Location: $asset_root/register");
                exit();
            }
        }
        else
        {
            echo "Error during registration. Please try again.";
            //header("Location: /register"); // header to error view
            exit();
        }
    }


    public function deleteUser($id)
    {
        $sql = "DELETE FROM user WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = [':id' => $id];
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
        $query->execute($parameters);
    }


    public function updateUser($username, $email, $id)
    {
        $sql = "UPDATE users SET username = :username, email = :email WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = [':username' => $username, ':email' => $email, ':id' => $id];
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
        $query->execute($parameters);
    }


    public function getCountOfUsers()
    {
        $sql = "SELECT COUNT(id) AS amount_of_users FROM users";
        $query = $this->db->prepare($sql);
        $query->execute();
        // fetch() is the PDO method that get exactly one result
        return $query->fetch()->amount_of_users;
    }


    public function validateLoginCredentials($email, $password)
    {
        // clear variable for new values
        unset($_SESSION['loginerror']);

        // store CONSTANT value in variable for use in header()
        // ASSET_ROOT defined @app/init.php ~ #24
        $asset_root = ASSET_ROOT;

        // set gate-keeper to true
        $okay = true;

        // check if fields have length
        if($email == "" || $password == "")
        {
            $_SESSION['loginerror'] = 'Please enter login email and password.';
            $okay = false;
            header("Location: $asset_root/login/index");
            exit();
        }

        // validate email
        if(filter_var($email, FILTER_SANITIZE_EMAIL === false))
        {
            $_SESSION['loginerror'] = 'Please enter a valid email address';
            $okay = false;
            header("Location: $asset_root/login/index");
            exit();
        }

        if($okay)
        {
            // check if email exists & retrieve password
            try
            {
                $sql = "SELECT * FROM users WHERE email = :email AND active = 1";
                $query = $this->db->prepare($sql);
                $parameters = [':email' => $email];
                $query->execute($parameters);
                $user = $query->fetch();

                //echo "<pre>";print_r($user);echo "</pre>"; exit();
            }
            catch (PDOException $e)
            {
                $_SESSION['loginerror'] = "Error checking credentials";
                header("Location: $asset_root/login/index");
                exit();
            }
        }


        if(empty($user))
        {
            $_SESSION['loginerror'] = "User not found";
            header("Location: $asset_root/login/index");
            exit();
        }

        if( (!empty($user)) && (password_verify($password, $user->password)) )
        {
            // create unique id & store in SESSION variable
            $uniqId = md5($user->id);
            $_SESSION['user'] = $uniqId;

            // assign user ID & access_level to SESSION variables
            $_SESSION['user_id'] = $user->id;
            $_SESSION['access_level'] = $user->access_level;

            // echo $_SESSION['user_id'];
            // echo $_SESSION['access_level'];
            // exit();

            // create new instance of Login class
            $login = new Login();

            // call loginGranted method of Login class & pass values
            $login->loginGranted($user->first_name, $user->last_name, $user->id, $user->access_level);
            exit();
        }
        else
        {
            $_SESSION['loginerror'] = "Matching credentials not found. Please verify and try again.";
            header("Location: $asset_root/login/index");
            exit();
        }
    }
}
