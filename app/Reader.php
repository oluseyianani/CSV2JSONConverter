<?php


namespace App;


class Reader
{
    public $stream;

    public array $record;

    public CSVColumn $classToExtract;

    public function __construct(CSVColumn $classColumn)
    {
        $this->classToExtract = $classColumn;
    }

    public function createFromPath(string $path): Reader
    {
        $this->stream = fopen($path, 'r');

        return $this;
    }

    public function getRecords(): Reader
    {
        $this->record = $this->classToExtract
                        ->setHeader()
                        ->setColumnPosition()
                        ->setDownloadName()
                        ->extractData($this->stream);

        return $this;
    }

    public function convertCSVRecordToJson(): bool
    {
        $filePath = $this->classToExtract->downloadName;
        $headerName = $this->classToExtract->header;
        file_put_contents($filePath, json_encode($this->classToExtract->data));

        print_r("$headerName File extracted and saved in path - $filePath \n");
        unset($this->classToExtract);
        return true;
    }

}