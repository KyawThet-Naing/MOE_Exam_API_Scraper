<?php

require("simple_html_dom.php");

function printData($status, $data)
{
    header("Content-Type: application/json");
    echo json_encode(["status" => $status, "result" => $data], JSON_PRETTY_PRINT);

}

function str_ends_with(string $haystack, string $needle): bool
{
    return $needle === '' || $needle === substr($haystack, -strlen($needle));
}

class  ExamYearDetail implements JsonSerializable
{
    private $detailLink, $locationName;

    /**
     * ExamYearDetail constructor.
     * @param $detailLink
     * @param $locationName
     */
    public function __construct($detailLink, $locationName)
    {
        $this->detailLink = $detailLink;
        $this->locationName = $locationName;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

class  ExamYearModel implements JsonSerializable
{
    private $year, $link;

    /**
     * ExamYearModel constructor.
     * @param $year
     * @param $link
     */
    public function __construct($year, $link)
    {

        $this->year = $year;
        $this->link = $link;
    }

    public function jsonSerialize()
    {

        return get_object_vars($this);
    }
}


function getYearLink()
{
    $url = "https://www.myanmarexam.org/";
    $html = new simple_html_dom();
    $html->load_file($url);
    $exam_year = $html->find("#menu-377-1 li a");
    if (!isset($exam_year)) {
        printData(false, null);
    } else {
        $result = array();
        foreach ($exam_year as $a) {

            if (str_ends_with($a->href, '/')) {
                $a->href = "$a->href";
            } else {
                $a->href = "$a->href/";
            }

            $model = new ExamYearModel($a->innertext, $a->href);

            array_push($result, $model);
        }
        printData(true, $result);
    }
}

try {
    function getYearDetail($url)
    {
//    $url = "https://2016.myanmarexam.org/";
        $detailHtml = new simple_html_dom();

        $detailHtml->load_file($url);
        $exam_detail = $detailHtml->find("tbody a[href]");
        if (isset($exam_detail)) {
            $yearDetailResult = array();
            foreach ($exam_detail as $exam) {
                if (substr($exam->href, 0, 8) === "https://") {

                    $ans = explode("ဒေသကြီး", $exam->innertext);
                    if (str_ends_with($ans[0], "တိုင်း")) {
                        $ans[0] = "$ans[0]ဒေသကြီး";
                    } else {
                        $ans[0] = "$ans[0]";
                    }

//                    echo "$exam->href<br><br>";
                    $exam_year_detail_model = new ExamYearDetail($exam->href, $ans[0]);

                    array_push($yearDetailResult, $exam_year_detail_model);


                } else {
                    $ans = explode("ဒေသကြီး", $exam->innertext);
                    if (str_ends_with($ans[0], "တိုင်း")) {
                        $ans[0] = "$ans[0]ဒေသကြီး";
                    } else {
                        $ans[0] = "$ans[0]";
                    }
//                    echo "$url$exam->href<br>";

                    $exam_year_detail_model = new ExamYearDetail($url . $exam->href, $ans[0]);
                    array_push($yearDetailResult, $exam_year_detail_model);
                }
            }

            printData(true, $yearDetailResult);

        } else {
            printData(false, null);
        }

    }

} catch (Exception $e) {
    printData(false, null);

}

//getYearDetail();
//
if (isset($_GET["all_exam_year"])) {
    getYearLink();
} elseif (isset($_GET["exam_year_detail"])) {
    $url = $_GET["exam_year_detail"];

    getYearDetail($url);
} else {
    printData(false, null);
}


