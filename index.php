<?php
class Switcher
{
    /**
     * @var array(callable) Contains set of functions to be called
     */
    private $cases = array();
    /**
     * @var mixed The info that is analyzed for function determinition. Analog: switch($condition)
     */
    private $condition = null;

    /**
     * Starts the switch/case construction. Writes the value of anchor
     *
     * @param mixed $cond The info that is analyzed for function determinition. Analog: switch($condition)
     * @return $this
     */
    public function _switch($cond)
    {
        $this->condition = $cond;
        return $this;
    }

    /**
     * Adds new case
     *
     * @param mixed $case The value that is anchor for function execution. Analog: case 'case':
     * @param callable $func Function that will be executed for a specific case
     * @return $this
     */
    public function _case($case, callable $func)
    {
        $this->cases[$case] = $func;
        return $this;
    }

    /**
     * Add default
     *
     * @param callable $func Function that will be executed if none of the anchors worked
     * @return $this
     */
    public function _default(callable $func)
    {
        $this->cases['345123default'] = $func;
        return $this;
    }

    /**
     * Calls a function based on anchor
     */
    public function run()
    {
        if (isset($this->cases[$this->condition]))
        {
            $this->cases[$this->condition]();
        }
        else
        {
            $this->cases['345123default']();
        }
    }
} 

//Usage

$upscopeVar = 'Variable from parent scope';
$var = 3;

$switcher = new Switcher();

$switcher->_switch($var)
	->_case(1, function(){
		echo 'case 1 performed';
	})
	->_case(2, function(){
		echo 'case 2 performed';
	})
	->_case(3, function() use ($upscopeVar){//Using variable from upper scope
		echo $upscopeVar;
	})
	->_default(function(){
		echo 'default performed';
	})
	->run();