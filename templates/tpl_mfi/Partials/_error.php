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
 *
 *   'app' => // $this->app
    object(Joomla\CMS\Application\SiteApplication)[19]
 *    private 'responseMap' (Joomla\CMS\Application\WebApplication) => array (size=61)
          100 => string 'HTTP/1.1 100 Continue' (length=21)
          101 => string 'HTTP/1.1 101 Switching Protocols' (length=32)
          102 => string 'HTTP/1.1 102 Processing' (length=23)
          200 => string 'HTTP/1.1 200 OK' (length=15)
          201 => string 'HTTP/1.1 201 Created' (length=20)
          202 => string 'HTTP/1.1 202 Accepted' (length=21)
          203 => string 'HTTP/1.1 203 Non-Authoritative Information' (length=42)
          204 => string 'HTTP/1.1 204 No Content' (length=23)
          205 => string 'HTTP/1.1 205 Reset Content' (length=26)
          206 => string 'HTTP/1.1 206 Partial Content' (length=28)
          207 => string 'HTTP/1.1 207 Multi-Status' (length=25)
          208 => string 'HTTP/1.1 208 Already Reported' (length=29)
          226 => string 'HTTP/1.1 226 IM Used' (length=20)
          300 => string 'HTTP/1.1 300 Multiple Choices' (length=29)
          301 => string 'HTTP/1.1 301 Moved Permanently' (length=30)
          302 => string 'HTTP/1.1 302 Found' (length=18)
          303 => string 'HTTP/1.1 303 See other' (length=22)
          304 => string 'HTTP/1.1 304 Not Modified' (length=25)
          305 => string 'HTTP/1.1 305 Use Proxy' (length=22)
          306 => string 'HTTP/1.1 306 (Unused)' (length=21)
          307 => string 'HTTP/1.1 307 Temporary Redirect' (length=31)
          308 => string 'HTTP/1.1 308 Permanent Redirect' (length=31)
          400 => string 'HTTP/1.1 400 Bad Request' (length=24)
          401 => string 'HTTP/1.1 401 Unauthorized' (length=25)
          402 => string 'HTTP/1.1 402 Payment Required' (length=29)
          403 => string 'HTTP/1.1 403 Forbidden' (length=22)
          404 => string 'HTTP/1.1 404 Not Found' (length=22)
          405 => string 'HTTP/1.1 405 Method Not Allowed' (length=31)
          406 => string 'HTTP/1.1 406 Not Acceptable' (length=27)
          407 => string 'HTTP/1.1 407 Proxy Authentication Required' (length=42)
          408 => string 'HTTP/1.1 408 Request Timeout' (length=28)
          409 => string 'HTTP/1.1 409 Conflict' (length=21)
          410 => string 'HTTP/1.1 410 Gone' (length=17)
          411 => string 'HTTP/1.1 411 Length Required' (length=28)
          412 => string 'HTTP/1.1 412 Precondition Failed' (length=32)
          413 => string 'HTTP/1.1 413 Payload Too Large' (length=30)
          414 => string 'HTTP/1.1 414 URI Too Long' (length=25)
          415 => string 'HTTP/1.1 415 Unsupported Media Type' (length=35)
          416 => string 'HTTP/1.1 416 Range Not Satisfiable' (length=34)
          417 => string 'HTTP/1.1 417 Expectation Failed' (length=31)
          418 => string 'HTTP/1.1 418 I'm a teapot' (length=25)
          421 => string 'HTTP/1.1 421 Misdirected Request' (length=32)
          422 => string 'HTTP/1.1 422 Unprocessable Entity' (length=33)
          423 => string 'HTTP/1.1 423 Locked' (length=19)
          424 => string 'HTTP/1.1 424 Failed Dependency' (length=30)
          426 => string 'HTTP/1.1 426 Upgrade Required' (length=29)
          428 => string 'HTTP/1.1 428 Precondition Required' (length=34)
          429 => string 'HTTP/1.1 429 Too Many Requests' (length=30)
          431 => string 'HTTP/1.1 431 Request Header Fields Too Large' (length=44)
          451 => string 'HTTP/1.1 451 Unavailable For Legal Reasons' (length=42)
          500 => string 'HTTP/1.1 500 Internal Server Error' (length=34)
          501 => string 'HTTP/1.1 501 Not Implemented' (length=28)
          502 => string 'HTTP/1.1 502 Bad Gateway' (length=24)
          503 => string 'HTTP/1.1 503 Service Unavailable' (length=32)
          504 => string 'HTTP/1.1 504 Gateway Timeout' (length=28)
          505 => string 'HTTP/1.1 505 HTTP Version Not Supported' (length=39)
          506 => string 'HTTP/1.1 506 Variant Also Negotiates' (length=36)
          507 => string 'HTTP/1.1 507 Insufficient Storage' (length=33)
          508 => string 'HTTP/1.1 508 Loop Detected' (length=26)
          510 => string 'HTTP/1.1 510 Not Extended' (length=25)
          511 => string 'HTTP/1.1 511 Network Authentication Required' (length=44)
 */

/** @var \Joomla\CMS\Document\ErrorDocument   $this */

// Partial loaded will be based on this var
$errorPartial = 'error-trace';



/*
 * Load partial / set headers for exceptions with correct HTTP error codes
 */

switch ( $this->error->getCode() ) {
  case '403':
  // header('Location: /index.php?option=com_content&view=article&id=75');
  break;

  case '404':
    header("HTTP/1.0 404 Not Found");
    // header('Location: /index.php?option=com_content&view=article&id=75');
    break;

  default:
}

// Load our template for body of error page
include dirname(__FILE__) . "/_body.php";
