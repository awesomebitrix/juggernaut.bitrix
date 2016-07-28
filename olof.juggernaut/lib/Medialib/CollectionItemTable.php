<?php
namespace Jugger\Medialib;

use Bitrix\Main,
	Bitrix\Main\Localization\Loc;

/**
 * Class CollectionItemTable
 * 
 * Fields:
 * <ul>
 * <li> COLLECTION_ID int mandatory
 * <li> ITEM_ID int mandatory
 * </ul>
 *
 * @package Bitrix\Medialib
 **/

class CollectionItemTable extends Main\Entity\DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'b_medialib_collection_item';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return array(
			'COLLECTION_ID' => array(
				'data_type' => 'integer',
				'primary' => true,
				'title' => Loc::getMessage('COLLECTION_ITEM_ENTITY_COLLECTION_ID_FIELD'),
			),
			'ITEM_ID' => array(
				'data_type' => 'integer',
				'primary' => true,
				'title' => Loc::getMessage('COLLECTION_ITEM_ENTITY_ITEM_ID_FIELD'),
			),
                        "COLLECTION" => new Main\Entity\ReferenceField(
                            "COLLECTION", 
                            'Jugger\Medialib\CollectionTable', 
                            ["=this.COLLECTION_ID" => "ref.ID"]
                        ),
                        "ITEM" => new Main\Entity\ReferenceField(
                            "ITEM", 
                            'Jugger\Medialib\ItemTable', 
                            ["=this.ITEM_ID" => "ref.ID"]
                        ),
		);
	}
}