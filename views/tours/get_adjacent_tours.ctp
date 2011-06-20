<?php

foreach($adjacentTours as $adjacentTour)
{
	echo $this->Html->div('adjacentTour', $adjacentTour['Tour']['title']);
}