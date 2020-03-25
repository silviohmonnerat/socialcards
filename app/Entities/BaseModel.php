<?php
namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\BaseUpdatePdo;

class BaseModel extends Model
{
	public $incrementing = false;
	public $timestamps = false;
	protected $dateFormat = 'Y-m-d H:i:s.u';
	/**
	 * The "booting" method of the model.
	 *
	 * @return void
	 */
	protected static function boot()
	{
		parent::boot();
		static::addGlobalScope(new BaseUpdatePdo());
	}
}