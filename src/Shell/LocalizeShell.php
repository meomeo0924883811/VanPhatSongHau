<?php
// namespace Sevenedge\Shell;
namespace App\Shell;

use App\Lib\I18n;
// use Cake\Console\Shell;
use App\Shell\ConsoleShell;
use Cake\Core\Configure;
use Cake\Network\Http\Client;
use Cake\Filesystem\File;
use Cake\Cache\Cache;

class LocalizeShell extends \App\Shell\ConsoleShell {
// class LocalizeShell extends Shell {

	private $_errHandler;

	public function __construct() {
		ini_set('memory_limit', '512M');
		$this->_errHandler = function ($level, $message) {
			switch ($level) {
				case E_USER_NOTICE:
					$this->log($message, LOG_DEBUG);
					break;
				case E_USER_WARNING:
					$this->log($message, LOG_WARNING);
					break;
				case E_USER_ERROR:
					$this->log($message, LOG_ERR);
					break;
			}
		};
		parent::__construct();
	}

	/**
     * Override main() to handle action
     *
     * @return mixed
     */
	public function main() {
		$parentOptions = get_class_methods('\App\Shell\ConsoleShell');
		$options = get_class_methods($this);
		$options = array_diff($options, $parentOptions);

		$this->out(__d('cake_console', "<info>USAGE: app/cake " . substr(get_class($this), 0, -5) . " [method]</info>"));
		$this->out(__d('cake_console', "<info>With [option] being one of the following</info>"));
		foreach ($options as $option) {
			if ($option !== 'main' && substr($option,0,1) !== '_') {
				$this->out(__d('cake_console', "<info>- $option</info>"));
			}
		}

		exit(1);
	}

	/**
     * updates or creates .po files from a .tsv file, with column 1 == string used in the __() function.
	 * header must contain langcodes starting from column 2.sz
     *
     * @param string|null $sourceFile Source File.
     * @return void
     */
	public function updateTranslation ($sourceFile = null, $useDefaultTranslation = '') {
		if ($sourceFile === NULL) {
			if (count($this->args) != 1 || !file_exists($this->args[0])) {
				$this->log("USAGE: bin/cake localize updateTranslation sourceFile");
				exit(1);
			}
		}

		$sourceFile = array_shift($this->args);
        if($useDefaultTranslation == 'default'){
            I18n::extract_default($sourceFile, $this->_errHandler);
        }
        else {
            I18n::extract($sourceFile, $this->_errHandler);
        }
	}
    /**
     * updates or creates .po files from google sheet, with column 1 == string used in the __() function.
     * header must contain langcodes starting from column 2.sz
     *
     * @param string|null $sourceFile Source File.
     * @return void
     */
    public function updateTranslationGoogleSheet($useDefaultTranslation = '')
    {
        $http = new Client();
        if ($sourceFileId = Configure::read('Translations.sheet_id')) {
            $gid = Configure::read('Translations.gid');
            $gs_url = 'https://docs.google.com/spreadsheets/d/'.$sourceFileId.'/export?format=tsv&id='.$sourceFileId.'&gid='.$gid;
            $this->out(__d('cake_console', "<info>".$gs_url."</info>"));
            $response = $http->get($gs_url);
            $temp_name = TMP.'temp_of_Translation.tsv';
            if ($response->isOk()) {
                $this->out(__d('cake_console', "<info>Save Temp : temp_of_Translation.tsv</info>"));
                $gs_content = $response->body();
                $file = new File($temp_name, true, 0777);
                $file->write($gs_content);
                $file->close();
                @chmod($temp_name, 0777);
                $this->out(__d('cake_console', "<info>start extracting</info>"));
                if($useDefaultTranslation == 'default'){
                    I18n::extract_default($temp_name, $this->_errHandler);
                }
                else {
                    I18n::extract($temp_name, $this->_errHandler);
                }
                $this->out(__d('cake_console', "<info>Finish extracting</info>"));
                Cache::clear(false,'_cake_core_');
            }
        }
        //example google sheet Translations
        //https://docs.google.com/spreadsheets/d/1-P7atbbata4Z52z1O4tX2DPkOhKxbkLPLnWNlK04owQ/edit#gid=806953753
    }
}