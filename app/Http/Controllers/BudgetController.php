<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;

class BudgetController extends Controller
{
    public function list()
    {
    	return Budget::all();
    }

    public function getById($id)
    {
    	return Budget::find($id);
    }
}
