<?php

class PreferredList implements Iterator
{
    protected $list;
    protected $preferred = null;
    protected $previously_preferred = null;
    protected $position = 0;

    public function __construct($list)
    {
        $this->list = $list;
    }

    /**
     * Preferring an item ensures that next time the list is processed, it
     * will come first.
     */
    public function prefer()
    {
        $this->preferred = $this->current();
    }

    public function rewind()
    {
        if (is_null($this->preferred)) {
            return null;
        }

        if ($this->preferred == $this->previously_preferred) {
            return null;
        }

        sort(
            $this->list,
            array($this, 'sort')
        );

        $this->position = 0;

        return true;
    }

    public function current()
    {
        return $this->list[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        $this->position++;
    }

    public function valid()
    {
        return isset($this->list[$this->position]);
    }

    protected function sort($a, $b) {
        if ($a == $this->preferred) {
            return -1;
        }

        return strnatcasecmp($a, $b);
    }
}

