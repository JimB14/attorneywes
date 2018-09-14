<?php

class Register extends Controller
{
    public function index()
    {
        $this->view('register/index', []);
    }


    public function register_new_user()
    {
        // call model method of Controller class & pass model name (User) &
        // receive back new instance of User class & db connection
        $userModel = $this->model('User');

        // call addUser method of User class instance ($userModel)
        $userModel->addUser();
    }


    public function addToUsersPending($token, $user_id, $email, $first_name)
    {
        // check for connection and data being passed
        // echo "<br>Connected to addToUsersPending method in Register controller!<br><br>";
        // echo $token . '<br>';
        // echo $user_id . '<br>';
        // echo $email . '<br>';
        // echo $first_name . '<br>';
        //exit();

        // call model method of Controller class/object to load UserPending model
        // & connection to db
        $userPendingModel = $this->model('UserPending');

        // call addUserPending method of UserPending model on instance of
        // UserPending class
        $result = $userPendingModel->addUserPending($token, $user_id);

        if($result)
        {
            // call sendEmail method of Mail class to send validation email
            $result = Mail::sendAccountVerificationEmail($token, $user_id, $email, $first_name);

            if($result)
            {
              // define message
              $message = "You have successfully registered! Please check your email for our verification email.";

              $this->view('success/index', [
                  'message' => $message
              ]);
            }
            else
            {
                echo "Error. Verification email not sent";
                exit();
            }
        }
        else
        {
            echo "Error occurred adding to users pending table";
            exit();
        }
    }


    public function test()
    {
        // call sendEmail method of Mail class
        //Mail::sendAccountVerificationEmail('123', 'id', 'jim.burns@webmediapartners.com', 'Jim');
    }



    public function verifyAccount()
    {
        //echo "Connected to verifyAccount method in register controller<br><br>"; //exit();

        // retrieve token in order to pass to verifyNewUserAccount method below
        $token = isset($_REQUEST['token']) ? filter_var($_REQUEST['token'], FILTER_SANITIZE_STRING) : '';
        $user_id = isset($_REQUEST['user_id']) ? filter_var($_REQUEST['user_id'], FILTER_SANITIZE_STRING) : '';

        // call model method of Controller.php to load UserPending model
        // & connection to db
        $userVerifyAcountModel = $this->model('UserPending');

        // call verifyNewUserAccount method of UserPending model on instance of
        // UserPending class (viz. $userVerifyAcountModel)
        $result = $userVerifyAcountModel->verifyNewUserAccount($token, $user_id);

        //echo '$result = '  . $result .  "<br>"; exit();

        // display success in view
        if($result)
        {
            // define message
            $message = "Congratulations! Your account has been verified. You can now login.";

            $this->view('success/index', [
                'message' => $message
            ]);
        }
        else
        {
            echo "An error occurred while verifying your account. Please try again.";
            exit();
        }
    }
}
