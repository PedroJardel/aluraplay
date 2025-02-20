<?php

namespace alura\mvc\Models;

class Video
{
    public readonly int $id;
    public readonly string $url;
    private ?string $filePath = null;

    public function __construct(
        string $url,
        public readonly string $title
    )
    {
        $this->setUrl($url);
    }

    public function id()
    {
        return $this->id;
    }

    public function title()
    {
        return $this->title;
    }

    public function url()
    {
        return $this->url;
    }

    public function filePath()
    {
        return $this->filePath;
    }

    private function setUrl(string $url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new \InvalidArgumentException("URL inválida");
        }
        $this->url = $url;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setFilePath(string $filePath)
    {
        $this->filePath = $filePath;
    }
}
