<?php
    namespace app\models;
    use yii\db\ActiveRecord;
    
    class Service_info extends ActiveRecord{
        private $name;
        private $price;

        public function rules(){
            return[
                [["name", "price"], "required"]
            ];
        }

        public function getLaborInfos(){
            return $this->hasMany(Labor_info::class, ["service_id" => "id"]);
        }
    }
?>