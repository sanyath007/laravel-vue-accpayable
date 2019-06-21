<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Approvement;
use App\Models\ApprovementDetail;
use App\Models\Creditor;
use App\Models\Budget;

class ApprovementController extends Controller
{
    public function list()
    {
    	return view('approvements.list');
    }

    public function search($searchKey)
    {
    	/** สถานะ 0=รอดำเนินการ,1=ขออนุมัติ,2=ชำระเงินแล้ว,3=ยกเลิก */
        if($searchKey == '0') {
            $approvements = Approvement::whereIn('app_stat', ['0', '1'])->paginate(20);
        } else {
            $approvements = Approvement::whereIn('app_stat', ['0', '1'])
            					->where('pay_to', 'like', '%'.$searchKey.'%')
            					->paginate(20);
        }

        return [
            'approvements' => $approvements,
        ];
    }

    public function add()
    {
    	return view('approvements.add', [
            'creditors' => Creditor::all(),
    		'budgets'	=> Budget::all(),
    	]);
    }
}
