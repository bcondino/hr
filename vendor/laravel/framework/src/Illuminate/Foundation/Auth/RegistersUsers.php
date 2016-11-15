<?php

namespace Illuminate\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;
use App\User;
use App\tbl_company_model;
use App\tbl_user_company_model;

trait RegistersUsers
{
    use RedirectsUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        return $this->showRegistrationForm();
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        if (property_exists($this, 'registerView')) {
            return view($this->registerView);
        }

        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        return $this->register($request);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        // creation of user
        $user = $this->create($request->all());

        // creation of company
        $company = tbl_company_model::create([
                 'company_name'     => $request->company_name
                ,'active_flag'      => 'N'
            ]);

        // creation of user company
        tbl_user_company_model::create([
                 'user_id'          => $user->user_id
                ,'company_id'       => $company->company_id
                ,'default_flag'     => 'Y'
            ]);

        // check email verfication
        Mail::send('auth/verifyemail', $user->getAttributes() , function($message) use($request) 
        {
            $message
            ->to( $request['email_address'])
            ->subject('Activate your NuvemHR account!');
        });

        // return to view
        return view('auth/verify', ['email_address' => $user->email_address]);
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return string|null
     */
    protected function getGuard()
    {
        return property_exists($this, 'guard') ? $this->guard : null;
    }

}
