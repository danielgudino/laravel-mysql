<?php

namespace App\Services;

use App\Models\Company;
use Log;

class CompanyService
{

    public static function getCompanies()
    {
        $company = Company::get();
        return $company;
    }

    public static function getCompany($id)
    {
        return Company::where('id', $id)->first();
    }

    public static function createCompany($data)
    {
        $newCompany = new Company();
        $newCompany->name = $data['name'];
        $newCompany->description = $data['description'];
        $newCompany->save();
        return $newCompany;
    }

    public static function updateCompany($id, $data)
    {
        $newCompany = Company::where('id', $id)->first();
        $newCompany->name   = $data['name'];
        $newCompany->description = $data['description'];
        $newCompany->save();
        return $newCompany;
    }

    public static function deleteCompany($id)
    {
        return Company::where('id', $id)->delete();
    }
}
