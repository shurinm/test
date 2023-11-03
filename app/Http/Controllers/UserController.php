<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;


class UserController extends Controller
{

    public function get()
    {

        $ch = curl_init('https://randomuser.me/api/?results=5000');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $response = curl_exec($ch);
        curl_close($ch);

        $responseData = json_decode($response, true);

        $countBefore = User::count();

        foreach ($responseData['results'] as $item) {
            $firstName = $item['name']['first'];
            $lastName = $item['name']['last'];
            $email = $item['email'];
            $age = $item['dob']['age'];

            DB::table('users')->updateOrInsert(
                ['first_name' => $firstName, 'last_name' => $lastName],
                ['email' => $email, 'age' => $age]
            );
        }

        $countAfter = User::count();
        $addedCount = $countAfter - $countBefore;
        $updatedCount = count($responseData['results']) - $addedCount;
        $data = json_encode(['countBefore' => $countBefore,
            'countAfter' => $countAfter,
            'addedCount' => $addedCount,
            'updatedCount' => $updatedCount]
    );
        return  $data;
    }
   public function welcome(){
       $countBefore = User::count();
       return view('welcome')->with([
           'countBefore' => $countBefore,
       ]);
   }

}
