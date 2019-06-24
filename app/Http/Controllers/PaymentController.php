<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Creditor;
use App\Models\Budget;
use App\Models\Debt;
use App\Models\DebtType;

class PaymentController extends Controller
{
    public function list()
    {
    	return view('payments.list');
    }

    public function search($searchKey)
    {
    	/** สถานะ 0=รอดำเนินการ,1=ขออนุมัติ,2=ชำระเงินแล้ว,3=ยกเลิก */
        if($searchKey == '0') {
            $payments = Payment::where(['paid_stat' => 'Y'])->paginate(20);
        } else {
            $payments = Payment::where('pay_to', 'like', '%'.$searchKey.'%')->paginate(20);
        }

        return [
            'payments' => $payments,
        ];
    }

    private function generateAutoId()
    {
        $app = \DB::table('nrhosp_acc_payment')
                        ->select('payment_id')
                        ->orderBy('payment_id', 'DESC')
                        ->first();

        $startId = 'FN'.substr((date('Y') + 543), 2);
        $tmpLastId =  ((int)(substr($app->app_id, 4))) + 1;
        $lastId = $startId.sprintf("%'.07d", $tmpLastId);

        return $lastId;
    }

    public function add()
    {
    	return view('payments.add', [
            'creditors' => Creditor::all(),
    		'budgets'	=> Budget::all(),
    	]);
    }

    public function store(Request $req)
    {
        $payment = new Payment();
        $payment->payment_id = $this->generateAutoId();
        $payment->payment_doc_no = $req['payment_doc_no'];
        $payment->payment_date = $req['payment_date'];
        $payment->payment_recdoc_no = $req['payment_recdoc_no'];
        $payment->payment_recdoc_date = $req['payment_recdoc_date'];

        $payment->supplier_id = $req['creditor_id'];
        $payment->pay_to = $req['pay_to'];
        $payment->budget_id = $req['budget_id'];

        $payment->amount = floatval(str_replace(",", "", $req['amount']));
        $payment->tax_val = floatval(str_replace(",", "", $req['tax_val']));
        $payment->discount = floatval(str_replace(",", "", $req['discount']));
        $payment->fine = floatval(str_replace(",", "", $req['fine']));
        $payment->vatrate = $req['vatrate'];
        $payment->vatamt = floatval(str_replace(",", "", $req['vatamt']));
        $payment->net_val = floatval(str_replace(",", "", $req['net_val']));
        $payment->net_amt = floatval(str_replace(",", "", $req['net_amt']));
        $payment->net_amt_str = $req['net_amt_str'];
        $payment->net_total = floatval(str_replace(",", "", $req['net_total']));
        $payment->net_total_str = $req['net_total_str'];
        $payment->cheque = floatval(str_replace(",", "", $req['cheque']));
        $payment->cheque_str = $req['cheque_str'];
        /** user info */
        $payment->cr_userid = $req['cr_user'];
        $payment->cr_date = date("Y-m-d H:i:s");
        $payment->chg_userid = $req['chg_user'];
        $payment->chg_date = date("Y-m-d H:i:s");
        /** สถานะ 0=รอดำเนินการ,1=ขออนุมัติ,2=ชำระเงินแล้ว,3=ยกเลิก */
        $payment->payment_stat = '0';
        $payment->is_approve = 'N';

        if($approvement->save()) {
            $index = 0;
            foreach ($req['debts'] as $debt) {
                /** Added Approvement Detail */
                $detail = new PaymentDetail();
                $detail->payment_id = $payment->app_id;
                $detail->debt_id = $debt['debt_id'];
                $detail->seq_no = ++$index;
                $detail->is_paid = 'N';
                $detail->app_detail_stat = '0';
                $detail->save();

                /** Updated debt status to 1 */
                Debt::find($debt['debt_id'])->update(['debt_status' => 1]);
            }

            return [
                "status"    => "success",
                "message"   => "Insert success.",
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Insert failed.",
            ];
        }
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
}
