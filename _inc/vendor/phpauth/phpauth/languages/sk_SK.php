<?php
$lang = array();

$lang['user_blocked']       = "Váš účet je v súčasnej dobe zablokovaný.";
$lang['user_verify_failed'] = "Overenie kódu captcha zlyhalo.";

$lang['email_password_invalid']   = "Neplatná e-mailová adresa alebo heslo.";
$lang['email_password_incorrect'] = "Nesprávná e-mailová adresa alebo heslo.";
$lang['remember_me_invalid']      = "Neplatná hodnota políčka zapamätať si ma.";

$lang['password_short']     = "Heslo je príliš krátké.";
$lang['password_weak']      = "Heslo je príliš slabé.";
$lang['password_nomatch']   = "Hesla nie su zhodné.";
$lang['password_changed']   = "Heslo úspešne zmenené.";
$lang['password_incorrect'] = "Súčasné heslo je nesprávné.";
$lang['password_notvalid']  = "Heslo je neplatné.";

$lang['newpassword_short']   = "Nové heslo je príliš krátké.";
$lang['newpassword_long']    = "Nové heslo je príliš dlhé.";
$lang['newpassword_invalid'] = "Nové heslo musí obsahovať aspoň jedno velké písmeno, aspoň jedno malé písmeno a aspoň jednu číslicu.";
$lang['newpassword_nomatch'] = "Nová hesla nie su zhodné.";
$lang['newpassword_match']   = "Nové heslo je rovnaké ako staré heslo.";

$lang['email_short']      = "E-mailová adresa je príliš krátká.";
$lang['email_long']       = "E-mailová adresa je príliš dlhá.";
$lang['email_invalid']    = "E-mailová adresa je neplatná.";
$lang['email_incorrect']  = "E-mailová adresa je nesprávná.";
$lang['email_banned']     = "Tato e-mailová adresa je zakázána.";
$lang['email_changed']    = "E-mailová adresa úspešne zmenená.";
$lang['username_changed'] = "Uživatelské meno úspešne zmenené.";
$lang['role_changed']     = "Úloha úspešne zmenená.";

$lang['newemail_match']    = "Nová e-mailová adresa je rovnaká ako stará.";
$lang['newusername_match'] = "Nové uživatelské meno je rovnaké ako staré.";
$lang['newrole_match']     = "Nová úloha je rovnaká ako stará.";

$lang['account_inactive']  = "Účet doposial nebol aktivovaný.";
$lang['account_activated'] = "Účet bol aktivovaný.";

$lang['logged_in']  = "Ste prihlásený/á.";
$lang['logged_out'] = "Ste odhlásený/á.";

$lang['system_error'] = "Nastala systémová chyba. Prosím, skúste to znovu.";

$lang['register_success']                         = "Účet bol vytvorený. Na vašu e-mailovú adresu bol zaslaný aktivačný e-mail.";
$lang['register_success_emailmessage_suppressed'] = "Účet vytvorený.";
$lang['email_taken']                              = "Táto e-mailová adresa je už používaná.";

$lang['resetkey_invalid']   = "Klúč k zmene hesla je neplatný.";
$lang['resetkey_incorrect'] = "Klúč k zmene hesla je nesprávny.";
$lang['resetkey_expired']   = "Platnosť klúča k zmene hesla vypršala.";
$lang['password_reset']     = "Heslo bolo úspešne zmenené.";

$lang['activationkey_invalid']   = "Aktivačný klúč je neplatný.";
$lang['activationkey_incorrect'] = "Aktivačný klúč je nesprávny.";
$lang['activationkey_expired']   = "Platnosť aktivačného klúča vypršala.";

$lang['reset_requested']                         = "Požiadavka na zmenu hesla bola odoslaná na e-mailovú adresu.";
$lang['reset_requested_emailmessage_suppressed'] = "Požiadavka na zmenu hesla bola vytvorená.";
$lang['reset_exists']                            = "Požiadavka na zmenu hesla už existuje.";

$lang['already_activated'] = "Účet bol už aktivovaný.";
$lang['activation_sent']   = "Aktivačný e-mail bol odoslaný.";
$lang['activation_exists'] = "Aktivačný e-mail bol už odoslaný.";

$lang['email_activation_subject'] = '%s - Aktivácia účtu';
$lang['email_activation_body']    = 'Dobrý deň,<br/><br/> abyste sa mohli prihlásiť do svojho účtu, musíte ho najskôr aktivovať kliknutím na tento odkaz : <strong><a href="%1$s/%2$s">%1$s/%2$s</a></strong><br/><br/> Potom musíte vložiť nasledujúci aktivačný klúč: <strong>%3$s</strong><br/><br/> Pokial ste sa v poslednej dobe neregistrovali na %1$s, znamená to, že tento e-mail bol odoslaný omylom a môžete ho ignorovať.';
$lang['email_activation_altbody'] = 'Dobrý deň,' . "\n\n" . 'abyste sa mohli prihlásiť do svojho účtu, musíte ho najskôr aktivovať kliknutím na tento odkaz :' . "\n" . '%1$s/%2$s' . "\n\n" . 'Potom musíte vložiť nasledujúci aktivačný klúč: %3$s' . "\n\n" . 'Pokial ste sa v poslednej dobe neregistrovali na %1$s, znamená to, že tento e-mail bol odoslaný omylom a môžete ho ignorovať.';

$lang['email_reset_subject'] = '%s - Žiadosť o zmenu hesla';
$lang['email_reset_body']    = 'Dobrý deň,<br/><br/>abyste mohli zmenit svoje heslo, musíte najprv kliknúť na nasledujúci odkaz :<br/><br/><strong><a href="%1$s/%2$s/%3$s">%1$s/%2$s/%3$s</a></strong><br/><br/>Potom musíte vložiť nasledujúci klúč pre zmenu hesla: <strong>%3$s</strong><br/><br/>Pokial ste v poslednej dobe nežiadali o zmenu hesla na %1$s, znamená to, že tento e-mail bol odoslaný omylom a môžete ho ignorovať.';
$lang['email_reset_altbody'] = 'Dobrý deň, ' . "\n\n" . 'abyste mohli zmeniť svoje heslo, musíte najprv kliknúť na následujúci odkaz :' . "\n" . '%1$s/%2$s' . "\n\n" . 'Potom musíte vložiť nasledujúci klúč pre zmenu hesla: %3$s' . "\n\n" . 'Pokial ste v poslednej dobe nežiadali o zmenu hesla na %1$s, znamená to, že tento e-mail bol odoslaný omylom a môžete ho ignorovať.';

$lang['account_deleted']   = "Účet bol úspešne zmazaný.";
$lang['function_disabled'] = "Táto funkcia bola deaktivovaná.";
