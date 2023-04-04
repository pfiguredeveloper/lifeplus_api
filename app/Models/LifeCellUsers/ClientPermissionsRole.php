<?php
namespace App\Models\LifeCellUsers;
use Illuminate\Database\Eloquent\Model;

class ClientPermissionsRole extends Model
{
    protected $connection = 'lifecell_users';
    protected $table      = 'permission_role';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','role_id','permission_id',
    ];

    public static function savePermissionsRole($permission_id = 0,$role_id = 0)
    {
    	$perRoleInfo                   = new self();
    	$perRoleInfo['role_id']        = $role_id;
        $perRoleInfo['permission_id']  = $permission_id;
        $perRoleInfo->save();
        return $perRoleInfo;
    }
}