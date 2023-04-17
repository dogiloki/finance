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

    public function countColumns(): int{
        return count($this->columns);
    }

    // Filas

    public function getRows(): array{
        return $this->rows;
    }

    public function getRow(int $index): array{
        return $this->rows[$index]??[];
    }

    public function addRow(array $row, array $rows_format=null): void{
        $row_new=[];
        $row_format_new=[];
        foreach($this->columns as $key=>$value){
            $row_new[$key]=$row[$key]??null;
            $row_format_new[$key]=$rows_format[$key]??$row_new[$key];
        }
        $this->rows[]=$row_new;
        $this->rows_format[]=$row_format_new;
    }

    public function removeRow(int $index): void{
        unset($this->rows[$index]);
        unset($this->rows_format[$index]);
    }

    public function countRows(): int{
        return count($this->rows);
    }

    public function getRowsFormat(): array{
        return $this->rows_format;
    }

    public function getRowFormat(int $index): array{
        return $this->rows_format[$index]??[];
    }

    public function countRowsFormat(): int{
        return count($this->rows_format);
    }

    // Obterner valores

    public function getValueAt(int $row, string|int $column){
        return $this->rows[$row][$column]??null;
    }

    public function getValueFormatAt(int $row, string|int $column){
        return $this->rows_format[$row][$column]??null;
    }

    public function setValueAt(int $row, string|int $column, $value): void{
        $this->rows[$row][$column]=$value;
    }

    public function setValueFormatAt(int $row, string|int $column, $value): void{
        $this->rows_format[$row][$column]=$value;
    }

    // Otras fucnionalidades

    public function isEmpty(): bool{
        return $this->countRows()==0;
    }

    public function clear(): void{
        $this->columns=[];
        $this->rows=[];
        $this->rows_format=[];
    }

    public function toArray(): array{
        return [
            'columns'=>$this->columns,
            'rows'=>$this->rows,
            'rows_format'=>$this->rows_format
        ];
    }

    // public function operation(string|int $column, string $operator): float{
    //     $result=0;
    //     foreach($this->rows as $row){
    //         if(is_numeric($row[$column])){
    //             $result=floatval(eval("return ".$result.$operator.$row[$column].";"));
    //         }
    //     }
    //     return $result;
    // }

    public function promedio(string|int $column): float{
        $suma=0;
        foreach($this->rows as $row){
            $suma+=$row[$column];
        }
        return $suma/$this->countRows();
    }

    public function getTotals($action=null): array{
        $totals=[];
        foreach($this->columns as $column_key=>$column_value){
            $totals[$column_key]=0;
            foreach($this->rows as $row_key=>$row_value){
                if(!is_numeric($row_value[$column_key])){
                    $totals[$column_key]=null;
                    continue 2;
                }
                $totals[$column_key]=floatval($totals[$column_key])+$row_value[$column_key];
            }
            if($action instanceof \Closure){
                $totals[$column_key]=$action($totals[$column_key]);
            }
        }
        return $totals;
    }

}

?>