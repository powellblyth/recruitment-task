# Recruitment task

This script / project simply parses either XML, Yaml or CSV data in a fixed format, and allows simple totalisation or averaging of the data found therein

## Command Syntax
`php Scripts/do.php --action=[summarise|average] --filename="/path/to/file.extension" [--field=value|length] [--output=file|screen]`

## Configurability
You can configure with command line switches to generate on-screen display
- Which file to load *--filename=*
- Which column in the data to apply the maths to *--field=*
- Which maths to load *--action=*
- What form of output to use *--output=* Note that currently only screen output is functional

## Requirements
- PHP 7.1 +
- composer
- Lib MBstring

## Over-Engineered? 
Absolutely

## Usage examples

`php Scripts/do.php --action=summarise --filename="data/file.yml" --field=value --output=screen`

`php Scripts/do.php --action=average --filename="data/file2.xml" --field=length --output=file`

## Extensibility

By configuring the factory classes, and creating your own importers and outputters, any conceivable input and output could be processed
New commands can be configured by adding them to the Commands folder, and adding them to the Scripts/do.php file

## Known Issues

- This script will not work at scale
- The Commands are poorly written, more re-use would enhance testability
- Commands should have a better factory method
- All the factories could discover classes, rather than have this hard-coded
- The format of the data is fixed, this is not extensible