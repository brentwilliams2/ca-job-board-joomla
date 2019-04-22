<?php
/**
 * Multi Family Insiders Bootstrap V3 Template
 *
 * This partial handles catching system errors and pretty-printing them for users
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

// no direct access
defined('_JEXEC') or die;

/*
 * Error Handling:
 *
 * ERROR PAGE:            Error page w/ explanation of the error
 * REDIRECT TO CMS PAGE:  Redirect to specific CMS error page (for 404 and 410 errors)
 * LOGIN:                 Flash message, redirect to login page? Or show AJAX login box on same page user clicked from, set it to proceed after successful login?
 * REDIRECT W/ FLASH:     Redirect to same page with flash message (for 403 access forbidden and 411 length required)
 *
 * 4xx Client errors:
 *
 * 400: "Bad request." // ERROR PAGE - malformed request syntax, size too large, invalid request message framing, or deceptive request routing
 * 401: “Unauthorized. Please login.” // LOGIN
 * 403: “Access to that resource is forbidden.” // REDIRECT W/ FLASH
 * 404: “The requested resource was not found.” // REDIRECT TO CMS PAGE
 * 405: “Request method not allowed.” // ERROR PAGE - PUT on a read-only GET page, etc.
 * 406: “Not acceptable response.” // ERROR PAGE - Server can't accomodate Accept headers from client.
 * 408: “The server timed out waiting for the rest of the request from the browser.” // ERROR PAGE - similar to 504, except server never received request after opening socket.
 * 410: “The requested resource is gone and won’t be coming back.” // REDIRECT TO CMS PAGE.
 * 411: "Length Required" // REDIRECT W/ FLASH - request did not specify the length of its content, e.g. file uploads.
 * 413: "Payload Too Large" // REDIRECT W/ FLASH - file upload larger than max set in PHP.
 * 414: "URI too long." // ERROR PAGE - Often too much data being encoded as a query-string of a GET request, convert to a POST request.
 * 415: "Unsupported media type." // REDIRECT W/ FLASH - e.g. client uploads an image as image/svg+xml, which isn't supported by the server.
 * 416: "Range Not Satisfiable" // REDIRECT W/ FLASH - client asked for a portion of a file, but the server cannot supply that portion e.g. it lies beyond the end of the file.
 * 419: "Page Expired" // REDIRECT W/ FLASH - not official, Laravel uses this when CSRF Token is missing or expired.
 * 429: “Too many requests.” // ERROR PAGE - user has sent too many requests in a given amount of time.
 * 431: "Request headers fields too large." // ERROR PAGE - either an individual request header field, or all the header fields collectively, are too large.
 *
 * 5xx Server errors:
 *
 * 500: “There was an error on the server and the request could not be completed.” // ERROR PAGE - generic error message.
 * 501: “Not Implemented.” // ERROR PAGE - either the server doesn't recognize the request method or can't fulfill the request.
 * 502: “Bad Gateway.” // ERROR PAGE - server was acting as a gateway or proxy and received an invalid response from the upstream server.
 * 503: “The server is unavailable to handle this request right now.” // ERROR PAGE - server cannot handle the request because it is overloaded or down for maintenance.
 * 504: “The server, acting as a gateway, timed out waiting for another server to respond.” // ERROR PAGE - same as 502 except server did not receive a timely response.
 * 505: "HTTP Version Not Supported" // ERROR PAGE
 */

/** @var \Joomla\CMS\Document\ErrorDocument   $this */

// @TODO: 500 server errors need to display a static version of the site, with a full stack trace when in debug mode

/*
 * server errors to handle:
 *
 * We should redirect for pages that make sense to do so:
 */

switch ( $this->error->getCode() ) {
  case '404':
    header("HTTP/1.0 404 Not Found");
    // header('Location: /index.php?option=com_content&view=article&id=75');
    break;

  default:

}

// Load our template for body of error page
include dirname(__FILE__) . "/_body.php";
