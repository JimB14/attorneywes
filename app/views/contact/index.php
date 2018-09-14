{% extends "base.php" %}

{% block browsertitle %}
  {{ contact.browsertitle }}
{% endblock %}

{% block content %}

<div class="row">
    <div class="col-md-8">

        {% if session.contacterror %}
          {% include 'errormessage.php' %}
        {% endif %}  

          <h1>Contact Us <i class="fa fa-balance-scale pull-right"></i></h1>
          <hr>

          <form method="post" action="contact/updateContact" id="editcontactpage" name="editpage">

              <article id="editablecontactcontent" class="editablecontent gray-bg-box">
                  {{ contact.page_content|raw }}
              </article>

              <article class="admin-hidden">
                  <a class="btn btn-primary" href="#" onclick="saveEditedPage()">Save</a>
                  <a class="btn btn-info" href="#!" onclick="turnOffEditing()">Cancel</a>
                  &nbsp;&nbsp;&nbsp;
                  <!-- page_id = 0 is set @getAddPage() in AdminController -->
                {% if contact.id == 0 %}
                  <br><br>
                  <input type="text" name="browser_title" placeholder="Enter browser title (slug)">
                {% endif %}
              </article>

              <input type="hidden" name="thedata" id="thecontactdata">
              <input type="hidden" name="old" id="oldcontact">
              <input type="hidden" name="page_id" value="{!! $page_id !!}">

          </form>


          <form name="contactform" id="contactform" class="form-horizontal" action="contact/postContactForm" method="post" novalidate>
              <!--<input type="hidden" name="_token" value="{!! htmlspecialchars($signer->getSignature()) !!}">-->
              <div class="form-group">
                  <label for="first_name" class="col-sm-2 control-label">First name</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control required" name="first_name" id="first_name" placeholder="First name" autofocus>
                  </div>
              </div>

              <div class="form-group">
                  <label for="last_name" class="col-sm-2 control-label">Last name</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control required" name="last_name" id="last_name" placeholder="Last name">
                  </div>
              </div>

              <div class="form-group">
                  <label for="telephone" class="col-sm-2 control-label">Telephone</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control required" name="telephone" id="telephone" placeholder="telephone">
                  </div>
              </div>

              <div class="form-group">
                  <label for="email" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-10">
                      <input type="email" class="form-control required email" name="email" id="email" placeholder="user@example.com">
                  </div>
              </div>

              <div class="form-group">
                  <label for="message" class="col-sm-2 control-label">Message</label>
                  <div class="col-sm-10">
                      <textarea class="form-control" name="message" id="message" placeholder="How can we help?"></textarea>
                  </div>
              </div>

              <hr>

              <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
              </div>

          </form>

      </div>
      <div class="col-md-4">
      </div>

  </div><!-- // .row  -->
{% endblock %}


{% block bottomjs %}

<script>
$(document).ready(function(){
  $("#contactform").validate();
});
</script>

  {# include javascript for page editing for logged in user with access rights #}
  {% if session.user == true and session.access_level == 2 %}
    {% include 'admin/admin-contact-js.php' %}
  {% endif %}

{% endblock %}
