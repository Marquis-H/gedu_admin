<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2018/10/25
 * Time: 10:29 AM
 */

namespace Admin\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Admin\Entity\BackendParameter;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ParameterController
 * @package Admin\Controller\Api
 */
class ParameterController extends AbstractApiController
{
	/**
	 * 获取设定
	 *
	 * @Route("/detail", name="api.setting.detail")
	 * @param $request
	 * @Method({"GET"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function getSetting(Request $request)
	{
		$identify = $request->query->get('identify');
		$em = $this->get('doctrine.orm.default_entity_manager');
		$parameterRepo = $em->getRepository('Admin:BackendParameter');

		$parameters = $parameterRepo->findBy(['identify' => $identify]);
		$settings = [];
		/** @var BackendParameter $parameter */
		foreach ($parameters as $parameter) {
			switch ($parameter->getCk()) {
				case 'logo':
					$settings[$parameter->getCk()] = $parameter->getParameter() ? $parameter->getParameter() : '';
					break;
				default:
					$settings[$parameter->getCk()] = $parameter->getParameter();
			}
		}

		return self::createSuccessJSONResponse($settings, 'success');
	}

	/**
	 * 创建及更新设定
	 *
	 * @Route("/create", name="api.setting.create")
	 * @param $request
	 * @Method({"POST"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function createAction(Request $request)
	{
		$identify = $request->query->get('identify');
		$data = $request->request->all();

		try {
			$parameterService = $this->get('admin.service.parameter');
			$result = $parameterService->save($identify, $data);
		} catch (\Exception $exception) {
			return self::createFailureJSONResponse('fail');
		}

		return self::createSuccessJSONResponse($result, 'success');
	}
}