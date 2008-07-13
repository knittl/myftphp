<?php
require_once('mfp_path.php');

// file wrapping class
// !!!try..throw..catch?
class mfp_file extends mfp_path {
	public function __construct($path) {
		parent::__construct($path);
		if(!$this->is_file())
			throw new Exception(sprintf($GLOBALS['l']['err']['nofile'], htmlspecialchars($path)));
	}

	// wrappers :), same name, but a bit more functionality
	public function file_get_contents() {
		return file_get_contents($this->fullpath);
	}
	public function file_put_contents($content) {
		#return @file_put_contents($this->fullpath, MQUOTES ? stripslashes($content) : $content);
		return file_put_contents($this->fullpath, $content);
	}
	public function show_source() { return show_source($this->fullpath, TRUE); }

	public function fopen($mode) {
		$this->handle = fopen($this->fullpath, $mode);
		return $this->handle;
	}
	public function fwrite($content) {
		return fwrite($this->handle, $content);
	}
	public function fread($bytes) {
		return fread($this->handle, $bytes);
	}
	public function fclose() {
		#if(!empty($this->handle))
			return fclose($this->handle);
	}
}
?>