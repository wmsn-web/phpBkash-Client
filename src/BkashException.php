<?php
namespace WmsnWeb\BkashPhpClient;
use Exception;

class BkashException extends Exception{
	public function errorMessage(): string
    {
        return "Error on line {$this->getLine()} in {$this->getFile()}. {$this->getMessage()}.";
    }
}