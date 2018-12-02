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
    	return view('debts.list', [
            "creditors" => Creditor::all(),
    	]);
    }

    public function debtRpt($creditor, $sdate, $edate, $showall)
    {
        if($showall == 1) {
            $debts = Debt::where('supplier_id', '=', $creditor)
                            ->where('debt_status', '=', '0')
                            ->with('debttype')
                            ->paginate(20);
            $apps = Debt::where('supplier_id', '=', $creditor)
                            ->where('debt_status', '=', '1')
                            ->with('debttype')
                            ->paginate(20);
            $paids = Debt::where('supplier_id', '=', $creditor)
                            ->whereIn('debt_status', [2,4])
                            ->with('debttype')
                            ->paginate(20);
        } else {
            $debts = Debt::where('supplier_id', '=', $creditor)
                            ->where('debt_status', '=', '0')
                            ->whereBetween('debt_date', [$sdate, $edate])
                            ->with('debttype')
                            ->paginate(20);
            $apps =  Debt::where('supplier_id', '=', $creditor)
                            ->where('debt_status', '=', '1')
                            ->whereBetween('debt_date', [$sdate, $edate])
                            ->with('debttype')
                            ->paginate(20);
            $paids = Debt::where('supplier_id', '=', $creditor)
                            ->whereIn('debt_status', [2,4])
                            ->whereBetween('debt_date', [$sdate, $edate])
                            ->with('debttype')
                            ->paginate(20);
        }

        $totalDebt = Debt::where('supplier_id', '=', $creditor)->sum('debt_total');
        
        return [
            "debts"     => $debts,
            "apps"      => $apps,
            "paids"     => $paids,
            "totalDebt" => $totalDebt,
        ];
    }

    private function generateAutoId()
    {
        $supplier = \DB::table('stock_supplier')
                        ->select('supplier_id')
                        ->orderBy('supplier_id', 'DESC')
                        ->first();

        $tmpLastId =  ((int)($supplier->supplier_id)) + 1;
        $lastId = sprintf("%'.05d", $tmpLastId);

        return $lastId;
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

    public function getById($debtId)
    {
        return [
            'debt' => Debt::find($debtId),
        ];
    }

    public function edit($creditor, $debtId)
    {
        return view('debts.edit', [
            "creditor" => Creditor::where('supplier_id', '=', $creditor)->first(),
            'debt' => Debt::find($debtId),
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
