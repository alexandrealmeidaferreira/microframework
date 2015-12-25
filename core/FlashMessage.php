<?php
/**
 * FlashMessage is an helper to add alerts between pages, it can render in bootstrap format, or can be customized
 *
 * User: alexandre
 * Date: 24/12/15
 * Time: 20:13
 */

namespace core;


class FlashMessage
{

    private $namespace = 'FlashMessage';
    private $messages = array();

    const DANGER = 'danger';
    const WARNING = 'warning';
    const ALERT = 'alert';
    const SUCCESS = 'success';

    const DANGER_TITLE = 'Danger!';
    const WARNING_TITLE = 'Warning!';
    const ALERT_TITLE = 'Alert!';
    const SUCCESS_TITLE = 'Success!';

    const DANGER_ICON = 'glyphicon glyphicon-exclamation-sign';
    const WARNING_ICON = 'glyphicon glyphicon-warning-sign';
    const ALERT_ICON = 'glyphicon glyphicon-alert';
    const SUCCESS_ICON = 'glyphicon glyphicon-ok';


    /**
     * Construct the flash messager with namespace
     *
     * @param string $namespace
     */
    public function __construct($namespace = 'FlashMessage')
    {
        $this->namespame = $namespace;
        if (isset($_SESSION[$this->namespace])) {
            $this->messages = $_SESSION[$this->namespace];
        } else {
            $_SESSION[$namespace] = array();
        }
    }

    /**
     * Returns all message in html format in bootstrap 3 alerts
     *
     * @return string
     */
    public function render()
    {
        $html = array();
        if ($this->hasMessages()) {
            $allMessages = $this->getMessages();
            foreach ($allMessages as $type => $messages) {
                foreach ($messages as $message) {
                    $timeout = ($message['timeout'] > 0) ? "data-dismiss-timeout=\"{$message['timeout']}\"" : '';
                    $html[] = "<div class=\"alert alert-dismissable alert-{$type} fade in\" {$timeout} >";
                    $html[] = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                    $html[] = !empty($message['icon']) ? "<span class=\"{$message['icon']}\" aria-hidden=\"true\"></span>" : '';
                    $html[] = !empty($message['title']) ? "<strong>{$message['title']}</strong>" : '';
                    $html[] = $message['message'];
                    $html[] = '</div>';
                }
            }
        }
        return implode("\n", $html);
    }

    /**
     * Add a message
     *
     * @param $type
     * @param string $message
     * @param string $title
     * @param int $timeout
     * @return $this
     */
    public function addMessage($type, $message = '', $title = null, $timeout = 0, $icon = null)
    {
        switch ($type) {
            default:
            case self::SUCCESS:
                $title = is_null($title) ? self::SUCCESS_TITLE : $title;
                $icon = is_null($icon) ? self::SUCCESS_ICON : $icon;
                if (!isset($this->messages[self::SUCCESS])) {
                    $this->messages[self::SUCCESS] = array();
                    $this->messages[self::SUCCESS][] = array(
                        'title' => $title,
                        'message' => $message,
                        'icon' => $icon,
                        'timeout' => $timeout
                    );
                }

                break;
            case self::ALERT:
                $title = is_null($title) ? self::ALERT_TITLE : $title;
                $icon = is_null($icon) ? self::SUCCESS_ICON : $icon;
                if (!isset($this->messages[self::ALERT])) {
                    $this->messages[self::ALERT] = array();
                    $this->messages[self::ALERT][] = array(
                        'title' => $title,
                        'message' => $message,
                        'icon' => $icon,
                        'timeout' => $timeout
                    );
                }

                break;
            case self::WARNING:
                $title = is_null($title) ? self::WARNING_TITLE : $title;
                $icon = is_null($icon) ? self::SUCCESS_ICON : $icon;
                if (!isset($this->messages[self::WARNING])) {
                    $this->messages[self::WARNING] = array();
                    $this->messages[self::WARNING][] = array(
                        'title' => $title,
                        'message' => $message,
                        'icon' => $icon,
                        'timeout' => $timeout
                    );
                }
                break;
            case self::DANGER:
                $title = is_null($title) ? self::DANGER_TITLE : $title;
                $icon = is_null($icon) ? self::SUCCESS_ICON : $icon;
                if (!isset($this->messages[self::DANGER])) {
                    $this->messages[self::DANGER] = array();
                    $this->messages[self::DANGER][] = array(
                        'title' => $title,
                        'message' => $message,
                        'icon' => $icon,
                        'timeout' => $timeout
                    );
                }
                break;
        }
        return $this;
    }

