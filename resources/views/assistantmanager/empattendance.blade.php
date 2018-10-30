<?php
    $use = Auth::user()->group_id;
    $ext = ($use == 14? "layouts.app":"layouts.amheader");
?>
@extends($ext)
@section('content')
<?php
    $dates = array();
    $logintimes = array();
?>
@foreach($attendances as $attendance)
    <?php array_push($dates,"$attendance->logindate"); ?>
@endforeach
@foreach($attendances as $attendance)
<?php
    $text = "In: ".$attendance->logintime."<br>Out: ".$attendance->logout."<br><a href=\"viewdailyreport?date=".$attendance->logindate."&&userId=".$attendance->employeeId."\">Report</a>";
    array_push($logintimes,$text);
    $userid = $attendance->employeeId;
?>
@endforeach
<?php
class Calendar {
    public $att = array();
    public $log = array();
    public function __construct(&$dates,&$login){
        $this->uid = $_GET['userId'];
        $this->naviHref = "amattendance";
        $this->att = $dates;
        $this->log = $login;
    }
    /********************* PROPERTY ********************/  
    private $dayLabels = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
    private $currentYear=0;
    private $currentMonth=0;
    private $currentDay=0;
    private $currentDate=null;
    private $daysInMonth=0;
    private $naviHref= null;
    /********************* PUBLIC **********************/  
    /**
    * print out the calendar
    */
    public function show() {
        $year  = null;
        $month = null;
        if(null==$year&&isset($_GET['year'])){
            $year = $_GET['year'];
        }else if(null==$year){
            $year = date("Y",time());  
        }          
        if(null==$month&&isset($_GET['month'])){
            $month = $_GET['month'];
        }else if(null==$month){
            $month = date("m",time());
        }                  
        $this->currentYear=$year;
        $this->currentMonth=$month;
        $this->daysInMonth=$this->_daysInMonth($month,$year);  
        $content='<div id="calendar">'.
                '<div class="box">'.
                $this->_createNavi().
                '</div>'.
                '<div class="box-content">'.
                '<ul class="label">'.$this->_createLabels().'</ul>';   
        $content.='<div class="clear"></div>';     
        $content.='<ul class="dates">';    
        $weeksInMonth = $this->_weeksInMonth($month,$year);
        // Create weeks in a month
        $count = 0;
        $found = 0;
        for( $i=0; $i<$weeksInMonth; $i++ ){
        //Create days in a week
            for($j=1;$j<=7;$j++){
                if($j==6){
                    $content.=$this->_showDay($i*7+$j,($count<sizeof($this->att)?$this->att[$count]:"na"),($count<sizeof($this->log)?$this->log[$count]:"na"),$count);
                }else{
                    $content.=$this->_showDay($i*7+$j,($count<sizeof($this->att)?$this->att[$count]:"na"),($count<sizeof($this->log)?$this->log[$count]:"na"),$count);
                }
            }
        }
        $content.='</ul>';
        $content.='<div class="clear"></div>';     
        $content.='</div>';  
        $content.='</div>';
        return $content;   
    }
    /********************* PRIVATE **********************/ 
    /**
    * create the li element for ul
    */
    private function _showDay($cellNumber,$date,$text,&$count){
        if($this->currentDay==0){
            $firstDayOfTheWeek = date('N',strtotime($this->currentYear.'-'.$this->currentMonth.'-01'));
            if(intval($cellNumber) == intval($firstDayOfTheWeek)){
                $this->currentDay=1;        
            }
        }
        if( ($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth) ){
            $this->currentDate = date('Y-m-d',strtotime($this->currentYear.'-'.$this->currentMonth.'-'.($this->currentDay)));
            $cellContent = $this->currentDay;
            $this->currentDay++;   
        }else{
            $this->currentDate =null;
            $cellContent=null;
        }
        if($this->currentDay == null){
            $count = 0;
        }else{
            if($date==$this->currentDate){
                $count++;
            }
        }
        return '<li id="li-'.
            $this->currentDate.
            '" class="'.
            ($cellNumber%7==1?' start ':($cellNumber%7==0?' end ':' ')).
            ($cellContent==null?'mask':'').
            '" style="'.
            ($cellNumber%7==0?' background-color:red; ':' ').
            '">'.
            $cellContent.($date==$this->currentDate?"<br>".$text: '').
        '</li>';
    }
    /**
    * create navigation
    */
    private function _createNavi(){
        $nextMonth = $this->currentMonth==12?1:intval($this->currentMonth)+1;
        $nextYear = $this->currentMonth==12?intval($this->currentYear)+1:$this->currentYear;
        $preMonth = $this->currentMonth==1?12:intval($this->currentMonth)-1;
        $preYear = $this->currentMonth==1?intval($this->currentYear)-1:$this->currentYear;
        return
            '<div class="header">'.
                '<a class="prev" href="'.$this->naviHref.'?userId='.$this->uid.'&month='.sprintf('%02d',$preMonth).'&year='.$preYear.'">Prev</a>'.
                    '<span class="title">'.date('M Y',strtotime($this->currentYear.'-'.$this->currentMonth.'-1')).'</span>'.
                '<a class="next" href="'.$this->naviHref.'?userId='.$this->uid.'&month='.sprintf("%02d", $nextMonth).'&year='.$nextYear.'">Next</a>'.
            '</div>';
    }
         
    /**
    * create calendar week labels
    */
    private function _createLabels(){          
        $content='';
        foreach($this->dayLabels as $index=>$label){
            $content.='<li class="'.($label==6?'end title':'start title').' title">'.$label.'</li>';
        }
        return $content;
    }
    /**
    * calculate number of weeks in a particular month
    */
    private function _weeksInMonth($month=null,$year=null){    
        if( null==($year) ) {
            $year =  date("Y",time()); 
        }
        if(null==($month)) {
            $month = date("m",time());
        }
        // find number of days in this month
        $daysInMonths = $this->_daysInMonth($month,$year);
        $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
        $monthEndingDay= date('N',strtotime($year.'-'.$month.'-'.$daysInMonths));
        $monthStartDay = date('N',strtotime($year.'-'.$month.'-01'));
        if($monthEndingDay<$monthStartDay){
            $numOfweeks++;
        }
        return $numOfweeks;
    }
    /**
    * calculate number of days in a particular month
    */
    private function _daysInMonth($month=null,$year=null){    
        if(null==($year))
            $year =  date("Y",time()); 
        if(null==($month))
            $month = date("m",time());
        return date('t',strtotime($year.'-'.$month.'-01'));
    }
     
}?>
<div class="col-md-6 col-md-offset-3">
    <div class="alert alert-success text-center">Name &nbsp;:&nbsp; {{ $user->name }} &nbsp;|&nbsp;
    Department &nbsp;:&nbsp; {{ $user->department->dept_name }} &nbsp;|&nbsp;
    Designation &nbsp;:&nbsp; {{ $user->group->group_name }}
    </div>
<?php
$calendar = new Calendar($dates,$logintimes);
 
echo $calendar->show();
?>
</div>
@endsection