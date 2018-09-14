<?php

/**
 * Configuration settings
 *
 * PHP version 7.0
 */
class Config
{

    /**
     * SMTP host
     *
     * @var string
     */
    //const SMTP_HOST = 'smtp.gmail.com';
    const SMTP_HOST = 'mail.attorneywes.com';  // no SSL, unsecure setting

    // use for mail from contact form to email on same server (info@attorneywes.com)
    const SMTP_SEND_MAIL_INTERNALLY_HOST = 'localhost';

    /**
     * SMTP port
     *
     * @var int
     */
    const SMTP_PORT = 587; // for gmail & non-SSL (IMH)

    /**
     * SMTP user
     *
     * @var string
     */
    const SMTP_USER = 'info@attorneywes.com';

    /**
     * SMTP password
     *
     * @var string
     */
    //const SMTP_PASSWORD = 'Hopehope1!';
    const SMTP_PASSWORD = 'my$onJ@ck1!';

}
