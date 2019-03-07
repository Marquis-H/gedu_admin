<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/2/13
 * Time: 6:33 PM
 */

namespace Admin\Command;

use Admin\Entity\Word;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Util\Json;

class WordUpdateCommand extends ContainerAwareCommand
{
	/**
	 * {@inheritdoc}
	 */
	protected function configure()
	{
		$this
			->setName('word:update:voice');
	}

	/**
	 * {@inheritdoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$conn = $this->getContainer()->get('doctrine.dbal.default_connection');
		$words = $conn->fetchAll('select * from word where mp3downloaded = false');
		$accessor = PropertyAccess::createPropertyAccessor();
		/** @var Word $word */
		foreach ($words as $word) {
			$data = Json::decode($word['data'], true);
			$ph_en_mp3 = $accessor->getValue($data, '[baesInfo][symbols][0][ph_en_mp3]');
			$ph_am_mp3 = $accessor->getValue($data, '[baesInfo][symbols][0][ph_am_mp3]');
			$ph_tts_mp3 = $accessor->getValue($data, '[baesInfo][symbols][0][ph_tts_mp3]');
			try {
				$conn->update('word', [
					'en_mp3' => $ph_en_mp3,
					'us_mp3' => $ph_am_mp3,
					'tts_mp3' => $ph_tts_mp3,
					'mp3downloaded' => true
				], ['id' => $word['id']]);
				$output->writeln('<info>' . $word['word'] . '</info>');
			} catch (\Exception $e) {

			}
		}
	}
}