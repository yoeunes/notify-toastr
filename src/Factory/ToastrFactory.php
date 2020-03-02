<?php

namespace Yoeunes\Notify\Toastr\Factory;

use Yoeunes\Notify\Factory\AbstractNotificationFactory;
use Yoeunes\Notify\Factory\Behaviour\ScriptableInterface;
use Yoeunes\Notify\Factory\Behaviour\StyleableInterface;
use Yoeunes\Notify\Toastr\Notification\Toastr;

final class ToastrFactory extends AbstractNotificationFactory implements StyleableInterface, ScriptableInterface
{
    /**
     * @var array<int, Toastr>
     */
    private $notifications = array();

    /**
     * {@inheritdoc}
     */
    public function notification($type, $message, $title = '', $context = array())
    {
        $notification = new Toastr($type, $message, $title, $context);

        $this->notifications[] = $notification;

        return $notification;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $options = isset($this->config['options']) ? $this->config['options'] : array();

        return sprintf('<script type="application/javascript">%stoastr.options = %s;%s%s</script>',
            PHP_EOL,
            json_encode($options),
            PHP_EOL,
            $this->notificationsToString()
        );
    }

    /**
     * @return string
     */
    private function notificationsToString()
    {
        $html = '';

        foreach ($this->getNotifications() as $notification) {
            $html .= $notification->render().PHP_EOL;
        }

        return $html;
    }

    /**
     * @return array<int, Toastr>
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * {@inheritdoc}
     */
    public function readyToRender()
    {
        return count($this->getNotifications()) > 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getScripts()
    {
        if (!isset($this->config['scripts'])) {
            return array();
        }

        return $this->config['scripts'];
    }

    /**
     * {@inheritdoc}
     */
    public function getStyles()
    {
        if (!isset($this->config['styles'])) {
            return array();
        }

        return $this->config['styles'];
    }
}
