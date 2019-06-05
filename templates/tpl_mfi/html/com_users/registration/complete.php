<?php
/**
 * Multi Family Insiders Bootstrap v3 Template with Schema.org markup
 *
 * com_users registration/complete.php template override
 *
 * @package     Calligraphic Job Board
 * @subpackage  User Plugin User.cajobboard
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

  // no direct access
  defined('_JEXEC') or die;
?>

<div class="registration-complete<?php echo $this->pageclass_sfx; ?>">

	<?php if ($this->params->get('show_page_heading')) : ?>
		<h1>
			<?php echo $this->escape($this->params->get('page_heading')); ?>
		</h1>
	<?php endif; ?>

</div>
