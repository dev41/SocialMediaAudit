<?php

namespace app\commands;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;
use yii\helpers\FileHelper;

class MessageController extends \yii\console\controllers\MessageController
{
    public $jsCategories = ['js'];
    public $jsFiles = ['js' => ['/www/js/report.js']];
    public $jsTranslatorRegExp = '/Yii\.t\((\'|")([^"\']+)(\'|")\)/';

    public $except = [
        '.svn',
        '.git',
        '.gitignore',
        '.gitkeep',
        '.hgignore',
        '.hgkeep',
        '/messages',
        '/BaseYii.php', // contains examples about Yii:t()
        '/vendor',
        '/runtime',
        '/www',
        '/migrations',
        '/tests',
    ];
    public $only = ['*.php'];
    public $translator = 'Yii::t';

    public function actionValidate()
    {
        // all except js
        $files = FileHelper::findFiles(realpath(Yii::$app->basePath), [
            'only' => $this->only,
            'except' => $this->except,
        ]);
        //print_r($files);
        $messages = [];
        foreach ($files as $file) {
            $messages = array_merge_recursive($messages, $this->extractMessages($file, $this->translator, array_merge($this->jsCategories, ['yii'])));
        }
        //print_r($messages);
        $errors = $this->checkDifference($messages);

        // js
        $messages = [];
        foreach ($this->jsFiles as $category => $jsFiles) {
            $messages[$category] = [];
            foreach ($jsFiles as $jsFile) {
                $messages[$category] = array_merge($messages[$category], $this->extractJsMessages(realpath(Yii::$app->basePath).$jsFile, $this->jsTranslatorRegExp));
            }
        }
        //print_r($messages);return;
        $errors = ArrayHelper::merge($errors, $this->checkDifference($messages));


        sort($errors);
        if (!empty($errors)) {
            $this->stdout(count($errors)." Errors found!\n", Console::FG_RED);
            foreach ($errors as $error) {
                $this->stdout($error."\n");
            }
        } else {
            $this->stdout("No errors\n", Console::FG_GREEN);
        }
    }

    protected function loadMessages($category)
    {
        $messageSource = Yii::$app->i18n->getMessageSource($category);
        $languageDirs = glob(Yii::getAlias($messageSource->basePath).DIRECTORY_SEPARATOR.'*' , GLOB_ONLYDIR);
        $languages = [];
        foreach ($languageDirs as $languageDir) {
            $tmp = explode(DIRECTORY_SEPARATOR, $languageDir);
            $language = array_pop($tmp);
            $filename = $languageDir.DIRECTORY_SEPARATOR.$category.'.php';
            $translations = include $filename;
            if (!empty($translations)) {
                $languages[$language] = array_keys($translations);
            } else {
                $this->stdout($filename." not found\n", Console::FG_RED);
            }
        }
        return $languages;
    }

    protected function checkDifference($messages)
    {
        $errors = [];
        foreach ($messages as $category => $strings) {
            $languages = $this->loadMessages($category);
            foreach ($languages as $language => $translations) {
                $diffs = array_diff($strings, $translations);
                if (!empty($diffs)) foreach ($diffs as $diff) {
                    $errors[] = '"'.$diff.'" not found in '.$language.'/'.$category;
                }
                $diffs = array_diff($translations, $strings);
                if (!empty($diffs)) foreach ($diffs as $diff) {
                    $errors[] = '"'.$diff.'" found in '.$language.'/'.$category.' but not in source files';
                }
            }
        }
        return $errors;
    }

    protected function extractJsMessages($fileName, $translatorRegExp)
    {
        $coloredFileName = Console::ansiFormat($fileName, [Console::FG_CYAN]);
        $this->stdout("Extracting messages from $coloredFileName...\n");

        $subject = file_get_contents($fileName);
        $messages = [];
        preg_match_all($translatorRegExp, $subject, $matches);
        if (isset($matches[2])) $messages = array_unique($matches[2]);
        $this->stdout("\n");

        return $messages;
    }
}