<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use App\Consts\AuthConst;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    // No. h.hashimoto 2022/08/18 ------>
    // public function create()
    // {
    //     return view('auth.register');
    // }
    public function create($tourokuUserType=0)
    {
        $arg=[
            'tourokuUserType'=>$tourokuUserType,
        ];
        return view('auth.register',$arg);
    }

    // <------  No. h.hashimoto 2022/08/18 

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $tourokuUserType = $request->tourokuUserType;//hidden項目

        if($tourokuUserType==AuthConst::USER_TYPE_HOGOSHA){
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                // No. h.hashimoto 2022/08/18 ------>
                'student_name' =>['string','max:40','required']
                // <------  No. h.hashimoto 2022/08/18 
            ]);
        }
        else{
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // No. h.hashimoto 2022/08/18 ------>
            'tourokuUserType' => intVal($tourokuUserType),
            'studentName' => $request->student_name,
            // <------  No. h.hashimoto 2022/08/18         
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
