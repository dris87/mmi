<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EmailFixes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $EmailTemplateFactory = new \App\Models\Factories\EmailTemplateFactory();

        $obj = $EmailTemplateFactory->getByTemplate("Company Verification Email");
        if($obj){
            $obj->body = '<p>Tisztelt {{first_name}},<br><br>{{company_name}} cégfiókhoz tartozó kapcsolattartói fiókja sikeresen elkészült.<br> Az alábbi link segítségével erősítse meg fiókját:<br><br><a href="{{verification_url}}" target="_blank">Fiók megerősítése</a></p><p>Üdvözlettel,<br>MUMI.HU csapata<br>www.mumi.hu<br><br></p>';
            $obj->save();
        }

        $obj = $EmailTemplateFactory->getByTemplate("Company Verified");
        if($obj){
            $obj->body = '<p>Tisztelt {{first_name}},<br>
<br>{{company_name}} cégfiókhoz tartozó kapcsolattartói fiókja sikeresen elkészült.<br>
Az alábbi adatok segítségével bejelentkezhet a cégfiókba:
<br>
<br>
<a href="{{login_url}}" target="_blank">Bejelentkezés</a>
<br>
<br>Felhasználó név: {{user_email}}
<br>Jelszó: A regisztrációkor megadott jelszó<br>
</p><p>Üdvözlettel,<br>MUMI.HU csapata<br>www.mumi.hu<br></p>
';
            $obj->save();
        }

        $obj = $EmailTemplateFactory->getByTemplate("Password Updated");
        if($obj){
            $obj->subject='Sikeres jelszó változtatás';
            $obj->body='<p>Tisztelt {{first_name}},<br><br>Sikeresen módosította jelszavát.<br><span style="background-color: transparent;">Amennyiben akaratán kívül történt a jelszó módosítása, kérjük&nbsp;</span>vegye fel ügyfélszolgálatunkkal a kapcsolatot.<span style="background-color: transparent;"><br></span><a href="{{app_url}}" target="_blank">Ügyfélszolgálat</a><span style="background-color: transparent;"> <br><br></span></p><p><span style="background-color: transparent;">Üdvözlettel,<br></span><span style="background-color: transparent;">MUMI.HU csapata<br></span><span style="background-color: transparent;">www.mumi.hu</span></p>';
            $obj->variables = "{{first_name}}";
            $obj->save();
        }

        $obj = $EmailTemplateFactory->getByTemplate("Password Reset Email");
        if($obj){
            $obj->subject='Elfelejtett jelszó';
            $obj->body='<p>Tisztelt {{first_name}},<br><br>
Ezt az email-t azért kapta, mert jelszó változtatási kérelmet adott le a weboldalon.<br>
Az alábbi hivatkozás érvényességi ideje 60 perc.<br><br>
<a href="{{reset_url}}">Jelszó megváltoztatása</a><br><br>
Amennyibe nem Ön kérelmezte a jelszó változatást, akkor Önnek nincs további teendője.<br>

</p><p>Üdvözlettel,<br>MUMI.HU csapata<br>www.mumi.hu<br></p>';
            $obj->variables = "{{reset_url}},{{from_name}},{{first_name}}";
            $obj->save();
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
