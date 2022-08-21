<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function companies()
    {
       return $this->belongsToMany(Company::class, 'user_company', 'user_id', 'company_id');
    }

    public function city()
    {
        return $this->hasOne(City::class, "state_id");
    }

    public function getUser($search, $seachIN, $filter)
    {
        $query = DB::table('users')
            ->selectRaw("users.id, users.name, users.email, users.telephone, users.birthday, city.name AS city")
            ->leftJoin('city', 'city.id', '=', 'users.city_id')
            ->leftJoin('state', 'state.id', '=', 'city.state_id')
            ->join('user_company', 'user_company.user_id', '=', 'users.id')
            ->join('company', 'company.id', '=', 'user_company.company_id')
            ->groupBy('users.name');
        if(!empty($search) && !empty($seachIN)){
            $query = $this->search($query, $search, $seachIN);
        }

        foreach ($filter as $fKey => $fValue){
            if(!empty($fValue)){
                $query = $this->filterBy($query, $fKey, $fValue);
            }
        }

        return $query;
    }

    private function search($model, $search, $seachIN)
    {
        $search = "%{$search}%";
        
        switch ($seachIN) {
            case 'email':
                $model->where('users.email', 'LIKE', $search);
                break;
            case 'telephone':
                $model->where('users.telephone', 'LIKE', $search);
                break;
            default:
                $model->where('users.name', 'LIKE', $search);
                break;
        }

        return $model;
    }

    private function filterBy($model, $filter, $value)
    {
        switch ($filter) {
            case 'city':
                $model->whereIn("city.id", $value);
                break;
            case 'state':
                $model->whereIn("state.id", $value);
                break;
            case 'company':
                $model->whereIn("company.id", $value);
                break;
            default:
                break;
        }
        return $model;
    }
}
