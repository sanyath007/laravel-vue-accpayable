<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Debt;
use App\Models\DebtType;
use App\Models\Creditor;


class DebtController extends Controller
{
    public function list()
    {
    	$debts = Debt::with('debttype')->paginate(20);
    	// dd($creditors);

    	return view('debts.list', [
            "creditors" => Creditor::all(),
    	]);
    }

    public function debtRpt($creditor, $sdate, $edate, $showall)
    {
        $totalDebt = Debt::where('supplier_id', '=', $creditor)->sum('debt_total');
        
        return [
            "debts"     => Debt::where('supplier_id', '=', $creditor)->with('debttype')->paginate(20),
            "totalDebt" => $totalDebt,
        ];
    }

    public function add($creditor)
    {
    	$debts = Debt::paginate(20);

    	return view('debts.add', [
    		"creditor" => Creditor::where('supplier_id', '=', $creditor)->first(),
            "debttypes" => DebtType::all(),
    	]);
    }
}
