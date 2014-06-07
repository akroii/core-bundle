 * A class to access the file system
 * The class handles file operations via the PHP functions.
class Files
			self::$objInstance = new static();
	public function mkdir($strDirectory)
	{
		$this->validate($strDirectory);
		return @mkdir(TL_ROOT . '/' . $strDirectory);
	}
	public function rmdir($strDirectory)
	{
		$this->validate($strDirectory);
		return @rmdir(TL_ROOT. '/' . $strDirectory);
	}
	public function fopen($strFile, $strMode)
	{
		$this->validate($strFile);
		return @fopen(TL_ROOT . '/' . $strFile, $strMode);
	}
	public function fputs($resFile, $strContent)
	{
		@fputs($resFile, $strContent);
	}
	public function fclose($resFile)
	{
		return @fclose($resFile);
	}
	public function rename($strOldName, $strNewName)
	{
		// Source file == target file
		if ($strOldName == $strNewName)
		{
			return true;
		}

		$this->validate($strOldName, $strNewName);

		// Windows fix: delete the target file
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' && file_exists(TL_ROOT . '/' . $strNewName))
		{
			$this->delete($strNewName);
		}

		// Unix fix: rename case sensitively
		if (strcasecmp($strOldName, $strNewName) === 0 && strcmp($strOldName, $strNewName) !== 0)
		{
			@rename(TL_ROOT . '/' . $strOldName, TL_ROOT . '/' . $strOldName . '__');
			$strOldName .= '__';
		}

		return @rename(TL_ROOT . '/' . $strOldName, TL_ROOT . '/' . $strNewName);
	}
	public function copy($strSource, $strDestination)
	{
		$this->validate($strSource, $strDestination);
		return @copy(TL_ROOT . '/' . $strSource, TL_ROOT . '/' . $strDestination);
	}
	public function delete($strFile)
	{
		$this->validate($strFile);
		return @unlink(TL_ROOT . '/' . $strFile);
	}
	public function chmod($strFile, $varMode)
	{
		$this->validate($strFile);
		return @chmod(TL_ROOT . '/' . $strFile, $varMode);
	}
	public function is_writeable($strFile)
	{
		$this->validate($strFile);
		return @is_writeable(TL_ROOT . '/' . $strFile);
	}
	public function move_uploaded_file($strSource, $strDestination)
	{
		$this->validate($strSource, $strDestination);
		return @move_uploaded_file($strSource, TL_ROOT . '/' . $strDestination);
	}