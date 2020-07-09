<?php

namespace app\traits;

/**
 * Трейт содержит вспомогательные функции для моделей
 *
 * @property string|null $firstErrorMessage
 */
trait ModelTrait
{
    /**
     * Получение текста первой ошибки валидации
     *
     * @return string|null
     */
    public function getFirstErrorMessage(): ?string
    {
        $errors = $this->getFirstErrors();

        return reset($errors);
    }
}