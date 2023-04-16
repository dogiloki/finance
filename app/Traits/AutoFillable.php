<?php

namespace App\Traits;

trait AutoFillable{

    public function run(){
        $this->fillable=$this->getFillable();
    }

    public function getFillable(){
        $fillable=[];
        $columns=$this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        foreach($columns as $column){
            if($column!=$this->getKeyName()){
                $fillable[]=$column;
            }
        }
        return $fillable;
    }

}

?>