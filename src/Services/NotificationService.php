<?php

namespace TomatoPHP\FilamentAlerts\Services;

class NotificationService
{


    public function __construct(
        private \TomatoPHP\FilamentAlerts\Models\UserToken $model
    )
    {}

    public function update(string $token,int $id):void{
        $deviceToken =    $this->model->where('model_id',$id)->first();
        if($deviceToken){
            $deviceToken->update([
                'provider_token' =>  $token
            ]);

        }
    }


    public function store(string $token,int $id):void{

        $this->model->updateOrCreate(
            [
                "model_id"=>$id,
            ],
            [
                "model_type"=>'TomatoPHP\TomatoCrm\Models\Account',
                "model_id"=>$id,
                "provider"=>"fcm-api ",
                "provider_token"=>$token
            ]);

    }

    public function delete( int $id):void{
        $this->model->where('model_id',$id)->delete();
    }

    public function isChecked(int $id,string $class){
        $this->model->where('model_id',$id)->delete();

    }
}
