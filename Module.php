<?php

namespace mmelcor\yii2transconv;

use Yii;
use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public $controllerNamespace = 'mmelcor\yii2transconv\contollers';

    public function init()
    {
        parent::init();

		/*if ($app instanceof \yii\console\Application) {
			$$this->controllerNamespace;
		}*/
    }

	public function bootstrap($app)
	{
		if ($app instanceof \yii\console\Application) {
			$app->controllerMap[$this->id] = [
				'class' =>
					'mmelcor\yii2transconv\commands\ConvertController',
				'module' => $this,
			];
		}
	}
}
