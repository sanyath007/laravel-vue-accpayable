<?php

namespace App\Exports;

use App\Models\Debt;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class DebttypeExport implements FromView, WithColumnFormatting
{
    use Exportable;

    public function __construct($debttype, $sdate, $edate, $showall)
    {
    	$this->debttype = $debttype;
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
        $sql .= "WHEN (b.debt_status='2') THEN 'ตัดจ่าย' END AS debt_status "; //, pa.paid_date 
        $sql .= "FROM nrhosp_acc_debt b ";
        $sql .= "LEFT JOIN nrhosp_acc_debt_type c ON (b.debt_type_id=c.debt_type_id)";
        /*$sql .= "LEFT JOIN ("; 
            $sql .= "SELECT pd.debt_id, p.paid_date, p.cheque_no, p.cheque_date ";
            $sql .= "FROM nrhosp_acc_payment_detail pd ";
            $sql .= "LEFT JOIN nrhosp_acc_payment p ON (pd.payment_id=p.payment_id)";
        $sql .= ") AS pa ON (b.debt_id=pa.debt_id)";*/        
        $sql .= "WHERE (b.debt_status IN ('0', '1'))";

        if($this->debttype != 0) {
            $sql .= "AND (b.debt_type_id='$this->debttype')";
        }

        if($this->showall == 0) {
            $sql .= "AND (b.debt_date BETWEEN '$this->sdate' AND '$this->edate')";
        }

        $sql .= "ORDER BY b.supplier_id, b.debt_date ";

        $debts = \DB::select($sql);

        return view('exports.debt-debttype-excel', [
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