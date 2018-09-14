<?php

class About extends Controller
{
    public function index()
    {
        // load Pages model, create new instance of Page model
        $aboutPageModel = $this->model('Page');

        // call method of $aboutPageModel class/object & return array of data
        $aboutPageContent = $aboutPageModel->getAboutPageContent();

        //echo "<pre>";print_r($aboutPageContent);echo "</pre>"; exit();

        // pass content of $aboutPageContent to view for display
        $this->view('about/index', [
            'about' => $aboutPageContent
        ]);
    }

    public function updateAbout()
    {
        // load Pages model, create new instance of Pages model
        $aboutUpdateModel = $this->model('Page');

        // call method of $aboutUpdateModel & get boolean result
        $result = $aboutUpdateModel->updateAboutPage();

        // display updated view; no data to pass
        //$this->view('about/index', []);
    }
}
