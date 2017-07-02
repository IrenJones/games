<?php
/**
 *
 * @author Ananaskelly
 */

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\BaseController;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Token;
use Auth;

class TokenController extends BaseController
{
    /**
     * return response on ajax query
     *
     * @return json
     */
    public function sendToken()
    {
        $user = Auth::user();
        $token = Token::getIdentificationToken($user);
        $msg = [
            'name' => 'token'
        ];
        if ($token !== null) {
            $data = [
                'state' => 'success',
                'token' => $token->token
            ];
        } else {
            $data = [
                'state' => 'failed'
            ];
        }
        $msg['data'] = $data;
        
        return response()->json($msg);
    }
}
