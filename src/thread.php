<?php

namespace KingBes\thread;

use Exception;

class Thread
{
    protected \FFI $ffi;
    protected $thread;

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

        $this->thread = $this->ffi->create();
    }

    /**
     * 安放函数 function
     *
     * @param Closure $fn 函数
     * @return self
     */
    public function emplace(\Closure $fn): self
    {
        $this->ffi->emplace($this->thread, $fn);
        return $this;
    }

    /**
     * 启动线程 function
     *
     * @return void
     */
    public function start(): void
    {
        $this->ffi->start($this->thread);
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
