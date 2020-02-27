<?php

namespace nlib\Orm\Traits\Orm;

use nlib\Log\Traits\LogTrait;

trait DebugTrait {

    use LogTrait;

    private $_debug = false;
    private $_die = false;

    protected function debug(...$debug) : void {
        if($this->_debug) :
            var_dump($debug);
            $logs = ['Orm Debug' => json_encode($debug)];
            if($this->_die) $this->log($logs); else $this->dlog($logs);
        endif;
    }

    public function setDebug(bool $debug, bool $die = false) : self { $this->_debug = $debug; $this->_die = $die; return $this; }
}