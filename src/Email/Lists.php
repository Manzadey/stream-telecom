<?php

namespace Manzadey\StreamTelecom\Email;

use Manzadey\StreamTelecom\Constants;

class Lists extends Job
{
    protected $method = 'lists.';
    /**
     * @var string
     */
    protected $abuse_email;
    /**
     * @var string
     */
    protected $abuse_name;
    /**
     * @var string
     */
    protected $company;
    /**
     * @var string
     */
    protected $address;
    /**
     * @var string
     */
    protected $city;
    /**
     * @var string
     */
    protected $zip;
    /**
     * @var string
     */
    protected $country = 'Российская Федерация';
    /**
     * @var string
     */
    protected $url;
    /**
     * @var string
     */
    protected $phone;
    /**
     * @var string
     */
    protected $state;
    /**
     * @var string
     */
    protected $email;
    /**
     * @var string
     */
    protected $file;
    /**
     * @var false|string
     */
    protected $choices;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var string
     */
    protected $req;
    /**
     * @var string
     */
    protected $var;
    /**
     * @var int
     */
    protected $merge_id;
    /**
     * @var bool
     */
    protected $update;
    /**
     * @var string
     */
    protected $gender = 'n';
    /**
     * @var string
     */
    protected $no_check;
    /**
     * @var string
     */
    protected $batch;
    /**
     * @var string
     */
    protected $reason;

    /**
     * @param string $email
     *
     * @return $this
     */
    public function abuseEmail(string $email) : self
    {
        filter_var($email, FILTER_VALIDATE_EMAIL) !== false ? $this->abuse_email = $email : null;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function abuseName(string $name) : self
    {
        $this->abuse_name = $name;

        return $this;
    }

    /**
     * @param string $company
     *
     * @return $this
     */
    public function company(string $company) : self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @param string $address
     *
     * @return $this
     */
    public function address(string $address) : self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @param string $city
     *
     * @return $this
     */
    public function city(string $city) : self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @param int $zip
     *
     * @return $this
     */
    public function zip(int $zip) : self
    {

        $this->zip = substr($zip, 0, 6);

        return $this;
    }

    /**
     * @param string $country
     *
     * @return $this
     */
    public function country(string $country) : self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function url(string $url) : self
    {
        filter_var($url, FILTER_VALIDATE_URL) !== FALSE ? $this->url = $url : null;

        return $this;
    }

    /**
     * @param string $phone
     *
     * @return $this
     */
    public function phone(string $phone) : self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @param string $state
     *
     * @return $this
     */
    public function state(string $state) : self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @param $email
     *
     * @return $this
     */
    public function email($email) : self
    {
        filter_var($email, FILTER_VALIDATE_EMAIL) !== false ? $this->email = $email : null;

        return $this;
    }

    /**
     * @param string $file
     *
     * @return $this
     */
    public function file(string $file) : self
    {
        filter_var($file, FILTER_VALIDATE_URL) !== false ? $this->file = $file : null;

        return $this;
    }

    /**
     * @param array $choices
     *
     * @return $this
     */
    public function choices(array $choices) : self
    {
        $this->choices = json_encode($choices);

        return $this;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function title(string $title) : self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string $req
     *
     * @return $this
     */
    public function req(string $req) : self
    {
        $this->req = $req;

        return $this;
    }

    /**
     * @param string $var
     *
     * @return $this
     */
    public function var(string $var) : self
    {
        $this->var = $var;

        return $this;
    }

    /**
     * @param int $merge_id
     *
     * @return $this
     */
    public function mergeId(int $merge_id) : self
    {
        $this->merge_id = $merge_id;

        return $this;
    }

    /**
     * @param int    $id
     * @param string $data
     *
     * @return $this
     */
    public function merge(int $id, string $data) : self
    {
        $id > 10 ? $id = Constants::EMAIL_MERGE_MAX : null;

        $merge = 'merge_' . $id;

        $this->$merge = $data;

        return $this;
    }

    /**
     * @param bool $update
     *
     * @return $this
     */
    public function update() : self
    {
        $this->update = true;

        return $this;
    }

    /**
     * @param string $gender
     *
     * @return $this
     */
    public function gender(string $gender) : self
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @param string $no_check
     *
     * @return $this
     */
    public function noCheck() : self
    {
        $this->no_check = true;

        return $this;
    }

    /**
     * @param string $batch
     *
     * @return $this
     */
    public function batch(string $batch) : self
    {
        $this->batch = $batch;

        return $this;
    }

    /**
     * @param string $reason
     *
     * @return $this
     */
    public function reason(string $reason) : self
    {
        $this->reason = $reason;

        return $this;
    }
}
