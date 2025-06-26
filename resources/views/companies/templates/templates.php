<script id="batchSelect" type="text/x-jsrender">
   <input type="checkbox" name="datatableSelected[]" class="batch-select-input" value="{{:id}}">
</script>
<script id="contactDetails" type="text/x-jsrender">
    <a href="mailto://{{:email}}">{{:email}}</a><br/>
    {{:phone}}
</script>
<script id="companyActionTemplate" type="text/x-jsrender">
   <a title="<?php echo __('messages.company_table.edit') ?>" class="btn btn-primary action-btn edit-btn" href="{{:url}}">
            <i class="fa fa-edit"></i>
   </a>
      <a title="<?php echo __('messages.common.warnings') ?>" class="btn btn-warning action-btn edit-btn" href="{{:url}}?section=warnings">
            <i class="fa fa-exclamation"></i>
   </a>
      <a title="<?php echo __('messages.common.delete') ?>" class="btn btn-danger action-btn delete-btn delete-company-btn" data-id="{{:id}}" href="#">
            <i class="fa fa-trash"></i>
   </a>
</script>

<script id="companyUserActionTemplate" type="text/x-jsrender">
   <a title="<?php echo __('messages.coworker.edit') ?>" class="btn btn-primary action-btn edit-btn" href="{{:url}}">
            <i class="fa fa-edit"></i>
   </a>
      <a title="<?php echo __('messages.common.delete') ?>" class="btn btn-danger action-btn delete-btn delete-company-user-btn" data-id="{{:id}}" href="#">
            <i class="fa fa-trash"></i>
   </a>
</script>
