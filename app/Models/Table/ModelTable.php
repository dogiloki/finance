<?php

namespace App\Models\Table;

class ModelTable{

    private $columns=[];
    private $rows=[];
    private $rows_format=[];

    public function __construct(){
        
    }

    // Columnas

    public function getColumns(): array{
        return $this->columns;
    }

    public function addColumn(string $name, $field=null): void{
        if($field==null){
            $this->columns[]=$name;
        }else{
            $this->columns[$field]=$name;
        }
    }   
    
    public function removeColumn(string|int $column): void{
        unset($this->columns[$column]);
    }

    // Filas

    public function getRows(): array{
        return $this->rows;
    }

    public function getRow(int $index): array{
        return $this->rows[$index]??[];
    }

    public function addRow(array $row): void{
        $row_new=[];
        foreach($this->columns as $key=>$value){
            $row_new[$key]=$row[$key]??null;
        }
        $this->rows[]=$row_new;
    }

    public function removeRow(int $index): void{
        unset($this->rows[$index]);
        unset($this->rows_format[$index]);
    }

    // Filas con formato

    public function getRowsFormat(): array{
        return $this->rows_format;
    }

    public function getRowFormat(int $index): array{
        return $this->rows_format[$index]??[];
    }

    public function addRowFormat(array $row): void{
        $row_new=[];
        foreach($this->columns as $key=>$value){
            $row_new[$key]=$row[$key]??null;
        }
        $this->rows_format[]=$row_new;
    }

    // Obterner valores

    public function getValueAt(int $row, string|int $column){
        return $this->rows[$row][$column]??'';
    }

    public function getValueFormatAt(int $row, string|int $column){
        return $this->getRowFormat[$row][$column]??'';
    }

    public function setValueAt(int $row, string|int $column, $value): void{
        $this->rows[$row][$column]=$value;
    }

    public function setValueFormatAt(int $row, string|int $column, $value): void{
        $this->rows_format[$row][$column]=$value;
    }

}

?>