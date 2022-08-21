<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StateRequest;
use App\Models\City;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $state = new State();
        if(!empty($search)){
            $state = $state->where('name', 'LIKE', "%{$search}%");
        }
        return response()->json($state->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StateRequest $request)
    {
        try{
            $state = New State();
            $state->name = $request->name;
            $state->save();

            return response()->json(['success' => 'successfully created state!'], 201);
        } catch (\Exception $e) {
            Log::info("[State]store: {$e->getMessage()}");
            return response()->json(['error' => 'internal server error'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StateRequest  $request
     * @param  State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(StateRequest $request, State $state)
    {
        try{
            $state->name = $request->name;
            $state->save();

            return response()->json(['success' => 'successfully updated state!'], 201);
        } catch (\Exception $e) {
            Log::info("[State]store: {$e->getMessage()}");
            return response()->json(['error' => 'internal server error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $state, Request $request)
    {
        try{
            $city = City::where('state_id', $state->id)
                ->count();
            if($city > 0){
                return response()->json(['error' =>  'The state is in use'], 422);
            }

            $state->delete();
            return response()->json(['success' =>  'successfully deleted!'], 201);
        } catch (\Exception $e) {
            Log::info("[State]destroy: {$e->getMessage()}");
            return response()->json(['error' => 'internal server error'], 500);
        }   
    }
}
