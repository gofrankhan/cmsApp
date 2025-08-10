<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;

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
        $validatedCustomer = $request->validate([
            // Customer fields
            'taxid' => 'required|unique:customers,taxid|max:255',
            'firstname' => 'nullable|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'account_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'customertype' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:255',
            'dateofbirth' => 'nullable|date',
            'pob' => 'nullable|string|max:255',
            'citizenship' => 'nullable|string|max:255',
            'addressline1' => 'nullable|string|max:255',
            'addressline2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'postcode' => 'nullable|string|max:255',

            // Subscription fields
            'is_subscribed' => 'required|boolean',
            'subscription_type' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string'
        ]);

        return DB::transaction(function () use ($request, $validatedCustomer) {
            // Create customer
            $customer = Customer::create($request->only([
                'account_id',
                'user_id',
                'taxid',
                'customertype',
                'company',
                'firstname',
                'lastname',
                'telephone',
                'mobile',
                'dateofbirth',
                'pob',
                'citizenship',
                'addressline1',
                'addressline2',
                'city',
                'region',
                'postcode'
            ]));

            // Create subscription using new customer's ID
            $subscription = Subscription::create([
                'customer_id' => $customer->id,
                'is_subscribed' => $request->is_subscribed,
                'subscription_type' => $request->subscription_type,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'description' => $request->description
            ]);

            return response()->json([
                'message' => 'Customer and subscription created successfully',
                'customer' => $customer,
                'subscription' => $subscription
            ], 201);
        });
    }

    public function update(Request $request, $customerId)
    {
        $validated = $request->validate([
            // Customer fields
            'taxid' => 'required|max:255|unique:customers,taxid,' . $customerId,
            'firstname' => 'nullable|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'account_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'customertype' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:255',
            'dateofbirth' => 'nullable|date',
            'pob' => 'nullable|string|max:255',
            'citizenship' => 'nullable|string|max:255',
            'addressline1' => 'nullable|string|max:255',
            'addressline2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'postcode' => 'nullable|string|max:255',

            // Subscription fields
            'is_subscribed' => 'required|boolean',
            'subscription_type' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string'
        ]);

        return DB::transaction(function () use ($request, $customerId) {
            // Find customer
            $customer = \App\Models\Customer::find($customerId);
            if (!$customer) {
                return response()->json(['message' => 'Customer not found'], 404);
            }

            // Update customer
            $customer->update($request->only([
                'account_id',
                'user_id',
                'taxid',
                'customertype',
                'company',
                'firstname',
                'lastname',
                'telephone',
                'mobile',
                'dateofbirth',
                'pob',
                'citizenship',
                'addressline1',
                'addressline2',
                'city',
                'region',
                'postcode'
            ]));

            // Update or create subscription
            $subscription = \App\Models\Subscription::updateOrCreate(
                ['customer_id' => $customer->id],
                [
                    'is_subscribed' => $request->is_subscribed,
                    'subscription_type' => $request->subscription_type,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'description' => $request->description
                ]
            );

            return response()->json([
                'message' => 'Customer and subscription updated successfully',
                'customer' => $customer,
                'subscription' => $subscription
            ], 200);
        });
    }

    public function destroy($customerId)
    {
        return DB::transaction(function () use ($customerId) {
            // Find customer
            $customer = \App\Models\Customer::find($customerId);
            if (!$customer) {
                return response()->json(['message' => 'Customer not found'], 404);
            }

            // Delete related subscriptions first
            \App\Models\Subscription::where('customer_id', $customerId)->delete();

            // Delete customer
            $customer->delete();

            return response()->json([
                'message' => 'Customer and related subscriptions deleted successfully'
            ], 200);
        });
    }
}
