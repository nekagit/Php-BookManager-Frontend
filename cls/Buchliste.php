<?php

class Buchliste {
    private $list = array();

    /**
     * Constructor that initializes the book list from a text file
     * @param string $filename Name of the text file containing book data
     * @param string $sort Sort parameter for the list
     */
    public function __construct($filename, $sort = "SORT") {
        $this->list = array();
        
        // Read file contents
        $lines = file($filename);
        
        foreach ($lines as $line) {
            $data = explode(";", trim($line));
            
            // Check if it's a regular book (6 entries) or non-fiction book (7 entries)
            if (count($data) == 6) {
                $this->list[] = new Buch($data);
            } elseif (count($data) == 7) {
                $this->list[] = new Sachbuch($data);
            }
        }
        
        // Sort the list according to the provided parameter
        if ($sort == "SORT") {
            usort($this->list, function($a, $b) {
                return strcmp($a->getTitle(), $b->getTitle());
            });
        }
    }
    
    /**
     * Creates an HTML table for the book list view
     * @return string HTML string containing the table
     */
   public function bookListTable() {
    $output = file_get_contents("tpl/bookListTable.htm");
    $tableContent = "";
    
    foreach ($this->list as $book) {
        $tableContent .= $book->tableRow();
    }
    
    return str_replace("{TABLE_BODY}", $tableContent, $output);
}
    
    /**
     * Creates a grid of book tiles for the tile view
     * @return string HTML string containing the tile grid
     */
    public function bookListTiles() {
        $output = "";
        foreach ($this->list as $book) {
            $output .= $book->tile();
        }
        return $output;
    }
    
    /**
     * Creates the complete HTML page
     * @param string $view View type ('list', 'tiles', or book index)
     * @param mixed $bookIndex Optional book index for single book view
     * @return string Complete HTML page
     */
    public function htmlPage($view, $bookIndex = null) {
        $template = file_get_contents("tpl/mainPage.htm");
        
        // Replace form action with self-reference
        $template = str_replace("FORM_ACTION", $_SERVER['PHP_SELF'], $template);
        
        // Set data options (list of .txt files)
        $txtFiles = glob("*.txt");
        $dataOptions = "";
        foreach ($txtFiles as $file) {
            $dataOptions .= "<option value=\"$file\">$file</option>\n";
        }
        $template = str_replace("DATA_OPTIONS", $dataOptions, $template);
        
        // Handle different views
        if ($view == "list") {
            $template = str_replace("BOOK_TABLE", $this->bookListTable(), $template);
            $template = str_replace("BOOK_VIEW", "", $template);
        } elseif ($view == "tiles") {
            $template = str_replace("BOOK_TABLE", "", $template);
            $template = str_replace("BOOK_VIEW", $this->bookListTiles(), $template);
        } elseif (is_numeric($bookIndex) && isset($this->list[$bookIndex])) {
            $template = str_replace("BOOK_TABLE", "", $template);
            $template = str_replace("BOOK_VIEW", $this->list[$bookIndex]->bookView(), $template);
        } else {
            $template = str_replace("BOOK_TABLE", "", $template);
            $template = str_replace("BOOK_VIEW", "", $template);
        }
        
        return $template;
    }
}
?>