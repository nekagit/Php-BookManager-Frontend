<?php
/* *************************************** class Sachbuch ******************************************* */

class Sachbuch extends Buch {
    private $topic;

    /**
     * Constructor for Sachbuch class
     * @param array $data Array containing book data with indices 0-6, where index 6 contains the topic
     */
    public function __construct($data) {
        parent::__construct(array_slice($data, 0, 6)); // Pass first 6 elements to parent constructor
        $this->topic = $data[6];
    }

    /**
     * Creates a table row for the current book object in the list view
     * @return string HTML string containing the table row
     */
    public function tableRow() {
        $baseRow = parent::tableRow();
        // Insert topic cell before the last closing tag
        return substr_replace($baseRow, "<td>{$this->topic}</td>", strrpos($baseRow, "</tr>"), 0);
    }

    /**
     * Creates a detailed view table for the current book object
     * @return string HTML string containing the detailed view
     */
    public function bookDetails() {
        $baseDetails = parent::bookDetails();
        // Insert topic row before the last closing tag
        return substr_replace(
            $baseDetails,
            "<tr><td>Topic:</td><td>{$this->topic}</td></tr>",
            strrpos($baseDetails, "</table>"),
            0
        );
    }

    // bookView() is inherited from parent class Buch
    // tile() is inherited from parent class Buch
}
?>

