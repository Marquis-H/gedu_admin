<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/3/29
 * Time: 11:35 AM
 */

namespace Admin\Command;

use Admin\Entity\Voice;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Util\Json;

class VoiceCommand extends ContainerAwareCommand
{
	/**
	 * {@inheritdoc}
	 */
	protected function configure()
	{
		$this
			->setName('crawl:voice');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
		$client = new Client();
		$dataPath = $this->getContainer()->get('kernel')->getRootDir() . '/../data/';
		if (($handle = fopen($dataPath . "jianqiao.csv", "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, "\r")) !== FALSE) {
				foreach ($data as $k => $v) {
					$url = $v;
					$name = 'Section ' . (($k + 1) / 4);
					$tab = 'Test 1';
					try {
						$reponse = $client->get(str_replace('"', '', $url));
						$content = Json::decode($reponse->getBody(), true);
						$voice = new Voice();
						$voice->setName($name);
						$voice->setUrl($content['data']['audioUrl']);
						$voice->setTab($tab);
						$voice->setTranslation($content['data']['sentence']);

						try {
							$em->persist($voice);
							$em->flush();
						} catch (\Exception $e) {
							dump($e->getMessage());
						}
					} catch (\Exception $e) {
						dump($e->getMessage());
						$output->writeln("<error>" . $url . "</error>");
					}
				}
			}

			fclose($handle);
		}
	}
}