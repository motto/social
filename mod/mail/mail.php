<?php
class Mail
{
    public function result()
    {
       $html=file_get_contents('mod/mail/contact.html', true);
        return $html;
    }
}