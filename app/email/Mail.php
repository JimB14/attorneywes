<?php

//require '../vendor/autoload.php'; // doesn't make PHPMailer available

class Mail
{
    // holds database connectivity; called in model method of base Controller
    protected $db;

    // pass PDO object method
    // adding 'PDO' before the variable is 'type hinting', e.g construct(PDO $db)
    // my tests show that it works with or without type hinting
    public function __construct(PDO $db)
    {
        //var_dump($db);  // check to see if PDO object exists

        // set $db object to protected $db (see above) so it can be used in
        // any method in Mail class
        $this->db = $db;
    }


    public static function sendAccountVerificationEmail($token, $user_id, $email, $first_name)
    {
        //echo "Connected to sendAccountVerificationEmail method"; exit();
        /**
         * Check PHPMailer is loaded
         */
        $mail = new PHPMailer();

        // echo get_class($mail); exit;
        // echo $token . '<br>';
        // echo $user_id . '<br>';
        // echo $email . '<br>';
        // echo $first_name . '<br>';
        // exit();

        // resource: https://github.com/PHPMailer/PHPMailer/blob/master/examples/gmail.phps

        //echo get_class($mail);
        $mail->isSMTP();
        $mail->Host     = Config::SMTP_HOST;
        $mail->Port     = Config::SMTP_PORT;
        $mail->SMTPAuth = true;
        $mail->Username = Config::SMTP_USER;
        $mail->Password = Config::SMTP_PASSWORD;
        $mail->SMTPSecure = 'tls';
        $mail->CharSet = 'UTF-8';

        /**
         * Enable SMTP debug messages
         */
        //$mail->SMTPDebug = 2;
        //$mail->Debugoutput = 'html';

        /**
         * solution
         * @https://github.com/PHPMailer/PHPMailer/wiki/Troubleshooting
         */
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        /**
         * Send an email
         */
        // "From" and "To"
        $mail->setFrom('info@attorneywes.com', 'Attorney Wes'); // gmail
        // overrides this setting with SMTP_USER
        $mail->addAddress($email, $first_name);

        // multiple "To" addresses
        //$mail->addAddress('sales@webmediapartners.com', 'Jim');
        //$mail->addAddress('info@webmediapartners.com');

        // "Cc" addresses
        //$mail->addCC('jim.burns@webmediapartners.com', 'Jim');
        //$mail->addCC('jim.burns14@gmail.com');

        // "Bcc" address
        //$mail->addBCC('jim.burns14@gmail.com');
        //$mail->addBCC('jim.burns@webmediapartners.com');

        // add different "Reply to" email address
        //$mail->addReplyTo('danat927@gmail.com', 'Dana');

        // sends email as HTML
        $mail->isHTML(true);

        // include plain text version (SPAM filters look for it)



        // add attachment (__FILE__ magic constant that returns full path & file name
        // of the script file); dirname() returns the path w/o file name
        //$mail->addAttachment(dirname(__FILE__) . '/assets/images/koala.jpg', 'newFileName.jpg');
        // add another attachment
        //$mail->addAttachment(dirname(__FILE__) . '/assets/images/penguins.jpg', 'anotherName.jpg');

        // Subject & body
        $mail->Subject = 'Verify Account';
        $mail->Body = '<h1 style="color:#0000FF;">Account Verification</h1>'
                    . '<h3>Attorney Wesley A. Johnston</h3>'
                    . '<p>Please click the link below to verify your account.</p>'
                    . '<p><a href="http://attorneywes.com/register/verifyAccount?token='
                    . $token . '&amp;user_id=' . $user_id . '">Click here to verify your account.</a></p>';

        // embed image in email
        //$mail->AddEmbeddedImage(dirname(__FILE__) . '/assets/images/koala.jpg', 'koala');

        // alternative body (plain-text email)
        //$mail->AltBody = "Hello. \nThis is the body in plain text for non-HTML
        //mail clients"; // must use "" or \n will not work

        // send email
        if(!$mail->send())
        {
            echo 'Mailer error: ' . $mail->ErrorInfo;
            exit();
        }
        else {
            $result = true;

            return $result;
        }
    }



