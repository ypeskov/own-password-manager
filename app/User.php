<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items() {
        return $this->hasMany(\App\Models\Item::class);
    }

    /**
     * @param string $password
     * @return bool
     */
    public function updateAndReEncrypt(string $password) {
        /**
         * @var $user User
         */
        $user = Auth::user();
        $items = $user->items;

        $key = session('enckey');

        try {
            DB::transaction(function() use ($items, $user, $password, $key) {
                $user->password = Hash::make($password);
                $user->save();

                $newKey = $password ^ $password;

                foreach($items as $item) {
                    $item->decrypt($key);
                    $item->encrypt($newKey);
                    $item->save();
                }

                session(['enckey' => $newKey]);
            });
        } catch(\Exception $e) {
            return false;
        }

        return true;
    }
}
