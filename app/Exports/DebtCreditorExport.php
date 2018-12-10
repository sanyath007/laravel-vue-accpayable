<?php

namespace App\Exports;

use App\Models\Debt;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class DebtCreditorExport implements FromView, WithColumnFormatting
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

    	$sql = "SELECT b.debt_id,b.debt_date,b.deliver_no,c.debt_type_name,b.debt_type_detail,";
        $sql .= "b.supplier_id,b.supplier_name,b.debt_amount,b.debt_vatrate,b.debt_vat,b.debt_total, ";
        $sql .= "CASE WHEN (b.debt_status='0') THEN 'ตั้งหนี้' ";
        $sql .= "WHEN (b.debt_status='1') THEN 'ขออนุมัติ' ";
        $sql .= "WHEN (b.debt_status='2') THEN 'ตัดจ่าย' END AS debt_status ";
        $sql .= "FROM nrhosp_acc_debt b ";
        $sql .= "LEFT JOIN nrhosp_acc_debt_type c ON (b.debt_type_id=c.debt_type_id)";
        $sql .= "WHERE (b.debt_status IN ('0', '1'))";

        if($this->creditor != 0) {
            $sql .= "AND (b.supplier_id='$this->creditor')";
        } 

        if($this->showall == 0) {
            $sql .= "AND (b.debt_date BETWEEN '$this->sdate' AND '$this->edate')";
        }

        $sql .= "ORDER BY b.debt_date ";

        $debts = \DB::select($sql);

        return view('exports.debt-creditor-excel', [
            'debts' => $debts,
        ]);
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'D' => '@',
        ];
    }
}