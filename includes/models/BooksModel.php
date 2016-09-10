<?php

class BooksModel {
    private $table_name = PREFIX."books";


    /**
     * get all books
     * @param string $extra [optional WHERE statement]
     * @return array 2D of the books || or Empty
     */
    public function GetAllBooks($extra = '')
    {
        $books = array(); //init

        $query = sprintf("SELECT * FROM %s %s", $this->table_name, $extra); // query
        //echo $query;
        System::Get('db')->Execute($query); //execute the query
        if (System::Get('db')->AffectedRows()) { //
            $books = System::Get('db')->GetRows();
            return $books;
        }
        return $books;
    }
}