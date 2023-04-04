<?php
namespace App\Models\LifeCell;
use Illuminate\Database\Eloquent\Model;

class Bonus2020 extends Model
{
    protected $connection = 'lifecell';
    protected $table      = 'bonus_2020';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','field1', 'field4', 'field5','sa_min','sa_max','rate',
    ];

    public static function saveBonus($postData)
    {
    	if(!empty($postData['id'])) {
    		$bonusInfo = self::where('id', $postData['id'])->first();
    	} else {
    		$bonusInfo = new self();
    	}
        $bonusInfo['field1']   = !empty($postData['field1']) ? $postData['field1'] : '';
        $bonusInfo['field4']   = !empty($postData['field4']) ? $postData['field4'] : '';
        $bonusInfo['field5']   = !empty($postData['field5']) ? $postData['field5'] : '';
        $bonusInfo['sa_min']   = !empty($postData['sa_min']) ? $postData['sa_min'] : '';
        $bonusInfo['sa_max']   = !empty($postData['sa_max']) ? $postData['sa_max'] : '';
        $bonusInfo['rate']     = !empty($postData['rate']) ? $postData['rate'] : '';
        $bonusInfo->save();
        return $bonusInfo;
    }
}

