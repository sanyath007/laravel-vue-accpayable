<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Creditor;
use App\Models\Budget;
use App\Models\BankAccount;
use App\Models\Debt;
use App\Models\DebtType;

class PaymentController extends Controller
{
    public function list()
    {
    	return [
            "suppliers" => Creditor::all(),
            "debttypes" => DebtType::all(),
        ];
    }

    public function search($creditor, $sdate, $edate, $showall)
    {
    	if($showall == 1) {
            if($creditor == 0) {
                $payments = Payment::where(['paid_stat' => 'Y'])->paginate(10);
            } else {
                $payments = Payment::where(['paid_stat' => 'Y'])
                                            ->where('supplier_id', '=', $creditor)
                                            ->paginate(10);
            }
        } else {
            if($creditor == 0) {
                $payments = Payment::where(['paid_stat' => 'Y'])
                                            ->whereBetween('paid_date', [$sdate, $edate])
                                            ->paginate(10);
            } else {
                $payments = Payment::where(['paid_stat' => 'Y'])
                                            ->where('supplier_id', '=', $creditor)
                                            ->whereBetween('paid_date', [$sdate, $edate])
                                            ->paginate(10);
            }
        }

        return [
            'payments' => $payments,
        ];
    }

    private function generateAutoId()
    {
        $payment = \DB::table('nrhosp_acc_payment')
                        ->select('payment_id')
                        ->orderBy('payment_id', 'DESC')
                        ->first();

        $startId = 'FN'.substr((date('Y') + 543), 2);
        $tmpLastId =  ((int)(substr($payment->payment_id, 4))) + 1;
        $lastId = $startId.sprintf("%'.07d", $tmpLastId);

        return $lastId;
    }

    public function add()
    {
    	return [
            "creditors" => Creditor::all(),
    		"budgets"	=> Budget::all(),            
            "bankaccs"  => BankAccount::with('bank')->get(),
    	];
    }

    public function store(Request $req)
    {
        $payment = new Payment();
        $payment->payment_id = $this->generateAutoId();
        $payment->paid_date = $req['paid_date'];
        $payment->supplier_id = $req['supplier'];
        $payment->paid_doc_no = $req['paid_doc_no'];
        $payment->cheque_no = $req['cheque_no'];
        $payment->cheque_date = $req['cheque_date'];

        $payment->bank_acc_id = $req['bank_acc'];
        $payment->budget_id = $req['budget'];
        $payment->pay_to = $req['pay_to'];
        $payment->cheque_receiver = $req['cheque_receiver'];
        $payment->remark = $req['remark'];
        $payment->paid_num = count($req['approves']);

        $payment->net_total = floatval(str_replace(",", "", $req['net_total']));
        $payment->net_val = floatval(str_replace(",", "", $req['net_val']));
        $payment->net_amt = floatval(str_replace(",", "", $req['net_amt']));
        $payment->fine = floatval(str_replace(",", "", $req['fine']));
        $payment->discount = floatval(str_replace(",", "", $req['discount']));
        $payment->remain = floatval(str_replace(",", "", $req['remain']));
        $payment->paid_amt = floatval(str_replace(",", "", $req['paid_amt']));
        $payment->total = floatval(str_replace(",", "", $req['total']));
        $payment->totalstr = $req['totalstr'];

        /** user info */
        $payment->cr_userid = $req['cr_userid'];
        $payment->cr_date = date("Y-m-d H:i:s");
        $payment->chg_userid = $req['chg_userid'];
        $payment->chg_date = date("Y-m-d H:i:s");

        $payment->paid_stat = 'Y';
        $payment->account_confirm = 'Y';

        try {
            $payment->save();

            $index = 0;
            foreach ($req['approves'] as $app) {
                foreach ($app['app_detail'] as $d) {
                    /** Added Approvement Detail */
                    $detail = new PaymentDetail();
                    $detail->payment_id = $payment->payment_id;
                    $detail->app_id = $app['app_id'];
                    $detail->seq_no = ++$index;
                    $detail->rcpamt = $app['net_total'];
                    $detail->net_val = $app['net_val'];
                    $detail->vat1_amt = $app['net_amt'];
                    $detail->discount = $app['discount'];
                    $detail->cheque_amt = $app['cheque'];
                    $detail->debt_id = $d['debt_id'];
                    $detail->save();

                    /** Updated debt status to 2 
                        สถานะ 0=รอดำเนินการ,1=ขออนุมัติ,2=ชำระเงินแล้ว,3=ยกเลิก 
                     */
                    $debt = Debt::find($d['debt_id'])->update(['debt_status' => 2]);
                }                
            }

            return [
                "status"    => "success",
                "message"   => "Insert success.",
                "payment"   => $payment,
                "detail"    => $detail,
                "debt"      => $debt,
            ];
        } catch (Exception $e) {
            return [
                "status" => "error",
                "message" => $e,
            ];
        }
        // if($payment->save()) {
        //     return [
        //         "status"    => "success",
        //         "message"   => "Insert success.",
        //     ];
        // } else {
        //     return [
        //         "status" => "error",
        //         "message" => "Insert failed.",
        //     ];
        // }
    }

    public function detail($appid)
    {   
        $debttypes = [];

        foreach (DebtType::all()->toArray() as $type) {
            $debttypes[$type['debt_type_id']] = $type['debt_type_name'];
        }        

        return [
            'paymentdetails' => PaymentDetail::where(['payment_id' => $appid])
                                                ->with('debt')
                                                ->orderBy('seq_no', 'ASC')
                                                ->get(),
            'debttypes' => $debttypes,
        ];
    }

    public function supplierPayments($supplier)
    {
        return [
            'payments' => Payment::where(['supplier_id' => $supplier])
                            ->where(['paid_stat' => 0])
                            ->paginate(5),
        ];
    }
}
