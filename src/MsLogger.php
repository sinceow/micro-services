<?php

namespace Jobsys\MicroServices;

class MsLogger
{
    public $conf = array(
        "separator" => "\t",
        "log_file" => ""
    );

    private $file_handle;

    protected function getFileHandle()
    {
        if (null === $this->file_handle) {
            if (empty($this->conf["log_file"])) {
                trigger_error("no log file specified.");
            }
            $log_dir = dirname($this->conf["log_file"]);
            if (!is_dir($log_dir)) {
                mkdir($log_dir, 0777, true);
            }
            $this->file_handle = fopen($this->conf["log_file"], "a");
        }
        return $this->file_handle;
    }

    public function log($log_data)
    {
        if ("" == $log_data || array() == $log_data) {
            return false;
        }
        if (is_array($log_data)) {
            $log_data = implode($this->conf["separator"], $log_data);
        }
        $log_data = $log_data . "\n";
        fwrite($this->getFileHandle(), $log_data);
    }
}

?>