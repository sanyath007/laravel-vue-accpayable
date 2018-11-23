<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Creditor;
use App\Models\SupplierPrefix;

class CreditorController extends Controller
{
    public function list()
    {
    	$creditors = Creditor::paginate(20);
    	// dd($creditors);

    	return view('creditors.list', [
    		'creditors' => $creditors,
    	]);
    }

    public function add()
    {
    	return view('creditors.add', [
            'prefixs' => SupplierPrefix::all(),
    	]);
    }

    private function generateAutoId()
    {
        return \DB::table('stock_supplier')
                        ->select('supplier_id')
                        ->orderBy('supplier_id', 'DESC')
                        ->first();
    }

    public function store(Request $req)
    {
        // $this->generateAutoId()->supplier_id;
    }
}
