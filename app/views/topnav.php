<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ ASSET_ROOT }}/home" title="home page">Attorney Wes</a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <!--<li><a href="{{ ASSET_ROOT }}/home">home</a></li>-->
        <li><a href="{{ ASSET_ROOT }}/about">about</a></li>
        <li><a href="{{ ASSET_ROOT }}/services">services</a></li>
        <li><a href="{{ ASSET_ROOT }}/contact">contact</a></li>
        <li><a href="{{ ASSET_ROOT }}/testimonials">testimonials</a></li>
        <!-- call public static function in LoggedIn class -->
          {% if session.user %}
          <li><a href="{{ ASSET_ROOT }}/testimonials/addTestimonial">add testimonial</a></li>
          <li><a><span style="color:#fff;">Welcome {{ session.full_name }}!</span></a></li>
          {% endif %}
          {% if session.user == false %}
          <li><a href="{{ ASSET_ROOT }}/register">register</a></li>
          {% endif %}
      </ul>

      <ul class="nav navbar-nav navbar-right">
            {% if session.user == true and session.access_level == 2 %}
            <li class=dropdown>
                <a href=# class=dropdown-toggle id=drop1 data-toggle=dropdown role=button aria-haspopup=true aria-expanded=false>
                  Admin
                  <span class=caret></span>
                </a>
                <ul class=dropdown-menu aria-labelledby=drop1>
                  <li><a class="menu-item" href="#" onclick="makePageEditable(this)">Edit page</a></li>
                  <li role=separator class=divider></li>
                  <!--
                  <li><a href="/admin/page/add">Add page</a></li>
                  <li role=separator class=divider></li>
                  <li><a href="#">Another action</a></li>
                -->
                </ul>
            </li>
            {% endif %}
            {% if session.user %}
            <li>
              <a href="{{ ASSET_ROOT }}/logout">
                <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
                logout
              </a>
            </li>
            {% endif %}

            {% if session.user == false %}
            <li>
              <a href="{{ ASSET_ROOT }}/login"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
                login
              </a>
            </li>
            {% endif %}
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>
<div style="margin-bottom: 30px;">&nbsp;</div>
