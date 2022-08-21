<?php

namespace App\Providers;

use App\Models\City;
use App\Models\Company;
use App\Models\State;
use Illuminate\Support\ServiceProvider;
use App\Services\ValidateCnpj\ValidateCnpj;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['validator']->extend('telephone', function ($attribute, $value)
        {
             return preg_match('/^\\d{2}\\d{4,5}\d{4}$/', $value) > 0; 
        });

        $this->app['validator']->extend('cnpj', function ($attribute, $value)
        {
             return $this->cnpj($value);
        });

        $this->app['validator']->extend('check_state', function ($attribute, $value)
        {
             return $this->checkState($value);
        });

        $this->app['validator']->extend('check_city', function ($attribute, $value)
        {
             return $this->checkCity($value);
        });

        $this->app['validator']->extend('check_companies', function ($attribute, $value)
        {
             return $this->checkCompanies($value);
        });
    }

    private function cnpj($value)
    {
        $c = preg_replace('/\D/', '', $value);
    
        $b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    
        if (strlen($c) != 14) {
            return false;
        
        }
        elseif (preg_match("/^{$c[0]}{14}$/", $c) > 0) {
        
            return false;
        }
    
        for ($i = 0, $n = 0; $i < 12; $n += $c[$i] * $b[++$i]);
    
        if ($c[12] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }
    
        for ($i = 0, $n = 0; $i <= 12; $n += $c[$i] * $b[$i++]);
    
        if ($c[13] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }
    
        return true;
    } 

    private function checkState($value)
    {
        if(empty($value)){
            return true;
        }

        $state = State::find($value);
        if($state){
            return true;
        } 

        return false;
    }

    private function checkCity($value)
    {
        if(empty($value)){
            return true;
        }

        $city = City::find($value);
        if($city){
            return true;
        }
        return false;
    }

    private function checkCompanies($value)
    {
        if(empty($value)){
            return true;
        }

        foreach($value as $companies){
            $company = Company::find($companies);
            if(!$company){
                return false;
                break;
            }
        }
        return true;
    }
}
