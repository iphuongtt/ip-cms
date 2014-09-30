<?php
namespace Media\Model;
class ipfiles{
	private $filePath;
	private $fileName;
	private $fileExt;
	private $mediaType;

	public function __construct($filePath, $fileName){
		$this->filePath = $filePath;
		$this->fileName = $fileName;
		$this->fileExt = substr($fileName, (strrpos($fileName, '.') + 1));
		$this->setMediaType();
	}
	public function getFileName(){
		return $this->fileName;
	}
	public function getFileSize(){
		return filesize($this->filePath);
	}
	public function getFileType(){
		return $this->fileType;
	}
	public function setMediaType(){
		$mediaMaps = array(
			'image'=>array('jpg','png','bmp','gif','jpeg')
			,'audio'=>array('wma','wav','mp3')
			,'video'=>array('flv','mp4','mkv','wmv')
			,'script'=>array('php')
		);
		foreach ($mediaMaps as $key => $value) {
			if(in_array($this->fileExt, $value)){
				$this->mediaType = $key;
				return $this;
			}
		}
	}
}