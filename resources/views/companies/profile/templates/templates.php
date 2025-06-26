<script id="companyApplicatonOptions" type="text/x-jsrender">
   <a title="<?php echo __('messages.jobs.preview') ?>" class="btn btn-success btn-options" target="_blank" href="{{:frontJobDetail}}/{{:job_id}}">
        <i class="fa fa-eye"></i>
   </a>

   <a title="<?php echo __('messages.candidates_table.downloadCv') ?>" id="triggerLoadJobApplicantsResumes" data-job-application-id="{{:id}}" data-toggle="modal" data-target="#appliedResumes" class="btn btn-info btn-options " href="javascript:void(0)">
            <i class="fas fa-file-download"></i>
   </a>

</script>
