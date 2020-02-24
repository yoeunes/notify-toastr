<?php

namespace Yoeunes\Notify\Toastr\Factories;

use Yoeunes\Notify\Factories\BaseFactory;
use Yoeunes\Notify\Factories\Behaviours\MultipleNotificationAwareTrait;
use Yoeunes\Notify\Factories\Behaviours\ScriptableInterface;
use Yoeunes\Notify\Factories\Behaviours\ScriptsAwareTrait;
use Yoeunes\Notify\Factories\Behaviours\StyleableInterface;
use Yoeunes\Notify\Factories\Behaviours\StylesAwareTrait;
use Yoeunes\Notify\Toastr\Notifiers\Toastr;

class ToastrFactory extends BaseFactory implements StyleableInterface, ScriptableInterface
{
    use MultipleNotificationAwareTrait;
    use StylesAwareTrait;
    use ScriptsAwareTrait;

    private $notifications = [];

    public function notification($type, $message, $title = '', $context = [])
    {
        $notification = new Toastr($type, $message, $title, $context);

        $this->notifications[] = $notification;

        return $notification;
    }

    public function render()
    {
        $options = isset($this->config['options']) ? $this->config['options'] : [];

        return sprintf('<script type="application/javascript">%stoastr.options = %s;%s%s</script>',
            PHP_EOL,
            json_encode($options),
            PHP_EOL,
            $this->notificationsToString()
        );
    }

    public function getNotifications()
    {
        return $this->notifications;
    }
}
