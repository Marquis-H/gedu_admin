<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2018/10/26
 * Time: 10:05 PM
 */

namespace Admin\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Admin\Helper\UploadHelper;

/**
 * Class UploadController
 * @package Admin\Controller\Api
 */
class UploadController extends AbstractApiController
{
	/**
	 * 上传图片
	 *
	 * @Route("/image", name="api.upload.image")
	 * @Method({"POST"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function UploadImage()
	{
		$fs = $this->get('filesystem');
		try {
			$relativePath = '/uploads/' . date('Y/m');
			$uploadDir = $this->container->getParameter('kernel.root_dir') . '/../public' . $relativePath;

			if (!$fs->exists($uploadDir))
				$fs->mkdir($uploadDir);
			$uploader = new UploadHelper('upload');
			$uploader->allowedExtensions = explode('|', 'png|jpeg|jpg|gif');
			$oldName = str_replace('.' . $uploader->getExtension(), '', $uploader->getFileName());
			$uploader->newFileName = sprintf('%s.%s',
				uniqid(mt_rand(10000, 99999)),
				strtolower($uploader->getExtension())
			);
			$status = $uploader->handleUpload($uploadDir);
			if ($status) {
				$uploadPath = $relativePath . '/' . $uploader->newFileName;
				$data = array(
					'name' => $oldName,
					'file' => $uploadPath,
					'extension' => $uploader->getExtension()
				);
				return $this->createSuccessJSONResponse($data, 'success');
			} else {
				$uploadPath = null;
				return $this->createFailureJSONResponse(-1, $uploader->getErrorMsg());
			}
		} catch (\Exception $e) {
			return $this->createFailureJSONResponse(-1, $e->getMessage());
		}
	}
}