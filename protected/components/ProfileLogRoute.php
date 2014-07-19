<?php  
class ProfileLogRoute extends CFileLogRoute
{
    protected function processLogs($logs)
    {
        $logFile=$this->getLogPath().DIRECTORY_SEPARATOR.$this->getLogFile();
        if(@filesize($logFile)>$this->getMaxFileSize()*1024)
            $this->rotateFiles();
        $fp=@fopen($logFile,'a');
        @flock($fp,LOCK_EX);

        $profileStack = array();
        $profileResults = array();
        foreach ($logs as $log)
        {
            if ($log[1] === CLogger::LEVEL_PROFILE)
            {
                $message = $log[0];
                if (!strncasecmp($message, 'begin:', 6))
                {
                    $log[0] = substr($message,6);
                    $profileStack[] = $log;
                }
                else if(!strncasecmp($message, 'end:', 4))
                {
                    $token = substr($message,4);
                    if(($last = array_pop($profileStack)) !== null && $last[0] === $token)
                    {
                        $info = array(
                            'delta' => $log[3] - $last[3],
                            'category' => $last[2],
                            'time' => $last[3]
                        );
                        $this->aggregateResult($token, $info, $profileResults);
                    }
                    else
                    {
                        throw new CException(Yii::t('yii','CProfileLogRoute found a mismatching code block "{token}". Make sure the calls to Yii::beginProfile() and Yii::endProfile() be properly nested.',
                            array('{token}'=>$token)));
                    }
                }
            }
            else
            {
                @fwrite($fp,$this->formatLogMessage($log[0],$log[1],$log[2],$log[3]));
            }
        }

        if (!empty($profileResults))
        {
            $now = microtime(true);
            while(($last = array_pop($profileStack)) !== null)
            {
                $info = array(
                    'delta' => $now - $last[3],
                    'category' => $last[2],
                    'time' => $last[3]
                );
                $token = $last[0];
                $this->aggregateResult($token, $info, $profileResults);
            }

            $entries = array_values($profileResults);
            $func = create_function('$a,$b','return $a["total"]<$b["total"]?1:0;');
            usort($entries, $func);
            foreach ($entries as $entry)
            {
                $message = sprintf("Min: % 11.8f    Max: % 11.8f    Total: % 11.8f    Calls: % 3d    %s", $entry['min'], $entry['max'], $entry['total'], $entry['calls'], $entry['token']);
                @fwrite($fp, $this->formatLogMessage($message, CLogger::LEVEL_PROFILE, $entry['category'], $entry['time']));
            }
        }

        @flock($fp,LOCK_UN);
        @fclose($fp);
    }

    protected function aggregateResult($token, $info, &$results)
    {
        if (isset($results[$token]))
        {
            if ($info['delta'] < $results[$token]['min'])
                $results[$token]['min'] = $info['delta'];
            else if($info['delta'] > $results[$token]['max'])
                $results[$token]['max'] = $info['delta'];
            $results[$token]['calls']++;
            $results[$token]['total'] += $info['delta'];
            return;
        }

        $results[$token] = array(
            'token' => $token,
            'calls' => 1,
            'min' => $info['delta'],
            'max' => $info['delta'],
            'total' => $info['delta'],
            'category' => $info['category'],
            'time' => $info['time']
        );
    }
}