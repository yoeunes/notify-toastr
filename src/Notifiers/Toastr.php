<?php

namespace Yoeunes\Notify\Toastr\Notifiers;

use Yoeunes\Notify\Notifiers\BaseNotification;

class Toastr extends BaseNotification
{
    public function getNotifier()
    {
        return 'toastr';
    }

    public function render()
    {
        $context = $this->getContext();
        $options = isset($context['options']) ? $context['options'] : [];

        return sprintf("toastr.%s('%s', '%s', %s);",
            $this->getType(),
            $this->getMessage(),
            $this->getTitle(),
            json_encode($options)
        );
    }
}