    /**
     * Add a danger message
     *
     * @param string $message
     * @param string $title
     * @param int $timeout
     * @param string $icon
     * @return FlashMessage
     */
    public function addDanger($message = '', $title = self::DANGER_TITLE, $timeout = 0, $icon = self::DANGER_ICON)
    {
        return $this->addMessage(self::DANGER, $message, $title, $timeout, $icon);
    }

    /**
     * Add a warning message
     *
     * @param string $message
     * @param string $title
     * @param int $timeout
     * @param string $icon
     * @return FlashMessage
     */
    public function addWarning($message = '', $title = self::WARNING_TITLE, $timeout = 0, $icon = self::WARNING_ICON)
    {
        return $this->addMessage(self::WARNING, $message, $title, $timeout, $icon);
    }

    /**
     * Add a alert message
     *
     * @param string $message
     * @param string $title
     * @param int $timeout
     * @param string $icon
     * @return FlashMessage
     */
    public function addAlert($message = '', $title = self::ALERT_TITLE, $timeout = 0, $icon = self::ALERT_TITLE)
    {
        return $this->addMessage(self::ALERT, $message, $title, $timeout, $icon);
    }

    /**
     * Add a success message
     *
     * @param string $message
     * @param string $title
     * @param int $timeout
     * @param string $icon
     * @return FlashMessage
     */
    public function addSuccess($message = '', $title = self::SUCCESS_TITLE, $timeout = 0, $icon = self::SUCCESS_ICON)
    {
        return $this->addMessage(self::SUCCESS, $message, $title, $timeout, $icon);
    }

    /**
     * Check if has danger message
     *
     * @return bool
     */
    public function hasDanger()
    {
        return (isset($this->messages[self::DANGER]) && !empty($this->messages[self::DANGER]));
    }

    /**
     * Check if has warning message
     *
     * @return bool
     */
    public function hasWarning()
    {
        return (isset($this->messages[self::WARNING]) && !empty($this->messages[self::WARNING]));
    }

    /**
     * Check if has alert message
     *
     * @return bool
     */
    public function hasAlert()
    {
        return (isset($this->messages[self::ALERT]) && !empty($this->messages[self::ALERT]));
    }

    /**
     * Check if has success message
     *
     * @return bool
     */
    public function hasSuccess()
    {
        return (isset($this->messages[self::SUCCESS]) && !empty($this->messages[self::SUCCESS]));
    }

    /**
     * Check if has any message
     *
     * @return bool
     */
    public function hasMessages()
    {
        return ($this->hasSuccess() || $this->hasAlert() || $this->hasDanger() || $this->hasWarning());
    }

    /**
     * Clear danger message
     *
     * @return $this
     */
    public function clearDangerMessages()
    {
        unset($this->messages[self::DANGER]);
        return $this;
    }

    /**
     * Clear warning message
     *
     * @return $this
     */
    public function clearWarningMessages()
    {
        unset($this->messages[self::WARNING]);
        return $this;
    }

    /**
     * Clear alert message
     *
     * @return $this
     */
    public function clearAlertMessages()
    {
        unset($this->messages[self::ALERT]);
        return $this;
    }

    /**
     * Clear success message
     *
     * @return $this
     */
    public function clearSuccessMessages()
    {
        unset($this->messages[self::SUCCESS]);
        return $this;
    }

    /**
     * Clear all messages
     *
     * @return $this
     */
    public function clearMessages()
    {
        $this->clearSuccessMessages();
        $this->clearAlertMessages();
        $this->clearWarningMessages();
        $this->clearDangerMessages();

        return $this;
    }

    /**
     * Return danger messages and clear
     *
     * @return mixed
     */
    public function getDangerMessages()
    {
        $messages = $this->messages[self::DANGER];
        $this->clearDangerMessages();
        return $messages;
    }

    /**
     * Return warning messages and clear
     *
     * @return mixed
     */
    public function getWarningMessages()
    {
        $messages = $this->messages[self::WARNING];
        $this->clearWarningMessages();
        return $messages;
    }

    /**
     * Return alert messages and clear
     *
     * @return mixed
     */
    public function getAlertMessages()
    {
        $messages = $this->messages[self::ALERT];
        $this->clearAlertMessages();
        return $messages;
    }

    /**
     * Return success messages and clear
     *
     * @return mixed
     */
    public function getSuccessMessages()
    {
        $messages = $this->messages[self::SUCCESS];
        $this->clearSuccessMessages();
        return $messages;
    }

    /**
     * Return all messages and clear
     *
     * @return array
     */
    public function getMessages()
    {
        $messages = $this->messages;

        $this->clearSuccessMessages();
        $this->clearAlertMessages();
        $this->clearWarningMessages();
        $this->clearDangerMessages();

        return $messages;
    }

    /**
     * Set back to session namespace
     */
    public function __destruct()
    {
        $_SESSION[$this->namespace] = $this->messages;
    }
}