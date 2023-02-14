<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Models\{Service, User, Order};

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::with(['User.DetailUser', 'Thumbnails'])->take(6)->latest()->get();

        return view('pages.Landing.index', compact('services'));
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

    // Custom method
    public function explore()
    {
        $services = Service::with(['User.DetailUser', 'Thumbnails'])->latest()->paginate(6);

        return view('pages.Landing.explore', compact('services'));
    }

    public function detail(Service $service)
    {
        return view('pages.Landing.detail', [
            'service' => $service->load(['Thumbnails', 'AdvantageUsers', 'AdvantageServices', 'Taglines', 'User.DetailUser.ExperienceUsers'])
        ]);
    }

    public function booking(Service $service)
    {
        $user_buyer = Auth::user();

        // Validation warning
        if( $service->user_id == $user_buyer->id ) {
            toast()->warning('Sorry, members cannot book their own services!');

            return back();
        }

        $order = new Order;
        $order->buyer_id = $user_buyer->id;
        $order->freelancer_id = $service->user->id;
        $order->service_id = $service->id;
        $order->file = null;
        $order->note = null;
        $order->expired = now()->addDays(3);
        $order->order_status_id = 4;
        $order->save();

        return redirect()->route('detail.booking.landing', $order->id);
    }

    public function detail_booking(Order $order)
    {
        return view('pages.Landing.booking', [
            'order' => $order->load(['OrderBuyer.DetailUser', 'OrderFreelancer.DetailUser'])
        ]);
    }
}
