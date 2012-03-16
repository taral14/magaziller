<?php
class ElfinderController extends Controller {

	public $layout=false;

    public function access($attr, $path, $data, $volume) {
        return strpos(basename($path), '.') === 0   // if file/folder begins with '.' (dot)
            ? !($attr == 'read' || $attr == 'write')  // set read+write to false, other (locked+hidden) set to true
            : ($attr == 'read' || $attr == 'write');  // else set read+write to true, locked+hidden to false
    }

	public function run() {
        Yii::import('ext.elFinder.elFinder');

        $elFinder=new elFinder(array(
            //'debug' => true,
            'roots' => array(
                array(
			        'driver'        => 'LocalFileSystem',
			        'path'          => Yii::app()->basePath.'/../storage',
			        'URL'           => Yii::app()->request->hostInfo.Yii::app()->baseUrl.'/storage',
                    'accessControl' => array($this, 'access'),
                    'separator'     => '/',
                )
            )
        ));

		$isPost = $_SERVER["REQUEST_METHOD"] == 'POST';
		$src    = $_SERVER["REQUEST_METHOD"] == 'POST' ? $_POST : $_GET;
		$cmd    = isset($src['cmd']) ? $src['cmd'] : '';
		$args   = array();

		if (!function_exists('json_encode')) {
			$error = $elFinder->error(elFinder::ERROR_CONF, elFinder::ERROR_CONF_NO_JSON);
			$this->output(array('error' => '{"error":["'.implode('","', $error).'"]}', 'raw' => true));
		}

		if (!$elFinder->loaded()) {
			$this->output(array('error' => $elFinder->error(elFinder::ERROR_CONF, elFinder::ERROR_CONF_NO_VOL)));
		}

		// telepat_mode: on
		if (!$cmd && $isPost) {
			$this->output(array('error' => $elFinder->error(elFinder::ERROR_UPLOAD_COMMON, elFinder::ERROR_UPLOAD_FILES_SIZE), 'header' => 'Content-Type: text/html'));
		}
		// telepat_mode: off

		if (!$elFinder->commandExists($cmd)) {
			$this->output(array('error' => $elFinder->error(elFinder::ERROR_UNKNOWN_CMD)));
		}

		// collect required arguments to exec command
		foreach ($elFinder->commandArgsList($cmd) as $name => $req) {
			$arg = $name == 'FILES'
				? $_FILES
				: (isset($src[$name]) ? $src[$name] : '');

			if (!is_array($arg)) {
				$arg = trim($arg);
			}
			if ($req && empty($arg)) {
				$this->output(array('error' => $elFinder->error(elFinder::ERROR_INV_PARAMS, $cmd)));
			}
			$args[$name] = $arg;
		}

		$args['debug'] = isset($src['debug']) ? !!$src['debug'] : false;

		$this->output($elFinder->exec($cmd, $args));
	}

	protected function output(array $data) {
		$header = isset($data['header']) ? $data['header'] : 'Content-Type: text/html; charset=utf-8' /*'Content-Type: application/json'*/;
		unset($data['header']);
		// debug($header);
		// exit();
		if ($header) {
			if (is_array($header)) {
				foreach ($header as $h) {
					header($h);
				}
			} else {
				header($header);
			}
		}

		if (isset($data['pointer'])) {
			rewind($data['pointer']);
			fpassthru($data['pointer']);
			if (!empty($data['volume'])) {
				$data['volume']->close($data['pointer'], $data['info']['hash']);
			}
			exit();
		} else {
			if (!empty($data['raw']) && !empty($data['error'])) {
				exit($data['error']);
			} else {
				exit(json_encode($data));
			}
		}
	}

}