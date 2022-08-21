<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CompanyRequest;
use App\Models\UserCompany;
use Illuminate\Http\Request;
use App\Services\ValidateCnpj\ValidateCnpj;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $company = Company::select(['id', 'name', 'cnpj', 'address']);
        if(!empty($search)){
            $company->where('name', 'LIKE', "%{$search}%");
            $company->orWhere('CNPJ', 'LIKE', "%{$search}%");
        }

        return response()->json($company->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CompanyRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        try{
            $company = New Company();
            $company->name = $request->name;
            $company->cnpj = $request->cnpj;
            $company->address = $request->address;
            $company->save();

            return response()->json(['success' => 'successfully created company!'], 201);
        } catch (\Exception $e) {
            Log::info("[Company]store: {$e->getMessage()}");
            return response()->json(['error' => 'internal server error'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        $company->users;
        return response()->json($company, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CompanyRequest $request
     * @param  Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, Company $company)
    {
        try{
            $company->name = $request->name;
            $company->cnpj = $request->cnpj;
            $company->address = $request->address;
            $company->save();

            return response()->json(['success' => 'successfully updated company!'], 201);
        } catch (\Exception $e) {
            Log::info("[Company]store: {$e->getMessage()}");
            return response()->json(['error' => 'internal server error'], 500);
        }
    }

    public function validateCnpj(Request $request) 
    {
        $vCnpj = new ValidateCnpj();
        $response = $vCnpj->checkCnpj($request->cnpj);

        if($response['status'] == 429){
            return response()->json($response, 429);
        }
        
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        try{
            $userCompany = UserCompany::where('company_id', $company->id)
                ->count();

            if($userCompany > 0){
                return response()->json(['error' =>  'The company is in use'], 422);
            }

            $company->delete();

            return response()->json(['success' =>  'successfully deleted!'], 201);
        } catch (\Exception $e) {
            Log::info("[Company]destroy: {$e->getMessage()}");
            return response()->json(['error' => 'internal server error'], 500);
        }   
    }
}
