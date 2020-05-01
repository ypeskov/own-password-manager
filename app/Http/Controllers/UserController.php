<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile() {
        $user = Auth::user();

        return view('views.user-settings', [
            'user' => $user,
            'activeMenu' => 'user.settings',
            'tab' => 'profile',
        ]);
    }

    public function password() {
        $passwordCurrent = request()->get('passwordCurrent', '');
        $passwordNew = request()->get('passwordNew', '');
        $credentials = [
            'email' => Auth::user()->email,
            'password' => $passwordCurrent,
        ];

        if (Auth::validate($credentials)) {
            $valid = $this->isPasswordValid($passwordNew);
            if (!$valid['isValid']) {
                return [
                    'status' => 'FAIL',
                    'code' => 'INVALID_NEW_PASSWORD',
                    'message' => $valid['errors']
                ];
            } else {
                $updated = Auth::user()->updateAndReEncrypt($passwordNew);

                if (!$updated) {
                    return [
                        'status' => 'FAIL',
                        'code' => 'PASSWORD_UPDATE_FAILED',
                        'message' => __('app.Password update failed'),
                    ];
                } else {
                    return [
                        'status' => 'OK',
                        'message' => __('app.Password successfully updated'),
                    ];
                }
            }
        } else {
            return [
                'status' => 'FAIL',
                'code' => 'INVALID_CURRENT_PASSWORD',
                'message' => __('app.Invalid current password')
            ];
        }
    }

    /**
     * @param string $property
     * @return array|false|string
     */
    public function changeProperty(string $property) {
        $newValue = request()->get('value', '');

        if (strlen($newValue) === 0) {
            abort(500, __('app.This field is required').': '.$property);
        }

        if ( !in_array($property, (new User())->getFillable()) ) {
            abort(500, __('Unknown property').': '.$property);
        }

        /**
         * @var $user User
         */
        $user = Auth::user();

        /**
         * password has its own validation rules so it is updated in a separate method UserController::password()
         */
        if ($property !== 'password') {
            $validator = $this->isValidProp($property, $newValue);

            if (!$validator['isValid']) {
                return [
                    'status' => 'FAIL',
                    'message' => $validator['errors'],
                ];
            }

            $user[$property] = $newValue;
            $user->save();
        }

        return json_encode([
            'status' => 'OK',
            'message' => __('app.Property updated').': '.$property,
        ]);
    }


    /**
     * @param string $password
     * @return array
     */
    private function isPasswordValid(string $password) : array {
        $ret = ['isValid' => true, 'errors' => []];

        $validator = Validator::make(['password' => $password], [
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            $ret = ['isValid' => false, 'errors' => $validator->errors()->messages()['password']];
        }

        return $ret;
    }

    /**
     * @param string $propName
     * @param string $propVal
     * @return array
     */
    private function isValidProp(string $propName, string $propVal) {
        $ret = ['isValid' => true, 'errors' => []];

        if ($propName === 'email') {
            $validator = Validator::make([$propName => $propVal], [
                'email' => 'email|unique:users,email',
            ]);

            if ($validator->fails()) {
                $ret = ['isValid' => false, 'errors' => $validator->errors()->messages()['email']];
            }
        }

        return $ret;
    }
}