    /**
     * Emails contact form data to specified email addresses
     *
     * @param  string $first_name The user's first name
     * @param  string $last_name  The user's last name
     * @param  string $telephone  The user's telephone
     * @param  string $email      The user's email address
     * @param  string $message    The user's message
     *
     * @return boolean
     */
    public static function mailContactFormData($first_name, $last_name, $telephone, $email, $message)
    {
      //  echo "Connected to mailContactFormData method in Mail class"; exit();

        /**
         * create instance of PHPMailer object
         */
        $mail = new PHPMailer();

        //echo get_class($mail); exit();

        // settings
        $mail->isSMTP();
        $mail->Host     = Config::SMTP_SEND_MAIL_INTERNALLY_HOST;
        //$mail->Port     = Config::SMTP_PORT;
        $mail->SMTPAuth = true;
        $mail->Username = Config::SMTP_USER;
        $mail->Password = Config::SMTP_PASSWORD;
        //$mail->SMTPSecure = 'tls';
        $mail->CharSet = 'UTF-8';

        /**
         * solution
         * @https://github.com/PHPMailer/PHPMailer/wiki/Troubleshooting
         */
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        /**
         * Send email
         */
        // "From" and "To"
        $mail->setFrom('contact@mail.com', $first_name . ' ' . $last_name);
        $mail->addAddress('info@attorneywes.com', 'Atty Wes');
        $mail->addCC('wesleyajohnston@gmail.com');
        //$mail->addCC('jim.burns@webmediapartners.com');
        $mail->addBCC('jim.burns14@gmail.com');
        $mail->isHTML(true);

        // Subject & body
        $mail->Subject = 'Message from site visitor';
        $mail->Body = '<h2 style="color:#0000FF;">Message from website contact form</h2>'
                    . '<p>Name: ' . $first_name . ' ' . $last_name . '</p>'
                    . '<p>Telephone: ' . $telephone . '</p>'
                    . '<p>Email: ' . $email . '</p>'
                    . '<p>Message: ' . $message . '</p>';

        // send mail & return $result to controller
        if($mail->send())
        {
            $result = true;

            return $result;
        }

        // if mail fails display error message
        if(!$mail->send())
        {
           echo $mail->ErrorInfo;
        }
    }




