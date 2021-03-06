<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Debt;
use App\Models\DebtType;
use App\Models\Creditor;


class DebtController extends Controller
{
    /** 0=รอดำเนินการ,1=ขออนุมัติ,2=ตัดจ่าย,3=ยกเลิก,4=ลดหนี้ศุนย์ */
    
    public function list()
    {
        return [
            "suppliers" => Creditor::all(),
            "debttypes" => DebtType::all(),
        ];
    }

    public function debtRpt($creditor, $sdate, $edate, $showall)
    {
        if($showall == 1) {
            $debts = Debt::where('supplier_id', '=', $creditor)
                            ->where('debt_status', '=', '0')
                            ->with('debttype')
                            ->orderBy('debt_date', 'DESC')
                            ->paginate(10);
            $apps = Debt::where('supplier_id', '=', $creditor)
                            ->where('debt_status', '=', '1')
                            ->with('debttype')
                            ->orderBy('debt_date', 'DESC')
                            ->paginate(10);
            $paids = Debt::where('supplier_id', '=', $creditor)
                            ->whereIn('debt_status', [2])
                            ->with('debttype')
                            ->orderBy('debt_date', 'DESC')
                            ->paginate(10);
            $setzeros = Debt::where('supplier_id', '=', $creditor)
                            ->whereIn('debt_status', [4])
                            ->with('debttype')
                            ->orderBy('debt_date', 'DESC')
                            ->paginate(10);
        } else {
            $debts = Debt::where('supplier_id', '=', $creditor)
                            ->where('debt_status', '=', '0')
                            ->whereBetween('debt_date', [$sdate, $edate])
                            ->with('debttype')
                            ->orderBy('debt_date', 'DESC')
                            ->paginate(10);
            $apps =  Debt::where('supplier_id', '=', $creditor)
                            ->where('debt_status', '=', '1')
                            ->whereBetween('debt_date', [$sdate, $edate])
                            ->with('debttype')
                            ->orderBy('debt_date', 'DESC')
                            ->paginate(10);
            $paids = Debt::where('supplier_id', '=', $creditor)
                            ->whereIn('debt_status', [2])
                            ->whereBetween('debt_date', [$sdate, $edate])
                            ->with('debttype')
                            ->orderBy('debt_date', 'DESC')
                            ->paginate(10);
            $setzeros = Debt::where('supplier_id', '=', $creditor)
                            ->whereIn('debt_status', [4])
                            ->whereBetween('debt_date', [$sdate, $edate])
                            ->with('debttype')
                            ->orderBy('debt_date', 'DESC')
                            ->paginate(10);
        }

        $totalDebt = Debt::where('supplier_id', '=', $creditor)->sum('debt_total');
        
        return [
            "debts"     => $debts,
            "apps"      => $apps,
            "paids"     => $paids,
            "setzeros"  => $setzeros,
            "totalDebt" => $totalDebt,
            "supplier"  => $creditor
        ];
    }

    private function generateAutoId()
    {
        $debt = \DB::table('nrhosp_acc_debt')
                        ->select('debt_id')
                        ->orderBy('debt_id', 'DESC')
                        ->first();

        $startId = 'DB'.substr((date('Y') + 543), 2);
        $tmpLastId =  ((int)(substr($debt->debt_id, 4))) + 1;
        $lastId = $startId.sprintf("%'.07d", $tmpLastId);

        return $lastId;
    }

