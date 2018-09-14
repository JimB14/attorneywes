<?php
/**
 *   Class utilizes Twig template engine
 */
class View
{
    protected $file;
    protected $data;
    protected $twig;

    public function __construct($file, $data)
    {
        $this->file = $file;
        $this->data = $data;

      // load Twig template engine
      // Resource: http://twig.sensiolabs.org/doc/intro.html
      $twigLoader = new Twig_Loader_Filesystem(INC_ROOT . '/app/views/', '__main__'); // see App/start.php for definition of INC_ROOT
      $this->twig = new Twig_Environment($twigLoader, [
          //'cache' => INC_ROOT . '/app/cache'  // this is optional
      ]);
      // set ASSET_ROOT as global variable in Twig views
      $this->twig->addGlobal('ASSET_ROOT', ASSET_ROOT );
      // dump($this->twig);

      // to be able to access SESSION variables
      $this->twig->addGlobal('session', $_SESSION);
      // to access $_SESSION['user'] ---> {{ session.user }}
      // resource:  http://stackoverflow.com/questions/8399389/accessing-session-from-twig-template?noredirect=1&lq=1

      // to be able to access SERVER variables
      $this->twig->addGlobal('server', $_SERVER); // doesn't work as it does for SESSION - I don't know why
      // to access $_SERVER['HTTP_HOST'] ---> {{ server.http_host }}
    }
    

    // The __toString() method allows a class to decide how it will react
    // when it is treated like a string.
    // resource: http://php.net/manual/en/language.oop5.magic.php#object.tostring
    // also:  http://www.techflirt.com/tutorials/oop-in-php/magic-methods-in-php.html
    // if view object is echoed as a string (@Controller.php),
    // the __toString method is invoked
    public function __toString()
    {
        return $this->parseView();
    }


    public function parseView()
    {
        // '.php' extension matches veiws file syntax;
        // if index.php is re-named to index.twig, this would have
        // to be changed to: $file = $this->file . 'twig';
        $file = $this->file . '.php';

        // is_null — Finds whether a variable is NULL; returns true if
        // variable is null
        // $data = 2nd param above line #15
        // check if $data is included
        if(is_null($this->data))
        {
            return $this->twig->render($file);
        }
        else
        {
            // pass 2nd parameter (array of values; see App.php line #65)
            return $this->twig->render($file, $this->data);
        }
    }
}
