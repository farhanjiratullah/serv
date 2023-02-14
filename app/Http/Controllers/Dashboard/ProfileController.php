<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Dashboard\Profile\UpdateDetailUserRequest;
use App\Http\Requests\Dashboard\Profile\UpdateProfileRequest;

use Storage;
use File;
use Auth;

use App\Models\{User, DetailUser, ExperienceUser};

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::with(['DetailUser', 'ExperienceUsers'])->whereId(Auth::id())->first();
        // dd($user);

        return view('pages.Dashboard.profile', compact('user'));
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
    public function update(UpdateProfileRequest $request_profile, UpdateDetailUserRequest $request_detail_user)
    {
        $data_profile = $request_profile->all();
        $data_detail_user = $request_detail_user->all();

        // Get photo user
        $get_photo = DetailUser::whereUserId(Auth::id())->value('photo');
        
        // Delete old file from storage
        if( $request_detail_user->hasFile('photo') ) {
            $data = 'storage/' . $get_photo;

            if( File::exists($data) ) {
                File::delete($data);

                $data_detail_user['photo'] = $request_detail_user->file('photo')->store('assets/photo', 'public');
            } else {
                File::delete('storage/app/public/' . $get_photo);
            }
        }

        // Process save to users
        $user = User::with('DetailUser')->whereId(Auth::id())->first();
        $user->update($data_profile);

        // Process save to detail_users
        $detail_user = DetailUser::find($user->DetailUser->id);
        $detail_user->update($data_detail_user);

        // Process save to experience_users
        $experience_user_id = ExperienceUser::whereDetailUserId($detail_user->id)->first();

        if( $experience_user_id ) {
            foreach ($data_profile['experience'] as $key => $value) {
                $experience_user = ExperienceUser::find($key);
                $experience_user->detail_user_id = $detail_user->id;
                $experience_user->experience = $value;
                $experience_user->save();
            }
        } else {
            foreach ($data_profile['experience'] as $key => $value) {
                if( $value ) {
                    $experience_user = new ExperienceUser;
                    $experience_user->detail_user_id = $detail_user->id;
                    $experience_user->experience = $value;
                    $experience_user->save();
                }
            }
        }

        toast()->success('Your profile has been updated');

        return back();
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
    public function delete(Request $request, DetailUser $detail_user)
    {
        // Delete file photo
        $data = 'storage/' . $detail_user->photo;

        if( File::exists($data) ) {
            File::delete($data);
        } else {
            File::delete('storage/app/public/' . $detail_user->photo);
        }
        
        // Second update value to null
        $detail_user->photo = null;
        $detail_user->save();


        toast()->success('Your photo has been deleted');

        return back();
    }
}
