<?php

class Page
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
        // any method in Page class
        $this->db = $db;
    }


    public function getAboutPageContent()
    {
        $sql = "SELECT * FROM pages WHERE id = 1";
        $query = $this->db->prepare($sql);
        $parameters = [];
        $query->execute($parameters);
        return $query->fetch();
    }


    public function getServicesPageContent()
    {
        $sql = "SELECT * FROM pages WHERE id = 6";
        $query = $this->db->prepare($sql);
        $parameters = [];
        $query->execute($parameters);
        return $query->fetch();
    }


    public function getContactPageContent()
    {
        $sql = "SELECT * FROM pages WHERE id = 2";
        $query = $this->db->prepare($sql);
        $parameters = [];
        $query->execute($parameters);
        return $query->fetch();
    }

    public function updateAboutPage()
    {
        // echo "Connected to updateAboutPage method from Page model";exit();

        $okay = true;

        $page_id = $_REQUEST['page_id'];
        $page_content = $_REQUEST['theaboutdata'];

        // check if page exists (new page will have page_id > 0)
        if($page_id > 0)
        {
            $sql = "UPDATE pages SET
                    page_content = :page_content
                    WHERE id = :id";
            $query = $this->db->prepare($sql);
            $parameters = [
              ':id' => $page_id,
              ':page_content' => $page_content
            ];
            $query->execute($parameters);
        }


        /*
        else
        {
            // create new instance of Page
            $page = new Page;

            // create new instance of Slugify
            $slugify = new Slugify;

            // retrieve post data and store in variable
            $browser_title = $_REQUEST['browser_title'];
            $page->browser_title = $browser_title;
            $page->slug = $slugify->slugify($browser_title);

            // check if slugify version of $browser_title is in DB; if found, store in $results
            $results = Page::where('slug', '=', $slugify->slugify($browser_title))->get();

            // loop will execute only if $results is not empty; if not empty, slug exists, so $okay = false;
            foreach($results as $result)
            {
                $okay = false;
            }

        }

        // store page_content in $page
        $page->page_content = $page_content;

        if($okay)
        {
            $page->save();
            echo "OK";
        }
        else
        {
            // reach here if $okay = false
            echo "Browser title is already in use. Please choose another title.";
        }
        */
    }


    public function updateServicePage()
    {
        // echo "Connected to updateAboutPage method from Page model";exit();

        $okay = true;

        $page_id = $_REQUEST['page_id'];
        $page_content = $_REQUEST['thedata'];

        // check if page exists (new page will have page_id > 0)
        if($page_id > 0)
        {
            $sql = "UPDATE pages SET
                    page_content = :page_content
                    WHERE id = :id";
            $query = $this->db->prepare($sql);
            $parameters = [
              ':id' => $page_id,
              ':page_content' => $page_content
            ];
            $query->execute($parameters);
        }
    }


    public function updateContactPage()
    {
        // echo "Connected to updateAboutPage method from Page model";exit();

        $okay = true;

        $page_id = $_REQUEST['page_id'];
        $page_content = $_REQUEST['thedata'];

        // check if page exists (new page will have page_id > 0)
        if($page_id > 0)
        {
            $sql = "UPDATE pages SET
                    page_content = :page_content
                    WHERE id = :id";
            $query = $this->db->prepare($sql);
            $parameters = [
              ':id' => $page_id,
              ':page_content' => $page_content
            ];
            $query->execute($parameters);
        }
    }
}
