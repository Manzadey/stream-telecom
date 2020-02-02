<?

namespace Manzadey\StreamTelecom\Email;

class Reports extends Job
{
    protected $method = 'reports.';
    /**
     * @var string
     */
    private $sent;

    /**
     * @param string $sent
     *
     * @return $this
     */
    public function sent(string $sent) : self
    {
        $this->sent = $sent;

        return $this;
    }
}