    /**
     * Sends notification email that user posted a testimonial
     *
     * @param  INT $id        The testimonial id
     * @param  INT $user_id   The user's id
     * @param  string $user_full_name   The user's first + last name
     * @param  string $token          Unique string for matching
     * @param  string $title          Testimonial title
     * @param  string $testimonial    Testimonial content
     *
     * @return boolean
     */
    public static function sendNewTestimonialNotification($id, $user_id, $user_full_name, $token, $title, $testimonial)
    {
        // echo "Connected to sendNewTestimonialNotification method in Mail class!<br>";
        // echo $id . "<br>";
        // echo $user_id . "<br>";
        // echo $user_full_name . "<br>";
        // echo $token . "<br>";
        // echo $title . "<br>";
        // echo $testimonial . "<br>";
        //exit();

        // create new instance of PHPMailer object
        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host       =  Config::SMTP_HOST;
        $mail->Port       =  Config::SMTP_PORT;
        $mail->SMTPAuth   =  true;
        $mail->Username   =  Config::SMTP_USER;
        $mail->Password   =  Config::SMTP_PASSWORD;
        $mail->SMTPSecure =  'tls';
        $mail->CharSet    =  'UTF-8';

        /**
         * solution
         * @https://github.com/PHPMailer/PHPMailer/wiki/Troubleshooting
         */
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        /**
         * Send an email
         */
        // "From" and "To"
        $mail->setFrom('info@attorneywes.com', 'Attorney Wes');
        //$mail->addAddress('info@attorneywes.com', 'Atty Wes');
        //$mail->addCC('wesleyajohnston@gmail.com');
        $mail->addBCC('jim.burns14@gmail.com');
        $mail->isHTML(true);

        // Subject & body
        $mail->Subject = 'New testmonial';
        $mail->Body = '<h1 style="color:#0000FF;">New Testimonial</h1>'
                    . '<p>A registered user just submitted a testimonial. The details are below.</p>'
                    . '<h3>'
                    . 'User: ' . $user_full_name
                    . '<br>'
                    . 'Title: ' . $title
                    . '<br>'
                    . 'Testimonial:'
                    . '</h3>'
                    . '<p>'
                    .  $testimonial
                    . '</p>'
                    . '<h3>'
                    . 'To publish this testimonial on your website, click the link below.'
                    . '<br>'
                    . 'If you do not wish to publish this testimonial, no action is required.'
                    . '</h3>'
                    . '<p>By clicking the link below:</p>'
                    . '<ol>'
                    . '<li>The testmonial will be published to the website</li>'
                    . '<li>A thank you email will be sent to the testimonial author&#39;s email address</li>'
                    . '<li>A copy of this &quot;thank you&quot; email will be sent to you (website owner or designee)</li>'
                    . '</ol>'
                    . '<p><a href="http://attorneywes.com/testimonials/publishTestimonial?token='
                    . $token . '&amp;id=' . $id . '&amp;user_id=' . $user_id . '">To publish this testimony, click here.</a></p>'
                    . '<p>If you clicked in error, please contact your web developer.</p>';


        // send email
        if(!$mail->send())
        {
            echo 'Mailer error: ' . $mail->ErrorInfo;
            exit();
        }
        else {
            $result = true;
            return $result;
        }

    }



    /**
     * Sends thank you email to testimonial author and website owner/designee
     *
     * @param  string $user_email     The user's email address
     * @param  string $user_full_name The user's full name (first & last name)
     *
     * @return boolean
     */
    public static function sendThanksForTestimonialEmail($user_email, $user_full_name)
    {
        //echo "Connected to sendThanksForTestimonialEmail method in Mail class";

        // create new instance of PHPMailer object
        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host       =  Config::SMTP_HOST;
        $mail->Port       =  Config::SMTP_PORT;
        $mail->SMTPAuth   =  true;
        $mail->Username   =  Config::SMTP_USER;
        $mail->Password   =  Config::SMTP_PASSWORD;
        $mail->SMTPSecure =  'tls';
        $mail->CharSet    =  'UTF-8';

        /**
         * solution
         * @https://github.com/PHPMailer/PHPMailer/wiki/Troubleshooting
         */
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        /**
         * Send an email
         */
        // "From" and "To"
        $mail->setFrom('info@attorneywes.com', 'Attorney Wes');
        $mail->addAddress($user_email, $user_full_name);
        $mail->addCC('wesleyajohnston@gmail.com');
        $mail->addBCC('jim.burns14@gmail.com');
        $mail->isHTML(true);

        // Subject & body
        $mail->Subject = 'Thank you';
        $mail->Body = '<h1 style="color:#0000FF;">Thank you!</h1>'
                    . '<p>'
                    . 'Thank you very much ' . $user_full_name
                    . ' for taking the time to post a nice testimonial.'
                    . '</p>'
                    . '<p>'
                    . 'We really appreciate hearing from our clients!'
                    . '</p>'
                    . '<p>'
                    . 'If there&#39;s anything else we can do to better serve '
                    . 'you, please let us know.'
                    . '</p>'
                    . 'Sincerely,'
                    . '<br>'
                    . '<p>'
                    . 'Attorney Wes Johnston'
                    . '</p>'
                    . '<p>'
                    . '<a href="http://attorneywes.com/testimonials/">Click here '
                    . 'to see your testimonial on our website.</a>'
                    . '</p>';


        // send email
        if(!$mail->send())
        {
            echo 'Mailer error: ' . $mail->ErrorInfo;
            exit();
        }
        else {
            $result = true;

            return $result;
        }
    }
}
