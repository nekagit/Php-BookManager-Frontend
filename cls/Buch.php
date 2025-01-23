<?php
/* ***************************************** class Buch ********************************************* */


class Buch {
    private $author;
    private $title;
    private $year;
    private $genre;
    private $isbn;
    private $cover;

    private $searchList = ['{AUTHOR}', '{TITLE}', '{YEAR}', '{GENRE}', '{ISBN}', '{BOOK_COVER}'];

    public function __construct($data) {
        $this-> author = $data[0];
        $this-> title = $data[1];
        $this-> year = $data[2];
        $this-> genre = $data[3];
        $this-> isbn = $data[4];
        $this-> cover = $data[5];
    }

     /**
     * Creates a row for the current book object in the table for list views
     * @return string HTML string using the tpl/bookTableRow.htm template
     */
    public function tableRow() {
        $template = file_get_contents('tpl/bookTableRow.htm');
        return str_replace(
              $this->searchList,
            [$this->author, $this->title, $this->year, $this->genre, $this->isbn, $this->cover],
            $template
        );
    }

    /**
     * Creates a tile for the current book object in the tile view
     * @return string HTML string using the tpl/bookTile.htm template
     */
    public function tile() {
        $template = file_get_contents('tpl/bookTile.htm');
        return str_replace(
              $this->searchList,
            [$this->author, $this->title, $this->year, $this->genre, $this->isbn, $this->cover],
            $template
        );
    }

    /**
     * Creates a details table for the current book object
     * @return string HTML string containing the book details
     */
    public function bookDetails() {
        $details = '';
        $details .= '<tr><td>Autor(en)</td><td>' . $this->author . '</td></tr>';
        $details .= '<tr><td>Titel</td><td>' . $this->title . '</td></tr>';
        $details .= '<tr><td>Jahr</td><td>' . $this->year . '</td></tr>';
        $details .= '<tr><td>Genre</td><td>' . $this->genre . '</td></tr>';
        $details .= '<tr><td>ISBN</td><td>' . $this->isbn . '</td></tr>';
        return $details;
    }

   /**
 * Creates an individual table for the current book object
 * @return string HTML string using the tpl/bookView.htm template
 */
public function bookView() {
    $template = file_get_contents('tpl/bookView.htm');
    $details = $this->bookDetails();
    return str_replace(
        ['{AUTHOR}', '{BOOK_TITLE}', '{YEAR}', '{GENRE}', '{ISBN}', '{BOOK_COVER}', '{BOOK_DETAILS}'],
        [$this->author, $this->title, $this->year, $this->genre, $this->isbn, $this->cover, $details],
        $template
    );
}

    public function getTitle() {
        return $this->title;
    }
}
?>
