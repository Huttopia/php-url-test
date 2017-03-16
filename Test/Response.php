<?php

namespace steevanb\PhpUrlTest\Test;

class Response
{
    /** @var ?int */
    protected $code;

    /** @var ?int */
    protected $numConnects;

    /** @var ?int */
    protected $size;

    /** @var ?string */
    protected $contentType;

    /** @var ?int */
    protected $connectTime;

    /** @var ?int */
    protected $preTranferTtime;

    /** @var ?int */
    protected $startTranferTime;

    /** @var ?int */
    protected $time;

    /** @var ?int */
    protected $redirectCount;

    /** @var ?int */
    protected $redirectTime;

    /** @var ?int */
    protected $url;

    /** @var string[] */
    protected $headers = [];

    /** @var ?int */
    protected $headerSize;

    /** @var ?string */
    protected $body;

    /** @var ?int */
    protected $bodySize;

    /** @var ?int */
    protected $errorCode;

    /** @var ?string */
    protected $errorMessage;

    public function __construct(
        $curl = null,
        ?string $response = null,
        ?int $errorCode = null,
        ?string $errorMessage = null
    ) {
        if (is_resource($curl)) {
            $this->code = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
            $this->numConnects = curl_getinfo($curl, CURLINFO_NUM_CONNECTS);
            $this->size = strlen($response);
            $this->contentType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
            $this->connectTime = curl_getinfo($curl, CURLINFO_CONNECT_TIME);
            $this->preTranferTtime = curl_getinfo($curl, CURLINFO_PRETRANSFER_TIME);
            $this->startTranferTime = curl_getinfo($curl, CURLINFO_STARTTRANSFER_TIME);
            $this->time = curl_getinfo($curl, CURLINFO_TOTAL_TIME);
            $this->url = curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);
            $this->redirectCount = curl_getinfo($curl, CURLINFO_REDIRECT_COUNT);
            $this->redirectTime = curl_getinfo($curl, CURLINFO_REDIRECT_TIME);
            $this->headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
            if ($this->headerSize > 0) {
                $this->defineHeaders(substr($response, 0, $this->headerSize));
            }
            $this->body = substr($response, $this->headerSize);
            $this->bodySize = strlen($this->body);
        }

        $this->errorCode = $errorCode;
        $this->errorMessage = $errorMessage;
    }

    protected function defineHeaders(string $header): self
    {
        foreach (explode("\r\n", substr($header, stripos($header, "\r\n"))) as $line) {
            [$name, $value] = explode(": ", $line);
            if ($name == null) {
                continue;
            }
            $this->headers[$name] = $value;
        }

        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function getNumConnects(): ?int
    {
        return $this->numConnects;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function getContentType(): ?string
    {
        return $this->contentType;
    }

    public function getConnectTime(): ?int
    {
        return $this->connectTime;
    }

    public function getPreTranferTtime(): ?int
    {
        return $this->preTranferTtime;
    }

    public function getStartTranferTime(): ?int
    {
        return $this->startTranferTime;
    }

    public function getTime(): ?int
    {
        return $this->time;
    }

    public function getRedirectCount(): ?int
    {
        return $this->redirectCount;
    }

    public function getRedirectTime(): ?int
    {
        return $this->redirectTime;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getHeaderSize(): ?int
    {
        return $this->headerSize;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function getBodySize(): ?int
    {
        return $this->bodySize;
    }

    public function getErrorCode(): ?int
    {
        return $this->errorCode;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }
}
