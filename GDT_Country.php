<?php
namespace GDO\Country;

use GDO\Core\GDT_ObjectSelect;
use GDO\Core\GDT_Template;

/**
 * Country selection field.
 * - Optional name label? Oo
 *
 * @version 7.0.1
 * @since 6.2.1
 * @author gizmore
 */
class GDT_Country extends GDT_ObjectSelect
{

	public bool $withName = true;

	protected function __construct()
	{
		parent::__construct();
		$this->table(GDO_Country::table());
		$this->emptyLabel('not_specified');
//		$this->min = $this->max = 2;
		$this->icon('flag');
 		$this->withCompletion();
	}

	public function gdtDefaultLabel(): ?string
    {
        return 'country';
    }

	##############
	### Render ###
	##############

	public function renderCell(): string
	{
		return GDT_Template::php('Country', 'country_html.php', ['field' => $this, 'option' => false]);
	}

// 	public function configJSON() : array
// 	{
// 	    return array_merge(parent::configJSON(), [
// 			'completionHref' => $this->completionHref,
// 		]);
// 	}

	##################
	### Name Label ###
	##################

	public function withCompletion()
	{
		return $this->completionHref(href('Country', 'Completion', '&_fmt=json'));
	}

	public function withName(bool $withName = true): self
	{
		$this->withName = $withName;
		return $this;
	}

}
