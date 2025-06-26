<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeedJobRequirementTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $obj = new \App\Models\JobRequirementType();
        $obj->id = 1;
        $obj->name = "Education";
        $obj->translation_key = "messages.job_requirement_types.education";
        $obj->view_key = "education";
        $obj->save();

        $obj = new \App\Models\JobRequirementType();
        $obj->id = 2;
        $obj->name = "Experience";
        $obj->translation_key = "messages.job_requirement_types.experience";
        $obj->view_key = "experience";
        $obj->save();

        $obj = new \App\Models\JobRequirementType();
        $obj->id = 3;
        $obj->name = "Driver's License";
        $obj->translation_key = "messages.job_requirement_types.drivers_license";
        $obj->view_key = "drivers_license";
        $obj->save();

        $obj = new \App\Models\JobRequirementType();
        $obj->id = 4;
        $obj->name = "IT Skill";
        $obj->translation_key = "messages.job_requirement_types.it_skill";
        $obj->view_key = "it_skill";
        $obj->save();

        $obj = new \App\Models\JobRequirementType();
        $obj->id = 5;
        $obj->name = "Software Skill";
        $obj->translation_key = "messages.job_requirement_types.software_skill";
        $obj->view_key = "software_skill";
        $obj->save();

        $obj = new \App\Models\JobRequirementType();
        $obj->id = 6;
        $obj->name = "Language Skill";
        $obj->translation_key = "messages.job_requirement_types.language_skill";
        $obj->view_key = "language_skill";
        $obj->save();

        $obj = new \App\Models\JobRequirementType();
        $obj->id = 7;
        $obj->name = "Personal Skill";
        $obj->translation_key = "messages.job_requirement_types.personal_skill";
        $obj->view_key = "personal_skill";
        $obj->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
