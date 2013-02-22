<?php
Configure::write('Email.from', 'TourDB <tourdb@tourdb.ch>');
Configure::write('Email.delivery', 'smtp');
Configure::write('Email.Smtp.host', 'tourdb.ch');
Configure::write('Email.Smtp.port', 25);
Configure::write('Email.Smtp.timeout', 30);
Configure::write('Email.Smtp.username', 'tourdb@tourdb.ch');
Configure::write('Email.Smtp.password', 'tourdb');