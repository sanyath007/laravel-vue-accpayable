<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Debt;
use App\Models\DebtType;
use App\Models\Creditor;
use App\Models\Payment;
use App\Models\PaymentDetail;

use App\Exports\ArrearExport;
use App\Exports\CreditorPaidExport;

class AccountController extends Controller
{
    public function arrear()
    {
    	return view('accounts.arrear', [
            "creditors" => Creditor::all(),
            "debttypes" => DebtType::all(),
    	]);
    }

    public function arrearRpt($debttype, $creditor, $sdate, $edate, $showall)
    {
        $debts = [];

        if($showall == 1) {
            $debts = \DB::table('nrhosp_acc_debt')
                            ->select('nrhosp_acc_debt.*', 'nrhosp_acc_debt_type.debt_type_name', 'nrhosp_acc_app.app_recdoc_date',
                                     'nrhosp_acc_app.app_id')
                            ->join('nrhosp_acc_debt_type', 'nrhosp_acc_debt.debt_type_id', '=', 'nrhosp_acc_debt_type.debt_type_id')
                            ->join('nrhosp_acc_app_detail', 'nrhosp_acc_debt.debt_id', '=', 'nrhosp_acc_app_detail.debt_id')
                            ->join('nrhosp_acc_app', 'nrhosp_acc_app_detail.app_id', '=', 'nrhosp_acc_app.app_id')
                            ->whereNotIn('nrhosp_acc_debt.debt_status', [2,3,4])
                            ->paginate(20);

            $totalDebt = Debt::whereNotIn('debt_status', [2,3,4])
                                ->sum('debt_total');
        } else {
            if($debttype != 0 && $creditor != 0) {
                /** 0=รอดำเนินการ,1=ขออนุมัติ,2=ตัดจ่าย,3=ยกเลิก,4=ลดหนี้ศุนย์ */
                
                $debts = Debt::whereNotIn('debt_status', [2,3,4])
                                ->where('debt_type_id', '=', $debttype)
                                ->where('supplier_id', '=', $creditor)
                                ->whereBetween('debt_date', [$sdate, $edate])
                                ->with('debttype')
                                ->paginate(20);

                $totalDebt = Debt::whereNotIn('debt_status', [2,3,4])
                                ->where('debt_type_id', '=', $debttype)
                                ->where('supplier_id', '=', $creditor)
                                ->whereBetween('debt_date', [$sdate, $edate])
                                ->sum('debt_total');
            } else {
                if($debttype != 0 && $creditor == 0) {
                    $debts = Debt::whereNotIn('debt_status', [2,3,4])
                                    ->where('debt_type_id', '=', $debttype)
                                    ->whereBetween('debt_date', [$sdate, $edate])
                                    ->with('debttype')
                                    ->paginate(20);

                    $totalDebt = Debt::whereNotIn('debt_status', [2,3,4])
                                    ->where('debt_type_id', '=', $debttype)
                                    ->whereBetween('debt_date', [$sdate, $edate])
                                    ->sum('debt_total');
                } else if($debttype == 0 && $creditor != 0) {
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

    public function arrearExcel($debttype, $creditor, $sdate, $edate, $showall)
    {
        $fileName = 'arrear-' . date('YmdHis') . '.xlsx';
        return (new ArrearExport($debttype, $creditor, $sdate, $edate, $showall))->download($fileName);
    }

    public function creditorPaid()
    {
        return view('accounts.creditor-paid', [
            "creditors" => Creditor::all(),
        ]);
    }

    public function creditorPaidRpt($creditor, $sdate, $edate, $showall)
    {
        $debts = [];

        if($showall == 1) {
            $payments = \DB::table('nrhosp_acc_payment')
                                ->select('nrhosp_acc_payment.*', 'nrhosp_acc_debt.debt_id', 'nrhosp_acc_debt.debt_type_detail', 
                                    'nrhosp_acc_debt.deliver_no', 'nrhosp_acc_debt.debt_total', 'nrhosp_acc_debt.debt_status',
                                    'nrhosp_acc_com_bank.bank_acc_no', 'nrhosp_acc_com_bank.bank_acc_name', 'nrhosp_acc_bank.bank_name',
                                    'nrhosp_acc_debt_type.debt_type_name')
                                ->join('nrhosp_acc_payment_detail', 'nrhosp_acc_payment.payment_id', '=', 'nrhosp_acc_payment_detail.payment_id')
                                ->join('nrhosp_acc_debt', 'nrhosp_acc_payment_detail.debt_id', '=', 'nrhosp_acc_debt.debt_id')
                                ->join('nrhosp_acc_debt_type', 'nrhosp_acc_debt.debt_type_id', '=', 'nrhosp_acc_debt_type.debt_type_id')
                                ->join('nrhosp_acc_com_bank', 'nrhosp_acc_payment.bank_acc_id', '=', 'nrhosp_acc_com_bank.bank_acc_id')
                                ->join('nrhosp_acc_bank', 'nrhosp_acc_com_bank.bank_id', '=', 'nrhosp_acc_bank.bank_id')
                                ->where('nrhosp_acc_payment.paid_stat', '=', 'Y')
                                ->paginate(20);

            $totalDebt = Payment::where('paid_stat', '=', 'Y')
                                ->sum('total');
        } else {
            if($creditor != 0) {
                /** 0=รอดำเนินการ,1=ขออนุมัติ,2=ตัดจ่าย,3=ยกเลิก,4=ลดหนี้ศุนย์ */
                
                $payments = \DB::table('nrhosp_acc_payment')
                                ->select('nrhosp_acc_payment.*', 'nrhosp_acc_debt.debt_id', 'nrhosp_acc_debt.debt_type_detail', 
                                    'nrhosp_acc_debt.deliver_no', 'nrhosp_acc_debt.debt_total', 'nrhosp_acc_debt.debt_status',
                                    'nrhosp_acc_com_bank.bank_acc_no', 'nrhosp_acc_com_bank.bank_acc_name', 'nrhosp_acc_bank.bank_name',
                                    'nrhosp_acc_debt_type.debt_type_name')
                                ->join('nrhosp_acc_payment_detail', 'nrhosp_acc_payment.payment_id', '=', 'nrhosp_acc_payment_detail.payment_id')
                                ->join('nrhosp_acc_debt', 'nrhosp_acc_payment_detail.debt_id', '=', 'nrhosp_acc_debt.debt_id')
                                ->join('nrhosp_acc_debt_type', 'nrhosp_acc_debt.debt_type_id', '=', 'nrhosp_acc_debt_type.debt_type_id')
                                ->join('nrhosp_acc_com_bank', 'nrhosp_acc_payment.bank_acc_id', '=', 'nrhosp_acc_com_bank.bank_acc_id')
                                ->join('nrhosp_acc_bank', 'nrhosp_acc_com_bank.bank_id', '=', 'nrhosp_acc_bank.bank_id')
                                ->where('nrhosp_acc_payment.supplier_id', '=', $creditor)
                                ->whereBetween('nrhosp_acc_payment.paid_date', [$sdate, $edate])
                                ->paginate(20);

                $totalDebt = Payment::where('paid_stat', '=', 'Y')
                                ->where('supplier_id', '=', $creditor)
                                ->whereBetween('paid_date', [$sdate, $edate])
                                ->sum('total');
            }
        }
        
        return [
            "payments"     => $payments,
            "totalDebt" => $totalDebt,
        ];
    }

    public function creditorPaidExcel($creditor, $sdate, $edate, $showall)
    {
        $fileName = 'creditor-paid-' . date('YmdHis') . '.xlsx';
        return (new CreditorPaidExport($creditor, $sdate, $edate, $showall))->download($fileName);
    }
}
