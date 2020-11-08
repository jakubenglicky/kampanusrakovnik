<?php declare(strict_types = 1);

class ActionsGenerator extends \Symfony\Component\Console\Command\Command
{

	private const EXCLUDE = [
		'zkouska',
		'interni',
		'?',
	];

	/**
	 * @var Google_Service_Calendar
	 */
	private $calendar;

	/**
	 * @var string
	 */
	private $path;


	public function __construct(Google_Client $client, string $path)
	{
		parent::__construct();

		$this->calendar = new Google_Service_Calendar($client);
		$this->path = $path;

	}


	public function configure()
	{
		$this->setName('generate:actions');
		$this->setDescription('Generate Yaml with actions');
	}


	public function execute(
		\Symfony\Component\Console\Input\InputInterface $input,
		\Symfony\Component\Console\Output\OutputInterface $output
	): int
	{
		$events = $this->prepareEvents();

		$yamlData = [];
		$yamlData['parameters']['actions'] = $events;

		@unlink($this->path . '/actions.yml');
		file_put_contents(
			$this->path . '/actions.yml',
			\Symfony\Component\Yaml\Yaml::dump($yamlData,3)
		);

		return 0;
	}


	private function prepareEvents()
	{
		$results = $this->calendar->events->listEvents(
			'kampanus.rakovnik@gmail.com',
			[
				'maxResults' => 1000,
				'orderBy' => 'startTime',
				'singleEvents' => TRUE,
				'timeMin' => date('c'),
			]
		);

		$eventData = [];

		foreach ($results->getItems() as $event) {

			$title = $event->getSummary();

			if ($this->isInternal($title)) {
				continue;
			}

			$date = $event->start->dateTime;
			if (empty($date)) {
				$date = $event->start->date;
			}

			$eventData[] = [
				'title' => $title,
				'date' => (new DateTime($date))->format('d. m. Y'),
			];

		}

		return $eventData;
	}


	public function isInternal(string $title)
	{
		$webalize = \Nette\Utils\Strings::webalize($title, '?');

		foreach (self::EXCLUDE as $exclude) {
			if (\Nette\Utils\Strings::contains($webalize, $exclude)) {
				return TRUE;
			}
		}

		return FALSE;
	}

}
