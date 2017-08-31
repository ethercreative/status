<?php

namespace Craft;

class StatusFieldType extends BaseFieldType implements IPreviewableFieldType
{

	public function getName ()
	{
		return Craft::t('Status');
	}

	public function getInputHtml ($name, $value)
	{
		$id           = craft()->templates->formatInputId($name);
		$namespacedId = craft()->templates->namespaceInputId($id);
		$statuses     = json_encode($this->getSettings()->statuses);

		craft()->templates->includeJsResource('status/js/StatusInput.js');
		craft()->templates->includeCssResource('status/css/StatusInput.css');
		craft()->templates->includeJs(
			"new StatusInput('{$namespacedId}', '{$statuses}');"
		);

		return craft()->templates->render(
			'status/input',
			[
				'name'  => $name,
				'id'    => $id,
				'value' => $value,
			]
		);
	}

	public function defineContentAttribute ()
	{
		return AttributeType::Slug;
	}

	protected function defineSettings ()
	{
		return [
			'statuses' => AttributeType::Mixed,
		];
	}

	public function getSettingsHtml ()
	{
		$columnSettings = [
			'name'    => [
				'heading'      => Craft::t('Name'),
				'type'         => 'singleline',
				'autopopulate' => 'handle',
			],
			'handle'  => [
				'heading' => Craft::t('Handle'),
				'class'   => 'code',
				'type'    => 'singleline',
			],
			'color'   => [
				'heading' => Craft::t('Color'),
				'class'   => 'status-color',
				'type'    => 'color',
				'width'   => 100,
			],
			'default' => [
				'heading' => Craft::t('Default?'),
				'type'    => 'checkbox',
				'class'   => 'thin',
			],
		];

		$rows = $this->getSettings()->statuses;

		if (!$rows) {
			$rows = [
				'col1' => [
					'name'    => '',
					'handle'  => '',
					'color'   => '#000000',
					'default' => true,
				],
			];
			$this->getSettings()->statuses = $rows;
		}

		craft()->templates->includeJsResource('status/js/StatusSettings.js');
		craft()->templates->includeJs("new StatusSettings();");

		return craft()->templates->renderMacro(
			'_includes/forms',
			'editableTableField',
			[
				[
					'label'        => Craft::t('Statuses'),
					'instructions' => Craft::t(
						'Define the custom statuses for the field.'
					),
					'id'           => 'statuses',
					'name'         => 'statuses',
					'cols'         => $columnSettings,
					'rows'         => $rows,
					'initJs'       => true,
				],
			]
		);
	}

	public function getTableAttributeHtml ($value)
	{
		if ($value)
		{
			foreach($this->getSettings()->statuses as $k=>$v){
				$a = array_search($value,$v,true) ? $k : false;
				if($a !== false){
					$key = $k;
				}
			}
			$status = $this->getSettings()->statuses[$key];
			return '<div class="color small static">' .
			           '<div class="colorpreview" style="background-color: '.$status['color'].';"></div>' .
			       '</div>'.
			       '<div class="colorhex" style="color:#29323d">'.$status['name'].'</div>';
		}
		else
		{
			return '';	
		}
	}

}
