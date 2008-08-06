<?php
// directory wrapping class
// implements iteratorAggregate, aggregates mfp_dir_iterator
// !!try..throw..catch?
class mfp_dir extends mfp_path implements IteratorAggregate {
	private $globContent = array();

	public function __construct($path) {
		parent::__construct($path);
		if(!$this->is_dir())
			throw new Exception(sprintf($GLOBALS['l']['err']['nodir'], htmlspecialchars($path)));
	}

	// wrappers
	public function opendir() {
		$this->handle = opendir($this->fullpath);
		return $this->handle;
	}
	public function closedir() {
		#if(!empty($this->handle))
			closedir($this->handle);
	}
	public function readdir() {
		return readdir($this->handle);
	}
	// glob mapped to this directory
	public function glob($pattern, $flags) {
		$this->globContent = glob($this->fullpath.'/'.$pattern, $flags);
		return $this->globContent;
	}

	// ==== ITERATOR ====
	// getIterator() required by IteratorAggregate interface:
	// aggregates mfp_dir_iterator class
	public function getIterator() { return new mfp_dir_iterator($this->fullpath); }
}
?>
