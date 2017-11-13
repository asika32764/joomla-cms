<?php
/**
 * @package     Joomla\CMS\Button
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */

namespace Joomla\CMS\Button;

use Joomla\CMS\Layout\LayoutHelper;
use Joomla\Registry\Registry;
use Joomla\Utilities\ArrayHelper;

/**
 * The TaskButton class.
 *
 * @since  __DEPLOY_VERSION__
 */
class ActionButton
{
	/**
	 * The button states profiles.
	 *
	 * @var  array
	 *
	 * @since  __DEPLOY_VERSION__
	 */
	protected $states = [
		'_default' => [
			'value'     => '_default',
			'task'      => '',
			'icon'      => 'icon-question',
			'title'     => 'Unknown state',
			'options'   => [
				'disabled'  => false,
				'only_icon' => false,
				'tip' => true,
				'tip_title' => '',
				'task_prefix' => '',
				'checkbox_name' => 'cb'
			]
		]
	];

	/**
	 * Options of this button set.
	 *
	 * @var  Registry
	 *
	 * @since  __DEPLOY_VERSION__
	 */
	protected $options;

	/**
	 * The layout path to render.
	 *
	 * @var  string
	 *
	 * @since  __DEPLOY_VERSION__
	 */
	protected $layout = 'joomla.button.action-button';

	/**
	 * ActionButton constructor.
	 *
	 * @param   array  $options  The options for all buttons in this group.
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function __construct(array $options = [])
	{
		$this->options = new Registry($options);

		$this->preprocess();
	}

	/**
	 * Configure this object.
	 *
	 * @return  void
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	protected function preprocess()
	{
		// Implement this method.
	}

	/**
	 * Add a state profile.
	 *
	 * @param   string  $value    The value of this state.
	 * @param   string  $task     The task you want to execute after click this button.
	 * @param   string  $icon     The icon to display for user.
	 * @param   string  $title    Title text will show if we enable tooltips.
	 * @param   array   $options  The button options, will override group options.
	 *
	 * @return  static  Return self to support chaining.
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function addState(string $value, string $task, string $icon = 'ok', string $title = '', array $options = []): self
	{
		// Force type to prevent null data
		$this->states[$value] = [
			'value'   => $value,
			'task'    => $task,
			'icon'    => $icon,
			'title'   => $title,
			'options' => $options
		];

		return $this;
	}

	/**
	 * Get state profile by value name.
	 *
	 * @param   string|integer  $value  The value name we want to get.
	 *
	 * @return  array|null  Return state profile or NULL.
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function getState(string $value): array
	{
		return $this->states[$value] ?? null;
	}

	/**
	 * Remove a state by value name.
	 *
	 * @param   string  $value  Remove state by this value.
	 *
	 * @return  static  Return to support chaining.
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function removeState(string $value): self
	{
		if (isset($this->states[$value]))
		{
			unset($this->states[$value]);
		}

		return $this;
	}

	/**
	 * Render action button by item value.
	 *
	 * @param   mixed   $value  Current value of this item.
	 * @param   string  $row    The row number of this item.
	 *
	 * @return  string  Rendered HTML.
	 *
	 * @since  __DEPLOY_VERSION__
	 */
	public function render(string $value = null, string $row = null): string
	{
		$data = $this->getState($value);

		$data = $data ? : $this->getState('_default');

		$data = ArrayHelper::mergeRecursive($this->getState('_default'), $data, ['options' => $this->options->toArray()]);

		$data['row'] = $row;

		return LayoutHelper::render($this->layout, $data);
	}

	/**
	 * Render to string.
	 *
	 * @return  string
	 *
	 * @since  __DEPLOY_VERSION__
	 */
	public function __toString(): string
	{
		try
		{
			return $this->render();
		}
		catch (\Throwable $e)
		{
			return (string) $e;
		}
	}

	/**
	 * Method to get property layout.
	 *
	 * @return  string
	 *
	 * @since  __DEPLOY_VERSION__
	 */
	public function getLayout():string
	{
		return $this->layout;
	}

	/**
	 * Method to set property template
	 *
	 * @param   string  $layout The layout path.
	 *
	 * @return  static  Return self to support chaining.
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function setLayout(string $layout)
	{
		$this->layout = $layout;

		return $this;
	}

	/**
	 * Method to get property Options
	 *
	 * @return  array
	 *
	 * @since  __DEPLOY_VERSION__
	 */
	public function getOptions(): array
	{
		return $this->options->toArray();
	}

	/**
	 * Method to set property options
	 *
	 * @param   array  $options  The options of this button group.
	 *
	 * @return  static  Return self to support chaining.
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function setOptions(array $options): self
	{
		$this->options = new Registry($options);

		return $this;
	}

	/**
	 * Get an option value.
	 *
	 * @param  string  $name     The option name.
	 * @param  mixed   $default  Default value if not exists.
	 *
	 * @return  mixed  Return option value or default value.
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function getOption(string $name, $default = null)
	{
		return $this->options->get($name, $default);
	}

	/**
	 * Set option value.
	 *
	 * @param   string  $name   The option name.
	 * @param   mixed   $value  The option value.
	 *
	 * @return  static  Return self to support chaining.
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function setOption(string $name, $value): self
	{
		$this->options->set($name, $value);

		return $this;
	}
}
