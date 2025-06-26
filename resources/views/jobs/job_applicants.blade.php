<?php

/**
 * @var $objApplication \App\Models\JobApplication
 */

?>


<div class="row">
    <div class="col-md-8">Név</div>
    <div class="col-md-4 text-right">Jelentkezés ideje</div>
</div>
<hr>

<?php
foreach ($arrApplications as $key =>  $objApplication){


?>
<div class="row" style="padding-bottom: 10px;">
    <div class="col-md-6">
        <a target="_blank" href="/admin/candidates/<?=$objApplication->candidate->id?>/edit?section=profile" >
            <?=$objApplication->candidate->user->first_name . " " . $objApplication->candidate->user->last_name?>
        </a>
    </div>
    <div class="col-md-6 text-right">
        <?=$objApplication->created_at?>
    </div>
</div>

<?php
}

?>
<br>
<br>

