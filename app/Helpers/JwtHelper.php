<?php 

use Illuminate\Support\Facades\Auth;

class JwtHelper 
{
    //Add this method to the Controller class
    protected function respondWithToken($user)
    {
        /*
        if (! $token = Auth::attempt($user)) {
            throw new Exception("Unathorized", 401);
        }

        return new [
          'token' => $token,
          'token_type' => 'bearer',
          'expires_in' => Auth::factory()->getTTL() * 60
        ], 200);
        */
    }
}