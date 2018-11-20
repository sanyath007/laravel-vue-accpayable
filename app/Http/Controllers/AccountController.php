<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Debt;
use App\Models\DebtType;
use App\Models\Creditor;

class AccountController extends Controller
{
    public function arrear()
    {
    	$debts = Debt::with('debttype')->paginate(20);
    	// dd($creditors);

    	return view('accounts.arrear', [
            "creditors" => Creditor::all(),
            "debttypes" => DebtType::all(),
    	]);
    }

    public function arrearRpt($creditor, $sdate, $edate, $showall)
    {
        $totalDebt = Debt::where('supplier_id', '=', $creditor)->sum('debt_total');
        
        return [
            "debts"     => Debt::where('supplier_id', '=', $creditor)->with('debttype')->paginate(20),
            "totalDebt" => $totalDebt,
        ];
    }
}
