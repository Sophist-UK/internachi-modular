<?php

namespace InterNACHI\Modular\Tests\Concerns;

use Illuminate\Filesystem\Filesystem;

trait WritesToAppFilesystem
{
	protected $filesystem;
	
	protected $base_path;
	
	protected function filesystem(): Filesystem
	{
		if (null === $this->filesystem) {
			$this->filesystem = new Filesystem();
		}
		
		return $this->filesystem;
	}
	
	protected function getBasePath()
	{
		if (null === $this->base_path) {
			$this->filesystem()->copyDirectory(
				parent::getBasePath(),
				$this->base_path = sys_get_temp_dir().DIRECTORY_SEPARATOR.md5(microtime())
			);
		}
		
		return $this->base_path;
	}
	
	protected function getModulePath(string $module_name, string $path = '/', string $modules_root = 'app-modules'): string 
	{
		$path = trim(str_replace('/', DIRECTORY_SEPARATOR, $path), DIRECTORY_SEPARATOR);
		if ('' !== $path) {
			$path = DIRECTORY_SEPARATOR.$path;
		}
		
		return $this->getBasePath()
			.DIRECTORY_SEPARATOR
			.$modules_root
			.DIRECTORY_SEPARATOR
			.$module_name
			.$path;
	}
}
