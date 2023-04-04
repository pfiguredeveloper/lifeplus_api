<?php
namespace App\Models\LifeCellUsers;
use Illuminate\Database\Eloquent\Model;

class ClientPermissions extends Model
{
    protected $connection = 'lifecell_users';
    protected $table      = 'permissions';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','title',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Models\LifeCellUsers\ClientRoles','permission_role','role_id','permission_id');
    }

    public static function savePermissions($postData)
    {
    	if(!empty($postData['id'])) {
    		$permissionsInfo = self::where('id', $postData['id'])->first();
    	} else {
    		$permissionsInfo = new self();
    	}
        $permissionsInfo['title']  = !empty($postData['title']) ? $postData['title'] : '';
        $permissionsInfo->save();
        return $permissionsInfo;
    }
}