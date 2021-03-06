#!/usr/bin/perl

use XML::Mini::Document;

my $newDoc = XML::Mini::Document->new();
my $newDocRoot = $newDoc->getRoot();

my $person = $newDocRoot->createChild('person');

my $name = $person->createChild('name');
$name->createChild('first')->text('John');
$name->createChild('last')->text('Doe');

my $eyes = $person->createChild('eyes');
$eyes->attribute('color', 'blue');
$eyes->attribute('number', 2);
			
print $newDoc->toString();

