<?php

namespace Craft;

class StatusPlugin extends BasePlugin {

	public function getName()
	{
		return 'Status';
	}

	public function getVersion()
	{
		return '1.0.0';
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

	public function getReleaseFeedUrl()
	{
		return 'https://raw.githubusercontent.com/ethercreative/status/master/releases.json';
	}

}