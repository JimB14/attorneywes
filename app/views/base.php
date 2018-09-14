<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
      <title>
        {% block browsertitle %}
          Attorney Wes
        {% endblock %}
      </title>

      {% block css %}

      {% endblock %}

      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      <link rel="stylesheet" href="{{ ASSET_ROOT }}/css/jquery-ui.min.css">
      <link rel="stylesheet" href="{{ ASSET_ROOT }}/css/styles.css">
      <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">

      <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
  </head>
  <body>

    {% include 'topnav.php' %}

    {% block outsidecontainer %}

    {% endblock %}

  <div class="container">

      <div class="row">
        <div class="col-md-12" style="margin-top:15px;">
          {% block content %}


          {% endblock %}
        </div>
    </div>


  </div><!-- // .container -->

  {% block modal %}

  {% endblock %}


  <!-- footer -->
  <div class="footer">
      <div class="footer-bg">
          <div class="container">
              <div class="row">
                  <div class="col-sm-4">
                      <div class="footer-column">
                          <h4>Wesley A. Johnston Law</h4>
                          <p>123 Main St</p>
                          <p>Akron, OH 44432</p>
                          <p>330-123-4567</p>
                      </div>
                  </div>

                  <div class="col-sm-4">
                      <div class="footer-column">
                          <h4>Law</h4>
                          <p><a href="#">Criminal defense</a></p>
                          <p><a href="#">Civil defense</a></p>
                          <p><a href="#">Contract law</a></p>
                      </div>
                  </div>

                  <div class="col-sm-4">
                      <div class="footer-column">
                          <h4>Information</h4>
                          <p><a href="/contact/">Contact Attorney Wes</a></p>
                          <p>Longer </p>
                          <p>Even longer</p>
                      </div>
                  </div>

              </div><!-- // .row  -->
          </div><!-- // .container  -->
      </div><!-- // .footer-bg -->

      <div class="footer-bg2">
          <div class="container">
              <div class="row">
                  <div class="col-md-12">
                    <p>&copy; 1999 - <script>document.write(new Date().getFullYear()); </script> Wesley A. Johnston</p>
                    <p class="wmp">Web development by <a href="http://webmediapartners.com" target="_blank">Web Media Partners</a></p>
                  </div>
              </div><!-- // .row  -->
          </div><!-- // .container  -->
      </div><!-- // .footer-bg2 -->
  </footer>



<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.js"></script>
    <script src="//use.fontawesome.com/6acf38a2cb.js"></script>
    {% if session.user == true and session.access_level == 2 %}
      <script src="//cdnjs.cloudflare.com/ajax/libs/ckeditor/4.5.10/ckeditor.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
      <script src="//code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
    {% endif %}


    {% block bottomjs %}

    {% endblock %}

  </body>
</html>
