<?php
namespace GDO\Country;

/**
 * Install country data.
 *
 * @author gizmore
 */
final class InstallCountries
{

	public static function install()
	{
		$module = Module_Country::instance();
		$path = $module->filePath('data/countries.csv');

		if ($fh = fopen($path, 'r'))
		{
			# Build csv index names from header row
			$headers = fgetcsv($fh, null, ';');
			$cca2 = array_search('cca2', $headers);
			$cca3 = array_search('cca3', $headers);
			$phone = array_search('callingCode', $headers);

			$data = [];

			# Loop
			while ($row = fgetcsv($fh, null, ';'))
			{
				if (count($row) > 3)
				{
					if (!GDO_Country::getById($row[$cca2]))
					{
						$data[] = [
							'c_iso' => $row[$cca2],
							'c_iso3' => $row[$cca3],
							'c_phonecode' => $row[$phone],
							'c_population' => '0',
						];
					}
				}
			}

			fclose($fh);

			$fields = GDO_Country::table()->gdoColumnsOnly('c_iso', 'c_iso3', 'c_phonecode', 'c_population');
			GDO_Country::bulkInsert($fields, $data);
		}
	}

}
