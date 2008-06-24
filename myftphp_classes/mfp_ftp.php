<?php
// ftp wrapper class for easy handling of ftp actions

class mfp_ftp {
	private $c; // connection handle
	#private $server, $user, $pass;

	public function __construct($server, $user, $pass, $port = 21) {
		// use ssl connection when possible
		if(function_exists('ftp_ssl_connect'))
			$this->c = ftp_ssl_connect($server, $port);
		else
			$this->c = ftp_connect($server, $port);

		if(!ftp_login($this->c, $user, $pass))
			throw new Exception('Unable to login to FTP Server');
	}
	
	// connection stuff
	public function pasv($pasv) { return ftp_pasv($this->c, $pasv); }
	
	// dir stuff
	public function cd($dir) { return ftp_chdir($this->c, $dir); }
	public function cdup($dir) { return ftp_cdup($this->c); }
	public function md($dir) { return ftp_mkdir($this->c, $dir); }
	public function pwd() { return ftp_pwd($this->c); }
	public function rmdir($dir) { return ftp_rmdir($this->c, $dir); }

	// general/file stuff // wrappers
	// non blocking transfer
	public function put($remote, $local, $mode = FTP_BINARY) {
		return ftp_nb_put($this->c, $remote, $local, $mode); }
	public function get($local, $remote, $mode = FTP_BINARY) {
		return ftp_get($this->c, $local, $remote, $mode); }
	// apparently exactly otherwise than php chmod
	public function chmod($mode, $file) {
		return ftp_chmod($this->c, $mode, $file); }
	public function delete($file) { return ftp_delete($this->c, $file); }
	public function nlist($dir) { return ftp_nlist($this->c, $dir); }
	public function rename($file, $newname) {
		return ftp_rename($this->c, $file, $newname); }
	public function size($file) { return ftp_size($this->c, $file); }

	// close connection
	public function __destruct() {
		return ftp_close($this->c);
	}

}
?>