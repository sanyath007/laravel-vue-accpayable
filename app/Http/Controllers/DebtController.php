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
            "debts"     => Debt::where('supplier_id', '=', $creditor)
                                ->where('debt_status', '=', '0')
                                ->with('debttype')
                                ->paginate(20),
            "apps"     => Debt::where('supplier_id', '=', $creditor)
                                ->where('debt_status', '=', '1')
                                ->with('debttype')
                                ->paginate(20),
            "paids"     => Debt::where('supplier_id', '=', $creditor)
                                ->whereIn('debt_status', [2,4])
                                ->with('debttype')
                                ->paginate(20),
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

    public function setZero(Request $req)
    {
        if(Debt::where('debt_id', '=', $req['debt_id'])->update(['debt_status' => '4']) <> 0) {
            return [
                'status' => 'success',
                'message' => 'Updated id ' . $req['debt_id'] . 'is successed.',
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Updated id ' . $req['debt_id'] . 'is failed.',
            ];
        }
    }
}
