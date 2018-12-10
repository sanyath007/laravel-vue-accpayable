<?php

namespace App\Exports;

use App\Models\Debt;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class ArrearExport implements FromView, WithColumnFormatting
{
    use Exportable;

    public function __construct($debttype, $creditor, $sdate, $edate, $showall)
    {
    	$this->debttype = $debttype;
    	$this->creditor = $creditor;
    	$this->sdate = $sdate;
    	$this->edate = $edate;
    	$this->showall = $showall;    	
    }

    public function view(): View
    {	$debts = [];

    	if($this->showall == '1') {
            $debts = \DB::table('nrhosp_acc_debt')
                        ->select('nrhosp_acc_debt.*', 'nrhosp_acc_debt_type.debt_type_name', 'nrhosp_acc_app.app_recdoc_date',
                                 'nrhosp_acc_app.app_id')
                        ->join('nrhosp_acc_debt_type', 'nrhosp_acc_debt.debt_type_id', '=', 'nrhosp_acc_debt_type.debt_type_id')
                        ->join('nrhosp_acc_app_detail', 'nrhosp_acc_debt.debt_id', '=', 'nrhosp_acc_app_detail.debt_id')
                        ->join('nrhosp_acc_app', 'nrhosp_acc_app_detail.app_id', '=', 'nrhosp_acc_app.app_id')
                        ->whereNotIn('nrhosp_acc_debt.debt_status', [2,3,4])
                        ->get();
        } else {
            if($this->debttype != 0 && $this->creditor != 0) {
                /** 0=รอดำเนินการ,1=ขออนุมัติ,2=ตัดจ่าย,3=ยกเลิก,4=ลดหนี้ศุนย์ */                
               $debts = \DB::table('nrhosp_acc_debt')
                            ->select('nrhosp_acc_debt.*', 'nrhosp_acc_debt_type.debt_type_name', 'nrhosp_acc_app.app_recdoc_date',
                                     'nrhosp_acc_app.app_id')
                            ->join('nrhosp_acc_debt_type', 'nrhosp_acc_debt.debt_type_id', '=', 'nrhosp_acc_debt_type.debt_type_id')
                            ->join('nrhosp_acc_app_detail', 'nrhosp_acc_debt.debt_id', '=', 'nrhosp_acc_app_detail.debt_id')
                            ->join('nrhosp_acc_app', 'nrhosp_acc_app_detail.app_id', '=', 'nrhosp_acc_app.app_id')
                            ->whereNotIn('nrhosp_acc_debt.debt_status', [2,3,4])
                            ->where('nrhosp_acc_debt.debt_type_id', '=', $this->debttype)
                            ->where('nrhosp_acc_debt.supplier_id', '=', $this->creditor)
                            ->whereBetween('nrhosp_acc_debt.debt_date', [$this->sdate, $this->edate])
                            ->get();
            } else {
                if($this->debttype != 0 && $this->creditor == 0) {
                    $debts = \DB::table('nrhosp_acc_debt')
                                ->select('nrhosp_acc_debt.*', 'nrhosp_acc_debt_type.debt_type_name', 'nrhosp_acc_app.app_recdoc_date',
                                         'nrhosp_acc_app.app_id')
                                ->join('nrhosp_acc_debt_type', 'nrhosp_acc_debt.debt_type_id', '=', 'nrhosp_acc_debt_type.debt_type_id')
                                ->join('nrhosp_acc_app_detail', 'nrhosp_acc_debt.debt_id', '=', 'nrhosp_acc_app_detail.debt_id')
                                ->join('nrhosp_acc_app', 'nrhosp_acc_app_detail.app_id', '=', 'nrhosp_acc_app.app_id')
                                ->whereNotIn('nrhosp_acc_debt.debt_status', [2,3,4])
                                ->where('nrhosp_acc_debt.debt_type_id', '=', $this->debttype)
                                ->whereBetween('nrhosp_acc_debt.debt_date', [$this->sdate, $this->edate])
                                ->get();
                } else if($this->debttype == 0 && $this->creditor != 0) {
                   $debts = \DB::table('nrhosp_acc_debt')
                                ->select('nrhosp_acc_debt.*', 'nrhosp_acc_debt_type.debt_type_name', 'nrhosp_acc_app.app_recdoc_date',
                                         'nrhosp_acc_app.app_id')
                                ->join('nrhosp_acc_debt_type', 'nrhosp_acc_debt.debt_type_id', '=', 'nrhosp_acc_debt_type.debt_type_id')
                                ->join('nrhosp_acc_app_detail', 'nrhosp_acc_debt.debt_id', '=', 'nrhosp_acc_app_detail.debt_id')
                                ->join('nrhosp_acc_app', 'nrhosp_acc_app_detail.app_id', '=', 'nrhosp_acc_app.app_id')
                                ->whereNotIn('nrhosp_acc_debt.debt_status', [2,3,4])
                                ->where('nrhosp_acc_debt.supplier_id', '=', $this->creditor)
                                ->whereBetween('nrhosp_acc_debt.debt_date', [$this->sdate, $this->edate])
                                ->get();
                }   
            }   
        }

        return view('exports.arrear-excel', [
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