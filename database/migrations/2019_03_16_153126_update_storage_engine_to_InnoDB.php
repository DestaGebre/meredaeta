<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStorageEngineToInnoDB extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables = ['approved_hitsuys', 'career_informations', 'core_degeftis', 'data1s', 'dismisses', 'donors', 'educations', 'education_informations', 'experts', 'first_instant_leaders', 'gifts', 'hitsuys', 'individualplans', 'lower_leaders', 'meseretawiwidabeaplans', 'meseretawi_wdabes', 'mewachos', 'mewacho_settings', 'middle_leaders', 'midebas', 'migrations', 'monthlies', 'monthly_settings', 'notyet_hitsuys', 'officeplans', 'password_resets', 'penalties', 'rejected_hitsuys', 'siltenas', 'srires', 'super_leaders', 'tabias', 'tara_members', 'terminations', 'top_leaders', 'training_settings', 'transfers', 'users', 'wahioplans', 'wahios', 'woredaplans', 'woredas', 'work_expriences', 'yearlies', 'yearly_settings', 'zobatats', 'zoneplans'];
        foreach ($tables as $table) {
            DB::statement('ALTER TABLE ' . $table . ' ENGINE = InnoDB');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tables = ['approved_hitsuys', 'career_informations', 'core_degeftis', 'data1s', 'dismisses', 'donors', 'educations', 'education_informations', 'experts', 'first_instant_leaders', 'gifts', 'hitsuys', 'individualplans', 'lower_leaders', 'meseretawiwidabeaplans', 'meseretawi_wdabes', 'mewachos', 'mewacho_settings', 'middle_leaders', 'midebas', 'migrations', 'monthlies', 'monthly_settings', 'notyet_hitsuys', 'officeplans', 'password_resets', 'penalties', 'rejected_hitsuys', 'siltenas', 'srires', 'super_leaders', 'tabias', 'tara_members', 'terminations', 'top_leaders', 'training_settings', 'transfers', 'users', 'wahioplans', 'wahios', 'woredaplans', 'woredas', 'work_expriences', 'yearlies', 'yearly_settings', 'zobatats', 'zoneplans'];
        foreach ($tables as $table) {
            DB::statement('ALTER TABLE ' . $table . ' ENGINE = MyISAM');
        }
    }
}
