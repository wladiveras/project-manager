<?php

namespace App\Imports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;

class ProjectImport implements ToModel
{
    use Importable;

    public function model(array $row)
    {
        return new Project([
            //
        ]);
    }
}
