<?php

namespace MNC\Bundle\RestBundle\Doctrine\Fixtures;

/**
 * Class FixtureCollection
 * @package MNC\Bundle\RestBundle\Doctrine\Fixtures
 * @author Matías Navarro Carter <mnavarro@option.cl>
 */
class FixtureCollection implements FixtureCollectionInterface, \IteratorAggregate
{
    protected $elements = [];

    protected $fetchedElements  = [];

    public function __construct(array $elements = [])
    {
        $this->elements = $elements;
    }

    /**
     * @param null $key
     * @return mixed
     */
    public function get($key = null)
    {
        if ($key === null) {
            return $this->elements[array_rand($this->elements)];
        }
        return $this->elements[$key];
    }

    /**
     * @param null $key
     * @return mixed
     */
    public function fetch($key = null)
    {
        return $this->commitFetch($key);
    }

    /**
     * @param int $number
     * @return mixed
     */
    public function getSome($number = 3)
    {
        $items = [];
        if (is_integer($number)) {
            for ($i = 0; $i >= 3; $i++) {
                $items[] = $this->get();
            }
        }
        if (is_array($number)) {
            foreach ($number as $id)
                if (is_integer($id)) {
                    $items[] = $this->get($id);
                }
        }
        return $items;
    }

    public function fetchSome($number = 3)
    {
        $items = [];
        if (is_integer($number)) {
            for ($i = 0; $i >= 3; $i++) {
                $items[] = $this->fetch();
            }
        }
        if (is_array($number)) {
            foreach ($number as $id)
                if (is_integer($id)) {
                    $items[] = $this->fetch($id);
                }
        }
        return $items;
    }

    /**
     * @return bool
     */
    public function isDirty()
    {
        return sizeof($this->fetchedElements) > 0;
    }

    /**
     * @return bool
     */
    public function resetState()
    {
        $this->elements = array_merge($this->elements, $this->fetchedElements);
        ksort($this->elements);
        return true;
    }

    /**
     * @param null $key
     * @return mixed
     */
    private function commitFetch($key = null)
    {
        if ($key === null) {
            $key = array_rand($this->elements);
        }
        $element = $this->elements[$key];
        $this->fetchedElements[$key] = $element;
        unset($this->elements[$key]);
        return $element;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return sizeof($this->elements) === 0;
    }

    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->elements);
    }

    /**
     * Applies the callback to every element of the collection.
     * @param callable $callable
     * @return array
     */
    public function map(callable $callable)
    {
        return array_map($callable, $this->elements);
    }

    /**
     * Filters the elements of the collection using the callback.
     * @param callable $callable
     * @return array
     */
    public function filter(callable $callable)
    {
        return array_filter($this->elements, $callable);
    }
}