<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection ,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = User::where('type' , 'user')->get();
        foreach($data as $k => $user)
        {
            unset($user->id,$user->password,$user->avatar,$user->email_verified_at,$user->phone,$user->dob,$user->gender,$user->skills,$user->is_active,$user->is_invited,$user->lang,$user->facebook,
            $user->whatsapp,$user->instagram,$user->likedin,$user->mode,$user->is_trial_done,$user->is_plan_purchased,$user->interested_plan_id,$user->is_register_trial,
            $user->plan,$user->plan_expire_date,$user->payment_subscription_id,$user->requested_plan,$user->details,$user->remember_token,$user->last_login_at,
            $user->messenger_color,$user->dark_mode,$user->active_status,$user->created_by,$user->is_active,$user->created_at,$user->updated_at);

        }
        return $data;
    }

    public function headings(): array
    {
        return [
            "Name",
            "Email",
            "Type",
        ];
    }
}
