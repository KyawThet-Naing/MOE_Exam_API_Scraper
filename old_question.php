<?php

require("simple_html_dom.php");

function printData($status, $data, $title)
{
    header("Content-Type: application/json");
    echo json_encode(["status" => $status, "title" => $title, "result" => $data], JSON_PRETTY_PRINT);
}

class OldQuestion implements JsonSerializable
{

    private $sbj_title, $pdfLink;

    /**
     * OldQuestion constructor.
     * @param $sbj_title
     * @param $pdfLink
     */
    public function __construct($sbj_title, $pdfLink)
    {

        $this->sbj_title = $sbj_title;
        $this->pdfLink = $pdfLink;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

function getOldQuestion($url, $className)
{


    $html = new simple_html_dom();
//    $url = "https://www.myanmarexam.org/questions";
//    $url_1="https://www.myanmarexam.org/questions?page=1";
//WITH_ID_GET_DATA//

    $html->load_file($url);

    $title = $html->find("$className h2 a", 0)->innertext;
    $subjects = $html->find("$className a[target$=_blank]");

    if (isset($title) && isset($subjects)) {

        $aArray = array();
        foreach ($subjects as $subject) {
            $spl_sbj = explode("&", $subject->href);
            $old_q_model = new OldQuestion($subject->innertext, $spl_sbj[0]);
            array_push($aArray, $old_q_model);
        }
        printData(true, $aArray, $title);
    }
}
//http://localhost:8080/php_projects/moe_exam/old_question.php?2020_old_questions_local
if (isset($_GET["2020_old_questions_foreign"])) {
    getOldQuestion("https://www.myanmarexam.org/questions", "div.views-row.views-row-1.views-row-odd.views-row-first");
} elseif (isset($_GET["2020_old_questions_local"])) {
    getOldQuestion("https://www.myanmarexam.org/questions", "div.views-row.views-row-2.views-row-even");
} elseif (isset($_GET["2019_old_questions_foreign"])) {
    getOldQuestion("https://www.myanmarexam.org/questions", "div.views-row.views-row-3.views-row-odd");
} elseif (isset($_GET["2019_old_questions_local"])) {
    getOldQuestion("https://www.myanmarexam.org/questions", "div.views-row.views-row-4.views-row-even");
} elseif (isset($_GET["2018_old_questions_foreign"])) {
    getOldQuestion("https://www.myanmarexam.org/questions", "div.views-row.views-row-5.views-row-odd");
} elseif (isset($_GET["2018_old_questions_local"])) {
    getOldQuestion("https://www.myanmarexam.org/questions", "div.views-row.views-row-6.views-row-even");
} elseif (isset($_GET["2017_old_questions_foreign"])) {
    getOldQuestion("https://www.myanmarexam.org/questions", "div.views-row.views-row-7.views-row-odd");
} elseif (isset($_GET["2017_old_questions_local"])) {
    getOldQuestion("https://www.myanmarexam.org/questions", "div.views-row.views-row-8.views-row-even");
} elseif (isset($_GET["2016_old_questions_foreign"])) {
    getOldQuestion("https://www.myanmarexam.org/questions", "div.views-row.views-row-9.views-row-odd");
} elseif (isset($_GET["2016_old_questions_local"])) {
    getOldQuestion("https://www.myanmarexam.org/questions", "div.views-row.views-row-10.views-row-even.views-row-last");
} elseif (isset($_GET["2015_old_questions_foreign"])) {
    getOldQuestion("https://www.myanmarexam.org/questions?page=1", "div.views-row.views-row-2.views-row-even.views-row-last");
} elseif (isset($_GET["2015_old_questions_local"])) {
    getOldQuestion("https://www.myanmarexam.org/questions?page=1", "div.views-row.views-row-1.views-row-odd.views-row-first");
} else {
    printData(false, null, null);
}
