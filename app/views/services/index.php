{% extends "base.php" %}


{% block browsertitle %}
  {{ services.browsertitle }}
{% endblock %}


{% block content %}

<div class="row">

    <div class="col-md-8">
        <div>
            <h1>Services <i class="fa fa-balance-scale pull-right"></i></h1>
            <hr>
            <form method="post" action="services/updateServices" id="editservicespage" name="editpage">

                <article id="editableservicescontent" class="editablecontent" style="width:100%; line-height:2em;margin-bottom: 15px;">
                    {{ services.page_content|raw }}
                </article>

                <article class="admin-hidden">
                    <a class="btn btn-primary" href="#" onclick="saveEditedPage()">Save</a>
                    <a class="btn btn-info" href="#!" onclick="turnOffEditing()">Cancel</a>
                    &nbsp;&nbsp;&nbsp;
                    <!-- page_id = 0 is set @getAddPage() in AdminController -->
                  {% if services.id == 0 %}
                    <br><br>
                    <input type="text" name="browser_title" placeholder="Enter browser title (slug)">
                  {% endif %}
                </article>

                <input type="hidden" name="thedata" id="theservicesdata">
                <input type="hidden" name="old" id="oldservices">
                <input type="hidden" name="page_id" value="{{ services.id }}">

            </form>
        </div>
        <div class="col-md-4">
        </div>
    </div>
</div><!-- // .row  -->

{% endblock %}

{% block bottomjs %}

  {# include javascript for page editing for logged in user with access rights #}
  {% if session.user == true and session.access_level == 2 %}
    {% include 'admin/admin-services-js.php' %}
  {% endif %}

{% endblock %}
