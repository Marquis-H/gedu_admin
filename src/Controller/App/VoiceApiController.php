<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/4/21
 * Time: 1:13 PM
 */

namespace Admin\Controller\App;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class VoiceApiController
 * @package Admin\Controller\App
 */
class VoiceApiController extends AbstractAppController
{
	/**
	 * 音频列表
	 *
	 * @Route("/list", name="app.voice.list")
	 * @Method({"GET"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function getList()
	{
		$voiceService = $this->get('admin.service.voice');
		$result = $voiceService->getList();

		return self::createSuccessJSONResponse($result);
	}

	/**
	 * 音频数据
	 *
	 * @Route("/detail", name="app.voice.detail")
	 * @Method({"GET"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function detail(Request $request)
	{
		$id = $request->query->get('id');
		$em = $this->container->get('doctrine.orm.default_entity_manager');
		$voice = $em->getRepository('Admin:Voice')->findOneBy(['id' => $id]);
		if ($voice === null) {
			return self::createFailureJSONResponse('error');
		}

		$voiceService = $this->get('admin.service.voice');
		$result = $voiceService->detail($id);

		return self::createSuccessJSONResponse($result);
	}
}