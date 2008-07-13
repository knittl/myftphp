<?php
// functions for both dirs/files(/links)
// better way is concrete (if we don't know the type, but need some basic functionality)
// mapping to OOP
// works relative to HOME

class mfp_path {
	protected $fullpath, $path, $realpath, $name, $dir;
	protected $handle;
	protected $lstat = array();

	public function __construct($path) {
		if(file_exists(HOME.'/'.$path)) {
			$this->setPathInfo($path);
		} else {
			throw new Exception(sprintf($GLOBALS['l']['err']['badfile'], htmlspecialchars($path)));
		}
	}
	
	// return path of file - i'm proud of this one :)
	// it's so moo'ish > http://mootools.net
	public function __toString() {
		return $this->path;
	}
	public function fullpath() {
		return $this->fullpath;
	}
	
	// also quite moo'ish
	// !!! secure enough???
	public function __call($f, $a) {
		return $f($this->fullpath);
	}

	// wrappers; same name, same functionality
	public function realpath() { return $this->realpath; }
	public function basename() { return $this->name; }
	public function dirname()  { return $this->dir; }
	#public function 

	//---


	function chmod($mode) {
		return chmod($this->fullpath, $mode);
		// to come
	}

	// takes relative path
	private function setPathInfo($path) {
		// works so far

		$this->path = $path;
		$this->fullpath = HOME.'/'.$this->path;

		// is $this->fullpath inside HOME?
		$this->performCheck();
	
		// just strings
		$this->realpath = realpath($this->fullpath);
		$this->name     = basename($this->realpath);
		$this->dir      = dirname($this->fullpath);

		// re-set paths to cleaned ones
		$this->path = $this->getCleanPath();
		$this->fullpath = HOME.'/'.$this->path;
	}
	// old allowed() function
	private function performCheck() {
		// throws on not 0 (zero)
		if(strpos(realpath($this->fullpath), REALHOME) !== 0) throw new Exception(sprintf($GLOBALS['l']['err']['forbidden'], htmlspecialchars($this->fullpath)));
	}
	// shows relative path from $home
	// no check if $home is within allowed range
	public function getCleanPath($home = HOME) {
		// needs benchmarking
		$cleanpath = str_replace(realpath($home), '', $this->realpath);
		if($cleanpath == '') return '.';
		return substr($cleanpath, 1);
		//---
		$realpath = realpath($this->fullpath);
		$realhome = realpath($home);
		if(strpos($realpath, $realhome) === 0)
			return substr($realpath, strlen($realhome));
		return '/'.$this->fullpath;
	}

	public function copy($destination) {
		// composites mfp_dir object (for security reasons and stuff)
		$newdir = new mfp_dir(dirname($destination));
		
		return copy($this->fullpath, HOME.'/'.$destination);
	}
	// only expects new filename, not new path
	// limitations: double renaming of parent directories of the script does not work :-/ but who does that?
	public function rename($newname) {
		// composites mfp_dir objects (for security reasons and stuff)
		$curdir = new mfp_dir(dirname($this->path));
			// only security check
			$newdir = new mfp_dir($curdir.'/'.dirname($newname));
		$newpath = $curdir.'/'.$newname;
		$fullnewpath = HOME.'/'.$newpath;

		if(file_exists($fullnewpath)) throw new Exception(sprintf($GLOBALS['l']['err']['fileexists'], '<var><a href="'.  htmlspecialchars(directLink($newpath)) .'" target="_blank">'. wrap(htmlspecialchars($newpath)) .'</a></var>', getfsize(filesize($fullnewpath))));

		// updates object's path
		if(rename($this->fullpath, $fullnewpath)) {
			$this->setPathInfo($newpath);
			return TRUE;
		}
		return FALSE;
	}
	// check if it works between different filesystems too ???
	public function move($destination) {
		return $this->rename($destination);
	}

	// dirs have to be empty!
	public function unlink() {
		$return = unlink($this->fullpath);
		// destroy object ...testing :)
		unset($this);
		return $return;
	}
	public function delete() {
		return $this->unlink();
	}

	// returns breadcrumbs list: array of parent directories
	// uses string processing to avoid use of too much realpath()
	// '/path/to/file'->breadcrumbs() = array('/path', '/path/to');
	public function breadcrumbs($from = HOME) {
		$cleanPath = $this->getCleanPath($from);
		$crumbTmp = $cleanPath;
		$breadcrumbs = array();

		// filling array in reversed order
		// assume every single array between $from and $this->fullpath is within allowed range
		while($crumbTmp = substr($crumbTmp, 0, strrpos($crumbTmp, '/'))) {
			array_unshift($breadcrumbs, $crumbTmp);
		}
	
		return $breadcrumbs;
	}
}
?>
