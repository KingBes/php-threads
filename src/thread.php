<?php

namespace KingBes\thread;

use Exception;

class Thread
{
    protected \FFI $ffi;

    public function __construct(
        protected string $libraryFile = ""
    ) {
        $header = file_get_contents(
            __DIR__ .
                DIRECTORY_SEPARATOR .
                "thread_php.h"
        );
        $depot = $this->os_path();

        $this->ffi = \FFI::cdef($header, $depot);
    }


    /**
     * 线程数组 function
     *
     * @param array $arr
     * @return void
     */
    public function arr(array $arr): void
    {
        $data = \FFI::new('void(*[' . count($arr) . '])()');
        foreach ($arr as $k => $v) {
            if (is_callable($v)) {
                $data[$k] = $v;
            } else {
                throw new Exception("The element must be a function");
            }
        }
        $this->ffi->threads_arr($data, count($arr));
    }

    /**
     * 拓展文件路径 function
     *
     * @return string
     */
    protected function os_path(): string
    {
        if ($this->libraryFile == "") {
            $this->libraryFile = match (PHP_OS_FAMILY) {
                "Linux" => __DIR__ .
                    DIRECTORY_SEPARATOR .
                    "os" .
                    DIRECTORY_SEPARATOR .
                    "linux" .
                    DIRECTORY_SEPARATOR .
                    "threads.so",
                "Windows" => __DIR__ .
                    DIRECTORY_SEPARATOR .
                    "os" .
                    DIRECTORY_SEPARATOR .
                    "windows" .
                    DIRECTORY_SEPARATOR .
                    "threads.dll",
                default => throw new Exception("Os is not supported, Only Linux and windows are only supported by default."),
            };
        }

        return $this->libraryFile;
    }
}
