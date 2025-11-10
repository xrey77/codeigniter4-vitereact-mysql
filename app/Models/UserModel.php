<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users'; // Name of the database table
    protected $primaryKey = 'id';    // Primary key of the table

    protected $useAutoIncrement = true;

    protected $returnType     = 'array'; // or 'object' or a custom Entity class
    protected $useSoftDeletes = false; // Set to true if you want to use soft deletes

    // The fields that are allowed to be mass-assigned
    protected $allowedFields = [
        'firstname',
        'lastname',
        'email',
        'mobile',        
        'username',
        'password',
        'roles',
        'isblocked',
        'mailtoken',
        'isactivated',
        'userpic',
        'secret',
        'qrcodeurl'
    ]; 

    // Dates
    protected $useTimestamps = true; // Enable automatic timestamps
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at'; // Required if useSoftDeletes is true

    // Validation
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
