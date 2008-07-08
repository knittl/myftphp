<?php
// functions for both dirs/files(/links)
// better way is concrete (if we don't know the type, but need some basic functionality)
// mapping to OOP

class mfp_path {
	protected $path, $realpath, $name, $dir;
	protected $handle;
	protected $lstat = array();

	public function __construct($path) {
		if(file_exists($path)) {
			$this->setPathInfo($path);

			// cache lstat results
			$this->lstat = lstat($this->path);
		} else {
			throw new Exception(sprintf($GLOBALS['l']['err']['badfile'], htmlspecialchars($path)));
		}
	}
	
	// return path of file - i'm proud of this one :)
	// it's so moo'ish > http://mootools.net
	public function __toString() {
		return $this->path;
	}
	
	// also quite moo'ish
	// could replace some of the following wrapper functions > currently commented out
	// !!! secure enough???
	public function __call($f, $a) {
		return $f($this->path);
	}

	// wrappers; same name, same functionality
	public function realpath() { return $this->realpath; }
	public function basename() { return $this->name; }
	public function dirname()  { return $this->dir; }

	#public function is_readable() { return is_readable($this->path); }
	#public function is_writable() { return is_writable($this->path); }

	#public function is_dir()  { return is_dir($this->path); }
	#public function is_file() { return is_file($this->path); }
	#public function is_link() { return is_link($this->path); }

	// stat functions
	public function lstat() { return $this->lstat; }
	#public function stat() { return stat($this->path); }

	// really needed this way? since php caches anyway
	public function filesize()  { return $this->lstat['size']; }
	public function fileatime() { return $this->lstat['atime']; } // accessed
	public function filemtime() { return $this->lstat['mtime']; } // modified
	public function filectime() { return $this->lstat['ctime']; } // created

	public function fileperms() { return $this->lstat['mode']; }
	public function fileowner() { return $this->lstat['uid']; }
	public function filegroup() { return $this->lstat['gid']; }
	//---


	function chmod($mode) {
		return chmod($this->path, $mode);
		// to come
	}

	private function setPathInfo($path) {
		// works so far

		$this->path = $path;
		// is $this->path inside HOME?
		$this->performCheck();
		$this->path = HOME . $this->getCleanPath();

		// just strings
		$this->realpath = realpath($this->path);
		$this->name  = basename($this->realpath);
		$this->dir   = dirname($this->path);
	}
	// old allowed() function
	private function performCheck() {
		// throws on not 0 (zero)
		if(!(strpos(realpath($this->path), REALHOME) === 0)) throw new Exception(sprintf($GLOBALS['l']['err']['forbidden'], htmlspecialchars($this->path)));
	}
	// shows relative path from $home
	// no check if $home is within allowed range
	public function getCleanPath($home = HOME) {
		// needs benchmarking
		return (str_replace(realpath($home), '', realpath($this->path)));
		//---
		$realpath = realpath($this->path);
		$realhome = realpath($home);
		if(strpos($realpath, $realhome) === 0) return (substr($realpath, strlen($realhome)));
		else return '/'.$this->path;
		return FALSE;
	}

	public function copy($destination) {
		// composites mfp_dir object (for security reasons and stuff)
		$newdir = new mfp_dir(dirname($destination));
		
		return copy($this->path, $destination);
	}
	// only expects new filename, not new path
	// limitations: double renaming of parent directories of the script does not work :-/ but who does that?
	public function rename($newname) {
		// composites mfp_dir objects (for security reasons and stuff)
		$curdir = new mfp_dir($this->dir);
			// only security check
			$newdir = new mfp_dir($curdir.'/'.dirname($newname));
		$newpath = $curdir.'/'.$newname;

		// updates object's path
		if(rename($this->path, $newpath)) {
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
		$return = @unlink($this->path);
		// destroy object ...testing :)
		unset($this);
		return $return;
	}
	// wrappers over wrappers
	// uses rename internally (another wrapper :)) other way would be copy&delete
	public function delete() {
		return $this->unlink();
	}

}
?>
