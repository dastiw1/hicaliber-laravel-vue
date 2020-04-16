<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Traits\ApiSearchableTrait;
use Illuminate\Http\Request;

class HousesController extends Controller
{
    //
    use ApiSearchableTrait;

    public $searchableFields = [
        'name' => 'partial',
        'price' => 'exact',
        'bedrooms' => 'exact',
        'bathrooms' => 'exact',
        'storeys' => 'exact',
        'garages' => 'exact',
    ];

    public function index(Request $request)
    {
        $input = $request->only(array_keys($this->searchableFields));

        $data = House::where($this->makeWhereClauses($input))->get();


        return response()->json($data);
    }
}
