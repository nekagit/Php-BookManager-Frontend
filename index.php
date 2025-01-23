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
    private $selectedBook = null;

    public function __construct() {
        // Load the main page template
        $this->mainTemplate = file_get_contents('tpl/mainPage.htm');

        // Determine the selected file and sorting
        $this->selectedFile = $_POST['fileName'] ?? 'alle.txt';
        $this->sorting = $_POST['sorting'] ?? 'orig';

        // Initialize the book list
        $this->buchListe = new Buchliste(
            'data/' . $this->selectedFile,
            $this->sorting === 'auf' ? 'SORT' : ''
        );

        // Handle request after book list is initialized
        $this->handleRequest();
    }

    private function handleRequest() {
        // Set view, defaulting to 'liste'
        $this->view = $_POST['view'] ?? 'liste';

        // Handle book details request
        if (isset($_POST['show'])) {
            $this->selectedBook = $this->findBookByTitle($_POST['show']);
        }
    }

    private function findBookByTitle($title) {
        // Find the book by its title
        foreach ($this->buchListe->getList() as $book) {
            if ($book->getTitle() === $title) {
                return $book;
            }
        }
        return null;
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
            'BOOK_VIEW' => $this->selectedBook ? 
                $this->selectedBook->bookView() : 
                ($this->view === 'kacheln' ? $this->getBookContent() : ''),
            '{TABLE_BODY}' => $this->view === 'liste' ? $this->buchListe->bookListTable() : ''
        ];

        $output = $this->mainTemplate;
        foreach ($replacements as $key => $value) {
            $output = str_replace($key, $value, $output);
        }

        echo $output;
    }
}

// Create and render the application
$app = new BuchVerwaltung();
$app->render();
?>