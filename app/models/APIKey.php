<?php

namespace app\models;

use mavoc\core\Exception;
use mavoc\core\Model;

class APIKey extends Model {
    public static $table = 'api_keys';
    public static $private = ['api_key_hash'];

    public static function create($args) {
        $prefix = ao()->env('API_PREFIX');
        $suffix = ao()->env('API_SUFFIX');

        $args['prefix'] = $prefix;
        $args['suffix'] = $suffix;

        // We don't want this to be too long otherwise we run into bcrypt 72 byte limit:
        // https://crypto.stackexchange.com/questions/24993/is-there-a-way-to-use-bcrypt-with-passwords-longer-than-72-bytes-securely
        // https://security.stackexchange.com/questions/39849/does-bcrypt-have-a-maximum-password-length
        $length = 16;
        $token = sodium_bin2hex(random_bytes($length));
        $args['last4'] = substr($token, -4);
        $args['api_key_hash'] = password_hash($prefix . $token . $suffix, PASSWORD_DEFAULT);

        $item = new APIKey($args);
        $item->save();

        // Temporarily save key to show to the user.
        $item->data['raw_key'] = $prefix . $token . $suffix;
        return $item;
    }

    public static function validate($username, $password) {
        $data = ao()->db->query('SELECT ak.user_id, ak.api_key_hash FROM users u, api_keys ak WHERE u.username = ? AND u.id = ak.user_id', $username);

        $pass = false;
        foreach($data as $row) {
            if(password_verify($password, $row['api_key_hash'])) {
                $user_id = $row['user_id'];
                $pass = true;
                break;
            }

        }

        $pass = ao()->hook('app_api_key_validate_pass', $pass, $username, $password);
        if(!$pass) {
            throw new Exception('The API user or key does not appear to be valid.', '', 401, 'json');
        }

        $user = User::find($user_id);
        $user = ao()->hook('app_api_key_validate_user', $user, $username, $password);
        return $user;
    }

    public function process($data) {
        //$example = Example::find($data['example_id']);
        //$data['example'] = $example->data;
        
        $data['display_key'] = $data['prefix'] . '...' . $data['last4'] . $data['suffix'];

        return $data;
    }

}
