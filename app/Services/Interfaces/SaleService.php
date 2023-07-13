<?php


namespace App\Services\Interfaces;


use App\Models\Sale;
use Illuminate\Http\Request;

interface SaleService
{

    public function save(Request $request): Sale;
}
