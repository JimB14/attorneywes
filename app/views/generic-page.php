{% extends 'base.php' %}


{% block browsertitle %}
  {{ $browser_title }}
{% endblock %}


{% block content %}

{% if session.user and session.access_level == 2 %}
<form method="post" action="admin/page/edit" id="editpage" name="editpage">

    <article id="editablecontent" class="editablecontent" style="width:100%; line-height:2em;margin-bottom: 15px;">
        {{ page_content }}
    </article>

    <article class="admin-hidden">
        <a class="btn btn-primary" href="#" onclick="saveEditedPage()">Save</a>
        <a class="btn btn-info" href="#!" onclick="turnOffEditing()">Cancel</a>
        &nbsp;&nbsp;&nbsp;
        <!-- page_id = 0 is set @getAddPage() in AdminController -->
      {% if page_id == 0 %}
        <br><br>
        <input type="text" name="browser_title" placeholder="Enter browser title (slug)">
      {% endif %}
    </article>

    <input type="hidden" name="thedata" id="thedata">
    <input type="hidden" name="old" id="old">
    <input type="hidden" name="page_id" value="{!! $page_id !!}">
</form>

{% else %}
  {{ page_content }}
{% endif %}

{% endblock %}
