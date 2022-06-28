<?php

declare(strict_types=1);

namespace app\core\form;

use app\core\Model;

class Field
{
    public function __construct(
        public string $type,
        public Model $model,
        public string $attribute
    ) {}

    public function __toString(): string
    {
        return sprintf(
            '<label class="form-label">%s</label>
            <input type="%s" class="form-control %s" name="%s" value="%s">
            <div class="invalid-feedback">%s</div>',
            $this->model->labels()[$this->attribute],
            $this->type,
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->getError($this->attribute)
        );
    }
}
