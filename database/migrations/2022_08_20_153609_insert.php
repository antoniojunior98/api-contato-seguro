<?php

use App\Models\City;
use App\Models\Company;
use App\Models\State;
use App\Models\User;
use App\Models\UserCompany;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $state = [
            ['name' => 'Pará'],
            ['name' => 'Rio Grande do Sul']
        ];

        $city = [
            [
                'name' => 'Belém',
                'state_id' => '1'
            ],
            [
                'name' => 'Porto Alegre',
                'state_id' => '2'
            ]
        ];

        $company = [
            [
                'name' => 'CONTATO SEGURO PREVENCAO DE RISCOS EMPRESARIAIS LTDA',
                'CNPJ' => '10916727000177',
                'address' => 'Av. Carlos Gomes, 466 / 501 - Boa Vista, Porto Alegre - RS, 90480-000'
            ],
            [
                'name' => 'Globo',
                'CNPJ' => '27865757000102',
                'address' => 'Rua Marques de Sao Vicente, 30 Loja 201 GAVEA RIO DE JANEIRO - RJ 22451-040'
            ]
        ];

        $users = [
            [
                'name' => 'Antonio Junior',
                'email' => 'antoniojuniorti98@gmail.com',
                'telephone' => '91985321753',
                'birthday' => '1998-07-03',
                'city_id' => '1'
            ],
            [
                'name' => 'Barra Junior',
                'email' => 'barrajuniorti98@gmail.com',
                'telephone' => '91985321753',
                'birthday' => '1998-07-03',
                'city_id' => '1'
            ],
            [
                'name' => 'João',
                'email' => 'joão@gmail.com',
                'telephone' => '91985321753',
                'birthday' => '1998-07-03',
                'city_id' => '2'
            ],
            [
                'name' => 'Maria',
                'email' => 'maria@gmail.com',
                'telephone' => '91985321753',
                'birthday' => '1998-07-03',
                'city_id' => '2'
            ],
            [
                'name' => 'Lucas',
                'email' => 'lucas@gmail.com',
                'telephone' => '91985321753',
                'birthday' => '1998-07-03',
                'city_id' => '1'
            ],
            [
                'name' => 'Camila',
                'email' => 'camila@gmail.com',
                'telephone' => '91985321753',
                'birthday' => '1998-07-03',
                'city_id' => '1'
            ],
            [
                'name' => 'Anna',
                'email' => 'anna@gmail.com',
                'telephone' => '91985321753',
                'birthday' => '1998-07-03',
                'city_id' => '2'
            ],
            [
                'name' => 'Marcos',
                'email' => 'marcos@gmail.com',
                'telephone' => '91985321753',
                'birthday' => '1998-07-03',
                'city_id' => '1'
            ],
            [
                'name' => 'Julia',
                'email' => 'julia@gmail.com',
                'telephone' => '91985321753',
                'birthday' => '1998-07-03',
                'city_id' => '1'
            ],
            [
                'name' => 'Mônica',
                'email' => 'monica@gmail.com',
                'telephone' => '91985321753',
                'birthday' => '1998-07-03',
                'city_id' => '1'
            ],
            [
                'name' => 'Eduardo',
                'email' => 'eduardo@gmail.com',
                'telephone' => '91985321753',
                'birthday' => '1998-07-03',
                'city_id' => '1'
            ],
            [
                'name' => 'Julio',
                'email' => 'julio@gmail.com',
                'telephone' => '91985321753',
                'birthday' => '1998-07-03',
                'city_id' => '1'
            ],
            [
                'name' => 'Antonio',
                'email' => 'antonio@gmail.com',
                'telephone' => '91985321753',
                'birthday' => '1998-07-03',
                'city_id' => '1'
            ]
        ];

        $userCompany = [
            [
                'company_id' => '1',
                'user_id' => '1'
            ],
            [
                'company_id' => '2',
                'user_id' => '1'
            ],
            [
                'company_id' => '1',
                'user_id' => '2'
            ],
            [
                'company_id' => '2',
                'user_id' => '2'
            ],
            [
                'company_id' => '1',
                'user_id' => '3'
            ],
            [
                'company_id' => '2',
                'user_id' => '4'
            ],
            [
                'company_id' => '1',
                'user_id' => '4'
            ],
            [
                'company_id' => '2',
                'user_id' => '5'
            ],
            [
                'company_id' => '1',
                'user_id' => '5'
            ],
            [
                'company_id' => '2',
                'user_id' => '6'
            ],
            [
                'company_id' => '2',
                'user_id' => '7'
            ],
            [
                'company_id' => '1',
                'user_id' => '8'
            ],
            [
                'company_id' => '1',
                'user_id' => '9'
            ],
            [
                'company_id' => '1',
                'user_id' => '10'
            ],
            [
                'company_id' => '2',
                'user_id' => '10'
            ],
            [
                'company_id' => '1',
                'user_id' => '11'
            ],
            [
                'company_id' => '2',
                'user_id' => '12'
            ],
            [
                'company_id' => '1',
                'user_id' => '12'
            ],
            [
                'company_id' => '2',
                'user_id' => '13'
            ],
            [
                'company_id' => '1',
                'user_id' => '13'
            ],
        ];

        State::insert($state);
        City::insert($city);
        Company::insert($company);
        User::insert($users);
        UserCompany::insert($userCompany);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
