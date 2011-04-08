<?php

$content = explode("\n", $content);

foreach($content as $line)
{
	printf('<p>%s</p>', $line);
}