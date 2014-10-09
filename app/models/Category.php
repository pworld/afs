<?php
class Category extends Eloquent {

	/* Soft Delete */
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];

	/* Eloquent */
	public $table = "categories";
	public $timestamps = true;

	public static $formItem = "category_items";

	public function category_items()
	{
		return $this->hasMany('CategoryItem');
	}
				
	/* Disabled Basic Actions */
	public static $disabledActions = array();

	/* Route */
	public $route = 'category';

	/* Mass Assignment */
	protected $fillable = array(
		'name',
		'code_id'
		);
	protected $guarded = array('id');

	/* Rules */
	public static $rules = array(
		'name' => 'required',
		'code_id' => 'required',
		);

	/* Database Structure */
	public static function structure()
	{
		$fields = array(
			'name' => array(
				'type' => 'text',
				'onIndex' => true
			),
			'code_id' => array(
				'type' => 'number',
				'onIndex' => true
			),
		);

		return compact('fields');
	}


}