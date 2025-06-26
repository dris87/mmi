<script id="jobActionTemplate" type="text/x-jsrender">
   <a title="<?php echo __('messages.job_table.edit') ?>" class="btn btn-options btn-warning  edit-btn" href="{{:edit_url}}">
            <i class="fa fa-edit"></i>
   </a>
      <a title="<?php echo __('messages.job_table.preview') ?>" class="btn btn-success btn-options delete-btn" target="_blank" href="{{:frontJobDetail}}/{{:job_id}}">
        <i class="fa fa-eye"></i>
   </a>

    <a title="<?php echo __('messages.job_table.applicants') ?>" id="triggerLoadJobApplicants" data-job-id="{{:id}}" data-toggle="modal" data-target="#appliedApplicants" class="btn btn-info btn-options " href="javascript:void(0)">
            <i class="fas fa-users"></i>
   </a>

</script>
<script id="batchSelect" type="text/x-jsrender">
   <input type="checkbox" name="datatableSelected[]" class="batch-select-input" value="{{:id}}">
</script>
<script id="isFeatured" type="text/x-jsrender">
  {{if !featured}}
      <a type="button" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
        <span class="btn btn-info action-btn w-100 dropdown-toggle text-white">
            <?php echo __('messages.front_settings.make_feature') ?>
        </span>
      </a>
    <div class="dropdown-menu w-100px">
        <a class="dropdown-item adminJobMakeFeatured" data-id="{{:id}}" href="#"><?php echo __('messages.front_settings.make_featured') ?></a>
    </div>
   {{else}}
    <div title="Expries On {{:expiryDate}}" data-toggle="tooltip" data-placement="top">
        <a type="button" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
            <span class="btn btn-success action-btn w-100 dropdown-toggle text-white">
                <?php echo __('messages.front_settings.featured') ?>
                <i class="far fa-check-circle pl-1 pt-1"></i>
            </span>
        </a>
      <div class="dropdown-menu w-100px">
          <a class="dropdown-item adminJobUnFeatured" data-id="{{:id}}" href="#"><?php echo __('messages.front_settings.remove_featured') ?></a>
      </div>
    </div>
   {{/if}}





</script>

<script id="isSuspended" type="text/x-jsrender">
   <label class="custom-switch pl-0">
        <input type="checkbox" name="Is Suspended" class="custom-switch-input isSuspended" data-id="{{:id}}" {{:checked}}>
        <span class="custom-switch-indicator"></span>
    </label>


</script>
