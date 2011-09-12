<?php
class RssController extends Zend_Controller_Action {

    public function indexAction() {
        $bookTable = new Application_Model_DbTable_Books();
        $feed = new Zend_Feed_Writer_Feed();
    $feed->setTitle('Ibooker');
    $feed->setLink('http://ibooker.lamminpaa.net');
    $feed->setFeedLink('http://ibooker.lamminpaa.net/rss', 'rss');
    
    $feed->setDescription('Your Book Library');
 
    $feed->setDateModified(time());
    $feed->setEncoding('iso-8859-1');

    foreach($bookTable->fetchAll() as $book){
        $entry = $feed->createEntry();
        $entry->setTitle("{$this->escapeRss($book->name)} ({$this->escapeRss($book->author)})");
        $entry->setLink("http://ibooker.lamminpaa.net/books/show/$book->id");
        
        $entry->setDateModified(time());
        $entry->setDateCreated(time());
        $entry->setDescription("{$this->truncate($this->escapeRss($book->description), 0, 50, '', '...')}");
        $entry->setContent("{$this->escapeRss($book->description)}");
        $feed->addEntry($entry);
        }
    $out = $feed->export('rss');
    $this->getResponse()->setHeader('Content-Type', 'application/xml');
    
    $this->_helper->layout->disableLayout();
    $this->view->rss = $out;
    }
        private function escape($input){
        return htmlspecialchars($input, ENT_QUOTES);
    }
    private function escapeRss($input){
        $input = preg_replace(array('/</', '/>/', '/"/'), array('&lt;', '&gt;', '&quot;'), $input);
        return $input;
    }
    
    private function truncate($string, $start = 0, $length = 100, $prefix = '...', $postfix = '...')
    {
        $truncated = trim($string);
        $start = (int) $start;
        $length = (int) $length;

        // Return original string if max length is 0
        if ($length < 1) return $truncated;

        $full_length = iconv_strlen($truncated);

        // Truncate if necessary
        if ($full_length > $length) {
            // Right-clipped
            if ($length + $start > $full_length) {
                $start = $full_length - $length;
                $postfix = '';
            }

            // Left-clipped
            if ($start == 0) $prefix = '';

            // Do truncate!
            $truncated = $prefix . trim(substr($truncated, $start, $length)) . $postfix;
        }

        return $truncated;
    }
}
