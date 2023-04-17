<?php

namespace App\Models\Table;

class ModelTable{

    private $columns=[];
    private $rows=[];

    public function __construct(){
        
    }

    public function getColumns(): array{
        return $this->columns;
    }

    public function getRows(): array{
        return $this->rows;
    }

    public function getRow(int $index): array{
        return $this->rows[$index]??[];
    }

    public function getValueAt(int $row, string|int $column){
        return $this->rows[$row][$column]??'';
    }

    public function addColumn(string $name, $field=null): void{
        if($field==null){
            $this->columns[]=$name;
        }else{
            $this->columns[$field]=$name;
        }
    }

    public function addRow(array $row): void{
        $row_new=[];
        foreach($this->columns as $key=>$value){
            $row_new[$key]=$row[$key]??null;
        }
        $this->rows[]=$row_new;
    }

}

?>