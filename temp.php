<?php

function myFunc ($data) 
{
  $category = new stdClass();

  foreach ($data as $property => $value) {
    $category->$property = $value;
  }

  var_dump($category);
}

$categories = json_decode('{
    "0": {
      "title": "Places",
      "alias": "places",
      "note": "",
      "description": "<p>Images depicting a place or location</p>",
      "metadesc": "",
      "params": {
        "category_layout": "",
        "image": "",
        "image_alt": "",
        "thumbnail_aspect_ratio": "aspect-ratio-4-3",
        "image_aspect_ratio": "aspect-ratio-4-3"
      },
      "metadata": {
        "author": "",
        "robots": ""
      }
    },
    "1": {
      "title": "Persons",
      "alias": "persons",
      "note": "",
      "description": "<p>Thumbnail images representing a user</p>",
      "metadesc": "",
      "params": {
        "category_layout": "",
        "image": "",
        "image_alt": "",
        "thumbnail_aspect_ratio": "aspect-ratio-1-1",
        "image_aspect_ratio": "aspect-ratio-4-3"
      },
      "metadata": {
        "author": "",
        "robots": ""
      }
    },
    "2": {
      "title": "Organizations",
      "alias": "organizations",
      "note": "",
      "description": "<p>Logo images for an organization</p>",
      "metadesc": "",
      "params": {
        "category_layout": "",
        "image": "",
        "image_alt": "",
        "thumbnail_aspect_ratio": "aspect-ratio-4-3",
        "image_aspect_ratio": "aspect-ratio-4-3"
      },
      "metadata": {
        "author": "",
        "robots": ""
      }
    }
}', true);


foreach ($categories as $data)
{
  $data['params'] = json_encode($data['params']);
  $data['metadata'] = json_encode($data['metadata']);
  $data['extension']        = "com_cajobboard";
  $data['published']        = "1";
  $data['access']           = "1";
  $data['created_user_id']  = "0";
  $data['language']         = "*";

  myFunc($data);
}
