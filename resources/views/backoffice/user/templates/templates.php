<script id="batchSelect" type="text/x-jsrender">
   <input type="checkbox" name="datatableSelected[]" class="batch-select-input" value="{{:id}}">
</script>
<script id="backoffice-name" type="text/x-jsrender">
<div>
    {{:name }} <br>
    ({{:branchOffice }})
</div>
</script>
<script id="backoffice-superior" type="text/x-jsrender">
<div>
    {{:superiorName }} <br>
    ({{:superiorPosition }})
</div>
</script>
<script id="backoffice-contact" type="text/x-jsrender">
<div>
    {{:email }} <br>
    {{:phone }}
</div>
</script>
<script id="backoffice-permissions" type="text/x-jsrender">
<div>
    <strong>{{:mainPermission }}</strong> <br>
    {{for permissions}}
        {{>}}
    {{/for}}
</div>
</script>
<script id="backoffice-options" type="text/x-jsrender">
<div>
    <p href="#" onclick="{{:onClick}}">Password Change</p>
</div>
</script>
<script id="backoffice-action" type="text/x-jsrender">
   <a title="<?php echo __('messages.common.edit') ?>"
   class="btn btn-primary action-btn edit-btn"
   href="{{:url}}">
            <i class="fa fa-edit"></i>
   </a>
      <a title="<?php echo __('messages.backoffice.user.reset_password') ?>"
      class="btn btn-warning action-btn edit-btn password-reset-btn"
      data-id="{{:id}}" href="#">
            <i class="fa fa-exclamation"></i>
   </a>
      <a title="<?php echo __('messages.common.delete') ?>" class="btn btn-danger action-btn delete-btn delete-user-btn" data-id="{{:id}}" href="#">
            <i class="fa fa-trash"></i>
   </a>
</script>
