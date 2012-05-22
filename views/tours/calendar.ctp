<?php

$this->Widget->includeCalendarScripts();
echo $this->Widget->calendar($tours, array('year' => $year, 'month' => $month, 'ajax' => false, 'viewlinks' => true));