<?php
// file wrapping class
class mfp_file extends mfp_path {
	public function __construct($path) {
		parent::__construct($path);
		if(!$this->is_file())
			throw new Exception(sprintf($GLOBALS['l']['err']['nofile'], htmlspecialchars($path)));
	}

	// wrappers :), same name, but a bit more functionality
	public function show_source($return = TRUE) {
		return show_source($this->fullpath, $return);
	}
	public function file_put_contents($content) {
		return file_put_contents($this->fullpath, $content);
	}

	// open file and save handle
	public function fopen($mode) {
		$this->handle = fopen($this->fullpath, $mode);
		return $this->handle;
	}
	// write content to file
	public function fwrite($content) {
		return fwrite($this->handle, $content);
	}
	// read $bytes from file
	public function fread($bytes) {
		return fread($this->handle, $bytes);
	}
	// close file handle
	public function fclose() {
		#if(!empty($this->handle))
			#fflush($this->handle) // TODO: read docs for this function
			return fclose($this->handle);
	}
}
?>