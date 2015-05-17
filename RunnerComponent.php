<?php

namespace filsh\yii2\runner;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;

class RunnerComponent extends \yii\base\Component
{
    /**
     * @var array an array of runners default configurations (name=>config).
     */
    public $runners = [];
    
    /**
     * Runs the runner with the given name.
     * 
     * @param string $name the name of the runner.
     * @param array $params initial values to be applied to the runner properties(merge with configuration).
     * @return string the formatted value.
     */
    public function run($name, $params = array())
    {
        return $this->createRunner($name, $params)->run();
    }
    
    /**
     * Create the runner with the given name.
     * 
     * @param string $format the name or class of the formatter.
     * @param CModel $object the model.
     * @param array $config initial values to be applied to the formatter properties.
     * @return BaseFormatter the formatter instance.
     */
    protected function createRunner($name, $config = array())
    {
        if(is_callable($name)) {
            $runner = new InlineRunner();
            $runner->method = $name;
            $runner->config = $config;
        } else {
            if(!isset($this->runners[$name])) {
                throw new InvalidConfigException('Object runner not found.');
            }
            
            if(is_string($this->runners[$name])) {
                $config['class'] = $this->runners[$name];
            } else if(is_array($this->runners[$name])) {
                $config = ArrayHelper::merge($this->runners[$name], $config);
            } else {
                throw new InvalidConfigException('Object runner configuration is invalid or not found.');
            }
            $runner = Yii::createObject($config);
        }
        return $runner;
    }
}