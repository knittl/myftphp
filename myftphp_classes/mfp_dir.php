<?php
require_once('mfp_path.php');

// directory wrapping class
// !!try..throw..catch?
class mfp_dir extends mfp_path {
	#private $dirContent; // mfp_list handler
	private $dirContent = array('dirs' => null, 'files' => null);
	private $dircount = 0;
	private $filecount = 0;

	public function __construct($path) {
		parent::__construct($path);
		if(!$this->is_dir())
			throw new Exception(sprintf($GLOBALS['l']['err']['nodir'], $path));
			
		$this->dirContent['dirs'] = new mfp_list();
		$this->dirContent['files'] = new mfp_list();
	}

	// wrappers
	public function opendir() {
		$this->handle = @opendir($this->path);
		return $this->handle;
	}
	public function closedir() {
		#if(!empty($this->handle))
			return @closedir($this->handle);
	}
	public function readdir() {
		return @readdir($this->handle);
	}
	// glob mapped to this directory
	public function glob($pattern, $flags) {
		return glob($this->path.'/'.$pattern, $flags);
	}

	public function fetchContent() {
		$this->opendir();
		// security and all other forms of checks, path correction...
		while($path = new mfp_path($this->readdir())) {
			//do a bit of class juggling here? !!!

			// add (string)path only
			if(is_dir($path)) {
				//directory
				$this->dirContent['dirs']->add((string)$path);
			} else {
				//other(file, link)
				$this->dirContent['files']->add((string)$path);
			}
			// later add here links
		}
		$this->closedir();
	}

	public function returnDirs() {
		return $this->dirContent['dirs'];
	}
	public function returnFiles() {
		return $this->dirContent['files'];
	}
	public function returnContent() {
		return array('dirs' => $this->returnDirs(), 'files' => $this->returnFiles());
	}
	public function returnContentMerged() {
		// not working atm
		#return array_merge();
	}
	
	// returns breadcrumbs list: array of parent directories
	// uses string processing to avoid use of realpath()
	public function returnBreadcrumbs($from = HOME) {
		$cleanPath = $this->getCleanPath($from);
		$crumbTmp = $cleanPath;
		$breadcrumbs = array();
	
		// fill array with directories - reverse afterwards
		// assume every single array between $from and $this->path is within allowed range
		while($crumbTmp = substr($crumbTmp, 0, strrpos($crumbTmp, '/'))) {
			$breadcrumbs[] = $crumbTmp;
		}
		$breadcrumbs = array_reverse($breadcrumbs);
	
		return $breadcrumbs;
	}
}

// test:
/*define('HOME', '..');
define('REALHOME', realpath(HOME));
include 'mfp_list.php';
$dir = new mfp_dir('.');*/
?>