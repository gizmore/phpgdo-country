<?php
namespace GDO\Country;

use GDO\Core\GDT_ObjectSelect;
use GDO\Core\GDT_Template;

/**
 * Country selection field.
 * 
 * @author gizmore
 * @version 7.0.1
 * @since 6.2.1
 */
final class GDT_Country extends GDT_ObjectSelect
{
	protected function __construct()
	{
		parent::__construct();
		$this->table(GDO_Country::table());
		$this->emptyLabel('not_specified');
		$this->min = $this->max = 2;
		$this->icon('flag');
		$this->withCompletion();
	}
	
	public function withCompletion()
	{
		return $this->completionHref(href('Country', 'Completion'));
	}
	
	public function defaultLabel() { return $this->label('country'); }
	
	public function configJSON()
	{
	    return array_merge(parent::configJSON(), array(
			'completionHref' => $this->completionHref,
		));
	}
	
	public function renderCell()
	{
		return GDT_Template::php('Country', 'cell/country.php', ['field'=>$this]);
	}
	
	public $withName = true;
	public function withName($withName=true)
	{
		$this->withName = $withName;
		return $this;
	}
	
}
