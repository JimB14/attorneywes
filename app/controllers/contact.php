<?php

class Contact extends Controller
{
    public function index()
    {
        // load Page model & instantiate a new instance of the Page model class
        $contactPagesModel = $this->model('Page');

        // call method of new instance of Page model, viz. $contactPagesModel
        // & store retrieved data in $variable
        $contactPageContent = $contactPagesModel->getContactPageContent();

        // pass content of $contactPageContent array to view
        $this->view('contact/index', [
            'contact' => $contactPageContent
        ]);
    }


    public function updateContact()
    {
        // load Pages model, create new instance of Pages model
        $contactUpdateModel = $this->model('Page');

        // call method of $aboutUpdateModel & get boolean result
        $result = $contactUpdateModel->updateContactPage();

        // display updated view; no data to pass
        //$this->view('about/index', []);
    }


    public function postContactForm()
    {
        $result = $this->processContactForm();

    }


    public function processContactForm()
    {
        // echo "Connected to processContactForm method in Contact class<br>";
        // exit();

        unset($_SESSION['contacterror']);

        $asset_root = ASSET_ROOT;

        // set gate-keeper
        $okay = true;

        // retrieve data
        $first_name = (isset($_REQUEST['first_name'])) ?  filter_var($_REQUEST['first_name'], FILTER_SANITIZE_STRING) : '';
        $last_name = (isset($_REQUEST['last_name'])) ?  filter_var($_REQUEST['last_name'], FILTER_SANITIZE_STRING) : '';
        $telephone = (isset($_REQUEST['telephone'])) ?  filter_var($_REQUEST['telephone'], FILTER_SANITIZE_NUMBER_INT) : '';
        $email = (isset($_REQUEST['email'])) ?  filter_var($_REQUEST['email'], FILTER_SANITIZE_EMAIL) : '';
        $message = (isset($_REQUEST['message'])) ?  filter_var($_REQUEST['message'], FILTER_SANITIZE_STRING) : '';

        // check for empty fields
        if($first_name === '' || $last_name === '' || $telephone === '' || $email === '' || $message === '')
        {
            $_SESSION['contacterror'] = "All fields are required";
            $okay = false;
            header("Location: $asset_root/contact");
            exit();
        }

        if(filter_var($email, FILTER_SANITIZE_EMAIL === false))
        {
            $_SESSION['contacterror'] = "Please enter valid email address";
            $okay = false;
            header("Location: $asset_root/contact");
            exit();
        }

        // echo $first_name . "<br>";
        // echo $last_name . "<br>";
        // echo $telephone . "<br>";
        // echo $email . "<br>";
        // echo $message . "<br>";
        // exit();

        if($okay)
        {
            // call mailContactFormData method of Mail class & store boolean in $result
            $result = Mail::mailContactFormData($first_name, $last_name, $telephone, $email, $message);

            // if successful display success message in view
            if ($result)
            {
                // display success message in view
                $message = "Your information was sent. We will contact you as soon
                as possible";

                $this->view('success/index', [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'message' => $message
                ]);
            }
            else
            {
                echo 'Mailer error';
                exit();
            }
        }
    }
}
