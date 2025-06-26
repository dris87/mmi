<script id="candidateExperienceTemplate" type="text/x-jsrender">
  <div class="col-12 col-sm-12 col-md-12 col-lg-12 candidate-experience"
  data-experience-id="{{:candidateExperienceNumber}}" data-id="{{:id}}">
    <article class="article article-style-b">
        <div class="article-details">
            <div class="article-title">
                <h4 class="text-primary">{{:title}}</h2>
                <h6 class="text-muted">{{:company}}</h3>
            </div>
            <span class="text-muted">{{:startDate}} - {{:endDate}} | {{:country}}</span>
            <p>{{:description}}</p>
            <div class="article-cta candidate-experience-edit-delete">
                <a href="javascript:void(0)" class="btn btn-warning action-btn title="Edit" edit-experience" data-id="{{:id}}"><i class="fa fa-edit p-1"></i></a>
                <a href="javascript:void(0)" class="btn btn-danger action-btn title="Delete"
                delete-experience" data-id="{{:id}}"><i class="fa fa-trash p-1"></i></a>
            </div>
        </div>
    </article>
</div>


</script>

<script id="candidateEducationTemplate" type="text/x-jsrender">
  <div class="col-12 col-sm-12 col-md-12 col-lg-12 candidate-education" data-education-id="{{:candidateEducationNumber}}" data-id="{{:id}}">
      <article class="article article-style-b">
          <div class="article-details">
              <div class="article-title">
                  <h4 class="text-primary education-degree-level">{{:degreeLevel}}</h2>
                  <h6 class="text-muted">{{:degreeTitle}}</h4>
              </div>
              <span class="text-muted">{{:year}} | {{:country}}</span>
              <p>{{:institute}}</p>
              <div class="article-cta candidate-education-edit-delete">
                  <a href="javascript:void(0)" class="btn btn-warning action-btn edit-education" title="Edit"
                     data-id="{{:id}}"><i class="fa fa-edit p-1"></i></a>
                  <a href="javascript:void(0)" class="btn btn-danger action-btn delete-education" title="Delete"
                     data-id="{{:id}}"><i class="fa fa-trash p-1"></i></a>
              </div>
          </div>
      </article>
  </div>


</script>
<script id="CVcandidateExperienceTemplate" type="text/x-jsrender">
  <div class="col-12 col-sm-12 col-md-12 col-lg-12 candidate-experience"
  data-experience-id="{{:candidateExperienceNumber}}" data-id="{{:id}}">
      <article class="article article-style-b">
          <div class="article-details border-0">
              <div class="article-title">
                  <h4>{{:title}}</h2>
                  <h6 class="text-muted">{{:company}}</h3>
              </div>
              <span class="text-muted">{{:startDate}} - {{:endDate}} | {{:country}}</span>
              <p>{{:description}}</p>
              <div class="article-cta candidate-experience-edit-delete">
                  <a href="javascript:void(0)" class="action-btn edit-experience" title="Edit" data-id="{{:id}}"><i class="fa fa-edit p-1"></i></a>
                  <a href="javascript:void(0)" class="text-danger action-btn delete-experience" title="Delete"
                                        data-id="{{:id}}"><i class="fa fa-trash p-1"></i></a>
              </div>
          </div>
      </article>
  </div>


</script>

<script id="CVcandidateEducationTemplate" type="text/x-jsrender">
  <div class="col-12 col-sm-12 col-md-12 col-lg-12 candidate-education" data-education-id="{{:candidateEducationNumber}}" data-id="{{:id}}">
        <article class="article article-style-b">
            <div class="article-details border-0">
                <div class="article-title">
                    <h4 class="education-degree-level">{{:degreeLevel}}</h2>
                    <h6 class="text-muted">{{:degreeTitle}}</h4>
                </div>
                <span class="text-muted">{{:year}} | {{:country}}</span>
                <p>{{:institute}}</p>
                <div class="article-cta candidate-education-edit-delete">
                    <a href="javascript:void(0)" class="action-btn edit-education" title="Edit"
                       data-id="{{:id}}"><i class="fa fa-edit p-1"></i></a>
                    <a href="javascript:void(0)" class="text-danger action-btn delete-education" title="Delete"
                       data-id="{{:id}}"><i class="fa fa-trash p-1"></i></a>
                </div>
            </div>
        </article>
    </div>


</script>


