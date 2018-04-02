<?php
/**
 * Created by PhpStorm.
 * User: Виктор
 * Date: 09.12.2017
 * Time: 1:49
 */

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;
use function App\xss_clear;

class ItemsModel
{
	protected $_ext_type = ['gif','jpg','jpeg','png'];

	/**
	 * @return array
	 * @throws \Exception
	 */
	public function validationAdd() : array
	{
		if (empty($_POST['name'])) {
			throw new \Exception('Отсутствует название');
		}

		if (empty($_POST['description'])) {
			throw new \Exception('Отсутствует описание');
		}

		if (empty($_POST['list'])) {
			throw new \Exception('Отсутствует список игр');
		}

		$files_count = count($_FILES['file']['name']);
		$photos = [];
		if ($files_count > 5) {
			throw new \Exception('Слишком много фотографий!');
		} else {
			$uploads_dir = APP_DIR . '/../public/upload';
			for ($i = 0; $i < $files_count; $i++ ) {
				if ($_FILES["file"]["error"][$i] === UPLOAD_ERR_OK) {
					$name = basename($_FILES["file"]["name"][$i]);
					$ext = explode('.',$name);
					$ext = end($ext);
					if (in_array($ext, $this->_ext_type, TRUE)) {
						$new_name = uniqid('img_') . '.' . $ext;
						if (move_uploaded_file($_FILES["file"]["tmp_name"][$i], "$uploads_dir/$new_name")) {
							if (extension_loaded('imagick')) {
								$thumbnail = new \Imagick();
								$thumbnail->readImage(realpath($uploads_dir.'/'.$new_name));
								$thumbnail->setImageCompression(\Imagick::COMPRESSION_DXT3);
								$thumbnail->setImageCompressionQuality(40);
								$thumbnail->stripImage();

								//TODO Fix: Разобраться со сжатием, иногда размер больше, чем был
								//if ($thumbnail->getImageLength() < filesize($uploads_dir.'/'.$new_name)) {
								$thumbnail->writeImage($uploads_dir.'/'.$new_name);
							}
							$photos[] = "/upload/$new_name";
						};
					}
				}
			}
		}

		$list_games = explode('\n', xss_clear($_POST['list']));
		$name = xss_clear($_POST['name']);

		$data = [
			'name'	=>	$name,
			'list'	=>	json_encode($list_games),
			'description'	=>	$_POST['description'],
			'photos'	=>	json_encode($photos),

		];

		return $data;
	}
}

