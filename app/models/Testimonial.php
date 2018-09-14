<?php

// Testimonial model
class Testimonial
{
    protected $errors = [];

    // holds database connectivity; called in model method of base Controller
    protected $db;

    // pass PDO object method
    // adding 'PDO' before the variable is 'type hinting', e.g construct(PDO $db)
    // works both ways
    public function __construct(PDO $db)
    {
        //var_dump($db);  // check if PDO object exists

        // set $db object to protected $db (see above) so it can be used in
        // any method in Testimonial class
        $this->db = $db;

        //var_dump($this->db);  // check if PDO object exists
    }


    /**
     * Gets testimonials from database
     *
     * @return array All testimonials
     */
    public function getTestimonials()
    {
        // returns testimonial content from testimonials table
        $sql = "SELECT * FROM testimonials WHERE display = 1
                ORDER BY created_at DESC";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }



    /**
     * Adds new testimonial to database
     */
    public function addNewTestimonial()
    {
        unset($_SESSION['addtestimonialerror']);

        // store CONSTANT value in variable for use in header()
        // ASSET_ROOT defined @app/init.php ~ #24
        $asset_root = ASSET_ROOT;

        // set gatekeeper to true
        $okay = true;

        // retrieve form data
        $title = ( isset($_REQUEST['title']) ) ? filter_var($_REQUEST['title'], FILTER_SANITIZE_STRING) : "";
        $testimonial = ( isset($_REQUEST['testimonial']) ) ? filter_var($_REQUEST['testimonial'], FILTER_SANITIZE_STRING) : "";

        // validate data
        if($title == '' || filter_var($title, FILTER_SANITIZE_STRING === false))
        {
            $_SESSION['addtestimonialerror'] = 'Please enter a valid title';
            $okay = false;
            header("Location: $asset_root/testimonials/addTestimonial");
            exit();
        }

        if($testimonial == '' || filter_var($testimonial, FILTER_SANITIZE_STRING === false))
        {
            $_SESSION['addtestimonialerror'] = 'Please enter a valid testimonial';
            $okay = false;
            header("Location: $asset_root/testimonials/addTestimonial");
            exit();
        }


        if($okay)
        {
            // create token for notification email
            $token = md5(uniqid(rand(), true)) . md5(uniqid(rand(), true));

            $sql = "INSERT INTO testimonials (title, testimonial, user_id, token) VALUES (:title, :testimonial, :user_id, :token)";
            $query = $this->db->prepare($sql);
            $parameters = [
                ':title'        => $title,
                ':testimonial'  => $testimonial,
                ':user_id'      => $_SESSION['user_id'],
                ':token'        => $token
            ];

            $result = $query->execute($parameters);

            // get id of new testimonial
            $id = $this->db->lastInsertId();

            // return array of data to testimonials controller
            $results = [
                'result' => $result,
                'id' => $id,
                'token' => $token,
                'title' => $title,
                'testimonial' => $testimonial
            ];

            return $results;
        }
        else {
            $_SESSION['addtestimonialerror'] = 'Unable to add testimonial. Please try again.';
            $okay = false;
            header("Location: $asset_root/testimonials/addTestimonial");
            exit();
        }
    }


    /**
     * get user name
     *
     * @param  INT $user_id The user's ID
     *
     * @return string   Concatenation of first name & last name
     */
    public function getUser($user_id)
    {
        // get name of user posting testimonial
        try {
            $sql = "SELECT * FROM users WHERE id = :id";
            $query = $this->db->prepare($sql);
            $parameters = [
                ':id' => $user_id
            ];
            $query->execute($parameters);

            // store results in $user array
            $user = $query->fetch(PDO::FETCH_OBJ);

            return $user;
        }
        catch (PDOException $e)
        {
            echo "Error fetching user data from database.";
            exit();
        }
    }



    /**
     * Updates display field of approved testimonial
     */
    public function setTestimonialToDisplay($id, $token)
    {
        // initiate gatekeeper
        $okay = true;

        if($token === '' || $id === '')
        {
            echo "Error. Variables are null";
            $okay = false;
            exit();
        }

        if(filter_var($token, FILTER_SANITIZE_STRING === false) || filter_var($id, FILTER_SANITIZE_NUMBER_INT === false))
        {
            echo "Error found in variables";
            $okay = false;
            exit();
        }

        // echo $token . "<br>";
        // echo $id . "<br>";
        // exit();

        if($okay)
        {
            // update display field if match found
            try {
                $sql = "UPDATE testimonials SET display = 1
                        WHERE id = :id AND token = :token";
                $query = $this->db->prepare($sql);
                $parameters = [
                    ':id' => $id,
                    ':token' => $token
                ];

                $result = $query->execute($parameters);

                return $result;
            }
            catch(PDOException $e)
            {
                echo "Error finding data match";
                exit();
            }
        }
    }
}
