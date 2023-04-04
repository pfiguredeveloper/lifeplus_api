<?php
namespace App\Models\LifeCellUsers;
use Illuminate\Database\Eloquent\Model;
use App\Models\LifeCellUsers\ClientPermissionsRole;

class ClientRoles extends Model
{
    protected $connection = 'lifecell_users';
    protected $table      = 'roles';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','title',
    ];

    public function permissions()
    {
        return $this->belongsToMany('App\Models\LifeCellUsers\ClientPermissions','permission_role','role_id','permission_id');
    }

    public static function saveRoles($postData)
    {
    	if(!empty($postData['id'])) {
    		$rolesInfo = self::where('id', $postData['id'])->first();
    	} else {
    		$rolesInfo = new self();
    	}
        $rolesInfo['title']  = !empty($postData['title']) ? $postData['title'] : '';
        $rolesInfo->save();
        if(!empty($postData['permissions'])) {
            $perRole = ClientPermissionsRole::where('role_id',$rolesInfo['id'])->get();
            if(!empty($perRole) && count($perRole) > 0) {
                foreach ($perRole as $key => $value) {
                    $value->delete();
                }
            }
            foreach ($postData['permissions'] as $key => $value) {
                ClientPermissionsRole::savePermissionsRole($value,$rolesInfo['id']);
            }
        }
        return $rolesInfo;
    }
}