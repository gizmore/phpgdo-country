<?php
namespace GDO\Country;

use GDO\Core\GDT_ObjectSelect;
use GDO\Core\GDT_Template;
use GDO\Table\GDT_Filter;
use GDO\User\GDO_User;
use GDO\Util\Strings;

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
		$this->min = 2;
        $this->max = 2;
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

    public function renderFilter(GDT_Filter $f): string
    {
        return GDT_Template::php('Core', 'select_filter.php', ['f' => $f, 'field' => $this]);
    }

    protected function getChoices(): array
    {
        $choices = parent::getChoices();
        $u = GDO_User::current();
        uasort($choices, function(GDO_Country $c1, GDO_Country $c2) use ($u){
            return Strings::compare($c1->displayNameForUser($u), $c2->displayNameForUser($u));
        });
        return $choices;
    }


}
