<?php

namespace Craft;

class StatusPlugin extends BasePlugin {

	public function getName()
	{
		return 'Status';
	}

	public function getVersion()
	{
		return '0.0.1';
	}

	public function getDeveloper()
	{
		return 'Ether Creative';
	}

	public function getDeveloperUrl()
	{
		return 'http://ethercreative.co.uk';
	}

	public function getDescription()
	{
		return 'A custom status FieldType';
	}

}