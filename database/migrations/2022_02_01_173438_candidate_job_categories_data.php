<?php

use App\Models\Skill;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CandidateJobCategoriesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->unsignedInteger('job_category_id')->nullable(true)->change();
        });

        DB::statement("delete from candidate_job_category where id < 1000");
        DB::statement("delete from job_categories where id < 1000");

        $categories = [
            [
                'name'        => 'Adminisztráció, Irodai munka',
                'description' => 'Adminisztráció, Irodai munka',
            ],
            [
                'name'        => 'Bank, Biztosítás, Bróker',
                'description' => 'Bank, Biztosítás, Bróker',
            ],
            [
                'name'        => 'Cégvezetés, Menedzsment',
                'description' => 'Cégvezetés, Menedzsment',
            ],
            [
                'name'        => 'Egészségügy, Gyógyszeripar',
                'description' => 'Egészségügy, Gyógyszeripar',
            ],
            [
                'name'        => 'Építőipar, Ingatlan',
                'description' => 'Építőipar, Ingatlan',
            ],
            [
                'name'        => 'Értékesítés, Kereskedelem',
                'description' => 'Értékesítés, Kereskedelem',
            ],
            [
                'name'        => 'Fizikai, Segéd, Betanított',
                'description' => 'Fizikai, Segéd, Betanított',
            ],
            [
                'name'        => 'Gyártás, Termelés',
                'description' => 'Gyártás, Termelés',
            ],
            [
                'name'        => 'HR, Munkaügy',
                'description' => 'HR, Munkaügy',
            ],
            [
                'name'        => 'IT programozás, Fejlesztés',
                'description' => 'IT programozás, Fejlesztés',
            ],
            [
                'name'        => 'IT üzemeltetés, Telekom',
                'description' => 'IT üzemeltetés, Telekom',
            ],
            [
                'name'        => 'Jog, Jogi tanácsadás',
                'description' => 'Jog, Jogi tanácsadás',
            ],
            [
                'name'        => 'Közigazgatás',
                'description' => 'Közigazgatás',
            ],
            [
                'name'        => 'Marketing, Média, PR',
                'description' => 'Marketing, Média, PR',
            ],
            [
                'name'        => 'Mérnök',
                'description' => 'Mérnök',
            ],
            [
                'name'        => 'Mezőgazdaság, Környezet',
                'description' => 'Mezőgazdaság, Környezet',
            ],
            [
                'name'        => 'Oktatás, Tudomány, Sport',
                'description' => 'Oktatás, Tudomány, Sport',
            ],
            [
                'name'        => 'Pénzügy, Könyvelés',
                'description' => 'Pénzügy, Könyvelés',
            ],
            [
                'name'        => 'Szakmunka',
                'description' => 'Szakmunka',
            ],
            [
                'name'        => 'Szállítás, Beszerzés',
                'description' => 'Szállítás, Beszerzés',
            ],
            [
                'name'        => 'Ügyfélszolgálat',
                'description' => 'Ügyfélszolgálat',
            ],
            [
                'name'        => 'Vendéglátás, Idegenforgalom',
                'description' => 'Vendéglátás, Idegenforgalom',
            ]
        ];

        foreach ($categories as $category) {
            \App\Models\JobCategory::create($category);
        }
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
