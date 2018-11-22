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
            $debts = Debt::whereNotIn('debt_status', [2,3,4])
                            ->with('debttype')->get();
        } else {
            if($this->debttype != 0 && $this->creditor != 0) {
                /** 0=รอดำเนินการ,1=ขออนุมัติ,2=ตัดจ่าย,3=ยกเลิก,4=ลดหนี้ศุนย์ */                
                $debts = Debt::whereNotIn('debt_status', [2,3,4])
                                ->where('debt_type_id', '=', $this->debttype)
                                ->where('supplier_id', '=', $this->creditor)
                                ->whereBetween('debt_date', [$this->sdate, $this->edate])
                                ->with('debttype')->get();
            } else {
                if($this->debttype != 0 && $this->creditor == 0) {
                    $debts = Debt::whereNotIn('debt_status', [2,3,4])
                                    ->where('debt_type_id', '=', $this->debttype)
                                    ->whereBetween('debt_date', [$this->sdate, $this->edate])
                                    ->with('debttype')->get();
                } else if($this->debttype == 0 && $this->creditor != 0) {
                    $debts = Debt::whereNotIn('debt_status', [2,3,4])
                                    ->where('supplier_id', '=', $this->creditor)
                                    ->whereBetween('debt_date', [$this->sdate, $this->edate])
                                    ->with('debttype')->get();
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