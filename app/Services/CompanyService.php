<?php

namespace App\Services;

use App\Company;

class CompanyService {

    function getRemote($code): Company{
        return factory(Company::class)->make();
    }
}
