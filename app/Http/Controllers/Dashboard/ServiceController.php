<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Dashboard\Service\StoreServiceRequest;
use App\Http\Requests\Dashboard\Service\UpdateServiceRequest;

use Storage;
use File;
use Auth;

use App\Models\{Service, AdvantageUser, AdvantageService, Tagline, Thumbnail, Order, User};

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::with(['Thumbnails', 'User.DetailUser'])->whereUserId(Auth::id())->orderByDesc('created_at')->get();

        return view('pages.Dashboard.service.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.Dashboard.service.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceRequest $request)
    {
        $data = $request->all();
        // dd($data);
        $data['user_id'] = Auth::id();

        // Add to service
        $service = Service::create($data);

        // Add to advantage service
        foreach ($data['advantage-service'] as $key => $value) {
            $advatage_service = new AdvantageService;
            $advatage_service->service_id = $service->id;
            $advatage_service->advantage = $value;
            $advatage_service->save();
        }

        // Add to advantage user
        foreach ($data['advantage-user'] as $key => $value) {
            $advatage_user = new AdvantageUser;
            $advatage_user->service_id = $service->id;
            $advatage_user->advantage = $value;
            $advatage_user->save();
        }

        // Add to thumbnail service
        if( $request->hasFile('thumbnail') ) {
            foreach ($request->file('thumbnail') as $file) {
                $path = $file->store('assets/service/thumbnail', 'public');

                $thumbnail = new Thumbnail;
                $thumbnail->service_id = $service->id;
                $thumbnail->thumbnail = $path;
                $thumbnail->save();
            }
        }

        // Add to tagline
        foreach ($data['tagline'] as $key => $value) {
            $tagline = new Tagline;
            $tagline->service_id = $service->id;
            $tagline->tagline = $value;
            $tagline->save();
        }

        toast()->success('Service has been added');

        return redirect()->route('member.service.index');
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
    public function edit(Service $service)
    {
        return view('pages.Dashboard.service.edit', [
            'service' => $service->load(['AdvantageUsers', 'AdvantageServices', 'Thumbnails', 'Taglines'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $data = $request->all();
        // dd($data);
        
        // Update to services
        $service->update($data);

        // Update to advantage_services
        foreach ($data['advantage-services'] as $key => $value) {
            $advantage_service = AdvantageService::find($key);
            $advantage_service->advantage = $value;
            $advantage_service->save();
        }

        // Add new advantage_services
        if( $data['advantage_service'] ) {
            foreach ($data['advantage_service'] as $key => $value) {
                $advantage_service = new AdvantageService;
                $advantage_service->service_id = $service->id;
                $advantage_service->advantage = $value;
                $advantage_service->save();
            }
        }

        // Update to advantage_users
        foreach ($data['advantage-users'] as $key => $value) {
            $advantage_user = AdvantageUser::find($key);
            $advantage_user->advantage = $value;
            $advantage_user->save();
        }

        // Add new advantage_users
        if( $data['advantage_user'] ) {
            foreach ($data['advantage_user'] as $key => $value) {
                $advantage_user = new Advantageuser;
                $advantage_user->service_id = $service->id;
                $advantage_user->advantage = $value;
                $advantage_user->save();
            }
        }

        // Update to taglines
        foreach ($data['taglines'] as $key => $value) {
            $tagline = Tagline::find($key);
            $tagline->tagline = $value;
            $tagline->save();
        }

        // Add new taglines
        if( $data['tagline'] ) {
            foreach ($data['tagline'] as $key => $value) {
                $tagline = new Tagline;
                $tagline->service_id = $service->id;
                $tagline->tagline = $value;
                $tagline->save();
            }
        }

        // Update to thumbnails
        if( $request->hasFile('thumbnails') ) {
            foreach ($request->file('thumbnails') as $key => $file) {
                // Get old thumbnail
                $get_thumbnail = Thumbnail::whereId($key)->first();

                // Store thumbnail
                $path = $file->store('assets/service/thumbnail', 'public');

                // Update thumbnail
                $thumbnail = Thumbnail::find($key);
                $thumbnail->thumbnail = $path;
                $thumbnail->save();

                // Delete old thumbnail
                $data = 'storage/' . $get_thumbnail['thumbnail'];

                if( File::exists($data) ) {
                    File::delete($data);
                } else {
                    File::delete('storage/app/public/' . $get_thumbnail['thumbnail']);
                }
            }
        }

        // Add to thumbnails
        if( $request->hasFile('thumbnail') ) {
            foreach ($request->file('thumbnail') as $key => $file) {
                // Store thumbnail
                $path = $file->store('assets/service/thumbnail', 'public');

                // Add new thumbnail
                $thumbnail = new Thumbnail;
                $thumbnail->service_id = $service->id;
                $thumbnail->thumbnail = $path;
                $thumbnail->save();
            }
        }

        toast()->success('Service has been updated');

        return redirect()->route('member.service.index');
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
