<?php

/**
 * @var $objApplication \App\Models\JobApplication
 */

?>

<div class="row">
    <div class="col-md-12"><h6><b>Munkavállaló :</b> <?=$objJobApplication->candidate->user->first_name." ".$objJobApplication->candidate->user->last_name?></h6></div>
</div>
<div class="row">
    <div class="col-md-12"><h6><b>Állás :</b> <?=$objJob->job_title?></h6></div>
</div>

<hr>

<div class="row">
    <div class="col-md-8">Önéletrajz elnevezése</div>
    <div class="col-md-4 text-right">Opciók</div>
</div>
<hr>

<?php
foreach ($arrApplicationResumes as $key =>  $objApplicationResume){

?>
<div class="row" style="padding-bottom: 10px;">
    <div class="col-md-8 text-left">
        <?=$objApplicationResume->media->name?>
    </div>
    <div class="col-md-4 text-right">
        <a href="/admin/media/<?=$objApplicationResume->media->id?>" >
            Letöltés
        </a>
    </div>

</div>

<?php
}

?>
<br>
<br>