    public function store(Request $req)
    {
        $debt = new Debt();
        $debt->debt_id = $this->generateAutoId();
        $debt->debt_date = $req['debt_date'];
        $debt->debt_doc_recno = $req['debt_doc_recno'];
        $debt->debt_doc_recdate = $req['debt_doc_recdate'];
        $debt->deliver_no = $req['deliver_no'];
        $debt->deliver_date = $req['deliver_date'];
        $debt->debt_doc_no = $req['debt_doc_no'];
        $debt->debt_doc_date = $req['debt_doc_date'];
        $debt->debt_type_id = $req['debt_type'];
        $debt->debt_type_detail = $req['debt_type_detail'];
        $debt->debt_month = $req['debt_month'];
        $debt->debt_year = $req['debt_year'];
        $debt->supplier_id = $req['supplier'];
        $debt->supplier_name = $req['supplier_name'];
        $debt->doc_receive = $req['doc_receive'];
        $debt->debt_amount = $req['debt_amount'];
        $debt->debt_vatrate = $req['debt_vatrate'];
        $debt->debt_vat = $req['debt_vat'];
        $debt->debt_total = $req['debt_total'];
        $debt->debt_remark = $req['debt_remark'];
        
        $debt->debt_creby = $req['debt_creby'];
        $debt->debt_credate = date("Y-m-d H:i:s");
        $debt->debt_userid = $req['debt_userid'];
        $debt->debt_chgdate = date("Y-m-d H:i:s");
        $debt->debt_status = '0';

        if($debt->save()) {
            return Debt::with('debttype')->find($debt->debt_id);
        } else {
            return [
                "status" => "error",
                "message" => "Insert failed.",
                "data"  => $debt,
            ];
        }
    }

    public function getById($debtId)
    {
        return [
            'debt' => Debt::find($debtId),
        ];
    }
    
    public function sumDebit()
    {
        return Debt::whereIn('debt_status', [2])->sum('debt_total');
    }
    
    public function sumCredit()
    {
        return Debt::sum('debt_total');
    }

    public function balance()
    {
        return Debt::whereIn('debt_status', [0, 1])->sum('debt_total');
    }

    public function edit($creditor, $debtId)
    {
        return view('debts.edit', [
            "creditor" => Creditor::where('supplier_id', '=', $creditor)->first(),
            'debt' => Debt::find($debtId),
            "debttypes" => DebtType::all(),
        ]);
    }

    public function update(Request $req, $debtId)
    {
        $debt = Debt::with('debttype')->find($debtId);
        
        $debt->debt_date = $req['debt_date'];
        $debt->debt_doc_recno = $req['debt_doc_recno'];
        $debt->debt_doc_recdate = $req['debt_doc_recdate'];        
        $debt->deliver_no = $req['deliver_no'];
        $debt->deliver_date = $req['deliver_date'];
        $debt->debt_doc_no = $req['debt_doc_no'];
        $debt->debt_doc_date = $req['debt_doc_date'];
        $debt->debt_type_id = $req['debt_type'];
        $debt->debt_type_detail = $req['debt_type_detail'];
        $debt->supplier_id = $req['supplier'];
        $debt->supplier_name = $req['supplier_name'];
        $debt->doc_receive = $req['doc_receive'];
        $debt->debt_year = $req['debt_year'];
        $debt->debt_amount = $req['debt_amount'];
        $debt->debt_vatrate = $req['debt_vatrate'];
        $debt->debt_vat = $req['debt_vat'];
        $debt->debt_total = $req['debt_total'];
        $debt->debt_remark = $req['debt_remark'];

        $debt->debt_userid = $req['debt_userid'];
        $debt->debt_chgdate = date("Y-m-d H:i:s");

        if($debt->save()) {
            return $debt;
        } else {
            return [
                "status" => "error",
                "message" => "Insert failed.",
                "data" => $debt,
            ];
        }

    }

    public function delete($debtId)
    {
        $debt = Debt::with('debttype')->find($debtId);

        if($debt->delete()) {
            return $debt;
        } else {
            return [
                "status" => "error",
                "message" => "Delete failed.",
            ];
        }   
    }

    public function setZero(Request $req)
    {
        $debt = Debt::with('debttype')->find($req['id']);

        if($debt->update(['debt_status' => '4']) <> 0) {
            return $debt;
        } else {
            return [
                'status' => 'error',
                'message' => 'Updated id ' . $req['debt_id'] . 'is failed.',
            ];
        }
    }

    public function supplierDebt($creditor)
    {
        return [
            'debts' => Debt::where(['supplier_id' => $creditor])
                        ->where(['debt_status' => 0])
                        ->with('debttype')
                        ->paginate(5),
        ];
    }
}
