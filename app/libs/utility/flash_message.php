<?php

/**
 * Class FlashMessage
 */
class FlashMessage
{
    /**
     * Set a message to flash.
     *
     * Save a message to be flashed in the upcoming page.
     *
     * @param string $msg_text Textual content to be flashed.
     * @param string $status CSS status class applied to the Bootstrap's alert.
     * @return int How many messages has been set till now.
     */
    public static function set($msg_text, $status="success")
    {
        if (!isset($_SESSION["flashed_messages"])) {
            $_SESSION["flashed_messages"] = array();
        }

        $_SESSION["flashed_messages"][] = array($msg_text, $status);
        return count($_SESSION["flashed_messages"]);
    }

    /**
     * Get array of current flashed messages and empties the buffer.
     *
     * @return array(array(string, string), ...) Flashed messages.
     */
    public static function get()
    {
        $messages = @$_SESSION["flashed_messages"]
        or $messages = array();

        unset($_SESSION["flashed_messages"]);

        return $messages;
    }
}

/**
 * Flash a message.
 *
 * Flash a message that will be shown in the upcoming page.
 *
 * @param string $msg_text Textual content to be flashed.
 * @param string $status CSS status class applied to the Bootstrap's alert.
 * @return int int How many messages has been set till now.
 */
function flash_message($msg_text, $status="success")
{
    return FlashMessage::set($msg_text, $status);
}

/**
 * Get array of current flashed messages and empties the buffer.
 *
 * @return array(array(string, string), ...) Flashed messages.
 */
function flash_message_get()
{
    return FlashMessage::get();
}
