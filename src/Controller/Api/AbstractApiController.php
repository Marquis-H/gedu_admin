<?php

namespace Admin\Controller\Api;

use Knp\Component\Pager\Pagination\SlidingPagination;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Created by PhpStorm.
 * User: Marquis
 * Date: 2018/8/20
 * Time: 下午12:03
 */
abstract class AbstractApiController extends Controller
{
	/**
	 * 成功返回的Response
	 *
	 * @param array $data
	 * @param null $message
	 * @return JsonResponse
	 */
	static public function createSuccessJSONResponse($data = [], $message = null)
	{
		return new JsonResponse([
			'code' => 0,
			'message' => $message,
			'data' => $data
		]);
	}

	/**
	 * @param $message
	 * @param int $code
	 * @param array $data
	 * @return JsonResponse
	 */
	static public function createFailureJSONResponse($message, $code = -1, $data = [])
	{
		return new JsonResponse([
			'code' => $code,
			'message' => $message,
			'data' => $data
		]);
	}

	/**
	 * 排序
	 *
	 * @param $sort
	 * @return null|string
	 */
	static public function transSortOrder($sort)
	{
		switch ($sort) {
			case 'ascend':
				return 'ASC';
			case 'descend':
				return 'DESC';
		}

		return null;
	}

	/**
	 * 分页结果
	 *
	 * @param Request $request
	 * @param $queryBuilder
	 * @return array
	 */
	public function pagination(Request $request, $queryBuilder)
	{
		$page = $request->query->getInt('page', 1);
		$limit = $request->query->getInt('limit', 20);

		/** @var SlidingPagination $pagination */
		$pagination = $this->container->get('paginator')->paginate($queryBuilder, $page, $limit);

		return [
			'page' => $page,
			'limit' => $limit,
			'total' => $pagination->getTotalItemCount(),
			'items' => $pagination->getItems()
		];
	}

	/**
	 * @param ConstraintViolationListInterface $errors
	 * @return array
	 */
	public function getErrors(ConstraintViolationListInterface $errors)
	{
		$data = [];
		$accessor = PropertyAccess::createPropertyAccessor();
		if (count($errors) > 0) {
			/** @var ConstraintViolation $error */
			foreach ($errors as $error) {
				$accessor->setValue($data, $error->getPropertyPath(), $error->getMessage());
			}
		}

		return $data;
	}
}