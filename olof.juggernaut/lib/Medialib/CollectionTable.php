<?php

namespace Jugger\Medialib;

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;

/**
 * Class CollectionTable
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> NAME string(255) mandatory
 * <li> DESCRIPTION string optional
 * <li> ACTIVE bool optional default 'Y'
 * <li> DATE_UPDATE datetime mandatory
 * <li> OWNER_ID int optional
 * <li> PARENT_ID int optional
 * <li> SITE_ID string(2) optional
 * <li> KEYWORDS string(255) optional
 * <li> ITEMS_COUNT int optional
 * <li> ML_TYPE int mandatory
 * </ul>
 *
 * @package Bitrix\Medialib
 **/

class CollectionTable extends Main\Entity\DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'b_medialib_collection';
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
				'title' => Loc::getMessage('COLLECTION_ENTITY_ID_FIELD'),
			),
			'NAME' => array(
				'data_type' => 'string',
				'required' => true,
				'validation' => array(__CLASS__, 'validateName'),
				'title' => Loc::getMessage('COLLECTION_ENTITY_NAME_FIELD'),
			),
			'DESCRIPTION' => array(
				'data_type' => 'text',
				'title' => Loc::getMessage('COLLECTION_ENTITY_DESCRIPTION_FIELD'),
			),
			'ACTIVE' => array(
				'data_type' => 'boolean',
				'values' => array('N', 'Y'),
				'title' => Loc::getMessage('COLLECTION_ENTITY_ACTIVE_FIELD'),
			),
			'DATE_UPDATE' => array(
				'data_type' => 'datetime',
				'required' => true,
				'title' => Loc::getMessage('COLLECTION_ENTITY_DATE_UPDATE_FIELD'),
			),
			'OWNER_ID' => array(
				'data_type' => 'integer',
				'title' => Loc::getMessage('COLLECTION_ENTITY_OWNER_ID_FIELD'),
			),
			'PARENT_ID' => array(
				'data_type' => 'integer',
				'title' => Loc::getMessage('COLLECTION_ENTITY_PARENT_ID_FIELD'),
			),
			'SITE_ID' => array(
				'data_type' => 'string',
				'validation' => array(__CLASS__, 'validateSiteId'),
				'title' => Loc::getMessage('COLLECTION_ENTITY_SITE_ID_FIELD'),
			),
			'KEYWORDS' => array(
				'data_type' => 'string',
				'validation' => array(__CLASS__, 'validateKeywords'),
				'title' => Loc::getMessage('COLLECTION_ENTITY_KEYWORDS_FIELD'),
			),
			'ITEMS_COUNT' => array(
				'data_type' => 'integer',
				'title' => Loc::getMessage('COLLECTION_ENTITY_ITEMS_COUNT_FIELD'),
			),
			'ML_TYPE' => array(
				'data_type' => 'integer',
				'required' => true,
				'title' => Loc::getMessage('COLLECTION_ENTITY_ML_TYPE_FIELD'),
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
	 * Returns validators for SITE_ID field.
	 *
	 * @return array
	 */
	public static function validateSiteId()
	{
		return array(
			new Main\Entity\Validator\Length(null, 2),
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