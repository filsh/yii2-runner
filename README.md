# yii2-runner

## Installation

It is recommended that you install the Gearman library [through composer](http://getcomposer.org/). To do so, add the following lines to your ``composer.json`` file.

```json
{
    "require": {
       "filsh/yii2-runner": "dev-master"
    }
}
```

## Examples

```php
// example runner
class Example extends \filsh\yii2\runner\BaseRunner
{
    public $fooValue;
    
    public $barValue;
    
    public function run()
    {
        echo 'example runner with param: ' . json_encode([$this->fooValue, $this->barValue]);
    }
}

// configure component
'components' => [
  'runner' => [
      'class' => 'filsh\yii2\runner\RunnerComponent',
      'runners' => [
          'example' => [
              'class' => Example::className(),
              'fooValue' => 'foo'
          ]
      ]
  ]
],

// run examples
$this->runner->run('example', ['barValue' => 'bar']); // example runner with param: ["foo","bar"]

$this->runner->run(function(array $params) {
    echo 'inline runner with params: ' . json_encode($params);
}, ['fooValue' => 'foo']); // inline runner with params: {"fooValue":"foo"}

```
