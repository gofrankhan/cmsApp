<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;


class CustomerController extends Controller
{
    public function index()
    {
        return response()->json(Customer::all());
    }

    public function show($id)
    {
        return response()->json(Customer::findOrFail($id));
    }

    public function store(Request $request)
    {
        $employee = Customer::create($request->all());
        return response()->json($employee, 201);
    }

    public function update(Request $request, $id)
    {
        $employee = Customer::findOrFail($id);
        $employee->update($request->all());
        return response()->json($employee);
    }

    public function destroy($id)
    {
        Customer::destroy($id);
        return response()->json(null, 204);
    }
}
