<?php

class FeedController extends Zend_Controller_Action {

    public function indexAction(){
        $this->_redirect('feed/rss');
    }
    public function atomAction(){
        $atom_feed = $this->feedCreator('atom');
         $this->getResponse()->setHeader('Content-Type', 'application/atom+xml');
        $this->_helper->layout->disableLayout();
       
         
        $this->view->feed = $atom_feed;
        $this->render('index');
    }
    public function rssAction(){
        $rss_feed = $this->feedCreator('rss');
         $this->getResponse()->setHeader('Content-Type', 'application/xml');
         $this->_helper->layout->disableLayout();
        $this->view->feed = $rss_feed;
        $this->render('index');
    }
    private function feedCreator($type) {
        if($type == "atom"){
            $type_text = "atom";
        }
        else if($type == "rss"){
            $type_text = "rss";
        }
        $bookTable = new Application_Model_DbTable_Books();
        $feed = new Zend_Feed_Writer_Feed();
        $feed->setTitle('Ibooker');
        $feed->setLink('http://ibooker.lamminpaa.net');
        $feed->setFeedLink("http://ibooker.lamminpaa.net/feed/$type_text", $type_text);
        $feed->setDateModified(time());

        $feed->setDescription('Your Book Library');

        foreach ($bookTable->fetchAll() as $book) {
            $entry = $feed->createEntry();
            $entry->setTitle("{$this->escapeRss($book->name)} ({$this->escapeRss($book->author)})");
            $entry->setLink("http://ibooker.lamminpaa.net/books/show/$book->id");
            $date = new Zend_Date($book->submit_date);
           
            $entry->setDateCreated($date);
            $entry->setDateModified($date);
            $entry->setId("http://ibooker.lamminpaa.net/books/show/$book->id");
           
            $entry->addAuthor('Kalle Lamminpää', 'lamminpaakm@gmail.com');
            $entry->setDescription("{$this->truncate($this->escapeRss($book->description), 0, 50, '', '...')}");
            $entry->setContent("{$this->escapeRss($book->description)}");
            $feed->addEntry($entry);
        }
        $out = $feed->export($type_text);
        return $out;
    }

    private function escape($input) {
        return htmlspecialchars($input, ENT_QUOTES);
    }

    private function escapeRss($input) {
        $input = preg_replace(array('/</', '/>/', '/"/'), array('&lt;', '&gt;', '&quot;'), $input);
        return $input;
    }

    private function truncate($string, $start = 0, $length = 100, $prefix = '...', $postfix = '...') {
        $truncated = trim($string);
        $start = (int) $start;
        $length = (int) $length;

        // Return original string if max length is 0
        if ($length < 1)
            return $truncated;

        $full_length = iconv_strlen($truncated);

        // Truncate if necessary
        if ($full_length > $length) {
            // Right-clipped
            if ($length + $start > $full_length) {
                $start = $full_length - $length;
                $postfix = '';
            }

            // Left-clipped
            if ($start == 0)
                $prefix = '';

            // Do truncate!
            $truncated = $prefix . trim(substr($truncated, $start, $length)) . $postfix;
        }

        return $truncated;
    }

}
