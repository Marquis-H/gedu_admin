<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/2/14
 * Time: 4:18 PM
 */

namespace Admin\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WordTabsUpdateCommand extends ContainerAwareCommand
{
	/**
	 * {@inheritdoc}
	 */
	protected function configure()
	{
		$this
			->setName('word:update:tabs');
	}

	/**
	 * {@inheritdoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$dataPath = $this->getContainer()->get('kernel')->getRootDir() . '/../data/';
		$row = 1;
		$conn = $this->getContainer()->get('doctrine.dbal.default_connection');
		if (($handle = fopen($dataPath . "toefl.csv", "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$row++;
				$word = $data[0];
				try {
					$words = $conn->fetchAll('select * from word where word = \'' . $word . '\'');
					$tabs = $words[0]['tabs'];
					$tabs = unserialize($tabs);
					if (!in_array('toefl', $tabs)) {
						array_push($tabs, 'toefl');
						$conn->update('word', [
							'tabs' => serialize($tabs),
						], ['word' => $word]);
						$output->writeln('<info>' . $word . '</info>');
					}
				} catch (\Exception $e) {
					$output->writeln("<error>" . $word . "</error>");
				}
			}
			fclose($handle);
		}
	}
}