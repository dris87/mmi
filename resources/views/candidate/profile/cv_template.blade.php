<?php
/** @var \App\Models\User $user */
?>
<iframe width="100%" height="600" style="border:none;"
        src="{{ url("/preview-cv-template/" . $candidate->getId()) }}"
        title="cv">
</iframe>

