<?php declare(strict_types = 1);

class RepertoireGenerator extends \Symfony\Component\Console\Command\Command
{

	/**
	 * @var string
	 */
	private $path;


	public function __construct(string $path)
	{
		parent::__construct();
		$this->path = $path;
	}


	public function configure()
	{
		$this->setName('generate:repertoire');
		$this->setDescription('Generate Yaml with songs');
	}


	public function execute(
		\Symfony\Component\Console\Input\InputInterface $input,
		\Symfony\Component\Console\Output\OutputInterface $output
	): int
	{
		$jsonData = \file_get_contents($this->path . '/songs.json');

		$repertoireArray = \json_decode($jsonData, TRUE);

		$result = [];
		$result['parameters']['repertoire'] = $repertoireArray;

		@unlink($this->path . '/songs.yml');
		file_put_contents($this->path . '/songs.yml', (string) \Symfony\Component\Yaml\Yaml::dump($result,3));

		return 0;
	}

}
