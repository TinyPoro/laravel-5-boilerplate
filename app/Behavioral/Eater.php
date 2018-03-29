<?php

namespace App\Behavioral;

class Eater implements \SplObserver
{
    private $menu = [];

    public function update(\SplSubject $chef)
    {
        $this->menu[] = $chef->food;
    }


    public function getMenu()
    {
        dump($this->menu);
    }
}
