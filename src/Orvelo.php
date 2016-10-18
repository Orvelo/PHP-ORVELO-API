<?php

/**
 * Class Orvelo
 */
class Orvelo
{
    private $orveloURL = "https://postman.orvelo.com/parser/curl_response";
    private $vid;
    private $channelHash;
    private $formName;
    private $fields;

    /**
     * Orvelo constructor.
     *
     * @since 1.0
     *
     * @param string|null $channelHash
     */
    public function __construct($channelHash = NULL)
    {
        $this->channelHash = $channelHash;
        $this->fields = [];
    }

    /**
     * Adds $_REQUEST data to the fields array
     *
     * @since 1.0
     * @return void
     */
    private function buildFromRequest()
    {
        foreach ($_REQUEST as $key => $value) {
            $this->addField($key, $value);
        }
    }

    /**
     * Sends form data to Orvelo
     *
     * @since 1.0
     *
     * @param bool $fromRequest If true will build the fields array using $_REQUEST. If false must first addField
     *
     * @return bool
     */
    public function send($fromRequest = true)
    {

        if ($fromRequest) {
            $this->buildFromRequest();
        }
        $fields = $this->getFields();
        $this->setChannelHash($this->channelHash);
        if (!empty($fields)) {
            if (!empty($this->formName)) {
                $this->setFormName($this->formName);
            }
            if (isset($_COOKIE['_oal'])) {
                $this->setVid($_COOKIE['_oal']);
            } else {
                $this->setVid("NA");
            }

            $fields_string = "";
            foreach ($this->getFields() as $key => $value) {
                $fields_string .= $key . '=' . $value . '&';
            }
            rtrim($fields_string, '&');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->getOrveloURL());
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_VERBOSE, 0);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            $result = curl_exec($ch);
            curl_close($ch);

            return $result;
        }

        return false;
    }

    /**
     * @param array $fields
     *
     * @since 1.0
     * @return $this
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Returns all the fields
     *
     * @since 1.0
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Adds a field to the fields array
     *
     * @param string $key field identifier
     * @param mixed $value field value
     *
     * @since 1.0
     * @return $this
     */
    public function addField($key, $value)
    {
        $this->fields[$key] = $value;

        return $this;
    }

    /**
     * Removes a field from the fields array
     *
     * @param string $key field identifier of the field you would like to remove
     *
     * @since 1.0
     * @return $this
     */
    public function removeField($key)
    {
        unset($this->fields[$key]);

        return $this;
    }

    /**
     * @since 1.0
     * @return string
     */
    public function getFormName()
    {
        return $this->formName;
    }

    /**
     * @param string $formName
     *
     * @since 1.0
     * @return $this
     */
    public function setFormName($formName)
    {
        $this->formName = $formName;
        $this->addField('OrveloName', $formName);

        return $this;
    }

    /**
     * @since 1.0
     * @return string
     */
    public function getOrveloURL()
    {
        return $this->orveloURL;
    }

    /**
     * @param string $orveloURL
     *
     * @since 1.0
     * @return $this
     */
    public function setOrveloURL($orveloURL)
    {
        $this->orveloURL = $orveloURL;

        return $this;
    }

    /**
     * @since 1.0
     * @return string
     */
    public function getVid()
    {
        return $this->vid;
    }

    /**
     * @param string $vid
     *
     * @since 1.0
     * @return $this
     */
    public function setVid($vid)
    {
        $this->vid = $vid;
        $this->addField('vid', $this->getVid());

        return $this;
    }

    /**
     * @since 1.0
     * @return string
     */
    public function getChannelHash()
    {
        return $this->channelHash;
    }

    /**
     * @since 1.0
     *
     * @param string $channelHash
     *
     * @return $this
     */
    public function setChannelHash($channelHash)
    {
        $this->channelHash = $channelHash;
        $this->addField('channel_hash', $channelHash);

        return $this;
    }

    function __toString()
    {
        $fields = $this->getFields();
        $fieldString = "";
        foreach ($fields as $key => $field) {
            $fieldString .= "<li><strong>{$key}:</strong> {$field}</li>";
        }

        return <<<ORVELOOUT
        <ul>
            <li><strong>URL:</strong> {$this->getOrveloURL()}</li>
            <li><strong>VID:</strong> {$this->getVid()}</li>
            <li><strong>HASH:</strong> {$this->getChannelHash()}</li>
            <li><strong>FORM NAME:</strong> {$this->getFormName()}</li>
            <li><strong>FIELDS:</strong>
                <ul>
                    $fieldString
                </ul>
            </li>
        </ul>
ORVELOOUT;

    }

}
