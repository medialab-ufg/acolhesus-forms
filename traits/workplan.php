<?php

trait WorkPlan {

    public static $totalCriticalPoints = 3;

    public static $totalObjectives = 5;

    public static $totalActivities = 5;

    public function totalActivityRows() {
        return self::$totalActivities * self::$totalObjectives;
    }
}