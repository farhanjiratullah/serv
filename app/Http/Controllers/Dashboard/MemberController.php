<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Models\{Order, OrderStatus, User};

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with(['OrderBuyer.DetailUser', 'OrderStatus', 'Service.Thumbnails'])->whereFreelancerId(Auth::id())->latest()->get();
        $progress = Order::whereFreelancerId(Auth::id())->whereOrderStatusId(2)->count();
        $completed = Order::whereFreelancerId(Auth::id())->whereOrderStatusId(1)->count();
        $freelancer = Order::whereBuyerId(Auth::id())->whereOrderStatusId(2)->distinct('freelancer_id')->count();

        return view('pages.Dashboard.index', compact('orders', 'progress', 'completed', 'freelancer'));
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
    public function show($id)
    {
        //
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
}
