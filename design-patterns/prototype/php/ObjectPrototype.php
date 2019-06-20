<?php

declare(strict_types=1);

class SubObject
{
    static int $instances = 0;
    public int $instance;

    public function __construct()
    {
        $this->instance = ++self::$instances;
    }

    public function __clone()
    {
        $this->instance = ++self::$instances;
    }
}

class MyCloneable
{
    public SubObject $object1;
    public SubObject $object2;

    public function __clone()
    {
        // Force a copy of this->object, otherwise it will point to same object.
        $this->object1 = clone $this->object1;
    }
}

$obj = new MyCloneable();

$obj->object1 = new SubObject();
$obj->object2 = new SubObject();

$obj2 = clone $obj;

print("Original Object:\n");
print_r($obj);

print("Cloned Object:\n");
print_r($obj2);