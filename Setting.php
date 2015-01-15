<?php

namespace funson86\setting;
use Yii;
use funson86\setting\models\Setting;

class Settings extends \yii\base\Component
{
    public function get($code)
    {
        if(!$code) return ;

        $setting = Setting::find()->where(['code' => $code])->one();

        if($setting)
            return $setting->value;
        else
            return ;
    }

}
