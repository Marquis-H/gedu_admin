<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2018/11/4
 * Time: 9:02 PM
 */

namespace Admin\Command;


use Admin\Entity\Page;
use Gedmo\Translatable\Entity\Repository\TranslationRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class GenerateBackendPageCommand
 * @package Admin\Command
 */
class GenerateBackendPageCommand extends ContainerAwareCommand
{
	/**
	 * @var string
	 */
	protected static $defaultName = 'generate:backend:page';

	/**
	 * {@inheritdoc}
	 */
	protected function configure()
	{
		$this
			->setDescription('创建前台页面');
	}

	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 * @return int|null|void
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$io = new SymfonyStyle($input, $output);
		$em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
		$page = new Page();
		$page->setPath('home');
		/** @var TranslationRepository $transRepo */
		$transRepo = $em->getRepository('GedmoTranslatable:Translation');
		$page->setTitle('主页');
		$page->setCreatedBy('admin');
		$page->setUpdatedBy('admin');
		$transRepo
			->translate($page, 'title', 'en', 'Homepage');
		try {
			$em->persist($page);
			$em->flush();
		} catch (\Exception $e) {
		}

		$io->success('Success');
	}
}