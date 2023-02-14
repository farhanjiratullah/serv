<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Dashboard\MyOrder\UpdateMyOrderRequest;

use Storage;
use File;
use Auth;

use App\Models\{Order, OrderStatus, User, Service};

class MyOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with(['OrderBuyer.DetailUser', 'Service.Thumbnails'])->whereFreelancerId(Auth::id())->orderByDesc('created_at')->get();

        return view('pages.Dashboard.order.index', compact('orders'));
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
    public function show(Service $order)
    {
        return view('pages.Dashboard.order.detail', [
            'service' => $order->load(['Thumbnails', 'AdvantageUsers', 'AdvantageServices', 'Taglines'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('pages.Dashboard.order.edit', [
            'order' => $order->load(['OrderBuyer.DetailUser', 'OrderStatus', 'Service.Thumbnails'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMyOrderRequest $request, Order $order)
    {
        $data = $request->all();

        if( $data['file'] ) {
            $data['file'] = $request->file('file')->store('assets/order/attachment', 'public');
        }

        $order->file = $data['file'];
        $order->note = $data['note'];
        $order->save();

        toast()->success('Your zip has been attach');

        return redirect()->route('member.order.index');
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
    public function accepted(Order $order)
    {
        $order->order_status_id = 2;
        $order->save();

        toast()->success('The order has been accepted');
        
        return back();
    }

    public function rejected(Order $order)
    {
        $order->order_status_id = 3;
        $order->save();

        toast()->success('The order has been rejected');
        
        return back();
    }
}
