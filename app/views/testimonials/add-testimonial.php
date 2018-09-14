{% extends "base.php" %}

{% block browsertitle %}
  Add testimonial
{% endblock %}


{% block content %}

<div class="row">
    <div class="col-md-8">

          {% if session.addtestimonialerror %}
            {% include 'errormessage.php' %}
          {% endif %}

          <h1>Add Testimonial</h1>
          <hr>
          <form method="post" name="testimonialform" class="form-horizontal" id="testimonialform" action="postTestimonial">

              <div class="form-group">
                  <label for="title"  class="col-sm-2 control-label">Title</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control required" id="title" name="title" placeholder="title" autofocus>
                  </div>
              </div>

              <div class="form-group">
                  <label for="testimonial"  class="col-sm-2 control-label">Testimonial</label>
                  <div class="col-sm-10">
                      <textarea class="form-control required" id="testimonial" name="testimonial" placeholder="testimonial"></textarea>
                  </div>
              </div>

              <hr>

              <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-primary">Submit Testimonial</button>
                  </div>
              </div>

          </form>

          <br><br>


        <div class="col-md-4">
        </div>
    </div>
</div><!-- // .row  -->

{% endblock %}

{% block bottomjs %}
  <script>
  $(document).ready(function(){
    $("#testimonialform").validate();
  });
  </script>
{% endblock %}
