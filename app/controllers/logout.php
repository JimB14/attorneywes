<?php

class Logout extends Controller
{
    public function index()
    {
        // store CONSTANT value in variable for use in header()
        // ASSET_ROOT defined @app/init.php ~ #24
        $asset_root = ASSET_ROOT;

        unset($_SESSION['user']);
        unset($_SESSION['full_name']);
        // extra measure to assure that all SESSION['user'] data eradicated!
        session_destroy();

        $message  = "You have been logged out.";

        $this->view('success/index', [
            'message' => $message
        ]);
    }
}
