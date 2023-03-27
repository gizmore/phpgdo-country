<?php
namespace GDO\Country;

use GDO\Core\GDO;
use GDO\Core\GDT_Char;
use GDO\Core\GDT_String;
use GDO\Core\GDT_Template;
use GDO\Core\GDT_UInt;
use GDO\Util\Strings;

/**
 * Country table and entity.
 * Renders UTF-8 flag in CLI mode.
 * Features Phone-Code.
 *
 * @TODO: More country metrics like citizens, currencies, languages and more.
 *
 * @version 7.0.1
 * @since 3.0.0
 * @author gizmore
 */
final class GDO_Country extends GDO
{

	###########
	### GDO ###
	###########
	/**
	 * Get a country by ID or return a stub object with name "Unknown".
	 */
	public static function getByISOOrUnknown(string $iso = null): self
	{
		if (($iso === null) || (!($country = self::getById($iso))))
		{
			$country = self::unknownCountry();
		}
		return $country;
	}

	##############
	### Getter ###
	##############

	public static function unknownCountry(): self
	{
		return self::blank(['c_iso' => 'ZZ']);
	}

	public function gdoColumns(): array
	{
		return [
			GDT_Char::make('c_iso')->label('id')->length(2)->ascii()->caseS()->primary(),
			GDT_Char::make('c_iso3')->length(3)->ascii()->caseS()->notNull(),
			GDT_String::make('c_phonecode')->min(2)->max(32),
			GDT_UInt::make('c_population')->bytes(8)->notNull()->initial('0'),
		];
	}

	public function getID(): ?string { return $this->gdoVar('c_iso'); }

	public function getIDFile(): string
	{
		$iso = strtolower($this->getISO());
		return $iso === 'ad' ? 'axx' : $iso;
	}

	public function getISO(): string { return $this->gdoVar('c_iso'); }

	public function getISO3(): string { return $this->gdoVar('c_iso3'); }

	public function displayEnglishName(): string { return ten('country_' . strtolower($this->getISO())); }	public function renderName(): string { return t('country_' . strtolower($this->getISO())); }







	###########
	### All ###
	###########
	/**
	 * @return self[]
	 */
	public function &allCached($order = null, $json = false): array
	{
		$all = parent::allCached($order, $json);
		return $this->allSorted($all);
	}

	public function &all(string $order = null, bool $json = false): array
	{
		return $this->allSorted(parent::all($order, $json));
	}

	private function &allSorted(array &$all): array
	{
		uasort($all, function (GDO_Country $a, GDO_Country $b)
		{
			return Strings::compare($a->renderName(), $b->renderName());
		});
		return $all;
	}

	##############
	### Render ###
	##############
	/**
	 * Render UTF-8 flag.
	 */
	public function renderCLI(): string
	{
		$iso = $this->getISO();
		$flag = '&#' . (0x1f1a5 + ord($iso[0])) . ';';
		$flag .= '&#' . (0x1f1a5 + ord($iso[1])) . ';';
		return mb_convert_encoding($flag, 'UTF-8', 'HTML-ENTITIES');
	}

	public function renderHTML(): string
	{
		return $this->renderFlag();
	}

	public function renderOption(): string
	{
		return $this->renderFlag(true);
	}

	public function renderFlag(bool $option = false): string
	{
		return GDT_Template::php('Country', 'country_html.php', ['field' => GDT_Country::make()->gdo($this), 'option' => $option]);
	}

}
