<?php

/**
 * Response.
 *
 * @author Katsuhiro Ogawa <fivestar@nequal.jp>
 */
class Response
{
    protected $content;
    protected $status_code = 200;
    protected $status_text = 'OK';
    protected $http_headers = array();

    /**
     * レスポンスを送信
     */
    public function send()
    {
        header('HTTP/1.1 ' . $this->status_code . ' ' . $this->status_text);

        foreach ($this->http_headers as $name => $value) {
            header($name . ': ' . $value);
        }

        echo $this->content;
    }

    /**
     * コンテンツを設定
     *
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * ステータスコードを設定
     *
     * @param integer $status_code
     * @param string $status_code
     */
    public function setStatusCode($status_code, $status_text = '')
    {
        $this->status_code = $status_code;
        $this->status_text = $status_text;
    }

    /**
     * HTTPレスポンスヘッダを設定
     *
     * @param string $name
     * @param mixed $value
     */
    public function setHttpHeader($name, $value)
    {
        $this->http_headers[$name] = $value;
    }
}
