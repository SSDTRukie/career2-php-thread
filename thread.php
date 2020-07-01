<?php

class Thread
{
    private $name;
    private const THREAD_FILE = 'thread.txt';

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getList()
    {
        return file_get_contents(self::THREAD_FILE);
    }

    public function post() {

    }

    public function delete() {

    }
}