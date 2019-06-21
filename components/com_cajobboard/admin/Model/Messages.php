<?php
/**
 * Admin Messages Model
 *
 * There is no site-side counterpart to EmailMessages, because it is a send-
 * only feature and the admin views are only for setting configuration to allow
 * non-developer updates to the HTML e-mail templates.
 *
 * This MVC triad allows using an HTML editor to modify the available
 * e-mail templates for tasks. It does not allow adding additional
 * templates to the database. Adding tasks requires adding appropriate
 * methods to the plg_cajobboard_mail plugin, and adding controller code
 * to dispatch events to the plugin task method.
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
