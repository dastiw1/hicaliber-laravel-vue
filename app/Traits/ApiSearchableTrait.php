<?php


namespace App\Traits;


trait ApiSearchableTrait
{
    /*
     * You must declare $searchableFields array
     * public $searchableFields = [
            'name' => 'partial',
    ];*/


    protected function makeWhereClauses(array $input = null)
    {
        $clauses = [];
        if ($input == null) {
            return [];
        }

        foreach ($input as $key => $requestValue) {
            if (isset($this->searchableFields[$key])) {
                switch ($this->searchableFields[$key]) {
                    case 'partial':
                        $operator = 'like';
                        $value = "%" . trim($requestValue) . "%";

                        break;
                    case 'exact':
                        $operator = '=';
                        $value = $requestValue;
                        break;

                }
                if (isset($operator) && isset($value)) {
                    $clauses[] = [
                        $key,
                        $operator,
                        $value

                    ];
                }


            }

        };

        return $clauses;
    }
}
