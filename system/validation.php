<?php

require_once 'system/redirect.php';

class Validation
{
    protected array $usedData;
    protected array $readableName;
    protected array $errors = [];

    public function __construct(
        protected array $data,
        protected bool $jsonRedirect = false,
    ) {}

    public function add(string $key, array $checks, null|string $readableName = null): self
    {
        $this->usedData[$key] = $this->data[$key] ?? null;
        $this->readableName[$key] = '"' . ($readableName ?: $key) . '"';
        foreach ($checks as $check) {
            $args = explode(':', $check, 2);
            switch ($args[0]) {
                case 'required':
                    $this->required($key);
                    break;
                case 'min':
                    $this->min($key, intval($args[1]));
                    break;
                case 'max':
                    $this->max($key, intval($args[1]));
                    break;
                case 'same':
                    $this->same($key, $args[1]);
                    break;
                case 'integer':
                    $this->integer($key);
                    break;
                case 'checkbox':
                    $this->checkbox($key);
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
                if ($i > 0 && $i === (count($errors) - 1))
                    $msgs .= 'dan ';
                $msgs .= $error;
            }
            $errs[$key] = $this->readableName[$key] . ' ' . $msgs . '.';
        }

        if (count($errs) > 0) {
            die(print_r($errs));
            $r = redirect()->current()->with('validation_errors', $errs);
            if ($this->jsonRedirect) {
                JsonResponse::redirect($r);
            } else {
                $r->send();
            }
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

    // NOTE: Inclusive
    private function min(string $key, int $n): void
    {
        if (strlen($this->usedData[$key] ?? '') < $n) {
            $this->error($key, "minimal sebanyak $n karakter");
        }
    }

    // NOTE: Inclusive
    private function max(string $key, int $n): void
    {
        if (strlen($this->usedData[$key] ?? '') > $n) {
            $this->error($key, "maksimal sebanyak $n karakter");
        }
    }

    private function same(string $key, string $other): void
    {
        if (isset($this->usedData[$key]) && isset($this->usedData[$other])) {
            if ($this->usedData[$key] !== $this->usedData[$other]) {
                $this->error($key, 'harus sama dengan ' . $this->readableName[$other]);
            }
        }
    }

    private function integer(string $key): void
    {
        if (!ctype_digit($this->usedData[$key] ?? null)) {
            $this->error($key, 'harus berupa angka');
        } else {
            $this->usedData[$key] = intval($this->usedData[$key]);
        }
    }

    private function checkbox(string $key): void
    {
        $this->usedData[$key] = $this->usedData[$key] !== null;
    }
}
