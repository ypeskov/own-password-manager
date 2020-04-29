<?php

namespace App\Models;

use App\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Item extends Model {
    use SoftDeletes;

    const MAX_NAME_LENGTH = 100;
    const MAX_URL_LENGTH = 200;
    const MAX_FOLDER_LENGTH = 100;
    const MAX_USERNAME_LENGTH = 200;
    const MAX_PASSWORD_LENGTH = 200;

    /**
     * @var array
     */
    protected $fillable = [
        'item_type_id',
        'name',
        'url',
        'folder',
        'username',
        'password',
        'comments',
    ];

    /**
     * The list of fields that should be encrypted/decrypted.
     * @var array
     */
    private $encryptedFields = [
        'url',
        'username',
        'password',
        'comments',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function validate() {
        $validator = Validator::make($this->attributes, [
            'name' => 'max:'.self::MAX_NAME_LENGTH,
            'url' => 'max:'.self::MAX_URL_LENGTH,
            'folder' => 'max:'.self::MAX_FOLDER_LENGTH,
            'username' => 'max:'.self::MAX_USERNAME_LENGTH,
            'password' => 'max:'.self::MAX_PASSWORD_LENGTH,
        ]);

        if ($validator->fails()) {
            return ['isValid' => false, 'errors' => $validator->errors()];
        }

        return ['isValid' => true, []];
    }

    /**
     * @param string $key
     * @return Item
     * @throws Exception
     */
    public function decrypt(string $key) : Item {
        foreach($this->encryptedFields as $field) {
            $this[$field] = $this->safeDecrypt($this[$field], $key);
        }

        return $this;
    }

    /**
     * @param string $key
     * @return Item
     * @throws Exception
     */
    public function encrypt(string $key) : Item {
        foreach($this->encryptedFields as $field) {
            $this[$field] = $this->safeEncrypt($this[$field], $key);
        }

        return $this;
    }

    /**
     * @param $plainText
     * @param $key
     * @param string $algorithm
     * @return string
     */
    private function safeEncrypt($plainText, $key, $algorithm='AES-128-CBC') : string {
        $ivlen = openssl_cipher_iv_length($algorithm);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($plainText, $algorithm, $key, $options=OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $iv.$ciphertext_raw, $key, $as_binary=true);

        return base64_encode( $iv.$hmac.$ciphertext_raw );
    }

    /**
     * @param $cipherText
     * @param $key
     * @param string $algorithm
     * @return false|string
     * @throws Exception
     */
    private function safeDecrypt($cipherText, $key, $algorithm='AES-128-CBC') {
        $c = base64_decode($cipherText);
        $ivlen = openssl_cipher_iv_length($algorithm);
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len=32);
        $ciphertext_raw = substr($c, $ivlen+$sha2len);
        $originalPlainText = openssl_decrypt($ciphertext_raw, $algorithm, $key, $options=OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $iv.$ciphertext_raw, $key, $as_binary=true);

        if (hash_equals($hmac, $calcmac)) { // с PHP 5.6+ сравнение, не подверженное атаке по времени {
            return $originalPlainText;
        }

        throw new Exception('Huston we have a problem!');
    }
}
