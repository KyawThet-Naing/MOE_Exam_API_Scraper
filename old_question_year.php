<?php

function printData($status, $data)
{
    header("Content-Type: application/json");
    echo json_encode(["status" => $status, "result" => $data], JSON_PRETTY_PRINT);
}

class OldQuestionYearModel implements JsonSerializable
{

    private $title, $paramName;

    /**
     * OldQuestionYearModel constructor.
     * @param $title
     * @param $paramName
     */
    public function __construct($title, $paramName)
    {
        $this->title = $title;
        $this->paramName = $paramName;
    }


    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

$oldQuestionYear = array(
    new OldQuestionYearModel("၂၀၂၀ ခုနှစ် တက္ကသိုလ်ဝင်စာမေးပွဲ မေးခွန်းဟောင်းများ (ပြည်ပ)", "2020_old_questions_foreign"),
    new OldQuestionYearModel("၂၀၂၀ ခုနှစ် တက္ကသိုလ်ဝင်စာမေးပွဲ မေးခွန်းဟောင်းများ (ပြည်တွင်း)", "2020_old_questions_local"),
    new OldQuestionYearModel("၂၀၁၉ ခုနှစ် တက္ကသိုလ်ဝင်စာမေးပွဲ မေးခွန်းဟောင်းများ (ပြည်ပ)", "2019_old_questions_foreign"),
    new OldQuestionYearModel("၂၀၁၉ ခုနှစ် တက္ကသိုလ်ဝင်စာမေးပွဲ မေးခွန်းဟောင်းများ (ပြည်တွင်း)", "2019_old_questions_local"),
    new OldQuestionYearModel("၂၀၁၈ ခုနှစ် တက္ကသိုလ်ဝင်စာမေးပွဲ မေးခွန်းဟောင်းများ (ပြည်ပ)", "2018_old_questions_foreign"),
    new OldQuestionYearModel("၂၀၁၈ ခုနှစ် တက္ကသိုလ်ဝင်စာမေးပွဲ မေးခွန်းဟောင်းများ (ပြည်တွင်း)", "2018_old_questions_local"),
    new OldQuestionYearModel("၂၀၁၇ ခုနှစ် တက္ကသိုလ်ဝင်စာမေးပွဲ မေးခွန်းဟောင်းများ (ပြည်ပ)", "2017_old_questions_foreign"),
    new OldQuestionYearModel("၂၀၁၇ ခုနှစ် တက္ကသိုလ်ဝင်စာမေးပွဲ မေးခွန်းဟောင်းများ (ပြည်တွင်း)", "2017_old_questions_local"),
    new OldQuestionYearModel("၂၀၁၆ ခုနှစ် တက္ကသိုလ်ဝင်စာမေးပွဲ မေးခွန်းဟောင်းများ (ပြည်ပ)", "2016_old_questions_foreign"),
    new OldQuestionYearModel("၂၀၁၆ ခုနှစ် တက္ကသိုလ်ဝင်စာမေးပွဲ မေးခွန်းဟောင်းများ (ပြည်တွင်း)", "2016_old_questions_local"),
    new OldQuestionYearModel("၂၀၁၅ ခုနှစ် တက္ကသိုလ်ဝင်စာမေးပွဲ မေးခွန်းဟောင်းများ (ပြည်ပ)", "2015_old_questions_foreign"),
    new OldQuestionYearModel("၂၀၁၅ ခုနှစ် တက္ကသိုလ်ဝင်စာမေးပွဲ မေးခွန်းဟောင်းများ (ပြည်တွင်း)", "2015_old_questions_local"),

);


if (isset($_GET["all_old_questions"])) {
    printData(true, $oldQuestionYear);
} else {
    printData(false, null);

}




