<?php
namespace Newscast\Models;

class UserRole extends Model {
    protected static string $table = 'user_roles';
    
    public string $role_name = '';

    public string $capabilities = '';
}