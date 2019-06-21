<?php
/*
@TODO: this model is where e-mail messages to send are queued to, using the "published" flag to indicate
       state of whether the e-mail is sent or not. The CLI script should use transactions to pull mail
       jobs from this model, doing both a query for unpublished emails to send and update them to sent
       in the same transaction to avoid concurrency issues. This model also serves a log of emails sent.

       Table fields should use Schema.org names and represent the e-mail headers (To, Bcc, etc.)
       One field is "body" or something and has a JSON object with all of the keys that correspond to the
       shortcodes used in the e-mail template associated with that object, e.g. 1:1 correspondence between
       JSON types (maybe multiple POPO classes in one file so they can be typed) and e-mail templates stored in DB.

*/
