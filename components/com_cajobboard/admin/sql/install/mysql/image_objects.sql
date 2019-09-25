/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Media schemas use type-per-hierarchy inheritance for extending schema
 * https://schema.org/MediaObject and schema https://schema.org/CreativeWork
 * to avoid multiple joins on query
 */

 /**
 * Image media table
 *
 * schema https://schema.org/ImageObject
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_image_objects` (
  image_object_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key',
  slug CHAR(255) NOT NULL COMMENT 'alias for SEF URL',

  /* FOF "magic" fields */
  asset_id	INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Enable record-level access control.', /* FK to the #__assets */
  access INT UNSIGNED NOT NULL DEFAULT '1' COMMENT 'The Joomla! view access level.',
  enabled TINYINT NOT NULL DEFAULT '1' COMMENT 'Publish status: -2 for trashed and marked for deletion, -1 for archived, 0 for unpublished, and 1 for published.',
  created_on DATETIME DEFAULT NULL COMMENT 'Timestamp of record creation, auto-filled by save().',
  created_by INT NOT NULL DEFAULT '0' COMMENT 'User ID who created the record, auto-filled by save().',
  modified_on DATETIME DEFAULT NULL COMMENT 'Timestamp of record modification, auto-filled by save(), touch().',
  modified_by INT DEFAULT '0' COMMENT 'User ID who modified the record, auto-filled by save(), touch().',
  locked_on DATETIME DEFAULT NULL COMMENT 'Timestamp of record locking, auto-filled by lock(), unlock().',
  locked_by INT DEFAULT '0' COMMENT 'User ID who locked the record, auto-filled by lock(), unlock().',

  /* Joomla UCM fields, used by Joomla!s UCM when using the FOF ContentHistory behaviour */
  publish_up DATETIME DEFAULT NULL COMMENT 'Date and time to change the state to published, schema.org alias is datePosted.',
  publish_down DATETIME COMMENT 'Date and time to change the state to unpublished.',
  version INT UNSIGNED NOT NULL DEFAULT '1' COMMENT 'Version of this item.',
  ordering INT NOT NULL DEFAULT '0' COMMENT 'Order this record should appear in for sorting.',
  metadata JSON COMMENT 'JSON encoded metadata field for this item.',
  metakey TEXT COMMENT 'Meta keywords for this item.',
  metadesc TEXT COMMENT 'Meta descriptionfor this item.',
  xreference TEXT COMMENT 'A reference to enable linkages to external data sets, used to output a meta tag like FB open graph.',
  params TEXT COMMENT 'JSON encoded parameters for the content item.',
  language CHAR(7) NOT NULL DEFAULT '*' COMMENT 'The language code for the article or * for all languages.',
  cat_id INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Category ID for this content item.',
  hits INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Number of hits the content item has received on the site.',
  featured TINYINT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Whether this content item is featured or not.',
  note TEXT COMMENT 'A note to save with this image object in the back-end interface.',

  /* SCHEMA: Thing */
  name VARCHAR(255) COMMENT 'A name for this image.',
  description TEXT COMMENT 'A long description of this image.',
  description__intro VARCHAR(280) COMMENT 'Short description of the item, used for the text shown on social media via shares and search engine results.',
  image JSON COMMENT 'Image metadata for social share and page header images',

  /* SCHEMA: ImageObject */
  caption VARCHAR(255) COMMENT 'Caption for the image.',
  exif_data JSON COMMENT 'JSON-encoded EXIF data for this image.',

  /* SCHEMA: MediaObject */
  content_url VARCHAR(255) COMMENT 'System filename of the image file referred to by the record. MD5 hash of original image file, same filename is used in all size folders e.g. thumb, large, etc.',
  content_size BIGINT(20) UNSIGNED COMMENT 'File size of the original image in bytes.',
  height INT UNSIGNED COMMENT 'Height of the original image in px.',
  width INT UNSIGNED COMMENT 'Width of the original image in px.',
  encoding_format CHAR(32) COMMENT 'MIME format of the image, e.g. image/gif, image/jpeg, image/png, image/svg+xml, or image/webp',

  /* SCHEMA: CreativeWork */
  content_location BIGINT UNSIGNED COMMENT 'Place depicted or described in the image.', /* FK to #__cajobboard_places */

  /* SCHEMA: Thing(additionalType) -> https://calligraphic.design/schema/AspectRatios */
  aspect_ratio CHAR(24) COMMENT 'An aspect ratio describing this image, using ENUM constants from Admin\Helper\Enum\ImageObjectSizeEnum',

  PRIMARY KEY (image_object_id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;


/*
 * Create content types for Image Objects, mapping fields to the UCM standard fields for history feature
 *
 * type_id:     auto-increment id number.
 *
 * type_title:  descriptive title for this table.
 *
 * type_alias:  <component name>.<type name>. For example: "com_content.article" or "com_content.category".
 *              Used by the com_contenthistory component to find the row for each component in the #__content_types table
 *
 * table:       JSON string that contains the name of the JTable class and other information about the table.
                Gives the com_contenthistory component the information it needs to work with the JTable class for each component.
 * rules:       Not used as of Joomla version 3.2.
 *
 * field_mappings:    Used by the com_tags component to map database columns from the component table to the ucm_content table.
 *
 * router:      Optional location of the component's router, if any.
 *
 * content_history_options:   JSON string used to store information for rendering the pop-up windows in the content history component.
 *                            Structure:
 *
 *    formfile:       This is the path to the XML JForm file for this form. If you add this, the Preview and
 *                    Compare views will look up the labels from this XML file. This way the user will see
 *                    translated labels instead of the database column name.
 *
 *    hideFields:     Some database columns are not meaningful for the user when viewing the item. For example,
 *                    asset_id or check_out_time are not things that appear in the form and are not helpful to
 *                    the user when figuring out the contents of an item. This is entered as an array of column names.
 *
 *    ignoreChanges:  The content history component uses a "hash" calculation (Sha1) to determine whether an item
 *                    has changed. This allows you to see which version in history matches the current version. It
 *                    also prevents duplicate versions from being saved in the content history table (for example,
 *                    if you press the "save" button without making any changes). For this to work properly, we need
 *                    to exclude some columns from the hash calculate. The "ignoreChanges" lets you exclude some database
 *                    columns from the hash so that changes to these columns will not be considered real changes to the
 *                    item. For example, columns such as "hits" or "modified_time" will change with each save, even if
 *                    no meaningful data was changed in the item. This is an array of database column names.
 *
 *    convertToInt:   When the hash value is created, it uses a JSON array of the database column values. In some cases,
 *                    such as start and stop publishing dates, the value might be blank when a row is first created and
 *                    then a different value after the item is saved. To get a consistent hash value for the first and
 *                    subsequent saves, these values can be converted to integers before the hash is created. That way,
 *                    we don't think a value has changed when it really hasn't. This is an array of database column names.
 *
 *    displayLookup:  Here we can define how to display more meaningful data, for example, displaying a category title
 *                    or user name instead of the ID. This is stored as an array of PHP standard class objects. Each
 *                    object has the following fields:
 *
 *        sourceColumn:  The column in the form to replace. For example, the "created_user_id" or "catid".
 *        targetTable:   The database table to get the title or name. For example, "#__users" or "#__categories".
 *        targetColumn:  The column in the target table to use in the SQL query JOIN statement. For example, "id".
 *        displayColumn: The column in the target table to display in the Preview or Compare pop-up window. For example, "name" or "title".
 */
INSERT INTO `#__content_types` (`type_id`, `type_title`, `type_alias`, `table`, `rules`, `field_mappings`, `router`, `content_history_options`)
VALUES(
  /* type_id */
  null,
  /* type_title */
  'ImageObjects',
  /* type_alias */
  'com_cajobboard.image_objects',
  /* table NOTE: No spaces, Joomla! stupidly has this set as a VARCHAR(255) field, how do you add config in that space? */
  '{
    "special":{
      "dbtable":"#__cajobboard_image_objects",
      "key":"image_object_id",
      "type":"ImageObject",
      "prefix":"ImageObjectsTable",
      "config":"array()"
    },
    "common":{
      "dbtable":"#__ucm_content",
      "key":"ucm_id",
      "type":"Corecontent",
      "prefix":"JTable",
      "config":"array()"}
    }',
  /* rules */
  '',
  /* field_mappings */
  '{
    "common":{
      "asset_id":"asset_id",
      "core_access":"access",
      "core_alias":"slug",
      "core_body":"description",
      "core_catid":"cat_id",
      "core_content_item_id":"image_object_id",
      "core_created_time":"created_on",
      "core_featured":"featured",
      "core_hits":"hits",
      "core_images":"null",
      "core_language":"language",
      "core_metadata":"metadata",
      "core_metadesc":"metadesc",
      "core_metakey":"metakey",
      "core_modified_time":"modified_on",
      "core_ordering":"null",
      "core_params":"params",
      "core_publish_down":"publish_down",
      "core_publish_up":"publish_up",
      "core_state":"enabled",
      "core_title":"name",
      "core_urls":"null",
      "core_version":"version",
      "core_xreference":"xreference"
    },
    "special":{
      "caption":"caption",
      "content_location":"content_location",
      "content_size":"content_size",
      "content_url":"content_url",
      "description__intro":"description__intro",
      "encoding_format":"encoding_format",
      "exif_data":"exif_data",
      "height":"height",
      "image":"image",
      "note":"note",
      "width":"width"
    }
  }',
  /* router */
  '',
  /* content_history_options */
  '{
    "formFile":"administrator\\/components\\/com_cajobboard\\/Form\\/common.xml",
    "hideFields":[
      "asset_id",
      "version",
      "locked_by",
      "locked_on"
    ],
    "ignoreChanges":[
      "hits",
      "modified_by",
      "modified",
      "locked_by",
      "locked_on"
    ],
    "convertToInt":[
      "publish_up",
      "publish_down"
    ],
    "displayLookup":[
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