<?php

namespace Admin\Command;

use Admin\Entity\BackendUser;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GenerateBackendUserCommand extends ContainerAwareCommand
{
	protected static $defaultName = 'generate:backend:user';

	protected function configure()
	{
		$this
			->setDescription('创建后台用户')
			->addArgument('role', InputArgument::OPTIONAL, 'Argument description');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$io = new SymfonyStyle($input, $output);
		$role = $input->getArgument('role');

		if ($role) {
			$container = $this->getContainer();
			$passwordEncoder = $container->get('security.password_encoder');
			/** @var EntityManager $em */
			$em = $container->get('doctrine.orm.default_entity_manager');

			try {
				$backendUser = new BackendUser();
				$backendUser->setEmail('Test@Admin.com');
				$backendUser->setEnabled(true);
				$backendUser->setIsSuperAdmin(true);
				$backendUser->setUsername('admin');
				$encoderPassword = $passwordEncoder->encodePassword($backendUser, '12345678');
				$backendUser->setPassword($encoderPassword);
				$backendUser->setRoles(['ROLE_ADMIN']);

				$em->persist($backendUser);
				$em->flush();
			} catch (\Exception $e) {
				$em->rollback();
			}
		}

		$io->success('You have a new command! Now make it your own! Pass --help to see your options.');
	}
}
