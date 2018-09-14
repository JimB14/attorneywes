{% extends "base.php" %}


{% block browsertitle %}
  Testimonials
{% endblock %}


{% block content %}

<div class="row">
    <div class="col-md-8">
        <div>
            <h1>Testimonials <i class="fa fa-balance-scale pull-right"></i></h1>
            <hr>
            <div class="list-group">
              <a href="#" class="list-group-item gray-bg-box">
                <h3>What clients are saying . . .</h3>
              </a>
                {% for item in testimonials %}
                <a href="#" class="list-group-item">
                  <h4 class="list-group-item-heading"><strong>{{ item.title }}</strong></h4>
                  <p class="list-group-item-text">{{ item.created_at }}</p>
                  <p class="list-group-item-text">{{ item.testimonial }}</p>
                </a>
                {% endfor %}
            </div>
        </div>
        <div class="col-md-4">
        </div>
    </div>
</div><!-- // .row  -->

{% endblock %}
