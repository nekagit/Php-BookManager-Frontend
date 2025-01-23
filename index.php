<?php
require_once 'cls/Buch.php';
require_once 'cls/Buchliste.php';
require_once 'cls/Sachbuch.php';

class BuchVerwaltung {
    private $mainTemplate;
    private $buchListe;
    private $selectedFile;
    private $view;
    private $sorting;
    
    public function __construct() {
        $this->mainTemplate = file_get_contents('tpl/mainPage.htm');
        $this->handleRequest();
        
        $this->buchListe = new Buchliste(
            'data/' . $this->selectedFile,
            $this->sorting === 'auf' ? 'SORT' : ''
        );
    }
    
   private function handleRequest() {
        $this->selectedFile = $_POST['fileName'] ?? 'alle.txt';
        $this->view = $_POST['view'] ?? 'liste';
        $this->sorting = $_POST['sorting'] ?? 'orig';
    }
    
    private function getDataOptions() {
        $files = glob('data/*.txt');
        $options = '';
        foreach ($files as $file) {
            $filename = basename($file);
            $selected = ($filename === $this->selectedFile) ? 'selected' : '';
            $options .= "<option value=\"$filename\" $selected>$filename</option>\n";
        }
        return $options;
    }
    
    private function getBookContent() {
        if ($this->view === 'liste') {
            return $this->buchListe->bookListTable();
        } else {
            return $this->buchListe->bookListTiles();
        }
    }
    
    public function render() {
        $replacements = [
            'FORM_ACTION' => htmlspecialchars($_SERVER['PHP_SELF']),
            'DATA_OPTIONS' => $this->getDataOptions(),
            'BOOK_TABLE' => $this->view === 'liste' ? $this->getBookContent() : '',
            'BOOK_VIEW' => $this->view === 'kacheln' ? $this->getBookContent() : '',
            '{TABLE_BODY}' => $this->view === 'liste' ? $this->buchListe->bookListTable() : ''
        ];
        
        $output = $this->mainTemplate;
        foreach ($replacements as $key => $value) {
            $output = str_replace($key, $value, $output);
        }
        
        echo $output;
    }
}

$app = new BuchVerwaltung();
$app->render();
?>