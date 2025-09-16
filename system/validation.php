<?php

require_once 'system/redirect.php';

class Validation
{
    protected array $data;
    protected array $usedData;
    protected array $readableName;
    protected array $errors = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function add(string $key, string $readableName, array $checks): self
    {
        $this->usedData[$key] = $this->data[$key];
        $this->readableName[$key] = $readableName;
        foreach ($checks as $check) {
            switch ($check) {
                case 'required':
                    $this->required($key);
                    break;
                default:
                    throw new Exception("Unknown check `$check`");
            }
        }
        return $this;
    }

    public function finalize(): array
    {
        $errs = [];
        foreach ($this->errors as $key => $errors) {
            $msgs = '';
            foreach ($errors as $i => $error) {
                if ($i > 0)
                    $msgs .= ', ';
                $msgs .= $error;
            }
            $errs[$key] = $this->readableName[$key] . ' ' . $msgs . '.';
        }

        if (count($errs) > 0) {
            redirect()->back()->with('validation_errors', $errs)->send();
        }

        return $this->usedData;
    }

    private function error(string $key, string $msg): void
    {
        if (!isset($this->errors[$key])) {
            $this->errors[$key] = [];
        }
        $this->errors[$key][] = $msg;
    }

    private function required(string $key): void
    {
        if (!isset($this->usedData[$key]) || empty($this->usedData[$key])) {
            $this->error($key, 'tidak boleh kosong');
        }
    }
}
