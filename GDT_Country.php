<?php
namespace GDO\Country;

use GDO\Core\GDT_ObjectSelect;
use GDO\Core\GDT_Template;

/**
 * Country selection field.
 * - Optional name label? Oo
 * 
 * @author gizmore
 * @version 7.0.1
 * @since 6.2.1
 */
final class GDT_Country extends GDT_ObjectSelect
{
	public function defaultLabel() : self { return $this->label('country'); }
	
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
	
	##############
	### Render ###
	##############
	public function renderHTML() : string
	{
		return GDT_Template::php('Country', 'country_html.php', ['field' => $this]);
	}
	
	public function configJSON() : array
	{
	    return array_merge(parent::configJSON(), [
			'completionHref' => $this->completionHref,
		]);
	}
	
	##################
	### Name Label ###
	##################
	public bool $withName = true;
	public function withName(bool $withName=true) : self
	{
		$this->withName = $withName;
		return $this;
	}
	
}
