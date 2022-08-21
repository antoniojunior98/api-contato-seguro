<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\UserCompany;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $searchIn = $request->get('search_in');
        $filter = $request->only([
            'state',
            'city',
            'company'
        ]);
        $user = new User();
        $user = $user->getUser($search, $searchIn, $filter);

        return response()->json($user->paginate(10), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try{
            $user = New User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->telephone = $request->telephone;
            $user->birthday = $request->birthday;
            $user->city_id = $request->city;
            $user->save();
            $this->insertUserCompany($user->id, $request->companies);
            return response()->json(['success' => 'successfully created user!'], 201);
        } catch (\Exception $e) {
            Log::info("[User]store: {$e->getMessage()}");
            return response()->json(['error' => 'internal server error'], 500);
        }
    }

    private function insertUserCompany($user_id, $companies)
    {
        $insert = [];
        foreach($companies as $company){
            $insert[] = [
                'company_id' => $company,
                'user_id' => $user_id
            ];
        }
        UserCompany::insert($insert);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->companies;
        $user->city;
        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserRequest  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        try{
            $user->name = $request->name;
            $user->email = $request->email;
            $user->telephone = $request->telephone;
            $user->birthday = $request->birthday;
            $user->city_id = $request->city;
            $user->save();
            $this->updateUserCompany($user->id, $request->companies);
            return response()->json(['success' => 'successfully updated user!'], 201);
        } catch (\Exception $e) {
            Log::info("[User]store: {$e->getMessage()}");
            return response()->json(['error' => 'internal server error'], 500);
        }
    }

    private function updateUserCompany($user_id, $companies)
    {
        $company_ids = UserCompany::select('company_id')
            ->where('user_id', $user_id)
            ->get()->pluck('company_id')->toArray();

        $insert = array_filter($companies, function($company) use($company_ids) {
                if(!in_array($company, $company_ids)){
                    return $company;
                }
            });
        
        $delete = array_filter($company_ids, function($company) use($companies){
                if(!in_array($company, $companies)){
                    return $company;
                }
            });
     
        if($insert){
            $this->insertUserCompany($user_id, $insert);
        }
        if($delete){
            $this->deleteUserCompany($user_id, $delete);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try{
            $this->deleteUserCompany($user->id);
            $user->delete();
            return response()->json(['success' =>  'successfully deleted!'], 201);
        } catch (\Exception $e) {
            Log::info("[User]destroy: {$e->getMessage()}");
            return response()->json(['error' => 'internal server error'], 500);
        }   
    }

    private function deleteUserCompany($user_id, $companies = null)
    {
        $userCompany = UserCompany::where('user_id', $user_id);
        if($companies){
            $userCompany->whereIn('company_id', $companies);
        }
        $userCompany->delete();
    }
}
