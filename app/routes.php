<?php

$this->addRoute('User/register', 'User,register');
$this->addRoute('User/login', 'User,login');
$this->addRoute('User/logout', 'User,logout');
$this->addRoute('User/update', 'User,update');
$this->addRoute('User/delete', 'User,delete');

$this->addRoute('Profile/index', 'Profile,index');
$this->addRoute('Profile/create', 'Profile,create');
$this->addRoute('Profile/modify', 'Profile,modify');
$this->addRoute('Profile/delete', 'Profile,delete');

$this->addRoute('Publication/index', 'Publication,index');
$this->addRoute('Publication/create', 'Publication,create');
$this->addRoute('Publication/modify/{publication_id}', 'Publication,modify');
$this->addRoute('Publication/delete/{publication_id}', 'Publication,delete');

$this->addRoute('PublicationComment/create/{publication_id}', 'PublicationComment,create');
$this->addRoute('PublicationComment/modify/{comment_id}', 'PublicationComment,modify');
$this->addRoute('PublicationComment/delete/{comment_id}', 'PublicationComment,delete');
