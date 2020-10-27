<?php
require("simple_html_dom.php");


function printData($status, $data)
{
    header("Content-Type: application/json");
    echo json_encode(["status" => $status, "result" => $data], JSON_PRETTY_PRINT);
}

class PDFLinkReadyModel implements JsonSerializable
{
    private $num, $chair_num, $exam_location, $result_link;

    /**
     * PDFLinkReady constructor.
     * @param $num
     * @param $chair_num
     * @param $exam_location
     * @param $result_link
     */
    public function __construct($num, $chair_num, $exam_location, $result_link)
    {
        $this->num = $num;
        $this->chair_num = $chair_num;
        $this->exam_location = $exam_location;
        $this->result_link = $result_link;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

function pdfLinkReady($url)
{

    $html = new simple_html_dom();
    $html->load_file($url);

    $trs = $html->find("tr");

    $trArray = array();


    if (isset($trs)) {

        foreach ($trs as $tr) {
            array_push($trArray, $tr);
        }
        $resultArray = array();
        for ($i = 1; $i < count($trArray); $i++) {
            $td = $trArray[$i]->find("td");
            $result_link = $trArray[$i]->find("a", 0)->href;
            $num = $td[1]->innertext;
            $chair_num = $td[2]->innertext;
            $exam_location = $td[3]->innertext;
            $model = new PDFLinkReadyModel($num, $chair_num, $exam_location, $result_link);
            array_push($resultArray, $model);
        }
        printData(true, $resultArray);

    } else {
        printData(false, null);

    }

}

//http://localhost:8080/php_projects/moe_exam/pdf_link_ready.php?ready_link=https://2020.myanmarexam.org/ygn.html
if (isset($_GET["ready_link"])) {
    $url = $_GET["ready_link"];
    pdfLinkReady($url);
} else {
    printData(false, null);
}


