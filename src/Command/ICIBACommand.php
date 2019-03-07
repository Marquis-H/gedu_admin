<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/2/13
 * Time: 4:08 PM
 */

namespace Admin\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ICIBACommand extends ContainerAwareCommand
{
	/**
	 * {@inheritdoc}
	 */
	protected function configure()
	{
		$this
			->setName('crawl:iciba')
			->addArgument('word', InputArgument::REQUIRED);
	}

	/**
	 * {@inheritdoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$word = $input->getArgument('word');
		$url = 'http://www.iciba.com/' . $word;
		$output->writeln([
			sprintf('WORD: <comment>%s</comment>', $word),
			sprintf('URL : <comment>%s</comment>', $url),
			''
		]);
		$ICIBAParser = $this->getContainer()->get('admin.service.ICIBA_parser');
		// 解析开始
		$data = $ICIBAParser->query($word);

		return $data;
	}
}