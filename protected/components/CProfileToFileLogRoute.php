<?php

/**
* Description of CFileProfileLogRoute
*
* This component for write yii profiling messages to file.
*
* @author candasm
*/
class CProfileToFileLogRoute extends CProfileLogRoute {

    /**
* File name
* @var string filename under runtime
*/
    public $logFile;

    /**
* Log path
* @var string log folderPath
*/
    public $logPath = './protected/runtime/';

    /**
* set log messages for CFileLogRoute formatLogMessage function
* @var array
*/
    protected $profileLog;

    /**
* Sets log messages formatLogMessage format
* @param string $log
*/
    protected function addProfileLog($log) {
        $this->profileLog[] = array(
            $log, //message
            CLogger::LEVEL_PROFILE, //level
            '', //category
            time(), //time
        );
    }

    /**
* rewrite CProfileLogRoute render function for write logs to file
* @param string $view
* @param array $data
*/
    protected function render($view, $data) {

        if ($view == 'profile-callstack') {
            $this->addProfileLog('Profiling Callstack Report');
            foreach ($data as $index => $entry) {
                list($proc, $time, $level) = $entry;
                $this->addProfileLog("[$time]{$spaces}{$proc}");
            }
            $this->addProfileLog('Report End');
        } else if ($view == 'profile-summary') {
            $this->addProfileLog('Profiling Summary Report');
            //$this->addProfileLog(' count total average min max ');
			$this->addProfileLog('total time taken');
            foreach ($data as $index => $entry) {
                $proc = $entry[0];
                //$count = sprintf('%5d', $entry[1]);
               // $min = sprintf('%0.5f', $entry[2]);
                //$max = sprintf('%0.5f', $entry[3]);
                $total = sprintf('%0.5f', $entry[4]);
                //$average = sprintf('%0.5f', $entry[4] / $entry[1]);
               // $this->addProfileLog(" $count $total $average $min $max {$proc}");
				$this->addProfileLog("$total");
            }
            $this->addProfileLog('Report End');
        }
        $fileLogRoute = new FileLogRoute;
        $fileLogRoute->setLogFile($this->logFile);
        $fileLogRoute->setLogPath($this->logPath);
        $fileLogRoute->writeLogs($this->profileLog);
    }

}

/**
* Description of FileLogRoute
*
* This Class for use CFileLogRoute processLogs function becaouse of it is protected function.
* @author candasm
*
*/
class FileLogRoute extends CFileLogRoute {

    public function writeLogs($logs) {
        $this->processLogs($logs);
    }

}