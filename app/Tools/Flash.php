<?php

namespace App\Tools;

class Flash
{
    /**
     * Create a flash message
     *
     * @param  string      $message
     * @param  string      $level
     * @param  string|null $key
     * @return void
     */
    public function message($message, $level, $key = 'flash')
    {
        session()->flash($key, [
            'body' => $message,
            'level'   => $level
        ]);
    }

    /**
     * Create a success flash message
     *
     * @param  string      $message
     * @return void
     */
    public function success($message)
    {
        $this->message($message, 'success');
    }

    /**
     * Create an information flash message
     *
     * @param  string      $message
     * @return void
     */
    public function info($message)
    {
        $this->message($message, 'info');
    }

    /**
     * Create a warning flash message
     *
     * @param  string      $message
     * @return void
     */
    public function warning($message)
    {
        $this->message($message, 'warning');
    }

    /**
     * Create a danger flash message.
     *
     * @param  string      $message
     * @return void
     */
    public function danger($message)
    {
        $this->message($message, 'danger');
    }

    /**
     * Create an error flash message.
     * Alias to danger
     *
     * @param  string      $message
     * @return void
     */
    public function error($message)
    {
        $this->danger($message);
    }
}
