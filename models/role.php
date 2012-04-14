<?php
class Role extends AppModel
{
	const SYSTEMADMIN	= 'systemadmin';
	const SECTIONADMIN	= 'sectionadmin';
	const TOURCHIEF		= 'tourchief';
	const TOURLEADER	= 'tourleader';
	const EDITOR		= 'editor';
	const SACMEMBER		= 'sacmember';
	const USER			= 'user';

	var $name = 'Role';

	var $displayField = 'rolename';
}