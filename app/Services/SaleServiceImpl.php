<?php


namespace App\Services;


use App\Models\Sale;
use App\Services\Interfaces\SaleService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SaleServiceImpl implements SaleService
{
    public function save(Request $request): Sale
    {
        $data = $request->all();

        if ($data['type'] === 'school') {
            $data['type'] = Sale::SALE_TYPE;
        } else {
            $data['type'] = null;
        }

        $sale = $request->has('id')
            ? Sale::find($request->id)
            : new Sale()
        ;

        $sale->fill($data);
        $sale->save();

        return $sale;
    }
}
