<?php declare(strict_types=1);

class SitemapGenerator extends \Symfony\Component\Console\Command\Command
{

	private const EXCLUDE = [
		'.',
		'..',
		'img',
		'assets',
		'index.html',
		'robots.txt',
		'sitemap.xml',
	];


	public function configure()
	{
		$this->setName('generate:sitemap');
		$this->setDescription('Generate sitemaps.xml');

		$this->addArgument('webDir');
	}


	public function execute(
		\Symfony\Component\Console\Input\InputInterface $input,
		\Symfony\Component\Console\Output\OutputInterface $output
	): int
	{
		$webDir = $input->getArgument('webDir');

		$aliases = $this->getSitemapAliases($webDir);

		$ltEngine = new \Latte\Engine();

		$result = $ltEngine->renderToString(__DIR__ . '/../templates/sitemap.latte', ['aliases' => $aliases]);

		@unlink($webDir  . '/' . 'sitemap.xml');
		file_put_contents( $webDir . '/' . 'sitemap.xml', $result);

		return 0;
	}


	public function getSitemapAliases(string $dir, string $prefix = ''): array
	{
		if ( ! file_exists($dir)) {
			return [];
		}

		$list = scandir($dir);

		$aliases = [];
		foreach ($list as $item) {
			if (in_array($item, self::EXCLUDE)) {
				continue;
			}

			$aliases[] = $item;
		}

		return $aliases;
	}
}