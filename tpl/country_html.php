<?php
namespace GDO\Country\tpl;

use GDO\Country\GDO_Country;
use GDO\Country\GDT_Country;

/** @var $field GDT_Country * */
$country = isset($field->gdo) ? $field->gdo : null;
if (!($country instanceof GDO_Country))
{
	if ($id = $field->getVar())
	{
		$country = GDO_Country::getById($field->getVar());
	}
}
?>
<span class="gdo-country">
<?php
if ($country instanceof GDO_Country) :
	$id = $country->getID();
	$name = $country->renderName();
	if ($option)
	{
		echo $country->renderCLI() . '&nbsp;' . $name;
		return;
	}
	?>
    <img
            alt="<?=$id?>"
            title="<?=$name?>"
            src="<?=GDO_WEB_ROOT?>GDO/Country/img/<?=$id?>.png"></img>
<?php
	if ($field->withName) : ?>
        <span><?=$name?></span>
	<?php
	endif; ?>
<?php
else : ?>
	<?php
	if ($option)
	{
		echo $country->renderCLI() . '&nbsp;' . t('unknown_country');
		return;
	}
	?>
    <img
            alt="??"
            title="<?=t('unknown_country')?>"
            src="<?=GDO_WEB_ROOT?>GDO/Country/img/ZZ.png"></img>
<?php
	if ($field->withName) : ?>
        <span><?=t('unknown_country')?></span>
	<?php
	endif; ?>
<?php
endif; ?>
</span>
