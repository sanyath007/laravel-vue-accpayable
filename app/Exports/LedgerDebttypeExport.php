<?php

namespace App\Exports;

use App\Models\Debt;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class LedgerDebttypeExport implements FromView, WithColumnFormatting
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

    	$sql = "SELECT d.debt_type_id, dt.debt_type_name,
                SUM(debt_total) as debit,
                SUM(pd.rcpamt) as credit
                FROM nrhosp_acc_debt d 
                LEFT JOIN nrhosp_acc_debt_type dt ON (d.debt_type_id=dt.debt_type_id)
                LEFT JOIN nrhosp_acc_payment_detail pd ON (d.debt_id=pd.debt_id) 
                WHERE (d.debt_status NOT IN ('3','4')) ";

        if($this->showall == '0') {
            $sql .= "AND (d.debt_date BETWEEN '$this->sdate' AND '$this->edate') ";
        }

        $sql .= "GROUP BY d.debt_type_id, dt.debt_type_name
                 ORDER BY debt_type_id";

        $debts = \DB::select($sql);

        return view('exports.ledger-debttype-excel', [
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