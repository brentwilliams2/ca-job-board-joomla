

/*
https://schema.org/Message

bccRecipient  ContactPoint or Organization or Person  A sub property of recipient. The recipient blind copied on a message.
ccRecipient  ContactPoint or Organization or Person  A sub property of recipient. The recipient copied on a message.
dateRead  DateTime  The date/time at which the message has been read by the recipient if a single recipient exists.
dateReceived  DateTime  The date/time the message was received if a single recipient exists.
dateSent  DateTime  The date/time at which the message was sent.
messageAttachment  CreativeWork  A CreativeWork attached to the message.
recipient  Audience ContactPoint or Organization or Person  A sub property of participant. The participant who is at the receiving end of the action.
sender  Audience ContactPoint or Organization or Person  A sub property of participant. The participant who is at the sending end of the action.
toRecipient  Audience ContactPoint or Organization or Person A sub property of recipient. The recipient who was directly sent the message.

*/

#__messages

message_idPrimary  int(10)   UNSIGNED AUTO_INCREMENT
user_id_from       int(10)   UNSIGNED DEFAULT 0
user_id_toIndex    int(10)   UNSIGNED DEFAULT 0
folder_id          tinyint(3)  UNSIGNED DEFAULT 0
date_time          datetime   DEFAULT 0000-00-00 00:00:00
stateIndex         tinyint(1)  DEFAULT 0
priority           tinyint(1)  UNSIGNED DEFAULT 0
subject            varchar(255)
message            text

#__messages_cfg

user_idIndex       int(10)   UNSIGNED  DEFAULT 0
cfg_nameIndex      varchar(100)
cfg_value          varchar(255)

/*
  this is different than emails, because it stores the message on the system (not just a template)
  so does it need a MessageTemplates model to generate the template for the message on the fly?
  Or does it just display text only messages? Being able to pass rich media files would be a nice
  feature.

  @TODO: Use heavy caching of templates to avoid database load

  @TODO: How to maintain an aggregate count of total messages read / total unread for a user - as an additional field to user profile?
*/
