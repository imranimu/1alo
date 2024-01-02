<?php

namespace App\Imports;

use App\Models\admin\CourseLicense as AdminCourseLicense;
use App\Models\CourseLicense;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;

class LicenseImport implements ToModel
{

    public function startRow(): int
    {
        return 2;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new AdminCourseLicense([
            'license' => $row[0],
            'created_by' => Auth::user()->id,
        ]);
    }
}
