<?php

namespace App\Exports;

use App\Models\Debt;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class LedgerExport implements FromView, WithColumnFormatting
{
    use Exportable;

    public function __construct($sdate, $edate, $showall)
    {
    	$this->sdate = $sdate;
    	$this->edate = $edate;
    	$this->showall = $showall;    	
    }

    public function view(): View
    {	
        $debts = [];

    	if($this->showall == '1') {
            $debts = \DB::table('nrhosp_acc_debt')
                            ->select('nrhosp_acc_debt.*', 'nrhosp_acc_debt_type.debt_type_name', 'nrhosp_acc_payment_detail.cheque_amt',
                                     'nrhosp_acc_payment_detail.rcpamt', 'nrhosp_acc_payment.cheque_no', 'nrhosp_acc_payment.payment_id')
                            ->leftJoin('nrhosp_acc_debt_type', 'nrhosp_acc_debt.debt_type_id', '=', 'nrhosp_acc_debt_type.debt_type_id')
                            ->leftJoin('nrhosp_acc_payment_detail', 'nrhosp_acc_debt.debt_id', '=', 'nrhosp_acc_payment_detail.debt_id')
                            ->leftJoin('nrhosp_acc_payment', 'nrhosp_acc_payment_detail.payment_id', '=', 'nrhosp_acc_payment.payment_id')
                            ->whereNotIn('nrhosp_acc_debt.debt_status', [3,4])
                            ->whereBetween('nrhosp_acc_debt.debt_date', [$this->sdate, $this->edate])
                            ->get();

            $subQuery = \DB::table('nrhosp_acc_debt')
                            ->select('nrhosp_acc_debt.supplier_id', 'nrhosp_acc_debt.supplier_name')
                            ->whereBetween('nrhosp_acc_debt.debt_date', [$this->sdate, $this->edate])
                            ->groupBy('nrhosp_acc_debt.supplier_id', 'nrhosp_acc_debt.supplier_name');

            $creditors = \DB::table(\DB::raw("(" .$subQuery->toSql() . ") as creditors"))
                            ->mergeBindings($subQuery)
                            ->get();
        } else {
            $debts = \DB::table('nrhosp_acc_debt')
                            ->select('nrhosp_acc_debt.*', 'nrhosp_acc_debt_type.debt_type_name', 'nrhosp_acc_payment_detail.cheque_amt',
                                     'nrhosp_acc_payment_detail.rcpamt', 'nrhosp_acc_payment.cheque_no', 'nrhosp_acc_payment.payment_id')
                            ->leftJoin('nrhosp_acc_debt_type', 'nrhosp_acc_debt.debt_type_id', '=', 'nrhosp_acc_debt_type.debt_type_id')
                            ->leftJoin('nrhosp_acc_payment_detail', 'nrhosp_acc_debt.debt_id', '=', 'nrhosp_acc_payment_detail.debt_id')
                            ->leftJoin('nrhosp_acc_payment', 'nrhosp_acc_payment_detail.payment_id', '=', 'nrhosp_acc_payment.payment_id')
                            ->whereNotIn('nrhosp_acc_debt.debt_status', [3,4])
                            ->whereBetween('nrhosp_acc_debt.debt_date', [$this->sdate, $this->edate])
                            ->get();

            $subQuery = \DB::table('nrhosp_acc_debt')
                            ->select('nrhosp_acc_debt.supplier_id', 'nrhosp_acc_debt.supplier_name')
                            ->whereBetween('nrhosp_acc_debt.debt_date', [$this->sdate, $this->edate])
                            ->groupBy('nrhosp_acc_debt.supplier_id', 'nrhosp_acc_debt.supplier_name');

            $creditors = \DB::table(\DB::raw("(" .$subQuery->toSql() . ") as creditors"))
                            ->mergeBindings($subQuery)
                            ->get();   
        }

        return view('exports.ledger-excel', [
            "creditors" => $creditors,
            'debts' => $debts,
        ]);
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'H' => '@',
        ];
    }
}