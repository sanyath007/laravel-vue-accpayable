<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DebtType;

class DebtTypeController extends Controller
{
    public function list()
    {
    	return view('debttypes.list');
    }

    public function search($searchKey)
    {
        if($searchKey == '0') {
            $debttypes = DebtType::paginate(20);
        } else {
            $debttypes = DebtType::where('debt_type_name', 'like', '%'.$searchKey.'%')->paginate(20);
        }

        return [
            'debttypes' => $debttypes,
        ];
    }

    private function generateAutoId()
    {
        $debttype = \DB::table('nrhosp_acc_debt_type')
                        ->select('debt_type_id')
                        ->orderBy('debt_type_id', 'DESC')
                        ->first();

        $tmpLastId =  ((int)($debttype->debt_type_id)) + 1;
        $lastId = sprintf("%'.05d", $tmpLastId);

        return $lastId;
    }

    public function add()
    {
    	return view('debttypes.add', [
            'cates' => \DB::table('nrhosp_acc_debt_cate')->select('*')->get(),
    	]);
    }

    public function store(Request $req)
    {
        $lastId = $this->generateAutoId();

        $debttype = new DebtType();
        $debttype->debt_type_id = $lastId;
        $debttype->debt_type_name = $req['debt_type_name'];
        $debttype->debt_cate_id = $req['debt_cate_id'];
        // $debttype->debt_cate_name = $req['debt_cate_name'];
        $debttype->debt_type_status = '1';

        if($debttype->save()) {
            return [
                "status" => "success",
                "message" => "Insert success.",
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Insert failed.",
            ];
        }
    }

    public function getById($debttypeId)
    {
        return [
            'debttype' => DebtType::find($debttypeId),
        ];
    }

    public function edit($debttypeId)
    {
        return view('debttypes.edit', [
            'debttype' => DebtType::find($debttypeId),
            'cates' => \DB::table('nrhosp_acc_debt_cate')->select('*')->get(),
        ]);
    }

    public function update(Request $req)
    {
        $debttype = DebtType::find($req['debt_type_id']);

        $debttype->debt_type_name = $req['debt_type_name'];
        $debttype->debt_cate_id = $req['debt_cate_id'];
        // $debttype->debt_cate_name = $req['debt_cate_name'];

        if($debttype->save()) {
            return [
                "status" => "success",
                "message" => "Update success.",
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Update failed.",
            ];
        }
    }

    public function delete($debttypeId)
    {
        $debttype = DebtType::find($debttypeId);

        if($debttype->delete()) {
            return [
                "status" => "success",
                "message" => "Delete success.",
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Delete failed.",
            ];
        }
    }
}
