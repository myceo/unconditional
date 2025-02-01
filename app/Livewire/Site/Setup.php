<?php

namespace App\Livewire\Site;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Setup extends Component
{
    public string $code;
    public string $message = '';

    public function render()
    { //
        $url = url('/');
        $basePath = parse_url($url, PHP_URL_PATH);
        if (!empty($basePath)){
            $this->message = __('site.'.'i'.'er',['dir'=>$basePath]);
        }

        return view('livewire.site.setup')->title(__('site.'.cmb(['p','c','v'])));
    }



    public function submit(){

       $this->message='';
        $this->validate([
            'code'=>'required|min:20'
        ]);

        $code = trim($this->code);
        if (!preg_match("/^([a-f0-9]{8})-(([a-f0-9]{4})-){3}([a-f0-9]{12})$/i", $code)) {
            $this->message = __('site.ipc');
            return;
        }
        $url = cmb(['htt','ps',':','//','int','erm','ati','cs','ng','.co','m','/a','pi/','en','va','to/','ve','ri','fy']);

        try {

            //call api on code
            $response = Http::timeout(10)->post($url, [
                'code' => $this->code,
                'item' => config('app.app_id'),
            ]);

            $data = $response->json();
            if($data['status']==true){
                if(!file_exists(dirname(getCFP()))) mkdir(dirname(getCFP()), 0777, true);  file_put_contents(getCFP(),$this->code);

                if(file_exists(getCFP())){
                    $this->redirect('/');
                }
                else{
                    $this->message = __('site.'.cmb(['u','t','s']));
                }

            }
            else{
                $this->message = $data['message'];
            }
        }
        catch (\Exception $exception){

            $this->message = __('site.'.cmb(['u','t','v'])).': '.str_replace($url,'',str_replace(getCFP(),'',$exception->getMessage()));
        }


    }
}
