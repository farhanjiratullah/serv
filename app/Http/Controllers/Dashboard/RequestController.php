<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Storage;
use File;
use Auth;

use App\Models\{Service, Order, User, OrderStatus};

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with(['OrderFreelancer.DetailUser', 'OrderStatus', 'Service.Thumbnails'])->whereBuyerId(Auth::id())->orderByDesc('created_at')->get();

        return view('pages.Dashboard.request.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $request)
    {
        return view('pages.Dashboard.request.detail', [
            'order' => $request->load(['OrderFreelancer.DetailUser', 'OrderStatus', 'Service.Thumbnails'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // Custom method
    public function approve(Order $order)
    {
        $order->order_status_id = 1;
        $order->save();

        toast()->success('You just approved the project');

        return redirect()->route('member.request.index');
    }
}
