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

    public function arrearRpt($debttypes, $creditor, $sdate, $edate, $showall)
    {
        $debts = [];

        if($showall == 1) {
            $debts = Debt::whereNotIn('debt_status', [2,3,4])
                            ->with('debttype')
                            ->paginate(20);

            $totalDebt = Debt::whereNotIn('debt_status', [2,3,4])
                                ->sum('debt_total');
        } else {
            if($debttypes != 0 && $creditor != 0) {
                /** 0=รอดำเนินการ,1=ขออนุมัติ,2=ตัดจ่าย,3=ยกเลิก,4=ลดหนี้ศุนย์ */
                
                $debts = Debt::whereNotIn('debt_status', [2,3,4])
                                ->where('debt_type_id', '=', $debttypes)
                                ->where('supplier_id', '=', $creditor)
                                ->whereBetween('debt_date', [$sdate, $edate])
                                ->with('debttype')
                                ->paginate(20);

                $totalDebt = Debt::whereNotIn('debt_status', [2,3,4])
                                ->where('debt_type_id', '=', $debttypes)
                                ->where('supplier_id', '=', $creditor)
                                ->whereBetween('debt_date', [$sdate, $edate])
                                ->sum('debt_total');
            } else {
                if($debttypes != 0 && $creditor == 0) {
                    $debts = Debt::whereNotIn('debt_status', [2,3,4])
                                    ->where('debt_type_id', '=', $debttypes)
                                    ->whereBetween('debt_date', [$sdate, $edate])
                                    ->with('debttype')
                                    ->paginate(20);

                    $totalDebt = Debt::whereNotIn('debt_status', [2,3,4])
                                    ->where('debt_type_id', '=', $debttypes)
                                    ->whereBetween('debt_date', [$sdate, $edate])
                                    ->sum('debt_total');
                } else if($debttypes == 0 && $creditor != 0) {
                    $debts = Debt::whereNotIn('debt_status', [2,3,4])
                                    ->where('supplier_id', '=', $creditor)
                                    ->whereBetween('debt_date', [$sdate, $edate])
                                    ->with('debttype')
                                    ->paginate(20);

                    $totalDebt = Debt::whereNotIn('debt_status', [2,3,4])
                                    ->where('supplier_id', '=', $creditor)
                                    ->whereBetween('debt_date', [$sdate, $edate])
                                    ->sum('debt_total');
                }   
            }   
        }
        
        return [
            "debts"     => $debts,
            "totalDebt" => $totalDebt,
        ];
    }
}
