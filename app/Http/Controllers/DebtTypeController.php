<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DebtType;

class DebtTypeController extends Controller
{
    public function list()
    {
    	$debttypes = DebtType::paginate(20);
    	// dd($creditors);

    	return view('debttypes.list', [
    		'debttypes' => $debttypes,
    	]);
    }
}
