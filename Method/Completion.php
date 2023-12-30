<?php
namespace GDO\Country\Method;

use GDO\Core\GDO;
use GDO\Core\GDT_String;
use GDO\Core\MethodCompletion;
use GDO\Core\MethodCompletionArray;
use GDO\Country\GDO_Country;
use GDO\User\GDO_User;

/**
 * Autocomplete adapter for countries.
 *
 * @version 7.0.1
 * @since 6.0.0
 * @author gizmore
 */
final class Completion extends MethodCompletionArray
{

	public function getMethodTitle(): string
	{
		return t('countries');
	}


    protected function gdoTable(): GDO
    {
        return GDO_Country::table();
    }

    protected function getHeaders(): array
    {
        return [
            GDT_String::make('c_iso'),
            GDT_String::make('english_name'),
            GDT_String::make('language_name'),
        ];
    }

    protected function getItems(): array
    {
        $countries = GDO_Country::table()->allCached();
        foreach ($countries as $country)
        {
            /** @var GDO_Country $country */
            $country->setVar('english_name', $country->displayEnglishName());
            $country->setVar('language_name', $country->displayNameForUser(GDO_User::current()));
        }
    }
}
