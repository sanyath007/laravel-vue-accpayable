<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class CreditorPaidExport implements FromView, WithColumnFormatting
{
    use Exportable;

    public function __construct($creditor, $sdate, $edate, $showall)
    {
    	$this->creditor = $creditor;
    	$this->sdate = $sdate;
    	$this->edate = $edate;
    	$this->showall = $showall;    	
    }

    public function view(): View
    {	
        $debts = [];

    	if($this->showall == '1') {
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
                                ->get();
        } else {
            if($this->creditor != 0) {                
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
                                ->where('nrhosp_acc_payment.supplier_id', '=', $this->creditor)
                                ->whereBetween('nrhosp_acc_payment.paid_date', [$this->sdate, $this->edate])
                                ->get();
            }
        }

        return view('exports.creditor-paid-excel', [
            'payments' => $payments,
        ]);
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'D' => '@',
            'E' => '@',
        ];
    }
}