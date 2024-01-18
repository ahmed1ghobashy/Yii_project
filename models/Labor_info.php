<?php
    namespace app\models;
    use yii\db\ActiveRecord;

    class Labor_info extends ActiveRecord{
        private $name;
        private $service_id;

        public function rules(){
            return[
                [["name", "service_id"], "required"]
            ];
        }

        public function getServiceInfo(){
            return $this->hasOne(Service_info::class, ["id" => "service_id"]);
        }
    }
?>