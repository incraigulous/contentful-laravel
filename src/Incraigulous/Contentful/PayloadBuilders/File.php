<?php
namespace Incraigulous\Contentful\PayloadBuilders;

class File implements PayloadBuilderInterface {
    protected $contentType;
    protected $fileName;
    protected $upload;
    protected $language;

    function __construct($contentType, $fileName, $upload, $language = 'en-US')
    {
        $this->contentType = $contentType;
        $this->fileName = $fileName;
        $this->upload = $upload;
        $this->language = $language;
    }

    /**
     * Return the payload builder array part.
     * @return array
     */
    function make()
    {
        return['file' => [$this->language =>
                [
                    'contentType' => $this->contentType,
                    'fileName' => $this->fileName,
                    'upload' => $this->upload
                ]
            ]
        ];
    }
}