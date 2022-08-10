<?php
namespace GDO\Country\tpl;
use GDO\Country\GDO_Country;
/** @var $field \GDO\Country\GDT_Country **/
$country = isset($field->gdo) ? $field->gdo : null;
if (!($country instanceof GDO_Country))
{
	if ($id = $field->getVar())
	{
		$country = GDO_Country::getById($field->getVar());
	}
}
?>
<div class="gdo-country">
<?php
if ($country instanceof GDO_Country) :
$id = $country->getID();
$name = $country->renderName();
?>
 <img
  alt="<?=$id?>"
  title="<?=$name?>"
  src="<?=GDO_WEB_ROOT?>GDO/Country/img/<?=$id?>.png" ></img>
<?php if ($field->withName) : ?>
 <span><?=$name?></span>
<?php endif; ?>
<?php else : ?>
 <img
  alt="??"
  title="<?=t('unknown_country')?>"
  src="<?=GDO_WEB_ROOT?>GDO/Country/img/ZZ.png" ></img>
<?php if ($field->withName) : ?>
 <span><?=t('unknown_country')?></span>
<?php endif; ?>
<?php endif; ?>
</div>
