<?php

class Services extends Controller
{
    public function index()
    {
        // load Pages model & create new instance of Pages model class
        $servicePageModel = $this->model('Page');

        // call method from new instance of Pages model ($servicePagesModel)
        $servicesPageContent = $servicePageModel->getServicesPageContent();

        // pass content of $servicesPageContent to view for display
        $this->view('services/index', [
          'services' => $servicesPageContent
        ]);
    }


    public function updateServices()
    {
        // load Pages model, create new instance of Pages model
        $servicesUpdateModel = $this->model('Page');

        // call method of $aboutUpdateModel & get boolean result
        $result = $servicesUpdateModel->updateServicePage();

        // display updated view; no data to pass
        //$this->view('about/index', []);
    }
}
