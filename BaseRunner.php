<?php

namespace filsh\yii2\runner;

use Yii;
use yii\helpers\FileHelper;

abstract class BaseRunner extends \yii\base\Component
{
    public $tmpPath = '@runtime/runner';
    
    public $tmpDirMode = 0775;
    
    public function init()
    {
        parent::init();
        $this->tmpPath = Yii::getAlias($this->tmpPath);
        if (!is_dir($this->tmpPath)) {
            FileHelper::createDirectory($this->tmpPath, $this->tmpDirMode, true);
        }
    }
    
    public function run()
    {
        if(false === $this->beforeRun()) {
            return false;
        }
        
        $result = $this->doRun();
        $this->afterRun();
        
        return $result;
    }
    
    protected function beforeRun()
    {
        return true;
    }
    
    protected function afterRun()
    {
    }
    
    abstract protected function doRun();
}