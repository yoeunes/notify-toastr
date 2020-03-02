<?php

namespace Yoeunes\Notify\Toastr\Notification;

use Yoeunes\Notify\Notification\AbstractNotification;

final class Toastr extends AbstractNotification
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $context = $this->getContext();
        $options = isset($context['options']) ? $context['options'] : array();

        return sprintf("toastr.%s('%s', '%s', %s);",
            $this->getType(),
            $this->getMessage(),
            $this->getTitle(),
            json_encode($options)
        );
    }
}
