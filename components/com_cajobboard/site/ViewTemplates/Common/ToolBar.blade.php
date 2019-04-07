<?php

// some code for implementing sort controls on the front-end

$input = $this->container->input;
$platform = $this->container->platform;



// Render the toolbar
if ( $input->getBool('render_toolbar', true) )
{
  $this->renderButtons($view, $task);
}

  /**
	 * Renders the toolbar buttons
	 *
	 * @param   string    $view    The active view name
	 * @param   string    $task    The current task
	 *
	 * @return  void
	 */
   protected function renderButtons($view, $task)
	{
		$substitutions = array(
			'icon-32-new'		    => 'icon-plus',
			'icon-32-publish'	  => 'icon-eye-open',
			'icon-32-unpublish'	=> 'icon-eye-close',
			'icon-32-delete'	  => 'icon-trash',
			'icon-32-edit'		  => 'icon-edit',
			'icon-32-copy'		  => 'icon-th-large',
			'icon-32-cancel'	  => 'icon-remove',
			'icon-32-back'		  => 'icon-circle-arrow-left',
			'icon-32-apply'		  => 'icon-ok',
			'icon-32-save'		  => 'icon-hdd',
			'icon-32-save-new'	=> 'icon-repeat',
    );

    $title = Factory::getDocument()->getTitle();
    $title ? Text::_($title) : Text::_('COM_CAJOBBOARD');

    $html = array();
    $actions = array();

		// We have to use the same id we're using inside other renderers
		$html[] = '<div class="well" id="header-container">';
		$html[] = '<div class="title-container">'.$title.'</div>';
    $html[] = '<div class="buttons-container">';

    $toolbar = Toolbar::getInstance('toolbar');
    $items = $toolbar->getItems();

		foreach ($items as $node)
		{
      $type = $node[0];
      $button = $toolbar->loadButtonType($type);

			if ($button !== false)
			{
				$action     = call_user_func_array(array(&$button, 'fetchButton'), $node);
				$action     = str_replace('class="toolbar"', 'class="toolbar btn"', $action);
				$action     = str_replace('<span ', '<i ', $action);
				$action     = str_replace('</span>', '</i>', $action);
				$action     = str_replace(array_keys($substitutions), array_values($substitutions), $action);
				$actions[]  = $action;
			}
    }

    $html   = array_merge($html, $actions);

		$html[] = '</div>';
    $html[] = '</div>';

		echo implode("\n", $html);
  }


