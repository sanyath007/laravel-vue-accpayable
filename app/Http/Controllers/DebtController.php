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
    	return view('debts.add', [
    		"creditor" => Creditor::where('supplier_id', '=', $creditor)->first(),
            "debttypes" => DebtType::all(),
    	]);
    }

    public function store(Request $req)
    {

    }

    public function edit($creditor, $debtId)
    {
        return view('debts.edit', [
            "creditor" => Creditor::where('supplier_id', '=', $creditor)->first(),
            "debt" => Debt::where('debt_id', '=', $debtId)->first(),
            "debttypes" => DebtType::all(),
        ]);
    }

    public function update(Request $req)
    {
        
    }

    public function delete(Request $req)
    {
        
    }
}
