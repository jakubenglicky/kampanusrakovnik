<?php declare(strict_types=1);

class GoogleClient
{

	public static function build(string $authFile)
	{
		$client = new Google_Client();

		$client->setApplicationName('Google Calendar API PHP Quickstart');
		$client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
		$client->setAuthConfig($authFile);
		$client->setAccessType('offline');
		$client->setPrompt('select_account consent');

		return $client;
	}

}
