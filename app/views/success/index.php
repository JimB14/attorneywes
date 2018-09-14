{% extends "base.php" %}

{% block browsertitle %}
  Success
{% endblock %}


{% block content %}

<div class="row">

    <div class="col-md-8">
        <div>
            <h1>Success</h1>
            <hr>

            {% if first_name %}
              <h3>
                Thanks {{ first_name }}! {{ message }}
              </h3>
              {% else %}
              <h3>
                {{ message }}
              </h3>
            {% endif %}

        </div>
        <div class="col-md-4">

        </div>
    </div>
</div><!-- // .row  -->

{% endblock %}
