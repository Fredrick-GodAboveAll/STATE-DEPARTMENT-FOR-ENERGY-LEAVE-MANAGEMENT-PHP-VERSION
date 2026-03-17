
<?php
namespace App\Utils;

class Validator
{
    private $data;
    private $errors = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function required(...$fields)
    {
        foreach ($fields as $field) {
            if (empty($this->data[$field])) {
                $this->errors[$field][] = ucfirst($field) . ' is required.';
            }
        }
        return $this;
    }

    public function email($field)
    {
        if (!empty($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = 'Please provide a valid email address.';
        }
        return $this;
    }

    public function min($field, $length)
    {
        if (!empty($this->data[$field]) && strlen($this->data[$field]) < $length) {
            $this->errors[$field][] = ucfirst($field) . " must be at least {$length} characters.";
        }
        return $this;
    }

    public function matches($field, $matchField)
    {
        if (!empty($this->data[$field]) && $this->data[$field] !== $this->data[$matchField]) {
            $this->errors[$field][] = ucfirst($field) . ' does not match ' . $matchField . '.';
        }
        return $this;
    }

    public function unique($field, $model, $exceptId = null)
    {
        $user = $model->findBy($field, $this->data[$field]);
        if ($user && ($exceptId === null || $user['id'] != $exceptId)) {
            $this->errors[$field][] = ucfirst($field) . ' already exists.';
        }
        return $this;
    }

    public function fails()
    {
        return !empty($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }
}
