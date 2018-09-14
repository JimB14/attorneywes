<?php

class Testimonials extends Controller
{
    public function index()
    {
        //echo "Connected to index method of Testimonials Controller"; exit();

        // call model method of Controller class & pass model name (Testimonial) &
        // receive back new instance of Testimonial class & db connection
        // $testimonialModel is new instance of Testimonials class
        $testimonialModel = $this->model('Testimonial');

        // call getShowTestimonials method of new instance of Testimonial class viz. $testimonialModel
        // store in $testimonials what the method returns
        $testimonials = $testimonialModel->getTestimonials();

        //echo "<pre>";print_r($testimonials);echo "</pre>";

        // pass $testimonials array to view; notice that you must identify a name ('testimonials')
        // and then pass the value of $testimonials to it.  Then, it is looped thru in the view
        $this->view('testimonials/index', [
            'testimonials' => $testimonials
        ]);

    }


    public function addTestimonial()
    {
        $this->view('testimonials/add-testimonial', []);
    }


    public function postTestimonial()
    {
        //echo "Connected to postTestimonial method!"; exit();

        // load the model
        $addTestimonialModel = $this->model('Testimonial');

        // call method in instance of Testimonial model ($addTestimonialModel)
        // $results is an array
        $results = $addTestimonialModel->addNewTestimonial();

        // store $results array elements in variables
        $id = $results['id'];
        $token = $results['token'];
        $title = $results['title'];
        $testimonial = $results['testimonial'];
        $result = $results['result'];
        $user_id = $_SESSION['user_id'];

        // echo '<pre>';
        // print_r($results);
        // echo  '</pre>';
        // echo $result;
        // exit();

        if($result)
        {
            // get user's name from database
            // load Testimonial model ($addTestimonialModel); call method; pass user's ID
            $user = $addTestimonialModel->getUser($_SESSION['user_id']);

            // store user_full_name in variable
            $user_full_name = $user->first_name . ' ' . $user->last_name;

            // send email to website owner or designee & pass testimonial data
            $result = Mail::sendNewTestimonialNotification($id, $user_id, $user_full_name, $token, $title, $testimonial);

            // define message
            $message = "Thank you for your testimonial! It will be reviewed
                        before being published.";

            $this->view('success/index', [
                'message' => $message
            ]);
        }

        // send email to website owner or designee & pass testimonial data
        //$result = Mail::sendNewTestimonialNotification($id, $user_id, $user_full_name, $token, $title, $testimonial);

        if(!$result)
        {
            echo "Error occurred with mailer sending testimony notification";
            exit();
        }
    }



    /**
     * Updates display field of testimonial
     *
     * @return boolean
     */
    public function publishTestimonial()
    {
        //echo "Connected to publishTestimonial method in testimonials controller!"; exit();

        // retrieve id & token from query string
        $id = isset($_REQUEST['id']) ? filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT) : '';
        $token = isset($_REQUEST['token']) ? filter_var($_REQUEST['token'], FILTER_SANITIZE_STRING) : '';
        $user_id = isset($_REQUEST['user_id']) ? filter_var($_REQUEST['user_id'], FILTER_SANITIZE_STRING) : '';

        // load Testimonial model and create new instance
        $publishTestimonialModel = $this->model('Testimonial');

        // call method of new instance of Testimonial class to set display = 1
        $results = $publishTestimonialModel->setTestimonialToDisplay($id, $token);

        //echo "Connected to publishTestimonial method of testimonials controller"; exit();

        // if database update successful (display = 1) send email to testimonial author
        // and copy to website owner or designee
        if($results)
        {
            // get user data
            $user = $publishTestimonialModel->getUser($user_id);

            $user_email = $user->email;
            $user_full_name = $user->first_name . ' ' . $user->last_name;

            // echo $user_email . '<br>';
            // echo $user_full_name . "<br>";
            // exit();

            // send thank you email
            $results = Mail::sendThanksForTestimonialEmail($user_email, $user_full_name);

            if($results)
            {
                header("Location: http://attorneywes.com/testimonials");
                exit();
            }
            else
            {
                echo "Error sending thank you email";
                exit();
            }
        }
    }
}
