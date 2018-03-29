<?php

namespace App\Behavioral;

class Chef implements \SplSubject
{
    public $food;

    private $eaters;

    public function __construct()
    {
        $this->eaters = new \SplObjectStorage();
    }

    public function attach(\SplObserver $eater)
    {
        $this->eaters->attach($eater);
    }

    public function detach(\SplObserver $eater)
    {
        $this->eaters->detach($eater);
    }

    public function cook(string $food)
    {
        $this->food = $food;
        $this->notify();
    }

    public function notify()
    {
        foreach ($this->eaters as $eater) {
            $eater->update($this);
        }
    }
}
