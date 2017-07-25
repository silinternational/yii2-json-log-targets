<?php
namespace Sil\JsonLog\target;

use Sil\EmailService\Client\EmailServiceClient;
use Sil\JsonLog\JsonLogHelper;
use yii\base\InvalidConfigException;
use yii\log\Target;

class EmailServiceTarget extends Target
{

    /**
     * @var string $baseUrl Email Service API base url
     */
    public $baseUrl;

    /**
     * @var string $accessToken Email Service API access token
     */
    public $accessToken;

    /**
     * @var bool $assertValidIp Whether or not to assert IP address resolved for Email Service is considered valid
     */
    public $assertValidIp = true;

    /**
     * @var array $validIpRanges Array of IP ranges considered valid, e.g. ['127.0.0.1','10.0.20.1/16']
     */
    public $validIpRanges = ['127.0.0.1'];

    /**
     * @var array $message Email config, properties: to, cc, bcc, subject
     */
    public $message;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (empty($this->baseUrl)) {
            throw new InvalidConfigException('The "baseUrl" option must be set for EmailServiceTarget::baseUrl.');
        }
        if (empty($this->accessToken)) {
            throw new InvalidConfigException('The "accessToken" option must be set for EmailServiceTarget::accessToken.');
        }
        if ($this->assertValidIp && empty($this->validIpRanges)) {
            throw new InvalidConfigException(
                'The "validIpRanges" option must be set for EmailServiceTarget::validIpRanges when EmailServicetarget::assertValidIp is true.'
            );
        }
        if (empty($this->message['to'])) {
            throw new InvalidConfigException('The "to" option must be set for EmailServiceTarget::message.');
        }
        if (empty($this->message['subject'])) {
            $this->message['subject'] = 'System Alert from Sil\JsonLog\target\EmailServiceTarget';
        }

        $this->message['cc'] = isset($this->message['cc']) ? $this->message['cc'] : '';
        $this->message['bcc'] = isset($this->message['bcc']) ? $this->message['bcc'] : '';
    }


    /**
     * Format a log message as a string of JSON.
     *
     * @param array $logMessageData The array of log data provided by Yii. See
     *     `\yii\log\Logger::messages`.
     * @return string The JSON-encoded log data.
     */
    public function formatMessage($logMessageData)
    {
        return JsonLogHelper::formatAsJson(
            $logMessageData,
            $this->getMessagePrefix($logMessageData)
        );
    }

    /**
     * Send message to Email Service
     */
    public function export()
    {
        try {
            $emailService = new EmailServiceClient(
                $this->baseUrl,
                $this->accessToken,
                [
                    EmailServiceClient::ASSERT_VALID_IP_CONFIG => $this->assertValidIp,
                    EmailServiceClient::TRUSTED_IPS_CONFIG => $this->validIpRanges,
                ]
            );

            foreach ($this->messages as $msg) {
                $body = $this->formatMessage($msg);

                $emailService->email([
                    'to_address' => $this->message['to'],
                    'cc_address' => $this->message['cc'],
                    'bcc_address' => $this->message['bcc'],
                    'subject' => $this->message['subject'],
                    'text_body' => $body,
                    'html_body' => $body,
                ]);
            }
        } catch (\Exception $e) {
            // squash exception? let it be thrown? not sure what is best here. 
        }

    }
}
