<?php

namespace App\Imports;

use App\Models\BookModel;
use Maatwebsite\Excel\Concerns\ToModel;

class BookImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new BookModel([
            'tensach' => $row[0],
            'tacgia' => $row[1],
            'giatien' => $row[2],
            'nhaxuatban' => $row[3],
        ]);
    }
}