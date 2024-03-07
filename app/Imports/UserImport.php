<?php

namespace App\Imports;

use App\Models\UserModel;
use Maatwebsite\Excel\Concerns\ToModel;

class UserImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new UserModel([
            'tensinhvien' => $row[0],
            'mssv' => $row[1],
            'dienthoai' => $row[2],
            'diachi' => $row[3],
        ]);
    }
}