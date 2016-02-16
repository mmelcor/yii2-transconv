<?php

namespace mmelcor\yii2transconv\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;
//use yii\i18n\I18n;

class ConvertController extends Controller
{
	public function actionIndex($directory)
	{
		$dir = $directory;
		$langs = $this->actionGetLang($dir);
		$cats = $this->actionGetCat($dir.$langs[0]."/");

		if($this->actionMsgLoop($dir, $langs, $cats)) {
			try {
				rename($dir, 'messages_php');
				rename('messages_po', $dir);
			} catch (Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
			}
		} else {
			echo "Could not create files.\n";
		}

	}

	protected function actionGetCat($lang_dir)
	{
		if(is_dir($lang_dir)){
			if($dh = opendir($lang_dir)) {
				while(($cat = readdir($dh)) !== false) {
					$cats [] = $cat;
				}
			}
		}

		unset($cats[0], $cats[1]);
		$cats = array_values($cats);

		return $cats;
	}

	protected function actionGetLang($directory) 
	{
		$dotFiles = "/(\w+)*\.\w+/";
		if(is_dir($directory)){
			if($dh = opendir($directory)) {
				while(($lang = readdir($dh)) !== false) {
					$langs [] = $lang;
				}
			}
		}

		unset($langs[0], $langs[1]);
		$langs = array_values($langs);
		$lnum = 0;
		foreach($langs as $lang) {
			if(preg_match($dotFiles, $lang)) {
				unset($langs[$lnum]);
			}
			$lnum++;
		}
		$langs = array_values($langs);

		return $langs;
	}

	protected function actionMsgLoop($dir, $langs, $cats)
	{
		$success = true;
		if($success){
			foreach($langs as $lang)
			{
				foreach($cats as $cat)
				{
					$success = $this->actionWriteMessage($dir, $lang, $cat);
				}
			}
		} else {
			echo "One of your files did not create properly.\n";
		}
		return $success;
	}

	protected function actionWriteMessage($dir, $lang, $cat)
	{
		$po_dir = "messages_po/".$lang."/";
		$cat_name = explode('.', $cat);
		$fname = "messages.po";

		if($phpfile = fopen($dir.$lang.'/'.$cat, 'r')) {
			while (($phpbuffer = fgets($phpfile)) !== false) {
				if(strpos($phpbuffer, "=>") !== false){
					$exp_string = explode("' => '", $phpbuffer);
					$msgid = addslashes(trim(str_replace("'", "", $exp_string[0])));
					$msgstr = addslashes(str_replace("',\n", "", $exp_string[1]));

					if(!file_exists($po_dir)) {
						mkdir($po_dir, 0755, true);
					}
					if($po_file = fopen($po_dir.$fname, "a")) {
						if(fwrite($po_file, 'msgctxt "'.$cat_name[0].'"'.PHP_EOL)) {
							if(fwrite($po_file, 'msgid "'.$msgid.'"'.PHP_EOL)) {
								if(fwrite($po_file, 'msgstr "'.$msgstr.'"'.PHP_EOL.PHP_EOL)) {
								} else {
									echo "Could not write ".$msgstr." to ".$po_file.".\n";
								}
							} else {
								echo "Could not write ".$msgid." to ".$po_file.".\n";
							}
						} else {
							echo "Could not write ".$cat_name." to ".$po_file.".\n";
						}

					} else {
						echo "Could not open/create ".$po_file.".\n";
					}
					fclose($po_file);
				}
			}
			echo "File: ".$lang."/".$fname." created successfully.\n";
		} else {
			echo "File: ".$lang."/".$cat." could not be opened.\n";
			return false;
		}
		return true;
	}
}

?>