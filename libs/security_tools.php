<?php
/**
 * This class provides methods for the generation of random strings, etc.
 * 
 * @author michaelze
 */
class SecurityTools
{
	const PASSWORDCHARS = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

	/**
	 * This method generates a random string of the specified length.
	 * 
	 * @param int $length
	 * 			The desired length of the created random string, default 10.
	 * @return string
	 * 			Returns the generated random string.
	 */
	function generateRandomString($length = 10)
	{
		return substr(str_shuffle(self::PASSWORDCHARS), 0, $length);
	}
}