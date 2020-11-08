<?php declare(strict_types=1);

namespace Unit;

class InternalActionsTest extends \PHPUnit\Framework\TestCase
{

	private const TEST_EXAMPLES = [
		'Zkouška - Neděle',
		'Ples Kněževes ???',
		'Oprava mixu - interní',
	];

	/**
	 * @var \ActionsGenerator
	 */
	private $generator;


	public function __construct()
	{
		parent::__construct();
		/** @var \Google_Client $googleClient */
		$googleClient = \Mockery::mock(\Google_Client::class);
		$this->generator = new \ActionsGenerator($googleClient, '');
	}

	
	public function testInternal(): void
	{
		foreach (self::TEST_EXAMPLES as $item) {
			$this->assertTrue($this->generator->isInternal($item));
		}
	}


	public function testPublic(): void
	{
		$this->assertFalse($this->generator->isInternal('Ples Jesenice'));
	}

}
