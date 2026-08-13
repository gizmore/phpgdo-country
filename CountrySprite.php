<?php
declare(strict_types=1);
namespace GDO\Country;

/**
 * Builds the deterministic ISO-3166 alpha-2 flag sprite.
 *
 * Each ISO code occupies the cell [first letter, second letter] in a 26×26
 * grid. Keeping this derivation next to the source flags makes the generated
 * asset reproducible on every module install.
 */
final class CountrySprite
{
	public const TILE_WIDTH = 32;
	public const TILE_HEIGHT = 24;
	public const LETTERS = 26;

	/** Return the background position for one ISO-alpha-2 sprite cell. */
	public static function backgroundPosition(string $code): string
	{
		$code = strtoupper($code);
		if (!preg_match('/^[A-Z]{2}$/', $code))
		{
			$code = 'ZZ';
		}
		$x = (ord($code[0]) - ord('A')) * self::TILE_WIDTH;
		$y = (ord($code[1]) - ord('A')) * self::TILE_HEIGHT;
		return "-{$x}px -{$y}px";
	}

	public static function build(?string $output = null): int
	{
		if (!function_exists('imagecreatetruecolor'))
		{
			error_log('Country sprite skipped: PHP GD extension is unavailable.');
			return 0;
		}

		$sourceDir = __DIR__ . '/img';
		$output ??= "{$sourceDir}/country-sprite.png";
		$sprite = imagecreatetruecolor(self::TILE_WIDTH * self::LETTERS, self::TILE_HEIGHT * self::LETTERS);
		imagealphablending($sprite, false);
		imagesavealpha($sprite, true);
		$transparent = imagecolorallocatealpha($sprite, 0, 0, 0, 127);
		imagefill($sprite, 0, 0, $transparent);

		$written = 0;
		foreach (glob("{$sourceDir}/*.png") as $filename)
		{
			$code = strtoupper(pathinfo($filename, PATHINFO_FILENAME));
			if (!preg_match('/^[A-Z]{2}$/', $code))
			{
				continue;
			}
			$flag = @imagecreatefromstring((string) file_get_contents($filename));
			if (!$flag)
			{
				error_log("Country sprite skipped unreadable flag: {$filename}");
				continue;
			}
			$sourceWidth = imagesx($flag);
			$sourceHeight = imagesy($flag);
			$scale = min(self::TILE_WIDTH / $sourceWidth, self::TILE_HEIGHT / $sourceHeight);
			$width = (int) round($sourceWidth * $scale);
			$height = (int) round($sourceHeight * $scale);
			$x = (ord($code[0]) - ord('A')) * self::TILE_WIDTH + intdiv(self::TILE_WIDTH - $width, 2);
			$y = (ord($code[1]) - ord('A')) * self::TILE_HEIGHT + intdiv(self::TILE_HEIGHT - $height, 2);
			imagealphablending($sprite, true);
			imagecopyresampled($sprite, $flag, $x, $y, 0, 0, $width, $height, $sourceWidth, $sourceHeight);
			imagedestroy($flag);
			$written++;
		}

		if (!imagepng($sprite, $output, 6))
		{
			imagedestroy($sprite);
			throw new \RuntimeException("Could not write country sprite: {$output}");
		}
		imagedestroy($sprite);
		return $written;
	}
}
