{% extends 'base.php' %}

{% block browsertitle %}
  Home | Atty Wes
{% endblock %}

{% block css %}
<style>

</style>
{% endblock %}

{% block outsidecontainer%}
    <div id="carousel-attorneywes" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#carousel-attorneywes" data-slide-to="0" class="active"></li>
          <li data-target="#carousel-attorneywes" data-slide-to="1"></li>
          <li data-target="#carousel-attorneywes" data-slide-to="2"></li>
          <li data-target="#carousel-attorneywes" data-slide-to="3"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
          <div class="item active">
            <img src="{{ ASSET_ROOT }}/images/slider/1b.jpg" alt="Attorney Wes Johnston">
            <div class="carousel-caption">
              Attorney Wes Johnston
            </div>
          </div>
          <div class="item">
            <img src="{{ ASSET_ROOT }}/images/slider/3b.jpg" alt="Attorney Wes Johnston">
            <div class="carousel-caption">
              Attorney Wes Johnston
            </div>
          </div>
          <div class="item">
            <img src="{{ ASSET_ROOT }}/images/slider/2b.jpg" alt="Attorney Wes Johnston">
            <div class="carousel-caption">
              Attorney Wes Johnston
            </div>
          </div>
          <div class="item">
            <img src="{{ ASSET_ROOT }}/images/slider/wes-01.jpg" alt="Attorney Wes Johnston">
            <div class="carousel-caption">
              Attorney Wes Johnston
            </div>
          </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-attorneywes" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-attorneywes" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
    </div>
{% endblock %}

{% block content %}
    <div class="row" style="margin-top:30px;">
        <div class="col-sm-4 well">
          <p class="text-center"><i class="fa fa-university fa-3x"></i></p>
          <h2 class="text-center">Law Area I</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet. </p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
        </div>
        <div class="col-sm-4 well" style="background-color:transparent;">
          <p class="text-center"><i class="fa fa-balance-scale fa-3x"></i></p>
          <h2 class="text-center">Law Area II</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet. </p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
       </div>
        <div class="col-sm-4 well">
          <p class="text-center"><i class="fa fa-gavel fa-3x"></i></p>
          <h2 class="text-center">Law Area III</h2>
          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, sit tellus ac curodo.</p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
        </div>
    </div><!-- // .row  -->
</div><!-- // .container  -->
{% endblock %}

{% block modal %}

{% endblock %}

{% block bottomjs %}
<script>
$(document).ready(function(){
  /*
    $("#login-greeting").dialog({

        // Set properties
        title: '',
        modal: true,
        width: 400,
        maxWidth: 400,
        show: 500,
        hide: {
            effect: 'explode',
            delay: 250,
            duration: 1000,
            easing: 'easeInQuad'
        }
    });
  */

});
</script>
{% endblock %}
