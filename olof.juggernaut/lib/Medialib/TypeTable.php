<?php
namespace Jugger\Medialib;

use Bitrix\Main,
	Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

/**
 * Class TypeTable
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> NAME string(255) optional
 * <li> CODE string(255) mandatory
 * <li> EXT string(255) mandatory
 * <li> SYSTEM bool optional default 'N'
 * <li> DESCRIPTION string optional
 * </ul>
 *
 * @package Bitrix\Medialib
 **/

class TypeTable extends Main\Entity\DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'b_medialib_type';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return array(
			'ID' => array(
				'data_type' => 'integer',
				'primary' => true,
				'autocomplete' => true,
				'title' => Loc::getMessage('TYPE_ENTITY_ID_FIELD'),
			),
			'NAME' => array(
				'data_type' => 'string',
				'validation' => array(__CLASS__, 'validateName'),
				'title' => Loc::getMessage('TYPE_ENTITY_NAME_FIELD'),
			),
			'CODE' => array(
				'data_type' => 'string',
				'required' => true,
				'validation' => array(__CLASS__, 'validateCode'),
				'title' => Loc::getMessage('TYPE_ENTITY_CODE_FIELD'),
			),
			'EXT' => array(
				'data_type' => 'string',
				'required' => true,
				'validation' => array(__CLASS__, 'validateExt'),
				'title' => Loc::getMessage('TYPE_ENTITY_EXT_FIELD'),
			),
			'SYSTEM' => array(
				'data_type' => 'boolean',
				'values' => array('N', 'Y'),
				'title' => Loc::getMessage('TYPE_ENTITY_SYSTEM_FIELD'),
			),
			'DESCRIPTION' => array(
				'data_type' => 'text',
				'title' => Loc::getMessage('TYPE_ENTITY_DESCRIPTION_FIELD'),
			),
		);
	}
	/**
	 * Returns validators for NAME field.
	 *
	 * @return array
	 */
	public static function validateName()
	{
		return array(
			new Main\Entity\Validator\Length(null, 255),
		);
	}
	/**
	 * Returns validators for CODE field.
	 *
	 * @return array
	 */
	public static function validateCode()
	{
		return array(
			new Main\Entity\Validator\Length(null, 255),
		);
	}
	/**
	 * Returns validators for EXT field.
	 *
	 * @return array
	 */
	public static function validateExt()
	{
		return array(
			new Main\Entity\Validator\Length(null, 255),
		);
	}
}