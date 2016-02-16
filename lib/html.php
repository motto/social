<?php
class BaseHtml extends Universal
{
    public $head;
    public $body;
    public $bodyhead;
    public $footer;

    /**
     * Ha nincs a paraméterben
     * a $part-ban megadott rész (body,head stb)
     * akkor  az aktuális tmpl '/part' mappájából
     * olvassa ki  avisszatérő html-t
     * @param $part
     * @return string
     */
    public function part_general($part)
    {
        if (empty($this->$part)) {
            $html = file_get_contents('tmpl/' . GOB::$tmpl . '/part/' . $part . '.html', true);
        } else {
            $html = $this->$part;
        }
        return $html;
    }

    /**
     *ha nem akarjuk feltolteni
     * ne tegyünk a html-be <!--|head|--> tagot
     * vagy mielőtt paraméterbe átadjuk cseréljük le
     */
    public function head()
    {
        $html = $this->part_general('head');
        $html = str_replace('<!--|head|-->', MOD::head(GOB::$head), $html);
        $html = str_replace('<!--|title|-->', GOB::$title, $html);
        return $html;
    }

    public function bodyhead()
    {
        $html = $this->part_general('bodyhead');
        $html = str_replace('<!--|bodyhead|-->', MOD::head(GOB::$bodyhead), $html);
        return $html;
    }

    public function result()
    {//echo $this->footer;
        $html = $this->head();
        $html = $html . $this->part_general('body');
        $html = str_replace('<!--|bodyhead|-->', $this->bodyhead(), $html);
        $html = str_replace('<!--|footer|-->', $this->part_general('footer'), $html);
        return $html;
    }

}