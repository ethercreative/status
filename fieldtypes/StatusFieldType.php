<?php

namespace Craft;

class StatusFieldType extends BaseFieldType
{

	public function getName()
	{
		return Craft::t('Status');
	}

	public function getInputHtml($name, $value)
	{
		$id = craft()->templates->formatInputId($name);
		$namespacedId = craft()->templates->namespaceInputId($id);
		$statuses = json_encode($this->getSettings()->statuses);

		craft()->templates->includeJsResource('status/js/StatusInput.js');
		craft()->templates->includeCssResource('status/css/StatusInput.css');
		craft()->templates->includeJs("new StatusInput('{$namespacedId}', '{$statuses}');");

		return craft()->templates->render('status/input', array(
			'name'  => $name,
			'id'    => $id,
			'value' => $value
		));
	}

	public function defineContentAttribute()
	{
		return AttributeType::Slug;
	}

	protected function defineSettings()
	{
		return [
			'statuses' => AttributeType::Mixed
		];
	}

	public function getSettingsHtml()
	{
		$columnSettings = array(
			'name' => array(
				'heading' => Craft::t('Name'),
				'type' => 'singleline',
				'autopopulate' => 'handle'
			),
			'handle' => array(
				'heading' => Craft::t('Handle'),
				'class' => 'code',
				'type' => 'singleline'
			),
			'color' => array(
				'heading' => Craft::t('Color'),
				'class' => 'code',
				'type' => 'color',
				'width' => 100
			),
			'default' => array(
				'heading'      => Craft::t('Default?'),
				'type'         => 'checkbox',
				'class'        => 'thin'
			),
		);

		$rows = $this->getSettings()->statuses;

		if (!$rows) {
			$rows = array('col1' => array('name' => '', 'handle' => '', 'color' => '#000000', 'default' => true));
			$this->getSettings()->statuses = $rows;
		}

		return craft()->templates->renderMacro('_includes/forms', 'editableTableField', array(
			array(
				'label'        => Craft::t('Statuses'),
				'instructions' => Craft::t('Define the custom statuses for the field.'),
				'id'           => 'statuses',
				'name'         => 'statuses',
				'cols'         => $columnSettings,
				'rows'         => $rows,
				'initJs'       => true
			)
		));
	}

	public function getTableAttributeHtml($value)
	{
		if ($value)
		{
			return '<div class="color small static"><div class="colorpreview" style="background-color: '.$value->color.';"></div></div>'.
			'<div class="colorhex code">'.$value->title.'</div>';
		}
		else
		{
			return '';
		}
	}

}