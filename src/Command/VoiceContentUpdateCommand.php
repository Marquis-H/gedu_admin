<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/5/16
 * Time: 9:08 PM
 */

namespace Admin\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class VoiceContentUpdateCommand extends ContainerAwareCommand
{
	/**
	 * {@inheritdoc}
	 */
	protected function configure()
	{
		$this
			->setName('crawl:voice_content');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
		$voiceRepo = $em->getRepository('Admin:Voice');
		$voices = 145;
		try {
			$data = $this->getContainer()->get('kernel')->getRootDir().'/../data/C13.xlsx';
			$spreadsheet = \PHPExcel_IOFactory::load($data);
			$allsheets = $spreadsheet->getAllSheets();
			foreach ($allsheets as$k =>  $allsheet){
				$highestRow = $allsheet->getHighestRow();
				$rowData = [];
				for ($row = 1; $row <= $highestRow; ++$row) {
					$en = $allsheet->getCell('A'.$row)->getValue();
					array_push($rowData, [
						'cntext' => '',
						'entext' => $en,
						'start' => '',
						'end' => ''
					]);
				}
				// 更新
				$voice = $voiceRepo->findOneBy(['id' => $voices +$k]);
				$voice->setTranslation($rowData);
				$em->persist($voice);
				$em->flush();
			}

		} catch (\Exception $exception) {

		}
	}
}