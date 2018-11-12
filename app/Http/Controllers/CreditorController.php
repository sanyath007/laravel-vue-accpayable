<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Creditor;

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
}
