<?php
namespace GDO\Country;

use GDO\Core\GDO_Module;
use GDO\UI\GDT_Divider;

/**
 * Country related functionality.
 *
 * @version 7.0.1
 * @since 3.0.0
 * @author gizmore
 */
class Module_Country extends GDO_Module
{

	public int $priority = 10;

	##############
	### Module ###
	##############
	public function thirdPartyFolders(): array { return ['/img/']; }

	public function getClasses(): array { return [GDO_Country::class]; }

	public function onInstall(): void { InstallCountries::install(); }

	public function onLoadLanguage(): void { $this->loadLanguage('lang/country'); }

	##############
	### Config ###
	##############
	public function getUserSettings(): array
	{
		return [
			GDT_Country::make('country_of_living')->label('country_of_living'),
			GDT_Country::make('country_of_origin')->label('country_of_origin'),
		];
	}

	public function getPrivacyRelatedFields(): array
	{
		return [
			GDT_Divider::make('privacy_info_country_module'),
			$this->setting('country_of_living'),
			$this->setting('country_of_origin'),
		];
	}

}
