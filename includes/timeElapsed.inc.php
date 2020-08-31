<?php
function timeElapsed($date){
        $months=array();
        date_default_timezone_set("America/Los_Angeles");
        for ($i=1; $i < 13; $i++) {
            $month = date('F',mktime(0,0,0,$i));
            $months += [substr($month,0,3) => $i];
        }
        $date_year = date('Y', strtotime($date));//year of the date
        $date_month = date('m', strtotime($date));//month of the date
        $date_day = date('d', strtotime($date));//day of the date
        $date_hour = date('h', strtotime($date));//hour of the date
        $date_minute = date('i', strtotime($date));//minute of the date
        $current_year = date('Y');//current year(2019 in this case)

        //seconds passed between the given and current date
        $seconds_passed = round((time()-strtotime($date)),0);

        //minutes  passed between the given and current date
        $minutes_passed = round((time()-strtotime($date))/ 60,0);

        //hours passed between the given and current date
        $hours_passed = round((time()-strtotime($date))/ 3600,0);

        //days passed between the given and current date
        $days_passed = round((time()-strtotime($date))/ 86400,0);

        if($seconds_passed<60) return $seconds_passed." second".($seconds_passed == (1) ? " " : "s")." ago";
        //outputs 1 second / 2-59 seconds ago

        else if($seconds_passed>=60 && $minutes_passed<60) return $minutes_passed." minute".($minutes_passed == (1) ? " " : "s")." ago";
        //outputs 1 minute/ 2-59 minutes ago

        else if($minutes_passed>=60 && $hours_passed<24) return $hours_passed." hour".($hours_passed == (1) ? " " : "s")." ago";
        //outputs 1 hour / 2-23 hours ago

        else if($hours_passed>=24 && $days_passed<2) return "Yesterday at ".$date_hour.":".$date_minute;
        //outputs [Yesterday at 11:30] for example

        elseif ($days_passed<15) return $days_passed." days ago";

        else{
            if($current_year!=$date_year){
                foreach($months as $month_name => $month_number){
                    if($month_number==$date_month){
                        $ampm = $date_hour < (12) ? "AM" : "PM " ;
                        return $month_name." ".$date_day.", ".$date_year." ".$date_hour.":".$date_minute." ".$ampm;

                        //outputs [Dec 11, 2018 11:32] for example
                    }
                }
            }
            else{
                foreach($months as $month_name => $months){
                    if($months==$date_month){
                        $ampm = $date_hour < (12) ? "AM" : "PM " ;
                        return $month_name." ".$date_day.", ".$date_hour.":".$date_minute." ".$ampm;
                        //outputs [Dec 11, 11:32] for example
                    }
                }
            }
        }
    }
