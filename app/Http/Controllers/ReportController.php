<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DebtType;
use App\Models\Creditor;

class ReportController extends Controller
{
    public function debtCreditor()
    {
    	return view('reports.debt-creditor', [
    		"creditors" => Creditor::all(),
    	]);
    }

    public function debtCreditorRpt($creditor, $sdate, $edate, $showall)
    {
        $sql = "SELECT b.debt_id,b.debt_date,b.deliver_no,c.debt_type_name,b.debt_type_detail,";
        $sql .= "b.supplier_id,b.supplier_name,b.debt_amount,b.debt_vatrate,b.debt_vat,b.debt_total, ";
        $sql .= "CASE WHEN (b.debt_status='0') THEN 'ตั้งหนี้' ";
        $sql .= "WHEN (b.debt_status='1') THEN 'ขออนุมัติ' ";
        $sql .= "WHEN (b.debt_status='2') THEN 'ตัดจ่าย' END AS debt_status ";
        $sql .= "FROM nrhosp_acc_debt b ";
        $sql .= "LEFT JOIN nrhosp_acc_debt_type c ON (b.debt_type_id=c.debt_type_id)";
        $sql .= "WHERE (b.supplier_id='$creditor')";
        //$sql .= "AND (b.debt_status='0')"";

        if($showall == 0) {
            $sql .= "AND (b.debt_date BETWEEN '$sdate' AND '$edate')";
        }

        $sql .= "ORDER BY b.supplier_id, b.debt_date ";

        return \DB::select($sql);
    }

    public function debtDebttype()
    {
    	return view('reports.debt-debttype', [
    		"debttypes" => DebtType::all(),
    	]);
    }

    public function debtDebttypeRpt($debttype, $sdate, $edate, $showall)
    {
    	// $sdate = $month . '-01';
     	// $edate = date("Y-m-t", strtotime($sdate));

        $sql = "SELECT b.debt_id,b.debt_date,b.deliver_no,c.debt_type_name,b.debt_type_detail,";
        $sql .= "b.supplier_id,b.supplier_name,b.debt_amount,b.debt_vatrate,b.debt_vat,b.debt_total, ";
        $sql .= "CASE WHEN (b.debt_status='0') THEN 'ตั้งหนี้' ";
        $sql .= "WHEN (b.debt_status='1') THEN 'ขออนุมัติ' ";
        $sql .= "WHEN (b.debt_status='2') THEN 'ตัดจ่าย' END AS debt_status, pa.paid_date ";
        $sql .= "FROM nrhosp_acc_debt b ";
        $sql .= "LEFT JOIN nrhosp_acc_debt_type c ON (b.debt_type_id=c.debt_type_id)";
        $sql .= "LEFT JOIN (SELECT pd.debt_id, p.paid_date, p.cheque_no, p.cheque_date FROM nrhosp_acc_payment_detail pd
LEFT JOIN nrhosp_acc_payment p ON (pd.payment_id=p.payment_id)) AS pa ON (b.debt_id=pa.debt_id)";
        $sql .= "WHERE (b.debt_type_id='$debttype')";
        //$sql .= "AND (b.debt_status='0')"";

        if($showall == 0) {
            $sql .= "AND (b.debt_date BETWEEN '$sdate' AND '$edate')";
        }

        $sql .= "ORDER BY b.supplier_id, b.debt_date ";

        return \DB::select($sql);
    }

    public function excel()
    {
        return view('reports.excel');
    }

    public function debtChart($month)
    {
        $sql = "SELECT
                SUM(CASE WHEN (debt_status IN ('0','1')) THEN debt_total END) as debt, 
                SUM(CASE WHEN (debt_status IN ('2','4')) THEN debt_total END) as paid
                FROM nrhosp_acc_debt
                WHERE (supplier_id='00058') ";

        return \DB::select($sql);
    }
}
