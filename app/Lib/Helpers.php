<?php
namespace App\Lib;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Transport\Dsn;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransportFactory;

class Helpers {

    static public function bootProviders(){

        try{
            //setup email
            $protocol = setting('mail_protocol');
            if($protocol=='smtp'){
                config([
                    'mail.driver' => 'smtp',
                    'mail.host' => setting('mail_smtp_host'),
                    'mail.port' => setting('mail_smtp_port'),
                    'mail.encryption' =>'tls',
                    'mail.username' => setting('mail_smtp_username'),
                    'mail.password' => setting('mail_smtp_password')
                ]);

                $dsn = new Dsn(
                    env('MAIL_ENCRYPTION','tls'),setting('mail_smtp_host'),setting('mail_smtp_username'),setting('mail_smtp_password'),setting('mail_smtp_port')
                );
                $factory = new EsmtpTransportFactory;
                $transport = $factory->create($dsn);

                Mail::mailer()->setSymfonyTransport($transport);
            }

            //set language
            $language = setting('config_language');
            if($language != 'en'){
                App::setLocale($language);
                Carbon::setLocale($language);
            }

            //set the timezone
            $timezone = setting('config_timezone');
            if(empty($timezone)){
                $timezone = 'UTC';
            }
            date_default_timezone_set($timezone);
        }
        catch(\Exception $ex){

        }



                validateFolder(ATTACHMENTS);
                validateFolder(DEPARTMENTS);
                validateFolder(DOWNLOADS);
                validateFolder(FORUM);
                validateFolder(GALLERIES);
                validateFolder(IMAGES);
                validateFolder(MEMBERS);
                validateFolder(SETTINGS);

                if(!file_exists(TEMP_DIR)){
                    rmkdir(TEMP_DIR);
                }




    }

}
