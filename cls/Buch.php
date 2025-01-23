<?php
/* ***************************************** class Buch ********************************************* */


class Buch {
    private $author;
    private $title;
    private $year;
    private $genre;
    private $isbn;
    private $cover;


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
            ['{AUTHOR}', '{TITLE}', '{YEAR}', '{GENRE}', '{ISBN}', '{BOOK_COVER}'],
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
            ['{AUTHOR}', '{TITLE}', '{YEAR}', '{GENRE}', '{ISBN}', '{BOOK_COVER}'],
            [$this->author, $this->title, $this->year, $this->genre, $this->isbn, $this->cover],
            $template
        );
    }

    /**
     * Creates a details table for the current book object
     * @return string HTML string using the tpl/bookDetails.htm template
     */
    public function bookDetails() {
        $template = file_get_contents('tpl/bookDetails.htm');
        return str_replace(
            ['{AUTHOR}', '{TITLE}', '{YEAR}', '{GENRE}', '{ISBN}', '{BOOK_COVER}'],
            [$this->author, $this->title, $this->year, $this->genre, $this->isbn, $this->cover],
            $template
        );
    }

    /**
     * Creates an individual table for the current book object
     * @return string HTML string using the tpl/bookView.htm template
     */
    public function bookView() {
        $template = file_get_contents('tpl/bookView.htm');
        $details = $this->bookDetails();
        return str_replace(
            ['{AUTHOR}', '{TITLE}', '{YEAR}', '{GENRE}', '{ISBN}', '{BOOK_COVER}'],
            [$this->author, $this->title, $this->year, $this->genre, $this->isbn, $this->cover, $details],
            $template
        );
    }

    public function getTitle() {
        return $this->title;
    }
}
?>
