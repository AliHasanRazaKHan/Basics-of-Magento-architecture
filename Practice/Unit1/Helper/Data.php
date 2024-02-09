<?php

declare(strict_types = 1);

namespace Practice\Unit1\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    public const XML_PATH_RECIPIENT_EMAIL = 'unit1/email/recipient_email';

    public const XML_PATH_SENDER_EMAIL_IDENTITY = 'unit1/email/sender_email_identity';

    public const XML_PATH_EMAIL_TEMPLATE = 'unit1/email/email_template';

    /**
     * Get the recipient_email value.
     *
     * @return string
     */
    public function getRecipientEmail(): string
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_RECIPIENT_EMAIL,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get the sender_email_identity value.
     *
     * @return string
     */
    public function getSenderEmailIdentity(): string
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_SENDER_EMAIL_IDENTITY,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get the email_template value.
     *
     * @return string
     */
    public function getEmailTemplate(): string
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_EMAIL_TEMPLATE,
            ScopeInterface::SCOPE_STORE
        );
    }
}
