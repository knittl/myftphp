<?php
// iterator class for traversing directories
class mfp_dir_iterator implements Iterator {
	private $handle  = NULL;
	private $path    = '';
	private $count   = '';
	private $current = 0;

	// open directory, create handle, init vars
	public function __construct($path) {
		$this->path   = $path;
		$this->handle = opendir($this->path);
	}
	// closes directory handle
	public function __destruct() {
		closedir($this->handle);
	}

	// iterator interface ===============================

	// rewinds to first directory entry and resets counter
	public function rewind() {
		rewinddir($this->handle);
		$this->count = 0;
		$this->next();
	}
	// returns name of current entry
	public function current() {
		return $this->current;
	}
	// returns and increments index of current entry
	public function key() {
		return $this->count++;
	}
	// sets and returns current entry
	public function next() {
		$this->current = readdir($this->handle);
		return $this->current;
	}
	// checks for valid entry
	public function valid() {
		return $this->current() !== FALSE;
	}

	// moo factor! ===========================
	public function __toString() {
		return $this->path;
	}
}
?>