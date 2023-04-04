<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Family_group extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'family_group';
    protected $primaryKey = 'GCODE';
    public $timestamps    = false;

    protected $fillable = [
        'GCODE','GNM','GADDRESS','GAD1','GAD2','GAD3','GPIN','GPHON_R','GPHON_O','CITYID','CITY','SELECT','GMOBILE','GEMAIL','LIFEPLUSID','DEMODATA','ARECD','OCODE','client_id','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$familygroupInfo = self::where('GCODE', $postData['id'])->first();
    	} else {
    		$familygroupInfo = new self();
    	}
        $familygroupInfo['GNM']        = !empty($postData['GNM']) ? $postData['GNM'] : '';
        $familygroupInfo['GADDRESS']   = !empty($postData['GADDRESS']) ? $postData['GADDRESS'] : '';
        $familygroupInfo['GAD1']       = !empty($postData['GAD1']) ? $postData['GAD1'] : '';
        $familygroupInfo['GAD2']       = !empty($postData['GAD2']) ? $postData['GAD2'] : '';
        $familygroupInfo['GAD3']       = !empty($postData['GAD3']) ? $postData['GAD3'] : '';
        $familygroupInfo['GPIN']       = !empty($postData['GPIN']) ? $postData['GPIN'] : 0;
        $familygroupInfo['GPHON_R']    = !empty($postData['GPHON_R']) ? $postData['GPHON_R'] : '';
        $familygroupInfo['GPHON_O']    = !empty($postData['GPHON_O']) ? $postData['GPHON_O'] : '';
        $familygroupInfo['CITYID']     = !empty($postData['CITYID']) ? $postData['CITYID'] : 0;
        $familygroupInfo['CITY']       = !empty($postData['CITY']) ? $postData['CITY'] : '';
        $familygroupInfo['SELECT']     = !empty($postData['SELECT']) ? $postData['SELECT'] : '';
        $familygroupInfo['GMOBILE']    = !empty($postData['GMOBILE']) ? $postData['GMOBILE'] : '';
        $familygroupInfo['GEMAIL']     = !empty($postData['GEMAIL']) ? $postData['GEMAIL'] : '';
        $familygroupInfo['LIFEPLUSID'] = !empty($postData['LIFEPLUSID']) ? $postData['LIFEPLUSID'] : 0;
        $familygroupInfo['DEMODATA']   = !empty($postData['DEMODATA']) ? $postData['DEMODATA'] : '';
        $familygroupInfo['ARECD']      = !empty($postData['ARECD']) ? $postData['ARECD'] : 0;
        $familygroupInfo['OCODE']      = !empty($postData['OCODE']) ? $postData['OCODE'] : 0;
        $familygroupInfo['client_id']  = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $familygroupInfo->save();
        return $familygroupInfo;
    }
}