<script id="candidateCVActionTemplate" type="text/x-jsrender">
   <a   title="<?php echo __('messages.common.delete') ?>
  " class="btn btn-danger delete-resume" data-id="{{:id}}" href=javascript:void(0)" data-toggle="tooltip" data-placement="bottom">
            <i class="fa fa-trash"></i>
   </a>

  <a title="<?php echo __('messages.candidates_table.downloadCv') ?>
  " class="btn btn-primary" data-id="{{:id}}" href="{{:downloadUrl}}" data-toggle="tooltip" data-placement="bottom">
            <i class="fas fa-file-download"></i>
   </a>

</script>

<script id="candidateDocumentActionTemplate" type="text/x-jsrender">
   <a   title="<?php echo __('messages.common.delete') ?>
  " class="btn btn-danger delete-resume" data-id="{{:id}}" href=javascript:void(0)" data-toggle="tooltip" data-placement="bottom">
            <i class="fa fa-trash"></i>
   </a>

  <a title="<?php echo __('messages.candidates_table.downloadDocument') ?>
  " class="btn btn-primary" data-id="{{:id}}" href="{{:downloadUrl}}" data-toggle="tooltip" data-placement="bottom">
            <i class="fas fa-file-download"></i>
   </a>

</script>

<script id="candidateActionTemplate" type="text/x-jsrender">
   <a title="<?php echo __('messages.common.edit') ?>"
   class="btn mt-1 mb-1 btn-warning action-btn edit-btn" href="{{:url}}" data-toggle="tooltip" data-placement="bottom">
            <i class="fa fa-edit"></i>
   </a>

<!--   <a title="--><?php //echo __('messages.common.delete') ?><!--" class="btn btn-danger action-btn delete-action-btn delete-btn" data-id="{{:id}}" href="#" data-toggle="tooltip" data-placement="bottom">-->
<!--            <i class="fa fa-trash"></i>-->
<!--   </a>-->
  {{if hasResume > 0}}
  <a title="<?php echo __('messages.candidates_table.downloadCv') ?>
  " class="btn btn-primary action-btn download-cv" data-id="{{:id}}" href="#" data-toggle="tooltip" data-placement="bottom">
            <i class="fa fa-file"></i>
   </a>
 {{/if}}

</script>

<script id="candidateCVActiveSwitcher" type="text/x-jsrender">
  {{if current_status == 1}}
  <label class="custom-switch pl-0">
        <input type="checkbox"
               class="custom-switch-input changeResumeActiveFlag"
               data-id="{{:id}}" change-to="{{:change_to}}" checked>
        <span class="custom-switch-indicator"></span>
    </label>
 {{/if}}
 {{if current_status == 0}}
  <label class="custom-switch pl-0">
        <input type="checkbox"
               class="custom-switch-input changeResumeActiveFlag"
               data-id="{{:id}}" change-to={{:change_to}} >
        <span class="custom-switch-indicator"></span>
    </label>
 {{/if}}

</script>


<script id="isActive" type="text/x-jsrender">
  <div class="candidate-status">
      <span class="candidate-status-label">{{:label}}</span>
  </div>

</script>
<script id="batchSelect" type="text/x-jsrender">
   <input type="checkbox" name="datatableSelected[]" class="batch-select-input" value="{{:id}}">

</script>
<script id="contactDetails" type="text/x-jsrender">
    <a href="mailto://{{:email}}">{{:email}}</a><br/>
    {{:phone}}

</script>
<script id="candidateLinklink" type="text/x-jsrender">
    <a href="/admin/candidates/{{:id}}/edit?section=profile">{{:name}}</a>

</script>
<script id="isVerified" type="text/x-jsrender">

  {{if !isVerified}}
      <div class="d-flex align-items-center">
      <label class="custom-switch pl-0">
        <input type="checkbox" name="Is Active" class="custom-switch-input is-candidate-email-verified" data-id="{{:id}}" {{:checked}}>
        <span class="custom-switch-indicator"></span>
      </label>
      <span class="pl-1">{{:notVerifiedLabel}}</span>
      </div>
   {{else}}
     <div>
        <a title="{{:resendLabel}}"
           class="btn btn-primary action-btn send-email-verification" data-id="{{:id}}"
           href="#">
            <i class="fa fa-sync"></i>
        </a>
        <span class="employee-label ml-1">{{:verifiedLabel}}</span>
    </div>
   {{/if}}

</script>
