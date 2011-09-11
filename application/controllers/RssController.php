<?php
class RssController extends Zend_Controller_Action {

    public function indexAction() {
        $bookTable = new Application_Model_DbTable_Books();
        $feed = new Zend_Feed_Writer_Feed();
    $feed->setTitle('Ibooker');
    $feed->setLink('http://ibooker.lamminpaa.net');
    
    $feed->setDescription('Your Book Library');
    $feed->addAuthor(array(
        'name'  => 'Kalle Lamminpää',
        'email' => 'lamminpaakm@gmail.com',
        'uri'   => 'http://www.lamminpaa.net',
    ));
    $feed->setDateModified(time());

    foreach($bookTable->fetchAll() as $book){
        $entry = $feed->createEntry();
        $entry->setTitle("{$this->escape($book->name)} ({$this->escape($book->author)})");
        $entry->setLink("http://ibooker.lamminpaa.net/books/show/$book->id");
        $entry->addAuthor(array(
            'name'  => 'Kalle Lamminpää',
            'email' => 'lamminpaakm@gmail.com',
            'uri'   => 'http://www.lamminpaa.net',
        ));
        $entry->setDateModified(time());
        $entry->setDateCreated(time());
        $entry->setDescription("{$this->truncate($this->escape($book->description), 0, 50, '', '...')}");
        $entry->setContent("{$this->escape($book->description)}");
        $feed->addEntry($entry);
        }
    $out = $feed->export('rss');
    $this->getResponse()->setHeader('Content-Type', 'text/xml');
    $this->view->rss = $out;
    }
       private function escape($input){
           $input = escapeshellarg($input);
        return htmlspecialchars($input, ENT_QUOTES);
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
