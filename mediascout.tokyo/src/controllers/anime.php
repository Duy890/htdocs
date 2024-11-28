<?php
class Anime extends Controller{
    function index()
    {
        $this->view("mainlayout", [
            "Page" => "home", ]);
    }
    function info($id) {
        $this->view("mainlayout", [
            "Page"=>"anime-details",
            "animeid"=> $id,
        ]);
    }
    function search()
    {
        $this->view("mainlayout", [
            "Page"=>"search",
        ]);
    }
    function result($query)
    {
        $this->view("mainlayout", [
            "Page"=>"search-result",
            "animeName"=> $query,
        ]);
    }
    //
    function TopRated()
    {
        $this->view("mainlayout", [
            "Page" => "view-top-rated",
        ]);
    }
    function Upcoming(){
        $this->view ("mainlayout", [
            "Page" => "view-upcoming",
        ]);
    }
    function Ova(){
        $this->view ("mainlayout", [
            "Page" => "view-top-ova",
        ]);
    }
    function Movie(){
        $this->view ("mainlayout", [
            "Page" => "view-top-movies",
        ]);
    }
    function Special(){
        $this->view ("mainlayout", [
            "Page" => "view-top-special",
        ]);
    }
    function Series(){
        $this->view ("mainlayout", [
            "Page" => "view-top-series",
        ]);
    }
    function Favorited(){
        $this->view ("mainlayout", [
            "Page" => "view-top-favorited",
        ]);
    }
    function TV(){
        $this->view ("mainlayout", [
            "Page" => "view-top-tv",
        ]);
    }
    function Airing(){
        $this->view ("mainlayout", [
            "Page" => "view-top-airing",
        ]);
    }

    function Seasonal()
    {
        $this->view ("mainlayout", [
            "Page" => "view-seasonal",
        ]);
    }
    function MyHistory()
    {
        $this->view ("mainlayout", [
            "Page" => "myhistory",
        ]);
    }
}