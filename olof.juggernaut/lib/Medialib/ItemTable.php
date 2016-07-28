<?php
namespace Jugger\Medialib;

use Bitrix\Main,
	Bitrix\Main\Localization\Loc;

/**
 * Class ItemTable
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> NAME string(255) mandatory
 * <li> ITEM_TYPE string(30) mandatory
 * <li> DESCRIPTION string optional
 * <li> DATE_CREATE datetime mandatory
 * <li> DATE_UPDATE datetime mandatory
 * <li> SOURCE_ID int mandatory
 * <li> KEYWORDS string(255) optional
 * <li> SEARCHABLE_CONTENT string optional
 * </ul>
 *
 * @package Bitrix\Medialib
 **/

class ItemTable extends Main\Entity\DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'b_medialib_item';
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
				'title' => Loc::getMessage('ITEM_ENTITY_ID_FIELD'),
			),
			'NAME' => array(
				'data_type' => 'string',
				'required' => true,
				'validation' => array(__CLASS__, 'validateName'),
				'title' => Loc::getMessage('ITEM_ENTITY_NAME_FIELD'),
			),
			'ITEM_TYPE' => array(
				'data_type' => 'string',
				'required' => true,
				'validation' => array(__CLASS__, 'validateItemType'),
				'title' => Loc::getMessage('ITEM_ENTITY_ITEM_TYPE_FIELD'),
			),
			'DESCRIPTION' => array(
				'data_type' => 'text',
				'title' => Loc::getMessage('ITEM_ENTITY_DESCRIPTION_FIELD'),
			),
			'DATE_CREATE' => array(
				'data_type' => 'datetime',
				'required' => true,
				'title' => Loc::getMessage('ITEM_ENTITY_DATE_CREATE_FIELD'),
			),
			'DATE_UPDATE' => array(
				'data_type' => 'datetime',
				'required' => true,
				'title' => Loc::getMessage('ITEM_ENTITY_DATE_UPDATE_FIELD'),
			),
			'SOURCE_ID' => array(
				'data_type' => 'integer',
				'required' => true,
				'title' => Loc::getMessage('ITEM_ENTITY_SOURCE_ID_FIELD'),
			),
			'KEYWORDS' => array(
				'data_type' => 'string',
				'validation' => array(__CLASS__, 'validateKeywords'),
				'title' => Loc::getMessage('ITEM_ENTITY_KEYWORDS_FIELD'),
			),
			'SEARCHABLE_CONTENT' => array(
				'data_type' => 'text',
				'title' => Loc::getMessage('ITEM_ENTITY_SEARCHABLE_CONTENT_FIELD'),
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
	 * Returns validators for ITEM_TYPE field.
	 *
	 * @return array
	 */
	public static function validateItemType()
	{
		return array(
			new Main\Entity\Validator\Length(null, 30),
		);
	}
	/**
	 * Returns validators for KEYWORDS field.
	 *
	 * @return array
	 */
	public static function validateKeywords()
	{
		return array(
			new Main\Entity\Validator\Length(null, 255),
		);
	}
}