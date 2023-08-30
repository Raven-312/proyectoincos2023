<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    
        use SendsPasswordResetEmails;
    
        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware('guest');
        }
    
        // Mostrar el formulario de solicitud de correo
        public function showLinkRequestForm()
        {
            return view('auth.email');
        }
    
        // Enviar el correo de restablecimiento de contraseña
        public function sendResetLinkEmail(Request $request)
        {
            $this->validateEmail($request);
    
            $response = $this->broker()->sendResetLink(
                $request->only('email')
            );
    
            return $response == Password::RESET_LINK_SENT
                ? $this->sendResetLinkResponse($response)
                : $this->sendResetLinkFailedResponse($request, $response);
        }
    
        // ... otros métodos ...
    
}
