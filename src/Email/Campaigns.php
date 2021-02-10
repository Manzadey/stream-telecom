<?php

namespace Manzadey\StreamTelecom\Email;

class Campaigns extends Job
{
    protected $method = 'campaigns.';
    /**
     * @var string
     */
    private $status;
    /**
     * @var string
     */
    private $subject;
    /**
     * @var string
     */
    private $html;
    /**
     * @var string
     */
    private $from_name;
    /**
     * @var string
     */
    private $from_email;
    /**
     * @var string
     */
    private $personalizeToEmail;
    /**
     * @var string
     */
    private $to_email;
    /**
     * @var string
     */
    private $track_opens;
    /**
     * @var string
     */
    private $track_clicks;
    /**
     * @var string
     */
    private $no_images_add;
    /**
     * @var string
     */
    private $plain_clicks;
    /**
     * @var string
     */
    private $analytics_tag;
    /**
     * @var string
     */
    private $analytics;
    /**
     * @var array
     */
    private $esegment;
    /**
     * @var string
     */
    private $plain_text;
    /**
     * @var int
     */
    private $delay_1;
    /**
     * @var string
     */
    private $delay_2;
    /**
     * @var string
     */
    private $campaigns;
    /**
     * @var int
     */
    private $auto;
    /**
     * @var string
     */
    private $action;
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $template;

    /**
     * @param string $status
     *
     * @return $this
     */
    public function status(string $status) : self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param string $subject
     *
     * @return $this
     */
    public function subject(string $subject) : self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @param string $html
     *
     * @return $this
     */
    public function html(string $html) : self
    {
        $this->html = $html;

        return $this;
    }

    /**
     * @param string $from_name
     *
     * @return $this
     */
    public function fromName(string $from_name) : self
    {
        $this->from_name = $from_name;

        return $this;
    }

    /**
     * @param string $from_email
     *
     * @return $this
     */
    public function fromEmail(string $from_email) : self
    {
        $this->from_email = $from_email;

        return $this;
    }

    /**
     * @param string $personalizeToEmail
     *
     * @return $this
     */
    public function personalizeToEmail(string $personalizeToEmail = 'off') : self
    {
        $this->personalizeToEmail = $personalizeToEmail;

        return $this;
    }

    /**
     * @param string $to_email
     *
     * @return $this
     */
    public function toEmail(string $to_email) : self
    {
        $this->to_email = $to_email;

        return $this;
    }

    /**
     * @param string $track_opens
     *
     * @return $this
     */
    public function noTrackOpens() : self
    {
        $this->track_opens = 'N';

        return $this;
    }

    /**
     * @param string $track_clicks
     *
     * @return $this
     */
    public function noTrackClicks() : self
    {
        $this->track_clicks = 'N';

        return $this;
    }

    /**
     * @param string $plain_clicks
     *
     * @return $this
     */
    public function plainClicks() : self
    {
        $this->plain_clicks = 'Y';

        return $this;
    }

    /**
     * @param string $no_images_add
     *
     * @return $this
     */
    public function noImagesAdd() : self
    {
        $this->no_images_add = 1;

        return $this;
    }

    /**
     * @param string $analytics
     *
     * @return $this
     */
    public function analytics() : self
    {
        $this->analytics = 'google';

        return $this;
    }

    /**
     * @param string $analytics_tag
     *
     * @return $this
     */
    public function analyticsTag(string $analytics_tag) : self
    {
        $this->analytics_tag = $analytics_tag;

        return $this;
    }

    /**
     * @param string $plain_text
     *
     * @return $this
     */
    public function plainText(string $plain_text) :self
    {
        $this->plain_text = $plain_text;

        return $this;
    }

    /**
     * @param array $esegment
     *
     * @return $this
     */
    public function esegment(array $esegment) : self
    {
        $this->esegment = $esegment;

        return $this;
    }

    /**
     * @param int    $delay
     * @param string $type_delay
     *
     * @return $this
     */
    public function delay(int $delay, string $type_delay = 'hour') : self
    {
        $this->delay_1 = $delay;
        $this->delay_2 = $type_delay;

        return $this;
    }

    /**
     * @param string $campaigns
     *
     * @return $this
     */
    public function campaigns(string $campaigns) : self
    {
        $this->campaigns = $campaigns;
    }

    /**
     * @param int $auto
     *
     * @return $this
     */
    public function auto(int $auto = 1) : self
    {
        $this->auto = $auto;

        return $this;
    }

    /**
     * @param string $action
     *
     * @return $this
     */
    public function action(string $action) : self
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function id(int $id) : self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $template
     *
     * @return $this
     */
    public function template(string $template) : self
    {
        $this->template = $template;

        return $this;
    }
}
