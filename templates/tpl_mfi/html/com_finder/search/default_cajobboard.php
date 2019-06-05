<?php
/**
 * Multi Family Insiders Bootstrap v3 Template with Schema.org markup
 *
 * con_finder search/default_cajobboard.php template override for use with
 * Calligraphic Job Board Finder search plugin
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

  use Joomla\String\StringHelper;
  use \Joomla\CMS\Router\Route;
  use \Joomla\CMS\HTML\HTMLHelper;
  use \Joomla\CMS\Plugin\PluginHelper;


  // no direct access
  defined('_JEXEC') or die;

  \JLoader::register('FinderIndexerHelper', JPATH_ADMINISTRATOR . '/components/com_finder/helpers/indexer/helper.php');

  // Get the mime type class.
  $mime = !empty($this->result->mime) ? 'mime-' . $this->result->mime : null;

  $show_description = $this->params->get('show_description', 1);

  if ($show_description)
  {
    // Calculate number of characters to display around the result
    $term_length = StringHelper::strlen($this->query->input);

    $desc_length = $this->params->get('description_length', 255);

    $pad_length  = $term_length < $desc_length ? (int) floor(($desc_length - $term_length) / 2) : 0;

    // Make sure we highlight term both in introtext and fulltext
    if (!empty($this->result->summary) && !empty($this->result->body))
    {
      $full_description = FinderIndexerHelper::parse($this->result->summary . $this->result->body);
    }
    else
    {
      $full_description = $this->result->description;
    }

    // Find the position of the search term
    $pos = $term_length ? StringHelper::strpos(StringHelper::strtolower($full_description), StringHelper::strtolower($this->query->input)) : false;

    // Find a potential start point
    $start = ($pos && $pos > $pad_length) ? $pos - $pad_length : 0;

    // Find a space between $start and $pos, start right after it.
    $space = StringHelper::strpos($full_description, ' ', $start > 0 ? $start - 1 : 0);

    $start = ($space && $space < $pos) ? $space + 1 : $start;

    $description = HTMLHelper::_('string.truncate', StringHelper::substr($full_description, $start), $desc_length, true);
  }

  $route = $this->result->route;

  // Get the route with highlighting information.
  if (
    !empty($this->query->highlight)
    && empty($this->result->mime)
    && $this->params->get('highlight_terms', 1)
    && PluginHelper::isEnabled('system', 'highlight')
  )
  {
    $route .= '&highlight=' . base64_encode(json_encode($this->query->highlight));
  }

  // @TODO: change to our CSS classes and add to stylings file
?>

<li>

	<h4 class="result-title <?php echo $mime; ?>">
		<a href="<?php echo Route::_($route); ?>">
			<?php echo $this->result->title; ?>
		</a>
	</h4>

	<?php if ($show_description && $description !== '') : ?>
		<p class="result-text<?php echo $this->pageclass_sfx; ?>">
			<?php echo $description; ?>
		</p>
	<?php endif; ?>

	<?php if ($this->params->get('show_url', 1)) : ?>
		<div class="small result-url<?php echo $this->pageclass_sfx; ?>">
			<?php echo $this->baseUrl, Route::_($this->result->route); ?>
		</div>
	<?php endif; ?>

</li>
