<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityRequest;
use App\Models\City;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $state = $request->state;
        $search = $request->search;
        $city = City::selectRaw("city.id, city.name, state.name AS state");
        $city->leftJoin('state', 'state.id', '=', 'city.state_id');
        if($state){
            $city->whereIn('state.id', $state);
        }
        if(!empty($search)){
            $city->where('city.name', 'LIKE', "%{$search}%");
        }
        return response()->json($city->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityRequest $request)
    {
        try{
            $city = New City();
            $city->name = $request->name;
            $city->state_id = $request->state_id;
            $city->save();

            return response()->json(['success' => 'successfully created city!'], 201);
        } catch (\Exception $e) {
            Log::info("[City]store: {$e->getMessage()}");
            return response()->json(['error' => 'internal server error'], 500);
        }
    }

    public function show(City $city)
    {
        $city->state;
        return response()->json($city, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CityRequest  $request
     * @param  City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(CityRequest $request, City $city)
    {
        try{
            $city->name = $request->name;
            $city->state_id = $request->state_id;
            $city->save();

            return response()->json(['success' => 'successfully updated city!'], 201);
        } catch (\Exception $e) {
            Log::info("[City]store: {$e->getMessage()}");
            return response()->json(['error' => 'internal server error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        try{
            $user = User::where('city_id', $city->id)
                ->count();
            if($user > 0){
                return response()->json(['error' =>  'The city is in use'], 422);
            }

            $city->delete();

            return response()->json(['success' =>  'successfully deleted!'], 201);
        } catch (\Exception $e) {
            Log::info("[City]destroy: {$e->getMessage()}");
            return response()->json(['error' => 'internal server error'], 500);
        }
    }
}
