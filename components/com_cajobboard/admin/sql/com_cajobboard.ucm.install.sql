/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Calligraphic unified content model (UCM) table
 *
 * This table is used to implement table-per-type inheritance for job board tables with common fields
 */
CREATE TABLE IF NOT EXISTS '#__cajobboard_ucm' (
  'id' BIGINT UNSIGNED NOT NULL AUTO_INCREMENT=0,
  'slug' CHAR(50) NOT NULL COMMENT 'alias for SEF URL',
  /* FOF "magic" fields */
  'asset_id'	INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'FK to the #__assets table for access control purposes',
  'access' INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'The Joomla! view access level',
  'enabled' TINYINT(3) NOT NULL DEFAULT '0' COMMENT 'Publish status: -2 for trashed and marked for deletion, -1 for archived, 0 for unpublished, and 1 for published',
  'ordering' BIGINT(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'order this record should appear in for sorting',
  'created_on' DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Timestamp of record creation, auto-filled by save()',
  'created_by' INT(11) NOT NULL DEFAULT '0' COMMENT 'user ID who created the record, auto-filled by save()',
  'modified_on' DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Timestamp of record modification, auto-filled by save(), touch()',
  'modified_by' INT(11) NOT NULL DEFAULT '0' COMMENT 'user ID who modified the record, auto-filled by save(), touch()',
  'locked_on' DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'timestamp of record locking, auto-filled by lock(), unlock()',
  'locked_by' INT(11) NOT NULL DEFAULT '0' COMMENT 'user ID who locked the record, auto-filled by lock(), unlock()',
  /* Joomla UCM fields, used by Joomla!s UCM when using the FOF ContentHistory behaviour */
  'publish_up' DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'date and time to change the state to published, schema.org alias is datePosted',
  'publish_down' DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'date and time to change the state to unpublished',
  'version' INT(10) UNSIGNED NOT NULL DEFAULT '1' COMMENT '',
  'ordering' INT(11) NOT NULL DEFAULT '0' COMMENT '',
  'metadata' JSON COMMENT 'JSON encoded metadata field for this item',
  'metakey' MEDIUMTEXT NOT NULL COMMENT 'meta keywords for this item',
  'metadesc' MEDIUMTEXT NOT NULL COMMENT '',
  'xreference' VARCHAR(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets, used to output a meta tag like FB open graph.',
  'params' MEDIUMTEXT NOT NULL COMMENT 'JSON encoded parameters for the content item.',
  'language' CHAR(7) NOT NULL COMMENT 'The language code for the article or * for all languages.',
  'cat_id' INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Category ID for this content item.',
  'hits' INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Number of hits the content item has received on the site.',
  'featured' TINYINT(4) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Whether this content item is featured or not.',
  INDEX ucm_slug_index (slug),
  PRIMARY KEY ('id')
) ENGINE=innoDB DEFAULT CHARSET=utf8;


/*
 * Create content type for this table, mapping fields to the UCM standard fields for history feature
 */
INSERT INTO `#__content_types` (`type_id`, `type_title`, `type_alias`, `table`, `rules`, `field_mappings`, `router`, `content_history_options`)
VALUES(
  null, /* type_id */
  'Example Category', /* type_title */
  'com_cajobboard.category', /* type_alias */
  '{
    "common":{
      "dbtable":"#__ucm_content",
      "key":"ucm_id",
      "type":"Corecontent",
      "prefix":"JTable",
      "config":"array()"
    },
    "special":{
        "dbtable":"#__categories",
        "key":"id",
        "type":"Category",
        "prefix":"JTable",
        "config":"array()"
    }
  }', /* table */
  '', /* rules */
  '{
    "common":{
        "core_content_item_id":"id",
        "core_title":"title",
        "core_state":"published",
        "core_alias":"alias",
        "core_created_time":"created_time",
        "core_modified_time":"modified_time",
        "core_body":"description",
        "core_hits":"hits",
        "core_publish_up":"publish_up",
        "core_publish_down":"publish_down",
        "core_access":"access",
        "core_params":"params",
        "core_featured":"featured",
        "core_metadata":"metadata",
        "core_metakey":"metakey",
        "core_metadesc":"metadesc",
        "core_language":"language",
        "core_images":"null",
        "core_urls":"null",
        "core_version":"version",
        "core_ordering":"null",
        "core_catid":"cat_id",
        "core_xreference":"xreference",
        "asset_id":"asset_id"
    },
    "special":{
        "parent_id":"parent_id",
        "lft":"lft",
        "rgt":"rgt",
        "level":"level",
        "path":"path",
        "extension":"extension",
        "note":"note"
    }
  }', /* field_mappings */
  'CajobboardHelperRoute::getCategoryRoute', /* router */
  '{
    "formFile":"administrator\\/components\\/com_categories\\/models\\/forms\\/category.xml",
    "hideFields":[
        "asset_id",
        "checked_out",
        "checked_out_time",
        "version",
        "lft",
        "rgt",
        "level",
        "path",
        "extension"
    ],
  }' /* content_history_options */
);

/*
 *
 */
INSERT INTO `#__content_types` (`type_id`, `type_title`, `type_alias`, `table`, `rules`, `field_mappings`, `router`, `content_history_options`)
VALUES(
  null, /* type_id */
  'Cajobboards', /* type_title */
  'com_cajobboard.subscription', /* type_alias */
  '{
    "special":{
        "dbtable":"#__cajobboard_example",
        "key":"id",
        "type":"Example",
        "prefix":"CajobboardTable"
    }
  }', /* table */
  '', '', '', ''
);

/*
 * Set up pop-up fields for history comparison screens in admin UI
 */
INSERT INTO `#__content_types` (`type_id`, `type_title`, `type_alias`, `table`, `rules`, `field_mappings`, `router`, `content_history_options`)
VALUES(
  null,
  'Example',
  'com_cajobboard.example',
  '{
   "special":{
      "dbtable":"#__cajobboard_example",
      "key":"id",
      "type":"Examplen",
      "prefix":"CajobboardTable"
   }
  }',
  '', '', '',
  '{
    "formFile":"administrator\\/components\\/com_joomprosubs\\/models\\/forms\\/example.xml",
    "hideFields":[
        "checked_out",
        "checked_out_time",
        "params",
        "language"
    ],
    "ignoreChanges":[
        "modified_by",
        "modified",
        "checked_out",
        "checked_out_time"
    ],
    "convertToInt":[
        "publish_up",
        "publish_down"
    ],
    "displayLookup":[
        {
          "sourceColumn":"catid",
          "targetTable":"#__categories",
          "targetColumn":"id",
          "displayColumn":"title"
        },
        {
          "sourceColumn":"group_id",
          "targetTable":"#__usergroups",
          "targetColumn":"id",
          "displayColumn":"title"
        },
        {
          "sourceColumn":"created_by",
          "targetTable":"#__users",
          "targetColumn":"id",
          "displayColumn":"name"
        },
        {
          "sourceColumn":"access",
          "targetTable":"#__viewlevels",
          "targetColumn":"id",
          "displayColumn":"title"
        },
        {
          "sourceColumn":"modified_by",
          "targetTable":"#__users",
          "targetColumn":"id",
          "displayColumn":"name"
        }
    ]
  }'
);
