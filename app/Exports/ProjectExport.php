<?php

namespace App\Exports;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProjectExport implements FromCollection ,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $usr           = Auth::user();
        $data = Project::where('created_by' , \Auth::user()->id)->get();

        foreach($data as $k => $project)
        {
            $project_user            = $project->users->where('user_id', '!=', $usr->id)->pluck('name');
            $data[$k]["project_id"]  = $project_user;
            
            unset($project->id,$project->image,$project->created_by,$project->is_active,$project->created_at,$project->updated_at);

        }
        return $data;
    }

    public function headings(): array
    {
        return [
            "Name",
            "Status",
            "Budget",
            "Start Date",
            "End Date",
            "Currency",
            "Currency Code",
            "Currency Position",
            "Description",
            "Project Progress",
            "Progress",
            "Task Progress",
            "Tags",
            "Estimated Hours",
            "Invited Users",
        ];
    }
}
