<?php
namespace Newscast\Models;

class User extends Model {
    protected static string $table = 'users';
    
    public string $username = '';

    public string $password = '';

    public string $email = '';

    public string $first_name = '';

    public string $last_name = '';

    public int $user_roles_id = 0;

    public bool $user_confirmed = false;

    public function user_roles(): mixed {
        return $this->attributes['user_roles'];
    }
}