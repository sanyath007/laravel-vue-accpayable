<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Debt;

class DebtController extends Controller
{
    public function list()
    {
    	$debts = Debt::with('debttype')->paginate(20);
    	// dd($creditors);

    	return view('debts.list', [
    		'debts' => $debts,
    	]);
    }

    public function add()
    {
    	$debts = Debt::paginate(20);
    	// dd($creditors);

    	return view('debts.list', [
    		'debts' => $debts,
    	]);
    }
}
